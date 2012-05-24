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
        Validator::INVALID    => ' ERR',
        Validator::ILLEGIBLE  => ' ILL',
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
            //BC
            $account = (string) $account;
            
            $status = $this->validator->validate($account);
            if ($status == Validator::ILLEGIBLE) {
                $account  = $this->guessIllegibleAccount($account);
            } else {
                $account .= $this->statusMap[$status];
            }
        }

        return $accounts;
    }

    protected function guessIllegibleAccount($account)
    {
        $modifiedAccount = $account;
        
        $position = strpos($account, '?');
        foreach(range(0,9) as $number) {
            $modifiedAccount[$position] = $number;
            if ($this->validator->validate($modifiedAccount) == Validator::VALID) {
                return $modifiedAccount;
            }
        }

        return $account . $this->statusMap[Validator::ILLEGIBLE];
    }
}