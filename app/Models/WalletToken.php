<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletToken extends Model
{
    public function token(): BelongsTo
    {
        return $this->belongsTo(Token::class);
    }
}
