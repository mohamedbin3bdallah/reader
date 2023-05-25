<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class DirectoryTest extends TestCase
{
    /**
     * A directory test example.
     *
     * @return void
     */
    public function testPositiveTestcaseForAssertDirectoryExists() 
    { 
        $directoryPath = '../reader/storage'; 
    
        // Assert function to test whether given
        // directory path exists or not
        $this->assertDirectoryExists(
            $directoryPath,
            "directoryPath exists"
        );
    } 
}