<?php
/**
 * This file is part of PHP_Depend.
 *
 * PHP Version 5
 *
 * Copyright (c) 2008-2010, Manuel Pichler <mapi@pdepend.org>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Manuel Pichler nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category   QualityAssurance
 * @package    PHP_Depend
 * @subpackage DbusUI
 * @author     Manuel Pichler <mapi@pdepend.org>
 * @copyright  2008-2010 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    SVN: $Id$
 * @link       http://pdepend.org/
 */

require_once 'PHP/Depend/ProcessListenerI.php';
require_once 'PHP/Depend/Visitor/AbstractListener.php';

// This is just fun and it is not really testable
// @codeCoverageIgnoreStart

/**
 * Fun result printer that uses dbus to show a notification window.
 *
 * @category   QualityAssurance
 * @package    PHP_Depend
 * @subpackage DbusUI
 * @author     Manuel Pichler <mapi@pdepend.org>
 * @copyright  2008-2010 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: 0.9.19
 * @link       http://pdepend.org/
 */
class PHP_Depend_DbusUI_ResultPrinter
       extends PHP_Depend_Visitor_AbstractListener
    implements PHP_Depend_ProcessListenerI
{
    /**
     * Time when it the process has started.
     *
     * @var integer
     */
    private $_startTime = 0;

    /**
     * Number of parsed/analyzed files.
     *
     * @var integer
     */
    private $_parsedFiles = 0;

    /**
     * Is called when PDepend starts the file parsing process.
     *
     * @param PHP_Depend_BuilderI $builder The used node builder instance.
     *
     * @return void
     */
    public function startParseProcess(PHP_Depend_BuilderI $builder)
    {
        $this->_startTime = time();
    }

    /**
     * Is called when PDepend has finished the file parsing process.
     *
     * @param PHP_Depend_BuilderI $builder The used node builder instance.
     *
     * @return void
     */
    public function endParseProcess(PHP_Depend_BuilderI $builder)
    {
    }

    /**
     * Is called when PDepend starts parsing of a new file.
     *
     * @param PHP_Depend_TokenizerI $tokenizer The used tokenizer instance.
     *
     * @return void
     */
    public function startFileParsing(PHP_Depend_TokenizerI $tokenizer)
    {
    }

    /**
     * Is called when PDepend has finished a file.
     *
     * @param PHP_Depend_TokenizerI $tokenizer The used tokenizer instance.
     *
     * @return void
     */
    public function endFileParsing(PHP_Depend_TokenizerI $tokenizer)
    {
        ++$this->_parsedFiles;
    }

    /**
     * Is called when PDepend starts the analyzing process.
     *
     * @return void
     */
    public function startAnalyzeProcess()
    {
    }

    /**
     * Is called when PDepend has finished the analyzing process.
     *
     * @return void
     */
    public function endAnalyzeProcess()
    {
    }

    /**
     * Is called when PDepend starts the logging process.
     *
     * @return void
     */
    public function startLogProcess()
    {
    }

    /**
     * Is called when PDepend has finished the logging process.
     *
     * @return void
     */
    public function endLogProcess()
    {
        if (extension_loaded('dbus') === false) {
            return;
        }

        $d = new Dbus(Dbus::BUS_SESSION);
        $n = $d->createProxy(
            "org.freedesktop.Notifications", // connection name
            "/org/freedesktop/Notifications", // object
            "org.freedesktop.Notifications" // interface
        );
        $n->Notify(
            'PDepend', 
            new DBusUInt32(0),
            'pdepend', 
            'PHP_Depend', 
            sprintf(
                '%d files analyzed in %s minutes...', 
                $this->_parsedFiles, 
                (date('i:s', time() - $this->_startTime))
            ),
            new DBusArray(DBus::STRING, array()),
            new DBusDict(DBus::VARIANT, array()),
            1000
        );
    }

    /**
     * Is called when PDepend starts a new analyzer.
     *
     * @param PHP_Depend_Metrics_AnalyzerI $analyzer The context analyzer instance.
     *
     * @return void
     */
    public function startAnalyzer(PHP_Depend_Metrics_AnalyzerI $analyzer)
    {
    }

    /**
     * Is called when PDepend has finished one analyzing process.
     *
     * @param PHP_Depend_Metrics_AnalyzerI $analyzer The context analyzer instance.
     *
     * @return void
     */
    public function endAnalyzer(PHP_Depend_Metrics_AnalyzerI $analyzer)
    {
    }

    /**
     * Generic notification method that is called for every node start.
     *
     * @param PHP_Depend_Code_NodeI $node The context node instance.
     *
     * @return void
     * @see PHP_Depend_Visitor_AbstractVisitor::startVisitNode()
     */
    public function startVisitNode(PHP_Depend_Code_NodeI $node)
    {
    }
}

// @codeCoverageIgnoreEnd
