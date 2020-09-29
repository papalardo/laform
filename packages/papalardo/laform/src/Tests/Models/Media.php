<?php

namespace Papalardo\Laform\Tests\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'laform_media';

    protected $fillable = [
        'link',
        'ref'
    ];

    protected $appends = ['url'];

    public function mediable() 
    {
        return $this->morphTo();
    }

    public function getUrlAttribute()
    {
        return $this->attributes['link'];
    }
}
