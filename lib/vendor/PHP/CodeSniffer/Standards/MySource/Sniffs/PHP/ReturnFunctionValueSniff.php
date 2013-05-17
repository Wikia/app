<?php
/**
 * Warns when function values are returned directly.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer_MySource
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   CVS: $Id: ReturnFunctionValueSniff.php 301632 2010-07-28 01:57:56Z squiz $
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */

/**
 * Warns when function values are returned directly.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer_MySource
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   Release: 1.3.0RC1
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class MySource_Sniffs_PHP_ReturnFunctionValueSniff implements PHP_CodeSniffer_Sniff
{


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(T_RETURN);

    }//end register()


    /**
     * Processes this sniff, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token in
     *                                        the stack passed in $tokens.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $functionName = $phpcsFile->findNext(T_STRING, ($stackPtr + 1), null, false, null, true);

        while ($functionName !== false) {
            // Check if this is really a function.
            $bracket = $phpcsFile->findNext(T_WHITESPACE, ($functionName + 1), null, true);
            if ($tokens[$bracket]['code'] !== T_OPEN_PARENTHESIS) {
                // Not a function call.
                $functionName = $phpcsFile->findNext(T_STRING, ($functionName + 1), null, false, null, true);
                continue;
            }

            $error = 'The result of a function call should be assigned to a variable before being returned';
            $phpcsFile->addWarning($error, $stackPtr, 'NotAssigned');
            break;
        }

    }//end process()


}//end class

?>
