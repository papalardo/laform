<?php

namespace Papalardo\Laform\Tests\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'laform_users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'country'
    ];

    public function playlist()
    {
        return $this->belongsToMany(Music::class, 'laform_user_music');
    }

    public function avatar()
    {
        return $this->morphOne(Media::class, 'mediable')->where('ref', 'avatar');
    }

    public function photos()
    {
        return $this->morphMany(Media::class, 'mediable')->where('ref', 'photos');
    }

    public function carDocument()
    {
        return $this->morphOne(Media::class, 'mediable')->where('ref', 'car_document');
    }

    public function documents()
    {
        return $this->morphMany(Media::class, 'mediable')->where('ref', 'documents');
    }
}
