<?php
/**
 * This file is part of phpUnderControl.
 *
 * PHP Version 5.2.0
 *
 * Copyright (c) 2007-2010, Manuel Pichler <mapi@phpundercontrol.org>.
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
 * @package   Data
 * @author    Sebastian Marek <proofek@gmail.com>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   SVN: $Id$
 * @link      http://www.phpundercontrol.org/
 */

/**
 * This class represents apply ant task in a build.xml file.
 *
 * See {@link http://ant.apache.org/manual/CoreTasks/apply.html}
 * for ant task details
 *
 * @category  QualityAssurance
 * @package   Tasks
 * @author    Sebastian Marek <proofek@gmail.com>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.6.1beta1
 * @link      http://www.phpundercontrol.org/
 */
class phpucApplyAntTask extends phpucAbstractAntTask
{
    /**
     * Ant task name
     *
     * @var string
     */
    public $taskName = 'apply';

    /**
     * The constructor takes the parent build file as an argument.
     * It sets executable file as 'php' by default
     *
     * @param phpucBuildFile $buildFile  The parent build file object.
     */
    public function __construct( phpucBuildFile $buildFile )
    {
        parent::__construct( $buildFile );

        $this->executable = 'php';
    }

    /**
     * Builds/Rebuilds the target and attached tasks xml content.
     *
     * @param DOMElement $target Xml element
     *
     * @return void
     */
    public function buildXml( DOMElement $target )
    {
        $apply = $target->appendChild( $this->createElement( $this->taskName ) );
        $apply->setAttribute( 'executable', $this->executable );
        $apply->setAttribute( 'dir', $this->dir );

        if ( $this->failonerror === true )
        {
            $apply->setAttribute( 'failonerror', 'on' );
        }
        if ( $this->logerror === true )
        {
            $apply->setAttribute( 'logerror', 'on' );
        }

        if ( $this->argLine !== null )
        {
            $arg = $apply->appendChild( $this->createElement( 'arg' ) );
            $arg->setAttribute( 'line', $this->argLine );
        }

        foreach ( $this->tasks as $task) {

            $task->buildXml( $apply );
        }
    }
}