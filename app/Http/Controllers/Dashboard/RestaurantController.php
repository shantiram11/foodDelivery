<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Restaurant::query();

            if ($search = $request->input('search.value')) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%");
                });
            }

            $total = $query->count();

            $restaurants = $query->orderBy('id')
                ->skip($request->input('start'))
                ->take($request->input('length'))
                ->get();

            $data = $restaurants->map(function ($restaurant) {
                return [
                    'id' => $restaurant->id,
                    'name' => $restaurant->name,
                    'address' => $restaurant->address,
                    'phone' => $restaurant->phone,
                    'email' => $restaurant->email,
                    'status' => $restaurant->status,
                    'rating' => $restaurant->rating ?? 'N/A',
                    'action' => '
                        <a href="'.route('restaurants.edit', $restaurant->id).'" class="btn btn-sm btn-primary">Edit</a>
                        <form action="'.route('restaurants.destroy', $restaurant->id).'" method="POST" style="display:inline">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure you want to delete this restaurant?\')">Delete</button>
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

        return view('dashboard.restaurants.index');
    }

    public function create()
    {
        return view('dashboard.restaurants.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();
        $data['status'] = $request->has('status') ? 'active' : 'inactive';

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads/restaurants'), $imageName);
            $data['image'] = $imageName;
        }

        Restaurant::create($data);

        return redirect()->route('restaurants.index')->with('status', 'restaurant-created');
    }

    public function show($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        return view('dashboard.restaurants.show', compact('restaurant'));
    }

    public function edit($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        return view('dashboard.restaurants.edit', compact('restaurant'));
    }

    public function update(Request $request, $id)
    {
        $restaurant = Restaurant::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();
        $data['status'] = $request->has('status') ? 'active' : 'inactive';

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($restaurant->image && file_exists(public_path('uploads/restaurants/'.$restaurant->image))) {
                unlink(public_path('uploads/restaurants/'.$restaurant->image));
            }

            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads/restaurants'), $imageName);
            $data['image'] = $imageName;
        }

        $restaurant->update($data);

        return redirect()->route('restaurants.index')->with('status', 'restaurant-updated');
    }

    public function destroy($id)
    {
        $restaurant = Restaurant::findOrFail($id);

        // Delete image if exists
        if ($restaurant->image && file_exists(public_path('uploads/restaurants/'.$restaurant->image))) {
            unlink(public_path('uploads/restaurants/'.$restaurant->image));
        }

        $restaurant->delete();

        return redirect()->route('restaurants.index')->with('status', 'restaurant-deleted');
    }
}
