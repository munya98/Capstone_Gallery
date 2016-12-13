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
    public function testUpload(){
    	$this->visit('/')
    		 ->click('Upload')
    		 ->seePageIs('/login');
    }

     /**
     * Test Login Page
     *
     * @return void
     */
    public function testLogin(){
        $this->visit('/')
             ->click('Login')
             ->seePageIs('/login');
    }
     /**
     * Test Register Page
     *
     * @return void
     */
    public function testSignUp(){
        $this->visit('/')
             ->click('Sign Up')
             ->seePageIs('/register');
    }

    //Pagination Sorting Links
    /**
     * Test Latest Link
     *
     * @return void
     */
    public function testLatest(){
        $this->visit('/')
             ->click('Latest')
             ->seePageIs('/?sort=latest');
    }
    /**
     * Test Oldest Link
     *
     * @return void
     */
    public function testOldest(){
        $this->visit('/')
             ->click('Oldest')
             ->seePageIs('/?sort=old');
    }
    /**
     * Test Most Viewed Link
     *
     * @return void
     */
    public function testMostViewed(){
        $this->visit('/')
             ->click('Most Viewed')
             ->seePageIs('/?sort=popular');
    }
    
    //Simple search images
    public function testSearch(){
        $this->visit('/search?search=abc')
             ->see('Could not find any images matching');
    }

    //Simple search images
    public function testSearch1(){
        $this->visit('/search?search=ric')
             ->see('Images matching');
    }
    public function testUserLogin(){
        $this->visit('/')
             ->click('/login')
             ->type('Admin', 'username')
             ->type('admin', 'password');
    }

}
