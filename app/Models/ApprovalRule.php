<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApprovalRule extends Model
{
    protected $fillable = [
        'company_id',
        'rule_type',
        'percentage',
        'specific_user_id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function specificUser()
    {
        return $this->belongsTo(User::class, 'specific_user_id');
    }
}
