<?php

namespace AliCemalTuran\AjaxWrapper\Classes;

use Cms\Twig\PartialNode;
use Twig\Error\SyntaxError as TwigErrorSyntax;
use Twig\Node\Node as TwigNode;
use Twig\Token as TwigToken;
use Twig\TokenParser\AbstractTokenParser as TwigTokenParser;

class WrapperPartialTokenParser extends TwigTokenParser
{


    /**
     * parse a token and returns a node.
     * @return TwigNode A TwigNode instance
     */
    public function parse(TwigToken $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();

        $name = $this->parser->getExpressionParser()->parseExpression();
        $paramNames = [];
        $nodes = [$name];
        $hasBody = $hasOnly = $hasLazy = false;
        $body = null;

        $isAjax = $this->getTag() === 'kumsalAjaxPartial';

        $end = false;
        while (!$end) {

            $current = $stream->next();
            if (
                $current->test(TwigToken::NAME_TYPE, 'lazy') &&
                !$stream->test(TwigToken::OPERATOR_TYPE, '=')
            ) {
                if (!$isAjax) {
                    throw new TwigErrorSyntax(
                        'Cannot use lazy mode with partial tag. Did you mean ajaxPartial?',
                        $stream->getCurrent()->getLine(),
                        $stream->getSourceContext()
                    );
                }

                $hasLazy = true;
                $current = $stream->next();
            }

            if (
                $current->test(TwigToken::NAME_TYPE, 'body') &&
                !$stream->test(TwigToken::OPERATOR_TYPE, '=')
            ) {
                $hasBody = true;
                $current = $stream->next();
            }

            if (
                $current->test(TwigToken::NAME_TYPE, 'only') &&
                !$stream->test(TwigToken::OPERATOR_TYPE, '=')
            ) {
                $hasOnly = true;
                $current = $stream->next();
            }
            switch ($current->getType()) {
                case TwigToken::NAME_TYPE:
                    $paramNames[] = $current->getValue();
                    $stream->expect(TwigToken::OPERATOR_TYPE, '=');

                    $nodes[] = $this->parser->getExpressionParser()->parseExpression();
                    break;

                case TwigToken::BLOCK_END_TYPE:
                    $end = true;
                    break;

                default:
                    throw new TwigErrorSyntax(
                        sprintf('Invalid syntax in the partial tag. Line %s', $lineno),
                        $stream->getCurrent()->getLine(),
                        $stream->getSourceContext()
                    );
                    break;
            }
        }

        if ($hasBody) {
            $body = $this->parser->subparse([$this, 'decidePartialEnd'], true);
            $stream->expect(TwigToken::BLOCK_END_TYPE);
        }

        $options = [
            'paramNames' => $paramNames,
            'hasOnly' => $hasOnly,
            'hasLazy' => $hasLazy,
            'isAjax' => $isAjax
        ];
        return new AjaxPartialNode(new TwigNode($nodes), $body, $options, $token->getLine(), $this->getTag());
    }

    /**
     * decidePartialEnd
     */
    public function decidePartialEnd(TwigToken $token)
    {
        return $token->test('endpartial');
    }

    /**
     * getTag name associated with this token parser
     */
    public function getTag()
    {
        return 'kumsalpartial';
    }
}
