<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadPhoneEmail extends Model
{
    use HasFactory;

    protected $table = 'leads_phone_email';

    protected $guarded = [];

    public function itinerary()
    {
        return $this->belongsTo(Itinerary::class);
    }

    public function user()
    {
        return $this->hasOneThrough(User::class, Itinerary::class);
    }
}
