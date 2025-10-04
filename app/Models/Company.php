<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'currency',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function approvalRules()
    {
        return $this->hasMany(ApprovalRule::class);
    }
}
