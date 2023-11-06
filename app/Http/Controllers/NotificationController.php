<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\NotificationRepositoryInterface;
use Carbon\Carbon;

class NotificationController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    public $user;

    /**
     * @var NotificationRepositoryInterface
     */
    public $notification;
    /**
     * constructor for ProjectController
     * 
     * @param UserRepositoryInterface $project
     *
     * @return void
     */
    public function __construct(UserRepositoryInterface $user, NotificationRepositoryInterface $notification)
    {
        $this->user = $user;
        $this->notification = $notification;
    }

    public function index()
    {
        return view('admin.notifications.index');
    }

    public function paginatedProjects()
    {
        $start = request()->get('start');
        $length = request()->get('length');
        $sortColumn = request()->get('order')[0]['column'];
        $sortDirection = request()->get('order')[0]['dir'];
        $searchValue = request()->get('search')['value'];

        $count = $this->notification->paginated($start, $length, $sortColumn, $sortDirection, $searchValue, true);
        $projects = $this->notification->paginated($start, $length, $sortColumn, $sortDirection, $searchValue);

        $data = array(
            "draw"            => intval(request()->input('draw')),
            "recordsTotal"    => intval($count),
            "recordsFiltered" => intval($count),
            "data"            => $projects
        );

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = $this->user->allNotifiables();
        return view('admin.notifications.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd(request()->all());
        $id = request()->get('id');
        
        $mode = $id ? 'update' : 'save';

        $validator = validator()->make(request()->all(), [
            'type' => 'required',
            'text' => 'required|max:500',
            'expiration' => 'required|date',
        ], [
            'type.required' => 'Type is required',
            'text.required' => 'Notification text is required',
            'expiration.required' => 'Expiration date is required',
        ]);        

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        $dateString = request()->get('expiration');

        $carbonDate = Carbon::parse($dateString);

        $expiration = $carbonDate->format('Y-m-d H:i:s');

        $data = [
            'type' => request()->get('type'),
            'text' => request()->get('text'),
            'expiration' => $expiration,
        ];

        // dd($this->notification);

        $notification = $this->notification->store($data, $id);

        $notification->users()->attach(request()->get('users'));

        return redirect()->back()->with('success', 'Notification saved successfully!');
    }

    public function read()
    {
        $user = $this->user->find(request()->get('user_id'));
        $pivot = $user->notifications()->wherePivot('user_id', $user->id)->wherePivot('notification_id', request()->get('notification_id'))->first()->pivot;
        if($pivot) {
            $pivot->read = 1;
            $pivot->save();
        }
        return;
    }
}