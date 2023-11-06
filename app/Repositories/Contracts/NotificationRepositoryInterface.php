<?php

namespace App\Repositories\Contracts;

use App\Repositories\Contracts\BaseRepositoryInterface;

interface NotificationRepositoryInterface extends BaseRepositoryInterface {
    public function paginated($start, $length, $sortColumn, $sortDirection, $searchValue, $countOnly = false);
    public function collectionModifier($notification);
}