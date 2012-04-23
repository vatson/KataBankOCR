<?php

namespace KataBankOCR;

/**
 * @author Vadim Tyukov <brainreflex@gmail.com>
 * @since 4/19/12
 */
class Parser
{
    /**
     * @param string $entries
     */
    public function parse($entries)
    {
        $result = array();
        $lines = explode(PHP_EOL, $entries);
        while ($entry = array_splice($lines, 0, 4)) {
            $result[] = $this->parseEntry($entry);
        }
        
        return array_filter($result);
    }
  
    /**
     * @param string $entry
     * 
     * @return string
     */
    protected function parseEntry(array $entryLines)
    {
        $explodedEntry = array();

        foreach ($entryLines as $line) {
            foreach (str_split($line, $length = 3) as $index => $chunk) {
                if (false === array_key_exists($index, $explodedEntry)) {
                    $explodedEntry[$index] = $chunk;
                } else {
                    $explodedEntry[$index] .= PHP_EOL . $chunk;
                }
            }
        }

        $parsedEntry = '';
        foreach ($explodedEntry as $entryChar) {
            if (isset($this->dictionary[$entryChar])) {
                $parsedEntry .= $this->dictionary[$entryChar];
            }
        }

        return $parsedEntry;

    }
  
    protected $dictionary = array(
<<<PHP
 _ 
| |
|_|
   
PHP
        => 0,
<<<PHP
   
  |
  |
   
PHP
        => 1,
<<<PHP
 _ 
 _|
|_ 
   
PHP
        => 2,
<<<PHP
 _ 
 _|
 _|
   
PHP
        => 3,
<<<PHP
   
|_|
  |
   
PHP
        => 4,
<<<PHP
 _ 
|_ 
 _|
   
PHP
        => 5,
<<<PHP
 _ 
|_ 
|_|
   
PHP
        => 6,
<<<PHP
 _ 
  |
  |
   
PHP
        => 7,
<<<PHP
 _ 
|_|
|_|
   
PHP
        => 8,
<<<PHP
 _ 
|_|
 _|
   
PHP
        => 9,
    );
}
