<?php

namespace App;

use function foo\func;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
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

/*
 * So, we can access the Phone model from our User.
 * Now, let's define a relationship on the Phone model that will let us access the User that owns the phone.
 * We can define the inverse of a hasOne relationship using the belongsTo method:
*/
    public function role(){
        return $this->belongsTo('App\Role');
    }

}