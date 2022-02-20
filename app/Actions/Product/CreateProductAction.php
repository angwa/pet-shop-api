<?php

namespace App\Actions\Product;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\User;
use Str;

class CreateProductAction
{
    private $request;

    /**
     * @param ProductRequest $request
     */
    public function __construct(ProductRequest $request)
    {
        $this->request = $request;
    }

    /**
     * @return object
     */
    public function execute(): object
    {
        $product = Product::create([
            'uuid' => Str::orderedUuid(),
            'category_uuid' => $this->request->category_uuid,
            'title' => $this->request->title,
            'price' => $this->request->price,
            'description' => $this->request->description,
            'metadata' => $this->request->metadata,
        ]);

        abort_if(!$product, CODE_BAD_REQUEST, 'Unable to create product. Try again');

        return $product;
    }
}
