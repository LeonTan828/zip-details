<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Utilities\ZipCodeAccessor;
use App\Exceptions\InvalidZipCodeInputException;
use App\Exceptions\NoDistanceInputException;

class ZipCodeAccessorTest extends TestCase
{
    public function testGetZipDetailApiThrowInvalidZipCodeInputExceptionWhenInputIsNotNumeric() {
        $classUnderTest = new ZipCodeAccessor();
        $this->expectException(InvalidZipCodeInputException::class);
        $classUnderTest->getZipDetailAPI('qwert');    
    }

    public function testZipDetailApiReturnNonEmptyResultWhenZipCodeIsValid() {
        $classUnderTest = new ZipCodeAccessor();
        $result = $classUnderTest->getZipDetailAPI('53703'); 
        $this->assertNotNull($result);
    }

    public function testFindZipCloseMatchApiThrowInvalidZipCodeInputExceptionWhenInputIsNotNumeric() {
        $classUnderTest = new ZipCodeAccessor();
        $this->expectException(InvalidZipCodeInputException::class);
        $classUnderTest->findZipCloseMatchAPI(array('123', '53706'), '10', 'miles');    
    }

    public function testFindZipCloseMatchApiThrowNoDistanceInputExceptionWhenInputHasNoDistance() {
        $classUnderTest = new ZipCodeAccessor();
        $this->expectException(NoDistanceInputException::class);
        $classUnderTest->findZipCloseMatchAPI(array('53703', '53706'), null, 'miles');  
    }

    public function testFindZipCloseMatchApiReturnNonEmptyResultWhenZipCodeIsValid() {
        $classUnderTest = new ZipCodeAccessor();
        $result = $classUnderTest->findZipCloseMatchAPI(array('53703', '53706'), 10, 'miles'); 
        $this->assertNotNull($result);
    }
    
}