<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','update_at'];

    public function tasks()
    {
        return $this->hasMany(Task::class,'client_id','id');
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'client_id','id');
    }
    public function user(){
        return $this->hasMany(User::class, 'user_id','id');
    }
}
