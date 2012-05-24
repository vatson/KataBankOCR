<?php
namespace KataBankOCR\Tests;

use KataBankOCR\ParsedEntry;

/**
 * @author Kotlyar Maksim <kotlyar.maksim@gmail.com>
 * @since 5/23/12
 */
class ParsedEntryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldBeConstructedWithoutAnyArguments()
    {
        new ParsedEntry();
    }
    
    /**
     * @test
     */
    public function shouldAllowSetSourceCharWithIndex()
    {
        $entry = new ParsedEntry();
        
        $entry->setSourceChar(
            $index = 7,
            $sourceChar = 'foo'
        );
    }

    /**
     * @test
     */
    public function shouldAllowGetSourceCharByIndex()
    {
        $entry = new ParsedEntry();

        $entry->setSourceChar(
            $index = 7,
            $sourceChar = 'foo'
        );
        
        $this->assertEquals($sourceChar, $entry->getSourceChar($index));
    }

    /**
     * @test
     */
    public function shouldAllowSetParsedCharWithIndex()
    {
        $entry = new ParsedEntry();

        $entry->setParsedChar(
            $index = 5,
            $parsedChar = 1
        );
    }

    /**
     * @test
     */
    public function shouldAllowGetParsedCharByIndex()
    {
        $entry = new ParsedEntry();

        $entry->setParsedChar(
            $index = 5,
            $parsedChar = 2
        );

        $this->assertEquals($parsedChar, $entry->getParsedChar($index));
    }
    
    /**
     * @test
     */
    public function couldBeConvertedToStringAsStringOfParsedChars()
    {
        $expectedParsedEntry = '125';
        
        $entry = new ParsedEntry();
        
        $entry->setParsedChar($index = 0, $parsedChar = 1);
        $entry->setParsedChar($index = 1, $parsedChar = 2);
        $entry->setParsedChar($index = 5, $parsedChar = 5);
        
        $this->assertEquals($expectedParsedEntry, (string) $entry);
    }
}