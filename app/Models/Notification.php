<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class);
    }

    public function getTypeTextAttribute()
    {
        switch ($this->type) {
            case 0:
                return 'Marketing';
            case 1:
                return 'Invoices';
            case 2:
                return 'System';
            default:
                return 'Unknown';
        }
    }
}
