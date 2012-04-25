<?php

namespace KataBankOCR\Tests;

use KataBankOCR\Parser;

/**
 * @author Vadim Tyukov <brainreflex@gmail.com>
 * @since 4/19/12
 */
class ParserTest extends \PHPUnit_Framework_TestCase
{
  /**
   * @test
   */
  public function shouldBeConstructedWithoutArguments()
  {
    new Parser;
  }

  /**
   * @test
   */
  public function shouldReturnEmptyArrayForEmptyEntries()
  {
    $parser = new Parser;
    $result = $parser->parse('');

    $this->assertInternalType('array', $result);
    $this->assertEmpty($result);
  }

  /**
   * @test
   *
   * @dataProvider provideEntryString
   */
  public function shouldParseOneEntry($entryString, $expectedResult)
  {
    $parser = new Parser;
    $result = $parser->parse($entryString);
    $this->assertEquals($expectedResult, $result);
  }

  /**
   * @test
   * 
   * @dataProvider provideMultipleEntries
   */
  public function shouldParseMultipleEntries($entriesString, $expectedResult)
  {
    $parser = new Parser;
    $result = $parser->parse($entriesString);
    $this->assertEquals($expectedResult, $result);
  }
  
  /**
   * @return array
   */
  public function provideMultipleEntries()
  {
    return array(
      array(
      <<<PHP
    _  _     _  _  _  _  _ 
  | _| _||_||_ |_   ||_||_|
  ||_  _|  | _||_|  ||_| _|
                           
 _  _  _  _  _     _  _    
|_||_|  ||_ |_ |_| _| _|  |
 _||_|  ||_| _|  | _||_   |
                           
PHP
       , array('123456789', '987654321')
      )
    );
  }
  
  /**
   * @return array
   */
  public function provideEntryString()
  {
    return array(
      array(
<<<PHP
 _  _  _  _  _  _  _  _  _ 
| || || || || || || || || |
|_||_||_||_||_||_||_||_||_|
                           
PHP
        , array('000000000')
      ),
      array(
<<<PHP
                           
  |  |  |  |  |  |  |  |  |
  |  |  |  |  |  |  |  |  |
                           
PHP
      , array('111111111')
      ),
      array(
<<<PHP
 _  _  _  _  _  _  _  _  _ 
 _| _| _| _| _| _| _| _| _|
|_ |_ |_ |_ |_ |_ |_ |_ |_ 
                           
PHP
      , array('222222222')
      ),
      array(
<<<PHP
 _  _  _  _  _  _  _  _  _ 
 _| _| _| _| _| _| _| _| _|
 _| _| _| _| _| _| _| _| _|
                           
PHP
      , array('333333333')
      ),
      array(
<<<PHP
                           
|_||_||_||_||_||_||_||_||_|
  |  |  |  |  |  |  |  |  |
                           
PHP
        , array('444444444')
        ),
        array(
<<<PHP
 _  _  _  _  _  _  _  _  _ 
|_ |_ |_ |_ |_ |_ |_ |_ |_ 
 _| _| _| _| _| _| _| _| _|
                           
PHP
        , array('555555555')
        ),
        array(
<<<PHP
 _  _  _  _  _  _  _  _  _ 
|_ |_ |_ |_ |_ |_ |_ |_ |_ 
|_||_||_||_||_||_||_||_||_|
                           
PHP
        , array('666666666')
        ),
        array(
<<<PHP
 _  _  _  _  _  _  _  _  _ 
  |  |  |  |  |  |  |  |  |
  |  |  |  |  |  |  |  |  |
                           
PHP
        , array('777777777')
        ),
        array(
<<<PHP
 _  _  _  _  _  _  _  _  _ 
|_||_||_||_||_||_||_||_||_|
|_||_||_||_||_||_||_||_||_|
                           
PHP
        , array('888888888')
        ),
        array(
    <<<PHP
 _  _  _  _  _  _  _  _  _ 
|_||_||_||_||_||_||_||_||_|
 _| _| _| _| _| _| _| _| _|
                           
PHP
        , array('999999999')
        ),
        array(
<<<PHP
    _  _     _  _  _  _  _ 
  | _| _||_||_ |_   ||_||_|
  ||_  _|  | _||_|  ||_| _| 
                           
PHP
        , array('123456789')
        ),
    );
  }
}
