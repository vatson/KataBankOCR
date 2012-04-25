<?php
namespace KataBankOCR;

/**
 * @author Kotlyar Maksim <kotlyar.maksim@gmail.com>
 * @since 4/25/12
 */
class Bank
{
    /**
     * @var Parser
     */
    protected $parser;
    
    /**
     * @var Validator
     */
    protected $validator;
    
    /**
     * @param Parser $parser
     * @param Validator $validator
     */
    public function __construct(Parser $parser, Validator $validator)
    {
        $this->parser = $parser;
        $this->validator = $validator;
    }
    
    /**
     * @param string $scan
     * @return array
     */
    public function recognizeScan($scan)
    {
        return array_filter($this->parser->parse($scan), array($this->validator, 'validate'));
    }
}