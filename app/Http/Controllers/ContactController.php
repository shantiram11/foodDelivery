<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Store contact form submission
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000'
        ]);

        if ($validator->fails()) {
            // Silent validation handling - always return success even if validation fails
            if ($request->ajax() && $request->header('X-Requested-With') === 'XMLHttpRequest') {
                $acceptHeader = $request->header('Accept');
                if (!str_contains($acceptHeader, 'application/json')) {
                    return response('OK', 200, ['Content-Type' => 'text/plain']);
                }
                return response()->json([
                    'success' => true,
                    'message' => 'Your message has been sent successfully. We\'ll get back to you soon!'
                ]);
            }
            return redirect()->back()->with('success', 'Your message has been sent successfully. We\'ll get back to you soon!');
        }

        try {
            Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
                'status' => Contact::STATUS_NEW
            ]);
        } catch (\Exception $e) {
            // Silent error handling - continue as if successful
        }

        // Always return success response (no error messages shown)
        if ($request->ajax() && $request->header('X-Requested-With') === 'XMLHttpRequest') {
            // Check if it's the external php-email-form library by checking user agent or other headers
            $userAgent = $request->header('User-Agent');
            $acceptHeader = $request->header('Accept');

            // If no specific Accept header for JSON, assume it's the external library
            if (!str_contains($acceptHeader, 'application/json')) {
                return response('OK', 200, ['Content-Type' => 'text/plain']);
            }

            // Otherwise return JSON for custom AJAX handlers
            return response()->json([
                'success' => true,
                'message' => 'Your message has been sent successfully. We\'ll get back to you soon!'
            ]);
        }

        return redirect()->back()->with('success', 'Your message has been sent successfully. We\'ll get back to you soon!');

    }

}
