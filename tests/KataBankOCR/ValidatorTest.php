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
  public function shouldReturnTrueWhenEntryIsValid()
  {
    $validator = new Validator;
    $this->assertTrue($validator->validate('000000051'));
  }

  /**
   * @test
   */
  public function shouldReturnFalseWhenEntryIsInvalid()
  {
    $validator = new Validator;
    $this->assertFalse($validator->validate('000000001'));
  }
}
