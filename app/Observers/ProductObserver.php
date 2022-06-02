<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Str;

class ProductObserver
{
    public function creating(Product $product)
    {
        $product->uuid = Str::uuid();
        $product->flag = Str::kebab($product->title);
    }

    public function updating(Product $product)
    {
        $product->flag = Str::kebab($product->title);
    }
}
