<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    protected $fillable = ['quote_id', 'emoji'];

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }
}
