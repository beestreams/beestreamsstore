<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Browser\Pages\ProductIndexPage;
use Tests\Browser\Pages\CreateProductPage;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductsTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_create_a_new_product()
    {
        $this->browse(function($browser) {
            $browser->loginAs(factory(User::class)->create())
                ->visit(new CreateProductPage)
                ->fillOutForm(['name' => 'My Product'])
                ->click('#product-form__submit')
                ->on(new ProductIndexPage)
                ->assertSee('My Product');
        });
    }

    public function test_edit_an_existing_product()
    {
        
    }
}
