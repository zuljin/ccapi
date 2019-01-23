<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Default preparation for each test
    */

    public function setUp()
    {
        parent::setUp();
        $this->prepareForTests();
    }
    
    /**
     * Migrates the database
     * This will cause the tests to run quickly.
    */

    private function prepareForTests()
    {
        \Artisan::call('migrate');
    }

    public function tearDown()
    {
		$this->mock 	= null;
		$this->mainAPP 	= null;
        parent::tearDown();
    }
    
}
