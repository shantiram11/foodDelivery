<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
        /**
     * Display a listing of contact messages
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Contact::query();

            // Filter by status if provided
            if ($request->has('status') && in_array($request->status, ['new', 'read', 'replied'])) {
                $query->where('status', $request->status);
            }

            if ($search = $request->input('search.value')) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('subject', 'like', "%{$search}%")
                        ->orWhere('message', 'like', "%{$search}%");
                });
            }

            $total = $query->count();

            $contacts = $query->orderBy('created_at', 'desc')
                ->skip($request->input('start'))
                ->take($request->input('length'))
                ->get();

            $data = $contacts->map(function ($contact) {
                $statusBadge = '';
                if ($contact->status === 'new') {
                    $statusBadge = '<span class="badge bg-danger">New</span>';
                } elseif ($contact->status === 'read') {
                    $statusBadge = '<span class="badge bg-warning">Read</span>';
                } else {
                    $statusBadge = '<span class="badge bg-success">Replied</span>';
                }

                $actions = '
                    <a href="'.route('contacts.show', $contact->id).'" class="btn btn-sm btn-primary" title="View">
                        <i class="bi bi-eye-fill"></i>
                    </a>';

                if ($contact->status !== 'replied') {
                    $actions .= '
                    <a href="'.route('contacts.reply', $contact->id).'" class="btn btn-sm btn-success" title="Mark as Replied">
                        <i class="bi bi-reply-fill"></i>
                    </a>';
                }

                $actions .= '
                    <form action="'.route('contacts.destroy', $contact->id).'" method="POST" style="display:inline" onsubmit="return confirm(\'Are you sure you want to delete this contact message?\')">
                        '.csrf_field().'
                        '.method_field('DELETE').'
                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </form>';

                return [
                    'id' => $contact->id,
                    'name' => $contact->name,
                    'email' => $contact->email,
                    'subject' => $contact->subject,
                    'status' => $statusBadge,
                    'created_at' => $contact->created_at->format('M d, Y H:i'),
                    'action' => $actions
                ];
            });

            return response()->json([
                'draw' => $request->input('draw'),
                'recordsTotal' => $total,
                'recordsFiltered' => $total,
                'data' => $data,
            ]);
        }

        return view('dashboard.contacts.index');
    }

    /**
     * Display the specified contact message
     */
    public function show($id)
    {
        $contact = Contact::findOrFail($id);

        // Mark as read if it's new
        if ($contact->status === Contact::STATUS_NEW) {
            $contact->markAsRead();
        }

        return view('dashboard.contacts.show', compact('contact'));
    }

    /**
     * Mark contact as replied
     */
    public function reply($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->markAsReplied();

        return redirect()->route('contacts.index')->with('success', 'Contact marked as replied.');
    }

    /**
     * Remove the specified contact from storage
     */
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('contacts.index')->with('success', 'Contact message deleted successfully.');
    }

    /**
     * Get contact statistics for dashboard
     */
    public function getStats()
    {
        return [
            'total' => Contact::count(),
            'new' => Contact::where('status', Contact::STATUS_NEW)->count(),
            'read' => Contact::where('status', Contact::STATUS_READ)->count(),
            'replied' => Contact::where('status', Contact::STATUS_REPLIED)->count(),
        ];
    }
}
