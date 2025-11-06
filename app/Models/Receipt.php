<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receipt extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'shop_id',
        'customer_id',
        'invoice_id',
        'document_number',
        'issue_date',
        'amount',
        'payment_method',
        'payment_reference',
        'notes',
        'sent_at',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'sent_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
