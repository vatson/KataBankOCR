<?php

namespace KataBankOCR\Tests\Integration;

use KataBankOCR\Validator;
use KataBankOCR\Parser;
use KataBankOCR\Bank;

/**
 * @author Vadim Tyukov <brainreflex@gmail.com>
 * @since 4/26/12
 */
class BankTest extends \PHPUnit_Framework_TestCase
{
  /**
   * @test
   * 
   * @dataProvider provideScan
   */
  public function shouldRecognizeValidScan($scan, $expectedResult)
  {
    $validator = new Validator;
    $parser = new Parser;
    $bank = new Bank($parser, $validator);
    
    $this->assertEquals($expectedResult, $bank->recognizeScan($scan));
  }
  
  /**
   * @return array
   */
  public function provideScan()
  {
    return array(
      array(
        <<<PHP
 _  _  _  _  _  _  _  _    
| || || || || || || ||_   |
|_||_||_||_||_||_||_| _|  |
                           
 _  _  _  _  _     _  _    
|_||_|  ||_ |_ |_| _| _|  |
 _||_|  ||_| _|  | _||_   |
                           
    _  _  _  _  _  _     _ 
|_||_|| || ||_   |  |  | _ 
  | _||_||_||_|  |  |  | _|
                           
PHP
      , array('000000051', '987654321 ERR', '49006771? ILL')
      )
    );
  }
}
