<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        // SELECT only required columns + map status to label
        $query = DB::table('users')
            ->select([
                'users.id',
                'users.name',
                'users.email',
                'users.status',
                'users.created_at',
                DB::raw("roles.name as role_name"),
                DB::raw("CASE WHEN users.status = 1 THEN 'Active' ELSE 'Inactive' END as status_label")
            ])
            ->leftJoin('roles', 'roles.id', '=', 'users.role_id');

        return DataTables::query($query)
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return date('Y-m-d', strtotime($row->created_at));
            })
            // status_select: build dropdown HTML: value=0/1
            ->addColumn('status_select', function ($row) {
                $selectedActive = ($row->status == 1) ? 'selected' : '';
                $selectedInactive = ($row->status == 0) ? 'selected' : '';
                return "<select class='form-control change-status' data-id='{$row->id}'>
                            <option value='1' {$selectedActive}>Active</option>
                            <option value='0' {$selectedInactive}>Inactive</option>
                        </select>";
            })
            ->addColumn('action', function ($row) {
                $edit = route('users.edit', $row->id);
                return "<a href='{$edit}' class='btn btn-sm btn-primary'>Edit</a>";
            })
            ->rawColumns(['status_select', 'action'])
            // Custom filters: use prefix matching to leverage indexes
            ->filterColumn('name', function ($query, $keyword) {
                $query->where('users.name', 'like', $keyword . '%');
            })
            ->filterColumn('email', function ($query, $keyword) {
                $query->where('users.email', 'like', $keyword . '%');
            })
            ->filterColumn('status_label', function ($query, $keyword) {
                $k = strtolower($keyword);
                if ($k === 'active')
                    $query->where('users.status', 1);
                if ($k === 'inactive')
                    $query->where('users.status', 0);
            })
            ->make(true);
    }

    // public function getData(Request $request)
    // {
    //     $query = User::with('role:id,name');

    //     return DataTables::of($query)
    //         // 🔹 Add index column
    //         ->addIndexColumn()
    //         ->addColumn('role_name', fn($user) => $user->role ? $user->role->name : 'No Role')
    //         ->addColumn('status_select', function ($user) {
    //             $selectedActive = $user->status === 'active' ? 'selected' : '';
    //             $selectedInactive = $user->status === 'inactive' ? 'selected' : '';
    //             return "
    //                 <select class='form-control change-status' data-id='{$user->id}'>
    //                     <option value='active' $selectedActive>Active</option>
    //                     <option value='inactive' $selectedInactive>Inactive</option>
    //                 </select>
    //             ";
    //         })
    //         ->addColumn('action', function ($user) {
    //             return '<a href="' . route('users.edit', $user->id) . '" class="btn btn-sm btn-primary">Edit</a>';
    //         })
    //         ->rawColumns(['status_select', 'action'])
    //         ->filterColumn('status_select', function ($query, $keyword) {
    //             $query->where('status', strtolower($keyword));
    //         })

    //         ->make(true);
    // }

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
