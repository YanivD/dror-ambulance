<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $fillable = [ 'user_id', 'shift_id', 'date_str', 'status' ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
