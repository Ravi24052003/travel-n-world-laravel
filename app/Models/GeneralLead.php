<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralLead extends Model
{
    use HasFactory;

    protected $table = 'general_leads';

    protected $guarded = [];
}
