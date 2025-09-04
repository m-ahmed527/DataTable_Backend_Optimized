<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('users.index');
    }

    public function getData(Request $request)
    {
        $query = User::with('role:id,name');

        return DataTables::of($query)
            ->addColumn('role_name', fn($user) => $user->role ? $user->role->name : 'No Role')
            ->addColumn('status_select', function ($user) {
                $selectedActive = $user->status === 'active' ? 'selected' : '';
                $selectedInactive = $user->status === 'inactive' ? 'selected' : '';
                return "
                    <select class='form-control change-status' data-id='{$user->id}'>
                        <option value='active' $selectedActive>Active</option>
                        <option value='inactive' $selectedInactive>Inactive</option>
                    </select>
                ";
            })
            ->addColumn('action', function ($user) {
                return '<a href="' . route('users.edit', $user->id) . '" class="btn btn-sm btn-primary">Edit</a>';
            })
            ->rawColumns(['status_select', 'action'])
            ->filterColumn('status_select', function ($query, $keyword) {
                $query->where('status', 'like', "%{$keyword}%");
            })
            ->make(true);
    }

    public function updateStatus(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->status = $request->status;
        $user->save();

        return response()->json(['success' => true]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash the password
        ]);

        return response()->json(['message' => 'User created successfully'], 201);
    }
    public function storeProduct(Request $request)
    {



        $user = User::find(4);
        // Create a new product
        $product = $user->products()->create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            // 'image' => $request->file('image')->store('images', 'public'), // Store the image
        ]);

        return response()->json(['message' => 'Product created successfully', 'product' => $product], 201);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
