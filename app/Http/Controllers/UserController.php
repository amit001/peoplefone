<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\IPQualityScore;

class UserController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    public $user;
    /**
     * constructor for ProjectController
     * 
     * @param UserRepositoryInterface $project
     *
     * @return void
     */
    public function __construct(UserRepositoryInterface $user)
    {
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $manager = app('impersonate');
        if($manager->getImpersonatorId()) {
            return redirect()->route('dashboard');
        }
        return view('admin.users.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = request()->get('id');
        
        $mode = $id ? 'update' : 'save';

        $validator = validator()->make(request()->all(), [
            'name' => 'required|max:100',
            'email' => 'required|max:500|unique:users,email'.($id ? ','.$id : null),
        ], [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.unique' => 'Email is already registered with another user',
        ]);

        if($phone = request()->get('phone')) {

            $qualityScore = new IPQualityScore($phone);

            $result = $qualityScore->verify();

            $validator->after(function ($validator) use($result) {
                if (!$result['valid']) {
                    $validator->errors()->add(
                        'phone', 'Invalid phone number'
                    );
                }
            });
        }

        

        if ($validator->fails()) {
            return response()->json(['error' => 1, 'message' => $validator->errors()->first()]);
        }

        $data = [
            'name' => request()->get('name'),
            'email' => request()->get('email'),
            'phone_number' => request()->get('phone'),
            'notification_switch' => request()->get('status'),
        ];

        $user = $this->user->store($data, $id);

        return response()->json(['error' => 0, 'message' => 'User '.$mode.'d successfully']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function paginatedProjects()
    {
        $start = request()->get('start');
        $length = request()->get('length');
        $sortColumn = request()->get('order')[0]['column'];
        $sortDirection = request()->get('order')[0]['dir'];
        $searchValue = request()->get('search')['value'];

        $count = $this->user->paginated($start, $length, $sortColumn, $sortDirection, $searchValue, true);
        $projects = $this->user->paginated($start, $length, $sortColumn, $sortDirection, $searchValue);

        $data = array(
            "draw"            => intval(request()->input('draw')),
            "recordsTotal"    => intval($count),
            "recordsFiltered" => intval($count),
            "data"            => $projects
        );

        return response()->json($data);
    }
}
