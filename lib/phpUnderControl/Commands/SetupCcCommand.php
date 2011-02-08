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
 * @package   Commands
 * @author    Sebastian Marek <proofek@gmail.com>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://www.phpundercontrol.org/
 */

/**
 * Command implementation for cruise control setup.
 *
 * For now it only installs init script for linux systems
 *
 * @category  QualityAssurance
 * @package   Commands
 * @author    Sebastian Marek <proofek@gmail.com>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.6.1beta1
 * @link      http://www.phpundercontrol.org/
 */
class phpucSetupCcCommand extends phpucAbstractCommand implements phpucConsoleCommandI
{
    /**
     * Creates all command specific {@link phpucTaskI} objects.
     *
     * @return array(phpucTaskI)
     */
    protected function doCreateTasks()
    {
        $tasks = array(
            new phpucInstallCcScriptTask()
        );

        return $tasks;
    }

    /**
     * Returns the cli command identifier.
     *
     * @return string
     */
    public function getCommandId()
    {
        return 'setup-cc';
    }

    /**
     * Callback method that registers a cli command.
     *
     * @param phpucConsoleInputDefinition $def The input definition container.
     *
     * @return void
     */
    public function registerCommand( phpucConsoleInputDefinition $def )
    {
        $def->addCommand(
            $this->getCommandId(),
            'Installs CruiseControl start-up script for linux.'
        );
        $def->addArgument(
            $this->getCommandId(),
            'cc-install-dir',
            'The installation directory of CruiseControl.'
        );
        $def->addArgument(
            $this->getCommandId(),
            'init-dir',
            'Init scripts directory.'
        );
    }
}