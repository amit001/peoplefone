<?php

namespace App\Repositories;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Models\User;

class UserRepository extends BaseRepository implements UserRepositoryInterface {

    public $user;

    public function __construct(User $user) {
        parent::__construct($user);

        $this->user = $user;
    }

    public function paginated($start, $length, $sortColumn, $sortDirection, $searchValue, $countOnly = false) {
        $query = $this->user->select('*');

        $query->where('id', '!=', auth()->id());

        if (!empty($searchValue)) {
            $query->where(function($q) use ($searchValue) {
                $q->orWhere('name', 'LIKE', "%$searchValue%");
                $q->orWhere('email', 'LIKE', "%$searchValue%");
                $q->orWhere('phone_number', 'LIKE', "%$searchValue%");
            });
        }

        if (!empty($sortColumn)) {
            $query->orderBy($sortColumn, $sortDirection);
        }

        $count = $query->count();

        if ($countOnly) {
            return $count;
        }

        $query->skip($start)->take($length);
        $users = $query->get();
        $users = $this->collectionModifier($users);
        return $users;
    }

    public function collectionModifier($users)
    {
        return $users->map(function($user) {
            $user->created_at_formated = $user->created_at->format('d M, Y');
            $user->unread_notification = $user->unread_notifications->count();
            $user->notification = $user->notification_switch ? '<span class="badge bg-green">On</span>' : '<span class="badge bg-red">Off</span>';
            $user->action = '<button class="btn btn-primary btn-sm" data-id="' . $user->id . '" data-toggle="modal" data-target="#edit-user" data-name="' . $user->name . '" data-email="' . $user->email . '" data-phone="' . $user->phone_number . '" data-notification_switch="' . $user->notification_switch . '">Edit</button> <a href="'.route('impersonate', $user->id).'" class="btn btn-info btn-sm">Impersonate</button>';
            return $user;
        });
    }

    public function allNotifiables()
    {
        return $this->user->where('notification_switch', 1)->get();
    }

}
