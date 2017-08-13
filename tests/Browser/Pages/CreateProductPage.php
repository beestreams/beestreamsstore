<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Illuminate\Http\UploadedFile;
use Laravel\Dusk\Page as BasePage;

class CreateProductPage extends BasePage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/products/create';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url());
    }

    public function fillOutForm($browser, Array $productDetails = [])
    {
        $standardValues = [
            'name' => 'Testproduct',
            'description' => 'This is a description of the product',
            'width' => 200,
            'height' => 300,
            'quantity' => 10,
            'images' => [
                UploadedFile::fake()->image('imageOne.jpg'),
                UploadedFile::fake()->image('imageTwo.jpg'),
            ],
        ];

        $productDetails = array_merge($standardValues, $productDetails);
        $browser->type('@name', $productDetails['name'])
            ->type('@description', $productDetails['description'])
            ->type('@width', $productDetails['width'])
            ->type('@height', $productDetails['height'])
            ->type('@quantity', $productDetails['quantity']);

        foreach ($productDetails['images'] as $key => $image) {
            $browser->attach("images[{$key}]", $image);
            $browser->click("@addImage");
       }
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@addImage' => '#gallery-creator__add-image',
            '@description' => 'description',
            '@name' => 'name',
            '@width' => 'width',
            '@height' => 'height',
            '@quantity' => 'quantity',
            
        ];
    }
}
