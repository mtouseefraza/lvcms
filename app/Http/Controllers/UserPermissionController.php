<?php

namespace App\Http\Controllers;
use App\Models\Models;
use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Http\Request;

class UserPermissionController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        $action = 'show';
        $isAjax = $request->ajax();
        if ($isAjax) {
            $sortBy = $request->get('sortBy', 'id'); // Default column to sort
            $sortOrder = $request->get('sortOrder', 'desc'); // Default order
            
            
            $user = User::query();
            $user = $user->select('id','name','email','role','parent_user_id');
            $user = $user->where('parent_user_id', $this->AuthUser->id);

            $email = $request->get('email', null); // name criteria
            $id = $request->get('id', null); // name criteria
            $name = $request->get('name', null); // name criteria
            $role = $request->get('role', null); // name criteria

            if ($id) {
                $user = $user->where('id', 'LIKE', "%$name%");
            }
            if ($name) {
                $user = $user->where('name', 'LIKE', "%$name%");
            }
            if ($email) {
                $user = $user->where('email', 'LIKE', "%$email%");
            }
            if ($role) {
                $user = $user->where('role', 'LIKE', "%$role%");
            }
            
            $userpermission = $user->orderBy($sortBy, $sortOrder)->paginate(5);
            return view('user-permission', compact('userpermission', 'action','isAjax','sortBy','sortOrder'))->render();
        }
        return view('user-permission', compact('action'));
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
        //
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
    public function edit($user_id)
    {
        $action = 'edit'; 
        $allmodels = [];

       // Select parent user permissions
        $parentUser = User::query()->select('parent_user_id')->where('id', $user_id)->first();
        if(isset($parentUser->parent_user_id) && $parentUser->parent_user_id == $this->AuthUser->id){

            // Select permission
            $selectedPermission = UserPermission::query()
                ->select('permission')
                ->where('user_id', $user_id)
                ->first();
            $selectedPermission = !empty($selectedPermission['permission']) ? $selectedPermission['permission'] : [];
            
            $models = Models::query()
                ->join('sections', 'models.section_id', '=', 'sections.id')
                ->select('models.id', 'models.name', 'models.section_id', 'models.url', 'models.permission', 'sections.name as section_name', 'sections.icon as sections_icon')
                ->get()
                ->toArray();

            if (!empty($this->AuthUser->role) && $this->AuthUser->role == 'superadmin') {
                foreach ($models as $m) {
                    $temp = [];
                    $temp['selectedPermission'] = isset($selectedPermission[$m['id']]) ? $selectedPermission[$m['id']] : [];
                    $allmodels[$m['section_name']][] = array_merge($temp, $m);
                }
            } else {
                // Select parent user permissions
                $parentUser = User::query()
                    ->select('parent_user_id')
                    ->where('id', $user_id)
                    ->first();
                if (!empty($parentUser) && !empty($parentUser->parent_user_id)) {
                    $selectedParentPermission = UserPermission::query()
                        ->select('permission')
                        ->where('user_id', $parentUser->parent_user_id)
                        ->first();
                    $selectedParentPermission = !empty($selectedParentPermission['permission']) ? $selectedParentPermission['permission'] : [];

                    foreach ($models as $m) {
                        if (!empty($selectedParentPermission[$m['id']])) {
                            $temp = [];
                            $valuesToMatch = $selectedParentPermission[$m['id']];
                            $m['permission'] = array_filter($m['permission'], function ($v) use ($valuesToMatch) {
                                return !empty($valuesToMatch[$v]);
                            });

                            $temp['selectedPermission'] = isset($selectedPermission[$m['id']]) ? $selectedPermission[$m['id']] : [];
                            $allmodels[$m['section_name']][] = array_merge($temp, $m);
                        }    
                    }
                } else {
                    // Handle case where parent user ID is invalid or not found
                    return redirect()->route('user-permission.index')->with(['error' => 'Invalid parent user ID.']);
                }
            }
        }else{
            return redirect()->route('user-permission.index')->with('error', 'Invalid user ID.');
        }    

       
        return view('user-permission', compact('allmodels', 'action', 'user_id'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$user_id)
    {
        $parentUser = User::query()->select('parent_user_id')->where('id', $user_id)->first();
        if(isset($parentUser->parent_user_id) && $parentUser->parent_user_id == $this->AuthUser->id){
            $request->validate([
                'permission' => 'required',
            ]);
            $permission = $request->input('permission',[]);

            $UserPermission = UserPermission::updateOrCreate(
                ['user_id' => $user_id], // Match on the ID
                [
                    'user_id' => $user_id, 
                    'permission' => $permission
                ]
            );
            return redirect()->route('user-permission.index')->with('success', 'User permission updated or created successfully.');
        }else{
            return redirect()->route('user-permission.index')->with('error', 'Invalid user ID.');
        }    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function export(){
        // Fetch data from the database
        $user = User::query()->select('id','name','email','role')->where('parent_user_id', $this->AuthUser->parent_user_id)->get();

        // Define the CSV file name
        $fileName = 'user_' . date('Y-m-d_H-i-s') . '.csv';

        // Add CSV headers
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        // Generate the CSV content
        $callback = function () use ($user) {
            $file = fopen('php://output', 'w');

            // Add column headings
            fputcsv($file, ['Id','Name','Email','Role']);

            // Add data rows
            foreach ($user as $row) {
                fputcsv($file, [$row->id, $row->name,$row->email,$row->role]);
            }

            fclose($file);
        };

        // Return the response as a downloadable CSV
        return response()->stream($callback, 200, $headers);
    }
}
