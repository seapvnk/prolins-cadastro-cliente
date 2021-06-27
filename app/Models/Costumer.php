<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Costumer extends Model
{
    use HasFactory;
    
    public $timestamps  = false;

    protected $fillable = [
        'name', 
        'email', 
        'address', 
        'number', 
        'complement', 
        'zip', 
        'district', 
        'city',
        'state'
    ];

    public function user()
    {
        return User::find($this->user_id);
    }

    public function attachItsUser(User $user)
    {
        $this->user_id = $user->id;
    }

}
