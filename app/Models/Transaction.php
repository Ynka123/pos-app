<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = ['invoice', 'total', 'discount', 'pay', 'change'];

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}