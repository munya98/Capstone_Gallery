<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GuestTest extends TestCase
{
    /**
     * Test About Page
     *
     * @return void
     */
    public function testAbout()
    {
        $this->visit('/about')
        	 ->click('About')
        	 ->seePageIs('/about');
    }

    /**
     * Test Browse Page
     *
     * @return void
     */
    public function testBrowse(){
    	$this->visit('/')
    		 ->click('Browse')
    		 ->seePageIs('/browse');
    }

    /**
     * Test Upload Page
     *
     * @return void
     */
    public function textUpload(){
    	$this->visit('/')
    		 ->click('Upload')
    		 ->seePageIs('/login')
    }
}
