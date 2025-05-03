<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable = ['text', 'author', 'approved'];

    public function reactions(){
        return $this->hasMany(Reaction::class);
    }
}
