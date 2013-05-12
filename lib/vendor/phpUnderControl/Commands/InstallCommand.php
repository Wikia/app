<?php
/**
 * This file is part of phpUnderControl.
 *
 * PHP Version 5
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
 * @author    Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   SVN: $Id$
 * @link      http://www.phpundercontrol.org/
 */

/**
 * Command implementation for the install mode.
 *
 * @category  QualityAssurance
 * @package   Commands
 * @author    Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.6.1beta1
 * @link      http://www.phpundercontrol.org/
 */
class phpucInstallCommand extends phpucAbstractCommand implements phpucConsoleCommandI
{
    /**
     * List of new files.
     *
     * @var array(string=>string)
     */
    private $installFiles = array(
        '/webapps/cruisecontrol/changeset.jsp',
        '/webapps/cruisecontrol/dashboard.jsp',
        '/webapps/cruisecontrol/error.jsp',
        '/webapps/cruisecontrol/favicon.ico',
        '/webapps/cruisecontrol/footer.jsp',
        '/webapps/cruisecontrol/forcebuild.jsp',
        '/webapps/cruisecontrol/header.jsp',
        '/webapps/cruisecontrol/metrics.cewolf.jsp',
        '/webapps/cruisecontrol/phpcs.jsp',
        '/webapps/cruisecontrol/phpunit.jsp',
        '/webapps/cruisecontrol/phpunit-pmd.jsp',
        '/webapps/cruisecontrol/phpunit-cpd.jsp',
        '/webapps/cruisecontrol/servertime.jsp',
        '/webapps/cruisecontrol/css/php-under-control.css',
        '/webapps/cruisecontrol/css/SyntaxHighlighter.css',
        '/webapps/cruisecontrol/images/php-under-control/collapsed.png',
        '/webapps/cruisecontrol/images/php-under-control/dashboard-broken-left.png',
        '/webapps/cruisecontrol/images/php-under-control/dashboard-broken-right.png',
        '/webapps/cruisecontrol/images/php-under-control/dashboard-good-left.png',
        '/webapps/cruisecontrol/images/php-under-control/dashboard-good-right.png',
        '/webapps/cruisecontrol/images/php-under-control/error.png',
        '/webapps/cruisecontrol/images/php-under-control/expanded.png',
        '/webapps/cruisecontrol/images/php-under-control/failed.png',
        '/webapps/cruisecontrol/images/php-under-control/header-center.png',
        '/webapps/cruisecontrol/images/php-under-control/header-left-logo.png',
        '/webapps/cruisecontrol/images/php-under-control/play-broken.png',
        '/webapps/cruisecontrol/images/php-under-control/play-good.png',
        '/webapps/cruisecontrol/images/php-under-control/info.png',
        '/webapps/cruisecontrol/images/php-under-control/skipped.png',
        '/webapps/cruisecontrol/images/php-under-control/success.png',
        '/webapps/cruisecontrol/images/php-under-control/tab-active.png',
        '/webapps/cruisecontrol/images/php-under-control/tab-inactive.png',
        '/webapps/cruisecontrol/images/php-under-control/throbber-broken.gif',
        '/webapps/cruisecontrol/images/php-under-control/throbber-good.gif',
        '/webapps/cruisecontrol/images/php-under-control/unknown.png',
        '/webapps/cruisecontrol/images/php-under-control/warning.png',
        '/webapps/cruisecontrol/js/php-under-control.js',
        '/webapps/cruisecontrol/js/shBrushPhp.js',
        '/webapps/cruisecontrol/js/shCore.js',
        '/webapps/cruisecontrol/js/effects.js',
        '/webapps/cruisecontrol/js/prototype.js',
        '/webapps/cruisecontrol/js/scriptaculous.js',
        '/webapps/cruisecontrol/xsl/phpcs.xsl',
        '/webapps/cruisecontrol/xsl/phpcs-details.xsl',
        '/webapps/cruisecontrol/xsl/phpcs-list.xsl',
        '/webapps/cruisecontrol/xsl/phpcs-summary.xsl',
        '/webapps/cruisecontrol/xsl/phpdoc.xsl',
        '/webapps/cruisecontrol/xsl/phphelper.xsl',
        '/webapps/cruisecontrol/xsl/phpunit.xsl',
        '/webapps/cruisecontrol/xsl/phpunit-cpd-details.xsl',
        '/webapps/cruisecontrol/xsl/phpunit-details.xsl',
        '/webapps/cruisecontrol/xsl/phpunit-pmd.xsl',
        '/webapps/cruisecontrol/xsl/phpunit-pmd-details.xsl',
        '/webapps/cruisecontrol/xsl/phpunit-pmd-list.xsl',
        '/webapps/cruisecontrol/xsl/phpunit-pmd-summary.xsl',
        '/webapps/cruisecontrol/WEB-INF/lib/php-under-control.jar',
    );

    /**
     * List of modified files.
     *
     * @var array(string=>string)
     */
    private $modifiedFiles = array(
        '/webapps/cruisecontrol/buildresults.jsp',
        '/webapps/cruisecontrol/index.jsp',
        '/webapps/cruisecontrol/main.jsp',
        '/webapps/cruisecontrol/metrics.jsp',
        '/webapps/cruisecontrol/xsl/buildresults.xsl',
        '/webapps/cruisecontrol/xsl/errors.xsl',
        '/webapps/cruisecontrol/xsl/header.xsl',
        '/webapps/cruisecontrol/xsl/modifications.xsl',
    );

    /**
     * Returns the cli command identifier.
     *
     * @return string
     */
    public function getCommandId()
    {
        return 'install';
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
            'Installs the CruiseControl patches.'
        );
        $def->addArgument(
            $this->getCommandId(),
            'cc-install-dir',
            'The installation directory of CruiseControl.'
        );
    }

    /**
     * Creates all command specific {@link phpucTaskI} objects.
     *
     * @return array(phpucTaskI)
     */
    protected function doCreateTasks()
    {
        $tasks = array();

        $modifyFileTask = new phpucModifyFileTask();
        $modifyFileTask->setFiles( $this->modifiedFiles );

        $createFileTask = new phpucCreateFileTask();
        $createFileTask->setFiles( $this->installFiles );

        $tasks[] = new phpucCruiseControlTask();
        $tasks[] = $modifyFileTask;
        $tasks[] = $createFileTask;

        return $tasks;
    }
}
