<?php

namespace App\Models\Models;

use App\Events\PostCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;
//    protected $dispatchesEvents = [
//        'created' => PostCreated::class,
//    ];
}
