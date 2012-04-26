<?php

namespace KataBankOCR;

/**
 * @author Vadim Tyukov <brainreflex@gmail.com>
 * @since 4/20/12
 */
class Validator
{
  const VALID     = 0xDEADCAFEBABE;
  const INVALID   = 0xDEADBEEF;
  const ILLEGIBLE = 0xDEADDAD;

  /**
   * @param string $accountNumber
   *
   * @return boolean
   */
  public function validate($accountNumber)
  {
    if (false !== strpos($accountNumber, '?')) {
      return self::ILLEGIBLE;
    }

    $checksum = 0;
    foreach (array_reverse(str_split($accountNumber)) as $index => $number) {
      $checksum += ($index+1)*$number;
    }

    return $checksum % 11 == 0 ? self::VALID : self::INVALID;
  }
}
