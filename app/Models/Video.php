<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Video extends Model
{
    use HasFactory;

    protected $table = 'videos';

    protected $fillable = [
        'title',
        'description',
        'content',
    ];

    public function tags() : BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'video_tag');
    }

    public function pictures(): HasMany
    {
        return $this->hasMany(Picture::class, 'video_id', 'id');
    }

}
