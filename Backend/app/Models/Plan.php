<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = ['tag', 'name', 'for', 'price', 'details','letter_count']; 
    
    public function userplan() 
    {
        return $this->hasMany(UserPlan::class);  
    } 
}
