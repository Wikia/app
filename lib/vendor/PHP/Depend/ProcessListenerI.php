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
 * @category  QualityAssurance
 * @package   PHP_Depend
 * @author    Manuel Pichler <mapi@pdepend.org>
 * @copyright 2008-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   SVN: $Id$
 * @link      http://pdepend.org/
 */

require_once 'PHP/Depend/BuilderI.php';
require_once 'PHP/Depend/TokenizerI.php';
require_once 'PHP/Depend/Visitor/ListenerI.php';
require_once 'PHP/Depend/Metrics/ListenerI.php';

/**
 * This listener can be used to get informations about the current pdepend process.
 *
 * @category  QualityAssurance
 * @package   PHP_Depend
 * @author    Manuel Pichler <mapi@pdepend.org>
 * @copyright 2008-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.9.19
 * @link      http://pdepend.org/
 */
interface PHP_Depend_ProcessListenerI
    extends PHP_Depend_Visitor_ListenerI,
            PHP_Depend_Metrics_ListenerI
{
    /**
     * Is called when PDepend starts the file parsing process.
     *
     * @param PHP_Depend_BuilderI $builder The used node builder instance.
     * 
     * @return void
     */
    function startParseProcess(PHP_Depend_BuilderI $builder);
    
    /**
     * Is called when PDepend has finished the file parsing process.
     *
     * @param PHP_Depend_BuilderI $builder The used node builder instance.
     * 
     * @return void
     */
    function endParseProcess(PHP_Depend_BuilderI $builder);
    
    /**
     * Is called when PDepend starts parsing of a new file.
     *
     * @param PHP_Depend_TokenizerI $tokenizer The used tokenizer instance.
     * 
     * @return void
     */
    function startFileParsing(PHP_Depend_TokenizerI $tokenizer);
    
    /**
     * Is called when PDepend has finished a file.
     *
     * @param PHP_Depend_TokenizerI $tokenizer The used tokenizer instance.
     * 
     * @return void
     */
    function endFileParsing(PHP_Depend_TokenizerI $tokenizer);
    
    /**
     * Is called when PDepend starts the analyzing process.
     * 
     * @return void
     */
    function startAnalyzeProcess();
    
    /**
     * Is called when PDepend has finished the analyzing process.
     * 
     * @return void
     */
    function endAnalyzeProcess();
    
    /**
     * Is called when PDepend starts the logging process.
     *
     * @return void
     */
    function startLogProcess();
    
    /**
     * Is called when PDepend has finished the logging process.
     *
     * @return void
     */
    function endLogProcess();
}