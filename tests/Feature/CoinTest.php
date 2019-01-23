<?php

namespace Tests\Feature;

use Tests\TestCase;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Faker\Factory as Faker;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;

use App\Models\Coin;
use App\Models\CoinHistorical;

class CoinTest extends TestCase
{    
    use WithoutMiddleware;

    protected $token   = '';
    protected $faker;
    
    public function setUp()
    {
        parent::setUp();
        $this->faker = Faker::create();
    }

    /**
 	 * Return request headers needed to interact with the API.
	 *
	*/
	
	protected function headers()
	{
	    $headers = 	[	'Content-Type ' => 'application/json',
	    				'Accept' 		=> 'application/json'  ];

	    // Add JWT to header
	    if (!empty($this->token)) 
	    {
	    	JWTAuth::setToken($this->token);
	    	$headers['Authorization'] = 'Bearer '. $this->token;
	   	}
    	return $headers;
    }
    
    protected function authentication()
	{
		if(!empty($this->token)) return true;

		$endPoint  = '/api/v1/auth';
		$response = $this->call('POST', $endPoint, 
	   							[	
	   								'username' => 'saul.goodman',
	    						 	'password' => 'goodlawyer!17' 
	    						],
                                $this->headers());
                                                          
		// Get and save token 
		if($response->status() == 200 && count($this->token) > 0)
		{
			$this->token = json_decode($response->getContent())->token;
			return true;
		} 

		return false;
    }

    /** @test  */
    public function it_not_found_a_coin_detail()
    {
        // Request
        $endPoint   = '/api/v1/coins/1';
        $response   = $this->call('GET', $endPoint, [/*postdata*/], [/* cookies */], [/* files */], [/*headers*/]);
        
        // Asserts
        $response->assertStatus(500);
    }
    
    /** @test  */
    public function it_found_a_coin_detail()
    {
        // Create Data
        $coin       = factory(Coin::class)->create();

        // Request
        $endPoint   = '/api/v1/coins/' . $coin->id;
        $response   = $this->call('GET', $endPoint, [/*postdata*/], [/* cookies */], [/* files */], [/*headers*/]);
        
        // Asserts
        $response->assertStatus(200);
        $response->assertJson(['id'=> true]);
        $response->assertJsonStructure([
            "id",
            "name",
            "symbol",
            "logo",
            "rank",
            "price_usd",
            "price_btc",
            "24h_volume_usd",
            "market_cap_usd",
            "available_supply",
            "total_supply",
            "percent_change_1h",
            "percent_change_24h",
            "percent_change_7d",
            "created_at",
            "updated_at"
        ]);
    }

    /** @test  */
    public function it_get_coin_list()
    {
        // Create Data
        $randomTotal = 50;
        for($i=0; $i<$randomTotal; $i++)
            factory(Coin::class)->create(['rank' => $i]);

        // Request
        $endPoint   = '/api/v1/coins';
        $response   = $this->call('GET', $endPoint, [/*postdata*/], [/* cookies */], [/* files */], [/*headers*/]);
        
        // Asserts
        $response->assertStatus(200);
        $response->assertJson(['total'=> $randomTotal]);
        //print_r($response->getContent());
    }

    /** @test  */
    public function it_get_coin_list_page()
    {   
        // Create data
        $randomTotal = 50;
        $currentPage = 2;
        for($i=0; $i<$randomTotal; $i++)
            factory(Coin::class)->create(['rank' => $i]);
        
        // Request
        $endPoint   = '/api/v1/coins?page=' . $currentPage;
        $response   = $this->call('GET', $endPoint, [/*postdata*/], [/* cookies */], [/* files */], [/*headers*/]);
        
        // Asserts
        $response->assertStatus(200);
        $response->assertJson(['total'=> $randomTotal]);
        $response->assertJson(['current_page'=> $currentPage]);
        //print_r($response->getContent());
    }

    /** @test  */
    public function it_get_historical_coin_details()
    {
        // Create data
        $coin           = factory(Coin::class)->create();
        $dateNow        = Carbon::now('Europe/Madrid');
        $dateMonthAgo   = Carbon::now('Europe/Madrid')->subMonths(1);
        $period         = CarbonPeriod::create( $dateMonthAgo , $dateNow );

        foreach (array_reverse($period->toArray()) as $date) 
        {
            $percentdiff      = (mt_rand( -100, 100 ) / 10);
            $coin->price_usd *= (1 + $percentdiff / 100);
            CoinHistorical::create([
                'coin_id'       => $coin->id,
                'price_usd'     => $coin->price_usd,
                'snapshot_at'   => $date,
            ]); 
        }       

        // Request
        $endPoint   = '/api/v1/coins/' . $coin->id . '/historical/' . $dateMonthAgo->format('Y-m-d') . '/' . $dateNow->format('Y-m-d');
        $response   = $this->call('GET', $endPoint, [/*postdata*/], [/* cookies */], [/* files */], [/*headers*/]);
        
        // Asserts
        $response->assertStatus(200);
        $response->assertJson(['historical'=> true]);
    }
}
