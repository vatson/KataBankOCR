<?php

namespace KataBankOCR\Tests;

use KataBankOCR\Bank;

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
            ->will($this->returnValue(true))
        ;
        
        $bank = new Bank($parserStub, $validatorMock);

        $result = $bank->recognizeScan('scan');
        
        $this->assertContains($validEntry, $result);
    }

    /**
     * @test
     */
    public function shouldNotReturnInvalidEntries()
    {
        $invalidEntry = '123123';

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
            ->will($this->returnValue(false))
        ;

        $bank = new Bank($parserStub, $validatorMock);

        $result = $bank->recognizeScan('scan');

        $this->assertNotContains($invalidEntry, $result);
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