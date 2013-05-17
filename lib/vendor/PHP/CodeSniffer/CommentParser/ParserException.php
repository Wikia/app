<?php
/**
 * An exception to be thrown when a DocCommentParser finds an anomilty in a
 * doc comment.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @author    Marc McIntyre <mmcintyre@squiz.net>
 * @copyright 2006 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   CVS: $Id: ParserException.php 224862 2006-12-11 23:59:35Z squiz $
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */

/**
 * An exception to be thrown when a DocCommentParser finds an anomilty in a
 * doc comment.
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
class PHP_CodeSniffer_CommentParser_ParserException extends Exception
{

    /**
     * The line where the exception occured, in relation to the doc comment.
     *
     * @var int
     */
    private $_line = 0;


    /**
     * Constructs a DocCommentParserException.
     *
     * @param string $message The message of the exception.
     * @param int    $line    The position in comment where the error occured.
     *                        A position of 0 indicates that the error occured
     *                        at the opening line of the doc comment.
     */
    public function __construct($message, $line)
    {
        parent::__construct($message);
        $this->_line = $line;

    }//end __construct()


    /**
     * Returns the line number within the comment where the exception occured.
     *
     * @return int
     */
    public function getLineWithinComment()
    {
        return $this->_line;

    }//end getLineWithinComment()


}//end class

?>
