<?php
namespace KataBankOCR;

/**
 * @author Kotlyar Maksim <kotlyar.maksim@gmail.com>
 * @since 5/23/12
 */
class ParsedEntry
{
    /**
     * @var array
     */
    protected $sourceChars = array();

    /**
     * @var array
     */
    protected $parsedChars = array();

    /**
     * @var string
     */
    protected $status;
    
    /**
     * @param string $index
     * @param string $sourceChar
     */
    public function setSourceChar($index, $sourceChar)
    {
        $this->sourceChars[$index] = $sourceChar;
    }
    
    /**
     * @param string $index
     * 
     * @return string
     */
    public function getSourceChar($index)
    {
        return $this->sourceChars[$index];
    }

    /**
     * @param string $index
     * @param string $parsedChar
     */
    public function setParsedChar($index, $parsedChar)
    {
        $this->parsedChars[$index] = $parsedChar;
    }

    /**
     * @param string $index
     *
     * @return string
     */
    public function getParsedChar($index)
    {
        return $this->parsedChars[$index];
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        $entryString = implode('', $this->parsedChars);
        if ($this->status) {
            $entryString .= " {$this->status}";
        }
        
        return $entryString;
    }
}