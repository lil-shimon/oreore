<?php

namespace App\Models;

use App\Models\WalletRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exchange extends Model
{
    public function walletRecords(): HasMany
    {
        return $this->hasMany(WalletRecord::class);
    }
}
