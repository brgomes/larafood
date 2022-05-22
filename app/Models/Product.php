<?php

namespace App\Models;

use App\Tenant\Traits\TenantTrait;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use TenantTrait;

    protected $fillable = ['title', 'flag', 'price', 'description', 'image'];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function categoriesAvailable($filter = null)
    {
        $categories = Category::whereNotIn('id', function ($query) {
            $query->select('category_product.category_id')
                ->from('category_product')
                ->whereRaw("category_product.product_id = {$this->id}");
        })
        ->where(function ($queryFilter) use ($filter) {
            if (isset($filter)) {
                $queryFilter->where('categories.name', 'LIKE', "%{$filter}%");
            }
        })
        ->paginate();

        return $categories;
    }
}
