<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadQueryForCustomizeItinerary extends Model
{
    use HasFactory;

    protected $table = 'leads_query_for_customize_itinerary';

    protected $guarded = [];

        /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'places_to_cover' => 'array', // Automatically handles JSON encoding/decoding
    ];


    public function itinerary()
    {
        return $this->belongsTo(Itinerary::class);
    }

    public function user()
    {
        return $this->hasOneThrough(User::class, Itinerary::class);
    }
}
