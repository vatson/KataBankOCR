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
  public function shouldReturnEmptyStringForEmptyEntry()
  {
    $parser = new Parser;
    $result = $parser->parse('');

    $this->assertInternalType('string', $result);
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

  public function provideEntryString()
  {
    return array(
      array(
<<<PHP
 _  _  _  _  _  _  _  _  _ 
| || || || || || || || || |
|_||_||_||_||_||_||_||_||_|
                           
PHP
        , '000000000'
      ),
      array(
<<<PHP
                           
  |  |  |  |  |  |  |  |  |
  |  |  |  |  |  |  |  |  |
                           
PHP
      , '111111111'
      ),
      array(
<<<PHP
 _  _  _  _  _  _  _  _  _ 
 _| _| _| _| _| _| _| _| _|
|_ |_ |_ |_ |_ |_ |_ |_ |_ 
                           
PHP
      , '222222222'
      ),
      array(
<<<PHP
 _  _  _  _  _  _  _  _  _ 
 _| _| _| _| _| _| _| _| _|
 _| _| _| _| _| _| _| _| _|
                           
PHP
      , '333333333'       
      ),
      array(
<<<PHP
                           
|_||_||_||_||_||_||_||_||_|
  |  |  |  |  |  |  |  |  |
                           
PHP
        , '444444444'
        ),
        array(
<<<PHP
 _  _  _  _  _  _  _  _  _ 
|_ |_ |_ |_ |_ |_ |_ |_ |_ 
 _| _| _| _| _| _| _| _| _|
                           
PHP
        , '555555555'
        ),
        array(
<<<PHP
 _  _  _  _  _  _  _  _  _ 
|_ |_ |_ |_ |_ |_ |_ |_ |_ 
|_||_||_||_||_||_||_||_||_|
                           
PHP
        , '666666666'
        ),
        array(
<<<PHP
 _  _  _  _  _  _  _  _  _ 
  |  |  |  |  |  |  |  |  |
  |  |  |  |  |  |  |  |  |
                           
PHP
        , '777777777'
        ),
        array(
<<<PHP
 _  _  _  _  _  _  _  _  _ 
|_||_||_||_||_||_||_||_||_|
|_||_||_||_||_||_||_||_||_|
                           
PHP
        , '888888888'
        ),
        array(
    <<<PHP
 _  _  _  _  _  _  _  _  _ 
|_||_||_||_||_||_||_||_||_|
 _| _| _| _| _| _| _| _| _|
                           
PHP
        , '999999999'
        ),
        array(
<<<PHP
    _  _     _  _  _  _  _ 
  | _| _||_||_ |_   ||_||_|
  ||_  _|  | _||_|  ||_| _| 
                           
PHP
        , '123456789'
        ),
    );
  }
}
