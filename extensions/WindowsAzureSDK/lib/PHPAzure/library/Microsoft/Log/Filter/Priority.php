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
 * @version    $Id: Priority.php 20260 2010-01-13 18:29:22Z ralph $
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
 * @version    $Id: Priority.php 20260 2010-01-13 18:29:22Z ralph $
 */
class Microsoft_Log_Filter_Priority extends Microsoft_Log_Filter_Abstract
{
    /**
     * @var integer
     */
    protected $_priority;

    /**
     * @var string
     */
    protected $_operator;

    /**
     * Filter logging by $priority.  By default, it will accept any log
     * event whose priority value is less than or equal to $priority.
     *
     * @param  integer  $priority  Priority
     * @param  string   $operator  Comparison operator
     * @throws Microsoft_Log_Exception
     */
    public function __construct($priority, $operator = NULL)
    {
        if (! is_integer($priority)) {
            require_once 'Microsoft/Log/Exception.php';
            throw new Microsoft_Log_Exception('Priority must be an integer');
        }

        $this->_priority = $priority;
        $this->_operator = is_null($operator) ? '<=' : $operator;
    }

    /**
     * Create a new instance of Microsoft_Log_Filter_Priority
     * 
     * @param  array $config
     * @return Microsoft_Log_Filter_Priority
     * @throws Microsoft_Log_Exception
     */
    static public function factory($config) 
    {
        $config = self::_parseConfig($config);
        $config = array_merge(array(
            'priority' => null, 
            'operator' => null,
        ), $config);

        // Add support for constants
        if (!is_numeric($config['priority']) && isset($config['priority']) && defined($config['priority'])) {
            $config['priority'] = constant($config['priority']);
        }

        return new self(
            (int) $config['priority'], 
            $config['operator']
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
        return version_compare($event['priority'], $this->_priority, $this->_operator);
    }
}
