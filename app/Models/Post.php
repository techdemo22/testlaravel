<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'post_title',
		'post_content',
		'post_status',
		'created_at',
		'updated_at',
		'post_posted_by',
		'post_future_date',	
    ];

}
