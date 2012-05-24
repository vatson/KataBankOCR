<?php

namespace KataBankOCR\Tests;

use KataBankOCR\Bank;
use KataBankOCR\Validator;

/**
 * @author Vadim Tyukov <brainreflex@gmail.com>
 * @since 4/19/12
 */
class BankTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldBeConstructedWithParserAndValidator()
    {
        new Bank(
            $this->createParserMock(),
            $this->createValidatorMock()
        );
    }

    /**
     * @test
     */
    public function shouldReturnValidEntries()
    {
        $validEntry = '000000051';

        $parserStub = $this->createParserMock();
        $parserStub
            ->expects($this->any())
            ->method('parse')
            ->will($this->returnValue(array($validEntry)))
        ;
        
        $validatorMock = $this->createValidatorMock();
        $validatorMock
            ->expects($this->once())
            ->method('validate')
            ->with($validEntry)
            ->will($this->returnValue(Validator::VALID))
        ;
        
        $bank = new Bank($parserStub, $validatorMock);

        $result = $bank->recognizeScan('scan');
        
        $this->assertContains($validEntry, $result);
    }

    /**
     * @test
     */
    public function shouldReturnInvalidEntriesWithStatus()
    {
        $invalidEntry = '123123';
        $invalidEntryWithStatus = $invalidEntry . ' ERR';

        $parserStub = $this->createParserMock();
        $parserStub
            ->expects($this->any())
            ->method('parse')
            ->will($this->returnValue(array($invalidEntry)))
        ;

        $validatorMock = $this->createValidatorMock();
        $validatorMock
            ->expects($this->once())
            ->method('validate')
            ->with($invalidEntry)
            ->will($this->returnValue(Validator::INVALID))
        ;

        $bank = new Bank($parserStub, $validatorMock);

        $result = $bank->recognizeScan('scan');

        $this->assertContains($invalidEntryWithStatus, $result);
    }
  
    /**
     * @test
     */
    public function shouldReturnIllegibleEntriesWithStatus()
    {
        $illegibleEntry = '123123?';
        $illegibleEntryWithStatus = $illegibleEntry . ' ILL';
  
        $parserStub = $this->createParserMock();
        $parserStub
          ->expects($this->any())
          ->method('parse')
          ->will($this->returnValue(array($illegibleEntry)))
        ;
  
        $validatorMock = $this->createValidatorMock();
        $validatorMock
          ->expects($this->any())
          ->method('validate')
          ->will($this->returnValue(Validator::ILLEGIBLE))
        ;
  
        $bank = new Bank($parserStub, $validatorMock);
  
        $result = $bank->recognizeScan('scan');
  
        $this->assertContains($illegibleEntryWithStatus, $result);
    }

    /**
     * @test
     *
     * @dataProvider provideIllegibleEntryWithOneQuestionChar
     */
    public function shouldCorrectlyGuessIllegibleEntryWithOneQuestionChar($illegibleEntry, $expectedEntry)
    {
        $parserStub = $this->createParserMock();
        $parserStub
            ->expects($this->any())
            ->method('parse')
            ->will($this->returnValue(array($illegibleEntry)))
        ;

        $validatorMock = $this->createValidatorMock();
        $validatorMock
            ->expects($this->any())
            ->method('validate')
            ->will($this->returnCallback(function($entry) use($expectedEntry) {
                return $entry == $expectedEntry ? Validator::VALID : Validator::ILLEGIBLE;
            }))
        ;

        $bank = new Bank($parserStub, $validatorMock);

        $result = $bank->recognizeScan('scan');
        
        $this->assertContains($expectedEntry, $result);
    }

    /**
     * @test
     */
    public function shouldNotGuessIllegibleEntryWithMoreThanOneQuestionChar()
    {
        $illegibleEntry = '?2?3123';
        $expectedEntry = '?2?3123 ILL';

        $parserStub = $this->createParserMock();
        $parserStub
            ->expects($this->any())
            ->method('parse')
            ->will($this->returnValue(array($illegibleEntry)))
        ;

        $validatorMock = $this->createValidatorMock();
        $validatorMock
            ->expects($this->at(0))
            ->method('validate')
            ->with($illegibleEntry)
            ->will($this->returnValue(Validator::ILLEGIBLE))
        ;

        $bank = new Bank($parserStub, $validatorMock);

        $result = $bank->recognizeScan('scan');

        $this->assertContains($expectedEntry, $result);
    }

//    /**
//     * @test
//     */
//    public function shouldNotGuessIllegibleEntry()
//    {
//
//    }

    public function provideIllegibleEntryWithOneQuestionChar()
    {
        return array(
            array('?23123', '523123'),
            array('52?123', '523123'),
            array('52312?', '523123'),
        );
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\KataBankOCR\Parser
     */
    protected function createParserMock()
        {
        return $this->getMock('KataBankOCR\Parser');
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\KataBankOCR\Validator
     */
    protected function createValidatorMock()
        {
        return $this->getMock('KataBankOCR\Validator');
    }
}