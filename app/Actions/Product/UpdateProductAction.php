<?php

namespace App\Actions\Product;

use App\Http\Requests\ProductRequest;
use App\Models\Product;

class UpdateProductAction
{
    private $request;
    private $product;

    public function __construct(ProductRequest $request, Product $product)
    {
        $this->request = $request;
        $this->product = $product;
    }

    public function execute()
    {
        $product = $this->product->update([
            'category_uuid' => $this->request->category_uuid,
            'title' => $this->request->title,
            'price' => $this->request->price,
            'description' => $this->request->description,
            'metadata' => $this->request->metadata,
        ]);
        
        abort_if(!$product, CODE_BAD_REQUEST, 'Unable to update product. Try again');

        return $product;
    }
}