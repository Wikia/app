<?php
/**
 * Ensures that all action classes throw ChannelExceptions only.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer_MySource
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   CVS: $Id: UnusedSystemSniff.php 293522 2010-01-13 22:28:20Z squiz $
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */

/**
 * Ensures that all action classes throw ChannelExceptions only.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer_MySource
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   Release: 1.3.0RC1
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class MySource_Sniffs_Channels_ChannelExceptionSniff implements PHP_CodeSniffer_Sniff
{


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(T_THROW);

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
        $fileName = strtolower($phpcsFile->getFilename());
        $matches  = array();
        if (preg_match('|/systems/(.*)/([^/]+)?actions.inc$|', $fileName, $matches) === 0) {
            // This is not an actions.inc file.
            return;
        }

        $tokens = $phpcsFile->getTokens();

        $exception     = $phpcsFile->findNext(array(T_STRING, T_VARIABLE), ($stackPtr + 1));
        $exceptionName = $tokens[$exception]['content'];

        if ($exceptionName !== 'ChannelException') {
            $data  = array($exceptionName);
            $error = 'Channel actions can only throw ChannelException; found "%s"';
            $phpcsFile->addError($error, $exception, 'WrongExceptionType', $data);
        }

    }//end process()


}//end class

?>
