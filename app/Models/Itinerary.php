<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
    use HasFactory;

    protected $table = 'itineraries';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
