<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Message;



class Seller extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'name',
    //     'user_name',
    //     'email',
    //     'password',
    // ];

     protected $guarded = [];

    protected $guard = 'sellers';


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function gigs()
    {
    	return $this->hasMany(Gig::class);
    }

    public function msg()
    {
        return $this->belongsTo(MessagePerson::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function messages(){
        return $this->hasMany(Message::class, 'user_id', 'id');
    }

}
