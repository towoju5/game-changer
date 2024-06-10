<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    
    protected $fillable = ['customer_name', 'user_id', 'customer_email', 'total'];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public static function boot() : void
    {
        parent::boot();
        self::saving(function($invoice) {
            if(Invoice::count() < 1) {
                $invoice->id = 100010;
            }
        });
    }
}
