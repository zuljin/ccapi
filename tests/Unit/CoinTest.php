<?php namespace Tests\Unit;

use Tests\TestCase;
use Faker\Factory as Faker;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Models\Coin;
use App\Repositories\CoinRepository;
use App\Repositories\CoinHistoricalRepository;

class CoinTest extends TestCase
{
    protected $faker;
    
    public function setUp()
    {
        parent::setUp();
        $this->faker = Faker::create();
    }

    /** @test */
    public function it_can_create()
    {
        $coin   = factory(Coin::class)->make();
        $this->assertInstanceOf(Coin::class, $coin);
    }

    /** @test */
    public function it_can_get_a_right_fields() 
    { 
        $data = [
            'name'                  => $this->faker->name,
            'symbol'                => str_random(3),
            'logo'                  => '',
            'rank'                  => $this->faker->unique()->randomDigitNotNull(),
            'price_usd'             => $this->faker->randomFloat(20, -1000, 5000),
            'price_btc'             => null,
            '24h_volume_usd'        => $this->faker->randomFloat(20, -1000, 5000),
            'market_cap_usd'        => $this->faker->randomFloat(20, -1000, 5000),
            'available_supply'      => $this->faker->randomFloat(20, -1000, 5000),
            'total_supply'          => $this->faker->randomFloat(20, -1000, 5000),
            'percent_change_1h'     => $this->faker->randomFloat(3, -100, 100),
            'percent_change_24h'    => $this->faker->randomFloat(3, -100, 100),
            'percent_change_7d'     => $this->faker->randomFloat(3, -100, 100),
        ];

        $coin = Coin::create( $data );
        $this->assertInstanceOf(Coin::class, $coin);
        $this->assertEquals($data['name'],                  $coin->name);
        $this->assertEquals($data['symbol'],                $coin->symbol);
        $this->assertEquals($data['logo'],                  $coin->logo);
        $this->assertEquals($data['rank'],                  $coin->rank);
        $this->assertEquals($data['price_usd'],             $coin->price_usd);
        $this->assertEquals($data['price_btc'],             $coin->price_btc);
        $this->assertEquals($data['24h_volume_usd'],        $coin->{'24h_volume_usd'});
        $this->assertEquals($data['market_cap_usd'],        $coin->market_cap_usd);
        $this->assertEquals($data['available_supply'],      $coin->available_supply);
        $this->assertEquals($data['percent_change_1h'],     $coin->percent_change_1h);
        $this->assertEquals($data['percent_change_24h'],    $coin->percent_change_24h);
        $this->assertEquals($data['percent_change_7d'],     $coin->percent_change_7d);
  
    }

    /** @test */
    public function it_can_show_the_coin()
    {
        $coin   = factory(Coin::class)->create();
        $found  = (new CoinRepository())->getById( $coin->id );

        $this->assertInstanceOf(Coin::class, $coin);
        $this->assertInstanceOf(Coin::class, $found);

        $this->assertEquals( $coin->name,               $found->name);
        $this->assertEquals( $coin->symbol,             $found->symbol);
        $this->assertEquals( $coin->logo,               $found->logo);
        $this->assertEquals( $coin->rank,               $found->rank);
        $this->assertEquals( $coin->price_usd,          $found->price_usd);
        $this->assertEquals( $coin->price_btc,          $found->price_btc);
        $this->assertEquals( $coin->{'24h_volume_usd'}, $found->{'24h_volume_usd'});
        $this->assertEquals( $coin->market_cap_usd,     $found->market_cap_usd);
        $this->assertEquals( $coin->available_supply,   $found->available_supply);
        $this->assertEquals( $coin->percent_change_1h,  $found->percent_change_1h);
        $this->assertEquals( $coin->percent_change_24h, $found->percent_change_24h);
        $this->assertEquals( $coin->percent_change_7d,  $found->percent_change_7d);
    }
}