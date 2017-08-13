<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\LoginPage;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuthTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_user_is_able_to_login()
    {
        
        $this->browse(function (Browser $browser) {
            $user = factory (User::class)->create();
            $browser->visit(new LoginPage)
                    ->loginAsUser($user)
                    ->assertSee("Welcome {$user->name}");
        });
    }
}
