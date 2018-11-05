<?php

namespace App;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable=[
      'user_id', 'message'
    ];

    protected $appends=[
      'user'
    ];
    public function getUserAttribute(){
        return User::where('id', $this->user_id)->first();
    }
}
