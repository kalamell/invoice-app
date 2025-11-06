<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShopSetting extends Model
{
    protected $fillable = [
        'shop_id',
        'document_prefix',
        'document_number',
        'primary_color',
        'secondary_color',
        'font_family',
        'footer_text',
        'show_tax',
        'tax_rate',
        'line_channel_token',
        'promptpay_id',
        'promptpay_name',
    ];

    protected $casts = [
        'show_tax' => 'boolean',
        'tax_rate' => 'decimal:2',
    ];

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function getNextDocumentNumber(): string
    {
        $number = str_pad($this->document_number, 5, '0', STR_PAD_LEFT);
        $this->increment('document_number');
        return $this->document_prefix . '-' . $number;
    }
}
