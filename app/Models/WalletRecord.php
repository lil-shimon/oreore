<?php

namespace App\Models;

use App\Models\WalletToken;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WalletRecord extends Model
{
    public function walletTokens(): HasMany
    {
        return $this->hasMany(WalletToken::class);
    }
}
