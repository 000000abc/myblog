<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Words extends Model
{
    protected $table='words';
    protected $fillable = [
       'id', 'content',
    ];
    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'create_time';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'update_time';


}
