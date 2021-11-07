<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Users extends Model
{
    use SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        'first_name',
        'last_name',
        'cpf_cnpj',
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
    ];

    public static function getRules()
    {
        return [
            'first_name' => 'trim|escape|capitalize',
            'last_name' => 'trim|escape|capitalize',
            'cpf_cnpj' => 'digit',
            'email' => 'trim|escape|lowercase',
            'fk_type' => 'digit',
        ];
    }

    public static function attributesToUpdate($fromRequest = [])
    {
        $editable = [
            'first_name',
            'last_name',
            'fk_type',
        ];

        if (empty($fromRequest))
            return [];

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
