<?php

namespace KataBankOCR\Tests;

use KataBankOCR\Validator;

/**
 * @author Vadim Tyukov <brainreflex@gmail.com>
 * @since 4/20/12
 */
class ValidatorTest extends \PHPUnit_Framework_TestCase
{
  /**
   * @test
   */
  public function couldBeConstructedWithoutArgs()
  {
    new Validator;
  }

  /**
   * @test
   */
  public function shouldReturnValidStatusWhenEntryIsValid()
  {
    $validator = new Validator;
    $this->assertSame(Validator::VALID, $validator->validate('000000051'));
  }

  /**
   * @test
   */
  public function shouldReturnInvalidStatusWhenEntryIsInvalid()
  {
    $validator = new Validator;
    $this->assertSame(Validator::INVALID, $validator->validate('000000001'));
  }
  
  /**
   * @test
   */
  public function shouldReturnIllegibleStatusWhenEntryHasQuestionChar()
  {
    $validator = new Validator;
    $this->assertSame(Validator::ILLEGIBLE, $validator->validate('00000?000'));
  }
}
