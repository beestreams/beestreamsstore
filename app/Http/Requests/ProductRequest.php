<?php

namespace App\Http\Requests;

use App\Product;
use App\Files\File;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends BaseRequest
{
    private $product;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required'
        ];
    }

    public function persist()
    {
        $files = $this->getImages();
        $product = $this->getProduct();
        $product->setFiles($files);
        $product->fill($this->all());
        $product->save();
    }

    public function setProduct(Product $product)
    {
        $this->product = $product;
        return $this;
    }

    protected function getProduct()
    {
        return $this->product ?? new Product;
    }
}
