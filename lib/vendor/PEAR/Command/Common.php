<?php
/**
 * PEAR_Command_Common base class
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This source file is subject to version 3.0 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_0.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   pear
 * @package    PEAR
 * @author     Stig Bakken <ssb@php.net>
 * @author     Greg Beaver <cellog@php.net>
 * @copyright  1997-2006 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    CVS: $Id: Common.php,v 1.32.2.1 2006/06/08 22:27:11 pajoye Exp $
 * @link       http://pear.php.net/package/PEAR
 * @since      File available since Release 0.1
 */

/**
 * base class
 */
require_once 'PEAR.php';

/**
 * PEAR commands base class
 *
 * @category   pear
 * @package    PEAR
 * @author     Stig Bakken <ssb@php.net>
 * @author     Greg Beaver <cellog@php.net>
 * @copyright  1997-2006 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    Release: 1.4.11
 * @link       http://pear.php.net/package/PEAR
 * @since      Class available since Release 0.1
 */
class PEAR_Command_Common extends PEAR
{
    // {{{ properties

    /**
     * PEAR_Config object used to pass user system and configuration
     * on when executing commands
     *
     * @var PEAR_Config
     */
    var $config;
    /**
     * @var PEAR_Registry
     * @access protected
     */
    var $_registry;

    /**
     * User Interface object, for all interaction with the user.
     * @var object
     */
    var $ui;

    var $_deps_rel_trans = array(
                                 'lt' => '<',
                                 'le' => '<=',
                                 'eq' => '=',
                                 'ne' => '!=',
                                 'gt' => '>',
                                 'ge' => '>=',
                                 'has' => '=='
                                 );

    var $_deps_type_trans = array(
                                  'pkg' => 'package',
                                  'ext' => 'extension',
                                  'php' => 'PHP',
                                  'prog' => 'external program',
                                  'ldlib' => 'external library for linking',
                                  'rtlib' => 'external runtime library',
                                  'os' => 'operating system',
                                  'websrv' => 'web server',
                                  'sapi' => 'SAPI backend'
                                  );

    // }}}
    // {{{ constructor

    /**
     * PEAR_Command_Common constructor.
     *
     * @access public
     */
    function PEAR_Command_Common(&$ui, &$config)
    {
        parent::PEAR();
        $this->config = &$config;
        $this->ui = &$ui;
    }

    // }}}

    // {{{ getCommands()

    /**
     * Return a list of all the commands defined by this class.
     * @return array list of commands
     * @access public
     */
    function getCommands()
    {
        $ret = array();
        foreach (array_keys($this->commands) as $command) {
            $ret[$command] = $this->commands[$command]['summary'];
        }
        return $ret;
    }

    // }}}
    // {{{ getShortcuts()

    /**
     * Return a list of all the command shortcuts defined by this class.
     * @return array shortcut => command
     * @access public
     */
    function getShortcuts()
    {
        $ret = array();
        foreach (array_keys($this->commands) as $command) {
            if (isset($this->commands[$command]['shortcut'])) {
                $ret[$this->commands[$command]['shortcut']] = $command;
            }
        }
        return $ret;
    }

    // }}}
    // {{{ getOptions()

    function getOptions($command)
    {
        $shortcuts = $this->getShortcuts();
        if (isset($shortcuts[$command])) {
            $command = $shortcuts[$command];
        }
        return @$this->commands[$command]['options'];
    }

    // }}}
    // {{{ getGetoptArgs()

    function getGetoptArgs($command, &$short_args, &$long_args)
    {
        $short_args = "";
        $long_args = array();
        if (empty($this->commands[$command]) || empty($this->commands[$command]['options'])) {
            return;
        }
        reset($this->commands[$command]['options']);
        while (list($option, $info) = each($this->commands[$command]['options'])) {
            $larg = $sarg = '';
            if (isset($info['arg'])) {
                if ($info['arg']{0} == '(') {
                    $larg = '==';
                    $sarg = '::';
                    $arg = substr($info['arg'], 1, -1);
                } else {
                    $larg = '=';
                    $sarg = ':';
                    $arg = $info['arg'];
                }
            }
            if (isset($info['shortopt'])) {
                $short_args .= $info['shortopt'] . $sarg;
            }
            $long_args[] = $option . $larg;
        }
    }

    // }}}
    // {{{ getHelp()
    /**
    * Returns the help message for the given command
    *
    * @param string $command The command
    * @return mixed A fail string if the command does not have help or
    *               a two elements array containing [0]=>help string,
    *               [1]=> help string for the accepted cmd args
    */
    function getHelp($command)
    {
        $config = &PEAR_Config::singleton();
        $help = @$this->commands[$command]['doc'];
        if (empty($help)) {
            // XXX (cox) Fallback to summary if there is no doc (show both?)
            if (!$help = @$this->commands[$command]['summary']) {
                return "No help for command \"$command\"";
            }
        }
        if (preg_match_all('/{config\s+([^\}]+)}/e', $help, $matches)) {
            foreach($matches[0] as $k => $v) {
                $help = preg_replace("/$v/", $config->get($matches[1][$k]), $help);
            }
        }
        return array($help, $this->getHelpArgs($command));
    }

    // }}}
    // {{{ getHelpArgs()
    /**
    * Returns the help for the accepted arguments of a command
    *
    * @param  string $command
    * @return string The help string
    */
    function getHelpArgs($command)
    {
        if (isset($this->commands[$command]['options']) &&
            count($this->commands[$command]['options']))
        {
            $help = "Options:\n";
            foreach ($this->commands[$command]['options'] as $k => $v) {
                if (isset($v['arg'])) {
                    if ($v['arg']{0} == '(') {
                        $arg = substr($v['arg'], 1, -1);
                        $sapp = " [$arg]";
                        $lapp = "[=$arg]";
                    } else {
                        $sapp = " $v[arg]";
                        $lapp = "=$v[arg]";
                    }
                } else {
                    $sapp = $lapp = "";
                }
                if (isset($v['shortopt'])) {
                    $s = $v['shortopt'];
                    @$help .= "  -$s$sapp, --$k$lapp\n";
                } else {
                    @$help .= "  --$k$lapp\n";
                }
                $p = "        ";
                $doc = rtrim(str_replace("\n", "\n$p", $v['doc']));
                $help .= "        $doc\n";
            }
            return $help;
        }
        return null;
    }

    // }}}
    // {{{ run()

    function run($command, $options, $params)
    {
        if (empty($this->commands[$command]['function'])) {
            // look for shortcuts
            foreach (array_keys($this->commands) as $cmd) {
                if (isset($this->commands[$cmd]['shortcut']) && $this->commands[$cmd]['shortcut'] == $command) {
                    if (empty($this->commands[$cmd]['function'])) {
                        return $this->raiseError("unknown command `$command'");
                    } else {
                        $func = $this->commands[$cmd]['function'];
                    }
                    $command = $cmd;
                    break;
                }
            }
        } else {
            $func = $this->commands[$command]['function'];
        }
        return $this->$func($command, $options, $params);
    }

    // }}}
}

?>
