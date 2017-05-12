<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    //na dinamičan način definiramo folder gdje se slike spremaju
    protected $uploads = '/images/';

    protected $fillable = ['file'];

    //ispisuje sliku
    public function getFileAttribute($photo){

        return $this->uploads . $photo;
    }
}
