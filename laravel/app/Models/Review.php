<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['place_id', 'author_id', 'review'];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function author()
    {
        return $this->hasOne(User::class);
    }
}