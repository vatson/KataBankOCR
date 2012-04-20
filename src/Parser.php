<?php

namespace KataBankOCR;

/**
 * @author Vadim Tyukov <brainreflex@gmail.com>
 * @since 4/19/12
 */
class Parser
{
  public function parse($entry)
  {
    if (<<<PHP
 _  _  _  _  _  _  _  _  _
| || || || || || || || || |
|_||_||_||_||_||_||_||_||_|

PHP
    == $entry
    ) {
      return '000000000';
    }



    return '';
  }
}
