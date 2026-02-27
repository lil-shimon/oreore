<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WalletRecord extends Model
{
    protected $fillable = ['exchange_id'];

    public function walletTokens(): HasMany
    {
        return $this->hasMany(WalletToken::class);
    }
}
