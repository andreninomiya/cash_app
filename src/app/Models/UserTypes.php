<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserTypes extends Model
{
    use SoftDeletes;

    protected $table = 'user_types';

    protected $fillable = [
        'description',
    ];

    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [
        'deleted_at',
    ];

    // Formata valores com o Sanitizer
    public static function getRules()
    {
        return [
            'description' => 'trim|escape',
        ];
    }

    public static function attributesToUpdate($fromRequest = [])
    {
        $editable = [
            'description',
        ];

        if (empty($fromRequest))
            return $editable;

        // Configura apenas atributos de Update
        $attributesToUpdate = [];
        foreach ($fromRequest as $column => $value) {
            if (in_array($column, $editable)) {
                $attributesToUpdate[$column] = $value;
            }
        }

        return $attributesToUpdate;
    }
}
