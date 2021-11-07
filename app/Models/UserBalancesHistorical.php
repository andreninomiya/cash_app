<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserBalancesHistorical extends Model
{
    use SoftDeletes;

    protected $table = 'user_balances_historical';

    protected $fillable = [
        'fk_user',
        'fk_balance',
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
            'fk_user' => 'digit',
            'fk_balance' => 'digit',
            'balance' => 'trim|escape',
        ];
    }
}
