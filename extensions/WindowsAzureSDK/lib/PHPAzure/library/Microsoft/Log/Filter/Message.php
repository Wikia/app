<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Microsoft
 * @package    Microsoft_Log
 * @subpackage Filter
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: Message.php 20982 2010-02-08 15:51:36Z matthew $
 */

/**
 * @see Microsoft_AutoLoader
 */
require_once dirname(__FILE__) . '/../../AutoLoader.php';

/**
 * @category   Microsoft
 * @package    Microsoft_Log
 * @subpackage Filter
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: Message.php 20982 2010-02-08 15:51:36Z matthew $
 */
class Microsoft_Log_Filter_Message extends Microsoft_Log_Filter_Abstract
{
    /**
     * @var string
     */
    protected $_regexp;

    /**
     * Filter out any log messages not matching $regexp.
     *
     * @param  string  $regexp     Regular expression to test the log message
     * @throws Microsoft_Log_Exception
     */
    public function __construct($regexp)
    {
        if (@preg_match($regexp, '') === false) {
            require_once 'Microsoft/Log/Exception.php';
            throw new Microsoft_Log_Exception("Invalid regular expression '$regexp'");
        }
        $this->_regexp = $regexp;
    }

    /**
     * Create a new instance of Microsoft_Log_Filter_Message
     * 
     * @param  array $config
     * @return Microsoft_Log_Filter_Message
     * @throws Microsoft_Log_Exception
     */
    static public function factory($config) 
    {
        $config = self::_parseConfig($config);
        $config = array_merge(array(
            'regexp' => null
        ), $config);

        return new self(
            $config['regexp']
        );
    }

    /**
     * Returns TRUE to accept the message, FALSE to block it.
     *
     * @param  array    $event    event data
     * @return boolean            accepted?
     */
    public function accept($event)
    {
        return preg_match($this->_regexp, $event['message']) > 0;
    }
}
