<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Menu::query();

            if ($search = $request->input('search.value')) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            }

            $total = $query->count();

            // Sort by menu name
            $menus = $query->orderBy('name')
                ->skip($request->input('start'))
                ->take($request->input('length'))
                ->get();

            $data = $menus->map(function ($menu) {
                return [
                    'id' => $menu->id,
                    'name' => $menu->name,
                    'price' => $menu->price,
                    'description' => $menu->description,
                    'image' => $menu->image,
                    'action' => '
                        <a href="'.route('menus.show', $menu->id).'" class="btn btn-sm btn-info">View</a>
                        <a href="'.route('menus.edit', $menu->id).'" class="btn btn-sm btn-primary">Edit</a>
                        <form action="'.route('menus.destroy', $menu->id).'" method="POST" style="display:inline">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure you want to delete this menu item?\')">Delete</button>
                        </form>'
                ];
            });

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $total,
                'recordsFiltered' => $total,
                'data' => $data,
            ]);
        }

        return view('dashboard.menus.index');
    }

    public function create()
    {
        return view('dashboard.menus.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Ensure user belongs to a restaurant
        if (!auth()->user()->restaurant_id) {
            return redirect()->back()->withErrors(['error' => 'You must be assigned to a restaurant to create menus.']);
        }

        $data = $request->all();
        
        // Automatically set restaurant_id from authenticated user
        $data['restaurant_id'] = auth()->user()->restaurant_id;

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads/menus'), $imageName);
            $data['image'] = $imageName;
        }

        Menu::create($data);

        return redirect()->route('menus.index')->with('status', 'menu-created');
    }

    public function show($id)
    {
        $menu = Menu::with('restaurant')->findOrFail($id);
        return view('dashboard.menus.show', compact('menu'));
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('dashboard.menus.edit', compact('menu'));
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Ensure user belongs to a restaurant
        if (!auth()->user()->restaurant_id) {
            return redirect()->back()->withErrors(['error' => 'You must be assigned to a restaurant to update menus.']);
        }

        $data = $request->all();
        
        // Automatically set restaurant_id from authenticated user
        $data['restaurant_id'] = auth()->user()->restaurant_id;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($menu->image && file_exists(public_path('uploads/menus/'.$menu->image))) {
                unlink(public_path('uploads/menus/'.$menu->image));
            }

            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads/menus'), $imageName);
            $data['image'] = $imageName;
        }

        $menu->update($data);

        return redirect()->route('menus.index')->with('status', 'menu-updated');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        // Delete image if exists
        if ($menu->image && file_exists(public_path('uploads/menus/'.$menu->image))) {
            unlink(public_path('uploads/menus/'.$menu->image));
        }

        $menu->delete();

        return redirect()->route('menus.index')->with('status', 'menu-deleted');
    }
}
