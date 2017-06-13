<?php 
namespace App\Adapters;

use Illuminate\Database\Eloquent\Collection;

class VueAdapter
{
    private $collection;

    
    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    public function asProducts()
    {
        // dd($this->collection);
        foreach ($this->collection as $product) {
            // $product->images[] = 'pr';
        }
        return $this->collection;
    }
}
