<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $fillable = [
        'user_id', 'uuid', 'name',  'data',
    ];

    /**
     * Mutator to decrypt
     * @param $value
     * @return mixed
     */
    public function getDataAttribute($value) {
        return decrypt($value);
    }

    /**
     * Mutator to encrypt
     * // @link: https://stefanzweifel.io/posts/how-to-encrypt-file-uploads-with-laravel
     * @param $value
     */
    public function setDataAttribute($value) {
        $this->attributes['data'] = encrypt($value);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
