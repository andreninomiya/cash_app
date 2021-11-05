<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Users extends Model
{
    use SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'cpf',
        'email',
        'password',
        'fk_type',
    ];

    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [
        'password',
        'deleted_at',
        'pivot'
    ];

    public static function getRules()
    {
        return [
            'name' => 'trim|escape',
            'cpf' => 'trim|escape',
            'email' => 'trim|escape|lowercase'
        ];
    }

    public static function attributesToUpdate($fromRequest = [])
    {
        $editable = [
            'name',
            'fk_type',
        ];

        if (empty($fromRequest))
            return $editable;

        // Setting only attributes from Update
        $attributesToUpdate = [];
        foreach ($fromRequest as $column => $value) {
            if (in_array($column, $editable)) {
                $attributesToUpdate[$column] = $value;
            }
        }

        return $attributesToUpdate;
    }
}
