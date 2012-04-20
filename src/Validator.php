<?php

namespace KataBankOCR;

/**
 * @author Vadim Tyukov <brainreflex@gmail.com>
 * @since 4/20/12
 */
class Validator
{
  /**
   * @param string $accountNumber
   *
   * @return boolean
   */
  public function validate($accountNumber)
  {
    $checksum = 0;
    foreach (array_reverse(str_split($accountNumber)) as $index => $number) {
      $checksum += ($index+1)*$number;
    }

    return $checksum % 11 == 0;
  }
}
