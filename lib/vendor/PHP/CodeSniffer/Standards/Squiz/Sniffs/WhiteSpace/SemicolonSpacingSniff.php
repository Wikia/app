<?php
/**
 * Squiz_Sniffs_WhiteSpace_SemicolonSpacingSniff.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @author    Marc McIntyre <mmcintyre@squiz.net>
 * @copyright 2006 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   CVS: $Id: SemicolonSpacingSniff.php 301632 2010-07-28 01:57:56Z squiz $
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */

/**
 * Squiz_Sniffs_WhiteSpace_SemicolonSpacingSniff.
 *
 * Ensure there is no whitespace before a semicolon.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @author    Marc McIntyre <mmcintyre@squiz.net>
 * @copyright 2006 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   Release: 1.3.0RC1
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class Squiz_Sniffs_WhiteSpace_SemicolonSpacingSniff implements PHP_CodeSniffer_Sniff
{

    /**
     * A list of tokenizers this sniff supports.
     *
     * @var array
     */
    public $supportedTokenizers = array(
                                   'PHP',
                                   'JS',
                                  );

    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(T_SEMICOLON);

    }//end register()


    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token
     *                                        in the stack passed in $tokens.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $prevType = $tokens[($stackPtr - 1)]['code'];
        if (in_array($prevType, PHP_CodeSniffer_Tokens::$emptyTokens) === true) {
            $nonSpace = $phpcsFile->findPrevious(PHP_CodeSniffer_Tokens::$emptyTokens, ($stackPtr - 2), null, true);
            $expected = $tokens[$nonSpace]['content'].';';
            $found    = $phpcsFile->getTokensAsString($nonSpace, ($stackPtr - $nonSpace)).';';
            $error    = 'Space found before semicolon; expected "%s" but found "%s"';
            $data     = array(
                         $expected,
                         $found,
                        );
            $phpcsFile->addError($error, $stackPtr, 'Incorrect', $data);
        }

    }//end process()


}//end class

?>
