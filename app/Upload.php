<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Upload - Model for uploads table.
 * Mutator methods are used to encrypt and decrypt data column
 * stands for uploaded file content.
 * @package App
 */
class Upload extends Model
{
    protected $fillable = [
        'user_id', 'uuid', 'name',  'data',
    ];

    /**
     * Mutator to decrypt data column holds uploaded file.
     * @param $value
     * @return mixed
     */
    public function getDataAttribute($value) {
        return decrypt($value);
    }

    /**
     * Mutator to encrypt data column holds uploaded file.
     * @link: https://stefanzweifel.io/posts/how-to-encrypt-file-uploads-with-laravel
     * @param $value
     */
    public function setDataAttribute($value) {
        $this->attributes['data'] = encrypt($value);
    }

    /**
     * Many uploads belong to one use relationship.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
