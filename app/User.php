<?php

namespace App;

use App\Filters\UserFilters;
use App\Group;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The groups that belong to the user.
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'user_group');
    }

    /**
     * Fetch all relevant filters from the request.
     *
     * @return array
     */
    public function scopeFilter($query, UserFilters $filters)
    {
        return $filters->apply($query);
    }
}
