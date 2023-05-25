<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchTwitter extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';

    protected $collection = 'search_data';

}
