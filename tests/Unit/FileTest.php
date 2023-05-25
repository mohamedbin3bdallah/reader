<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    /**
     * A file test example.
     *
     * @return void
     */
    public function testPositiveTestcaseForAssertFileExists() 
    { 
        $filename = '../reader/storage/test.txt'; 
    
        // Assert function to test whether given 
        // file name exists or not 
        $this->assertFileExists( 
            $filename, 
            "filename doesn't exists"
        ); 
    } 
}