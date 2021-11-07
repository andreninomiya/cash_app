<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserBalancesHistorical extends Model
{
    use SoftDeletes;

    protected $table = 'user_balances_historical';

    protected $fillable = [
        'balance',
    ];

    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [
        'deleted_at',
    ];

    public static function getRules()
    {
        return [
            'balance' => 'trim|escape',
        ];
    }

    public static function attributesToUpdate($fromRequest = [])
    {
        $editable = [
            'balance',
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
