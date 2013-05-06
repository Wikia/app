<?php
/**
 * View Abtract
 *
 * PHP Version 5.3.0
 *
 * Copyright (c) 2007-2010, Mayflower GmbH
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
 *   * Neither the name of Mayflower GmbH nor the names of his
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
 * @category  PHP_CodeBrowser
 * @package   PHP_CodeBrowser
 * @author    Elger Thiele <elger.thiele@mayflower.de>
 * @author    Jan Mergler <jan.mergler@mayflower.de>
 * @author    Simon Kohlmeyer <simon.kohlmeyer@mayflower.de>
 * @copyright 2007-2010 Mayflower GmbH
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   SVN: $Id$
 * @link      http://www.phpunit.de/
 * @since     File available since  0.1.0
 */

/**
 * CbViewAbstract
 *
 * This class is generating the highlighted and formatted html view for file.
 *
 * @category  PHP_CodeBrowser
 * @package   PHP_CodeBrowser
 * @author    Elger Thiele <elger.thiele@mayflower.de>
 * @author    Jan Mergler <jan.mergler@mayflower.de>
 * @author    Simon Kohlmeyer <simon.kohlmeyer@mayflower.de>
 * @copyright 2007-2010 Mayflower GmbH
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.9.0
 * @link      http://www.phpunit.de/
 * @since     Class available since  0.1.0
 */
class CbViewAbstract
{
    /**
     * Template directory
     *
     * @var string
     */
    protected $_templateDir;

    /**
     * Output directory
     *
     * @var string
     */
    protected $_outputDir;

    /**
     * Available ressource folders
     *
     * @var array
     */
    protected $_ressourceFolders = array('css', 'js', 'img');

    /**
     * IOHelper for filesystem interaction.
     *
     * @var CbIOHelper
     */
    protected $_ioHelper;

    /**
     * Default Constructor
     *
     * @param String $templateDir   The directory containing the templates.
     * @param String $outputDir     The directory where the reviews should be.
     * @param CbIOHelper $ioHelper  The CbIOHelper object to use for I/O.
     */
    public function __construct($templateDir, $outputDir, $ioHelper)
    {
        $this->_templateDir = realpath($templateDir);
        if (!$this->_templateDir) {
            throw new Exception("Specified template directory '$templateDir'"
                                . 'does not exist');
        }

        $this->_outputDir = realpath($outputDir);
        if (!$this->_outputDir) {
            throw new Exception("Specified output directory '$outputDir'"
                                . 'does not exist');
        }

        $this->_ioHelper = $ioHelper;
    }

    /**
     * Copy needed resources to output directory
     *
     * @return void
     * @throws Exception
     * @see cbIOHelper->copyFile
     */
    public function copyRessourceFolders()
    {
        foreach ($this->_ressourceFolders as $folder) {
            $this->_ioHelper->copyDirectory(
                $this->_templateDir . DIRECTORY_SEPARATOR . $folder,
                $this->_outputDir . DIRECTORY_SEPARATOR . $folder
            );
        }
    }

    /**
     * Copy the noErrors file as index.html to indicate that no
     * source files were found
     *
     * @return void
     */
    public function copyNoErrorsIndex()
    {
        $this->_ioHelper->createFile(
            $this->_outputDir . '/index.html',
            $this->_render('noErrors', array())
        );
    }

    /**
     * Creates a javascript-filled index.html
     *
     * @param Array $files The files to show in the sidebar
     *
     * @return void
     */
    public function generateIndex(Array $fileList)
    {
        $data['treeList'] = $this->_getTreeListHtml($fileList);
        $data['fileList'] = $fileList;

        $this->_ioHelper->createFile(
            $this->_outputDir . '/index.html',
            $this->_render('index', $data)
        );
    }

    /**
     * Convert a list of files to a html fragment for jstree.
     *
     * @param Array $fileList       The files, format: array('name' => CbFile).
     * @param String $hrefPrefix    The prefix to put before all href= tags.
     *
     * @return String           The html fragment.
     */
    protected function _getTreeListHtml(Array $fileList, $hrefPrefix = '')
    {
        /*
         * In this method, all directories have a trailing DIRECTORY_SEPARATOR.
         * This is important so that $curDir doesn't become empty if we go
         * up to the root directory ('/' on linux)
         */
        $curDir = CbIOHelper::getCommonPathPrefix(array_keys($fileList))
            . DIRECTORY_SEPARATOR;
        $preLen = strlen($curDir);

        $ret = '<ul>';
        foreach ($fileList as $name => $file) {
            $dir = dirname($name) . DIRECTORY_SEPARATOR;

            // Go back until the file is somewhere below curDir
            while (strpos($dir, $curDir) !== 0) {
                // chop off one subdir from $curDir
                $curDir = substr(
                    $curDir,
                    0,
                    strrpos($curDir, DIRECTORY_SEPARATOR, -2) + 1
                    //strrpos($curDir, DIRECTORY_SEPARATOR)
                );
                $ret .= '</ul></li>';
            }

            if ($dir !== $curDir) {
                // File is in a subdir of current directory
                // relDir has no leading or trailing slash.
                $relDir  = substr($dir, strlen($curDir), -1);
                $relDirs = explode(DIRECTORY_SEPARATOR, $relDir);

                foreach ($relDirs as $dirName) {
                    $ret .= "<li><a class='treeDir'>$dirName</a><ul>";
                }
                $curDir = $dir;
            }

            $shortName = substr($name, $preLen);
            $fileName  = basename($name);
            $count = '';
            if ($file->getErrorCount() != 0 || $file->getWarningCount() != 0) {
                $count .= '(<span class="errorCount">';
                $count .= $file->getErrorCount();
                $count .= '</span>|<span class="warningCount">';
                $count .= $file->getWarningCount();
                $count .= '</span>)';
            }

            $ret .= '<li class="php" ><a class="fileLink" href="';
            $ret .= $hrefPrefix . $shortName . '.html">';
            $ret .= "$fileName $count</a></li>";
        }

        $ret .= '</ul>';
        return $ret;
    }

    /**
     * Render a template.
     *
     * Defined template is parsed and filled with data.
     * Rendered content is read from output buffer.
     *
     * @param String $templateName Template file to use for rendering
     * @param Array  $data         Given dataset to use for rendering
     *
     * @return String              HTML files as string from output buffer
     */
    protected function _render($templateName, $data)
    {
        $filePath = $this->_templateDir . DIRECTORY_SEPARATOR
                  . $templateName . '.tpl';

        extract($data, EXTR_SKIP);

        ob_start();
        include($filePath);
        $contents = ob_get_contents();
        ob_end_clean();

        return $contents;
    }
}
