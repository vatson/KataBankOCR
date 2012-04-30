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
        $illegibleEntry = '123123';
        $illegibleEntryWithStatus = $illegibleEntry . ' ILL';
  
        $parserStub = $this->createParserMock();
        $parserStub
          ->expects($this->any())
          ->method('parse')
          ->will($this->returnValue(array($illegibleEntry)))
        ;
  
        $validatorMock = $this->createValidatorMock();
        $validatorMock
          ->expects($this->once())
          ->method('validate')
          ->with($illegibleEntry)
          ->will($this->returnValue(Validator::ILLEGIBLE))
        ;
  
        $bank = new Bank($parserStub, $validatorMock);
  
        $result = $bank->recognizeScan('scan');
  
        $this->assertContains($illegibleEntryWithStatus, $result);
    }

    /**
     * @test
     */
    public function shouldCorrectlyGuessIllegibleEntryWithOneQuestionChar()
    {
        $illegibleEntry = '?23123';
        $validEntry = '523123';
        
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
        
        $this->assertContains($validEntry, $result);
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