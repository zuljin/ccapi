<?php

namespace Tests\Feature;

use Tests\TestCase;
use Carbon\Carbon;
use Faker\Factory as Faker;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;

use App\Models\Coin;
use App\Models\User;
use App\Models\UserTrade;

use App\Repositories\UserTradeRepository;

class UserTest extends TestCase
{    
    use WithoutMiddleware;

    protected $token   = '';
    protected $faker;
    
    public function setUp()
    {
        parent::setUp();
        $this->faker = Faker::create();
    }

    /** @test  */
    public function it_get_a_user_crypto_trade_resume()
    {
        // Create Date
        $user = factory(User::class)->create();
        $coin = factory(Coin::class)->create();

        $userTrade1 = UserTrade::create([
            'coin_id'   => $coin->id,
            'user_id'   => $user->id,
            'amount'    => ($coin->price_usd) * (mt_rand( 0, 50 ) / 5) ,    // totally random based on price_used
            'price_usd' => $coin->price_usd,
            'total_usd' => ($coin->price_usd) * (mt_rand( 0, 100 ) / 10),    // totally random based on price_used
            'notes'     => '',
            'traded_at' => Carbon::now()->subDays(rand(1, 180)),
        ]);   

        $userTrade2 = UserTrade::create([
            'coin_id'   => $coin->id,
            'user_id'   => $user->id,
            'amount'    => ($coin->price_usd) * (mt_rand( 0, 50 ) / 5) ,    // totally random based on price_used
            'price_usd' => $coin->price_usd,
            'total_usd' => ($coin->price_usd) * (mt_rand( 0, 100 ) / 10),    // totally random based on price_used
            'notes'     => '',
            'traded_at' => Carbon::now()->subDays(rand(1, 180)),
        ]);
        $portfolio = (new UserTradeRepository())->getPortfolio ( $user->id );
        //var_dump($portfolio);
        
        // Request
        $endPoint   = '/api/v1/user/' . $user->id . '/portfolio';
        $response   = $this->call('GET', $endPoint, [/*postdata*/], [/* cookies */], [/* files */], [/*headers*/]);
        $results    = json_decode($response->getContent(), true)[0];

        // Asserts
        $response->assertStatus(200);
        $this->assertEquals( $results['coin_id'], $coin->id);
        $this->assertEquals( $results['amount'], ( $userTrade1->amount + $userTrade2->amount ));
        $this->assertEquals( $results['price_usd'], ($userTrade1->price_usd + $userTrade2->price_usd ));
    }
    
    /** @test  */
    public function it_add_a_user_crypto_trade()
    {   
        // Create Date
        $user = factory(User::class)->create();
        $coin = factory(Coin::class)->create();

        // Request
        $endPoint   = '/api/v1/user/' . $user->id . '/trade'; // POST     
        $postData   = [     "coin_id"   => $coin->id,
                            "amount"    => 31.32,
                            "price_usd" => 32.323323,
                            "traded_at" => "2018-04-20T16:40:51.620Z",
                            "notes"     => "I want that lambo!" ];
        $response = $this->call('POST', $endPoint, $postData, [/* cookies */], [/* files */], []);
        
        // Asserts
        $response->assertStatus(201);
        $response->assertJson(['user_id'=> $user->id]);
        $response->assertJson(['coin_id'=> $coin->id]);
    }

}

