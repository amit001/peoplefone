<?php

namespace App\Repositories;

use App\Repositories\Contracts\NotificationRepositoryInterface;
use App\Models\Notification;

class NotificationRepository extends BaseRepository implements NotificationRepositoryInterface {
    public $notification;
    public function __construct(Notification $notification) {
        parent::__construct($notification);
        $this->notification = $notification;
    }

    public function paginated($start, $length, $sortColumn, $sortDirection, $searchValue, $countOnly = false) {
        $query = $this->notification->select('*');

        if (!empty($searchValue)) {
            $query->where(function($q) use ($searchValue) {
                $q->orWhere('text', 'LIKE', "%$searchValue%");
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
        $notifications = $query->get();
        $notifications = $this->collectionModifier($notifications);
        return $notifications;
    }

    public function collectionModifier($notification)
    {
        return $notification->map(function($notification) {
            $notification->created_at_formated = $notification->created_at->format('d M, Y');
            $notification->type_text = $notification->type_text;
            // $notification->action = '<button class="btn btn-primary btn-sm" data-id="' . $user->id . '" data-toggle="modal" data-target="#edit-user" data-name="' . $user->name . '" data-email="' . $user->email . '" data-phone="' . $user->phone_number . '" data-notification_switch="' . $user->notification_switch . '">Edit</button> <button class="btn btn-danger btn-sm" data-id="' . $user->id . '">Delete</button><a href="'.route('impersonate', $user->id).'" class="btn btn-info btn-sm">View</button>';
            return $notification;
        });
    }
}
