<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function company(){
        return $this->hasOne(Company::class);
    }

    public function itinerary(){
        return $this->hasMany(Itinerary::class);
    }

    public function blog(){
        return $this->hasMany(Blog::class);
    }

    public function leadPhoneEmail()
    {
    return $this->hasManyThrough(LeadPhoneEmail::class, Itinerary::class);
    }

    public function leadQueryForCustomizeItinerary()
    {
    return $this->hasManyThrough(LeadQueryForCustomizeItinerary::class, Itinerary::class);
    }
}
