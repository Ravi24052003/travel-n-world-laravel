<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
    use HasFactory;

    protected $table = 'itineraries';

    protected $guarded = [];

    protected $casts = [
        'days_information' => 'array',
        'hotel_details' => 'array',
        'duration' => 'array',
        'selected_destination' => 'array',
        'itinerary_theme' => 'array',
        'destination_images' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
