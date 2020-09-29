<?php

namespace Papalardo\Laform\Tests\Models;

use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    protected $table = 'laform_musics';

    protected $fillable = [
        'name',
        'album'
    ];
}
