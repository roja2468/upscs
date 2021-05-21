<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VideoTypes extends Model
{
	use SoftDeletes;
	protected $table = 'video_types';
    protected $fillable = [
        'vid_id', 'videotype_name','vidtype_status'
    ];
}