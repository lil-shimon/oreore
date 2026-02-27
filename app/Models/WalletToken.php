<?php

namespace App\Models;

use App\Models\Token;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletToken extends Model
{
    public function tokens(): BelongsTo
    {
        return $this->belongsTo(Token::class);
    }
}
