<?php

namespace Aeliot\Bundle\EncryptDB\Doctrine\ORM\Query\AST\Functions\AELIOT;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\SimpleArithmeticExpression;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * "AELIOT_DECRYPT" "(" SimpleArithmeticExpression ")"
 */
class DecryptFunction extends FunctionNode
{
    /**
     * @var SimpleArithmeticExpression
     */
    public $simpleArithmeticExpression;

    /**
     * @return string
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        return sprintf(
            'AELIOT_DECRYPT(%s)',
            $sqlWalker->walkSimpleArithmeticExpression($this->simpleArithmeticExpression)
        );
    }

    /**
     * @return void
     */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->simpleArithmeticExpression = $parser->SimpleArithmeticExpression();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
