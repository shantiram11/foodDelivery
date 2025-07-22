<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = User::query();

            if ($search = $request->input('search.value')) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            }

            $total = $query->count();

            $users = $query->orderBy('id')
                ->skip($request->input('start'))
                ->take($request->input('length'))
                ->get();

            $data = $users->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role ?? 'User',
                    'created_at' => $user->created_at->format('Y-m-d'),
                    'action' => '<a href="'.route('users.edit', $user->id).'" class="btn btn-sm btn-primary">Edit</a>'
                ];
            });

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $total,
                'recordsFiltered' => $total,
                'data' => $data,
            ]);
        }
        return view('dashboard.users.index');
    }

    public function create(){
        return view('dashboard.users.create');
    }
    public function store(UserRequest $request){
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
//            'role' => 'user',
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);
        return redirect()->route('users.index')->with('status', 'user-created');
    }
    public function edit($id){
        $user = User::find($id);
        return view('dashboard.users.edit',compact('user'));
    }
    public function update(Request $request){

    }
    public function destroy(){
//        return view('dashboard.users.destroy');
    }
}
