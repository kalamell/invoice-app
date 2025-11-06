<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class DocumentItem extends Model
{
    protected $fillable = [
        'document_type',
        'document_id',
        'description',
        'quantity',
        'unit_price',
        'discount',
        'total',
        'sort_order',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function document(): MorphTo
    {
        return $this->morphTo();
    }
}
