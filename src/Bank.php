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
     * @var array
     */
    protected $statusMap = array(
      Validator::VALID      => '',
      Validator::INVALID    => 'ERR',
      Validator::ILLEGIBLE  => 'ILL',
    );
  
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
        $accounts = $this->parser->parse($scan);
        foreach ($accounts as &$account) {
          $status = $this->statusMap[$this->validator->validate($account)];
          $account .= $status ? ' '.$status : '';
        }

        return $accounts;
    }
}