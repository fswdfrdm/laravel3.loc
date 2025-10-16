<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stocks extends Model
{
    protected $fillable = [
        'date',
        'last_change_date', 
        'supplier_article',
        'tech_size',
        'barcode',
        'quantity',
        'is_supply',
        'is_realization',
        'quantity_full',
        'warehouse_name',
        'in_way_to_client',
        'in_way_from_client',
        'nm_id',
        'subject',
        'category',
        'brand',
        'sc_code',
        'price',
        'discount'
    ];

    protected $casts = [
        'date' => 'datetime',
        'last_change_date' => 'datetime',
        'is_supply' => 'boolean',
        'is_realization' => 'boolean'
    ];
}
