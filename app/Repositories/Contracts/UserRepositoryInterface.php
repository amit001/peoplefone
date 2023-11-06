<?php

namespace App\Repositories\Contracts;

use App\Repositories\Contracts\BaseRepositoryInterface;

interface UserRepositoryInterface extends BaseRepositoryInterface {
    public function paginated($start, $length, $sortColumn, $sortDirection, $searchValue, $countOnly = false);
    public function collectionModifier($users);
    public function allNotifiables();
}