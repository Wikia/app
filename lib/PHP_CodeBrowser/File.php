<?php
/**
 * File
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
 * @author    Simon Kohlmeyer <simon.kohlmeyer@mayflower.de>
 * @copyright 2007-2010 Mayflower GmbH
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   SVN: $Id$
 * @link      http://www.phpunit.de/
 * @since     File available since 0.2.0
 */

/**
 * CbFile
 *
 * An object of this class represents a single source file
 * with it's issues, if any.
 *
 * @category  PHP_CodeBrowser
 * @package   PHP_CodeBrowser
 * @author    Simon Kohlmeyer <simon.kohlmeyer@mayflower.de>
 * @copyright 2007-2010 Mayflower GmbH
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.9.0
 * @link      http://github.com/mayflowergmbh
 * @since     Class available since 0.2.0
 */
class CbFile
{
    /**
     * Filename.
     *
     * @var String
     */
    private $_name;

    /**
     * Issues associated with this file.
     *
     * @var Array of CbIssue
     */
    private $_issues;

    /**
     * Default constructor.
     *
     * @param String $name The name of the file.
     */
    public function __construct($name, Array $issues = array())
    {
        $this->_name = $name;
        $this->_issues = $issues;
    }

    /**
     * Add an issue for this file.
     *
     * @param CbIssue $issue The issue to add.
     */
    public function addIssue($issue)
    {
        if ($issue->fileName !== $this->_name) {
            throw new InvalidArgumentException(
                'Tried to add issue to wrong file.'
            );
        }
        $this->_issues[] = $issue;
    }

    /**
     * Gets an array containing the issues for this file.
     *
     * @return Array of CbIssue The issues.
     */
    public function getIssues()
    {
        return $this->_issues;
    }

    /**
     * Returns the absolute name of this file.
     *
     * @return String
     */
    public function name()
    {
        return $this->_name;
    }

    /**
     * Returns the basename of this file.
     *
     * @return String
     */
    public function basename()
    {
        return basename($this->_name);
    }

    /**
     * Returns the dirname of this file.
     *
     * @return String
     */
    public function dirname()
    {
        return dirname($this->_name);
    }

    /**
     * Returns the number of issues this file has.
     *
     * @return Integer
     */
    public function getIssueCount()
    {
        return count($this->_issues);
    }

    /**
     * Returns the number of errors this file has.
     *
     * @return Integer
     */
    public function getErrorCount()
    {
        $count = 0;
        foreach ($this->_issues as $issue) {
            if (strcasecmp($issue->severity, 'error') === 0) {
                $count += 1;
            }
        }
        return $count;
    }

    /**
     * Returns the number of issues this file has that are not errors.
     *
     * @return Integer
     */
    public function getWarningCount()
    {
        return $this->getIssueCount() - $this->getErrorCount();
    }

    /**
     * Merges the issues from two file objects representing the same file.
     *
     * @param CbFile The CbFile to merge with.
     */
    public function mergeWith($file)
    {
        if ($this->_name !== $file->_name) {
            throw new InvalidArgumentException(
                'Tried to merge different files'
            );
        }
        $this->_issues = array_merge($this->_issues, $file->_issues);
    }

    /**
     * Sorts an array of CbFiles. Key value association will be preserved.
     *
     * @param Array $files The files to sort.
     */
    public static function sort(Array &$files)
    {
        uasort($files, 'CbFile::_sort');
    }

    /**
     * Sorting function used in CbFile::sort()
     */
    protected static function _sort($first, $second)
    {
        $first = $first->name();
        $second = $second->name();

        $prefix = CbIOHelper::getCommonPathPrefix(array($first, $second));
        $prelen = strlen($prefix) + 1;

        $first = substr($first, $prelen);
        $second = substr($second, $prelen);

        $firstIsInSubdir = (substr_count($first, DIRECTORY_SEPARATOR) !== 0);
        $secondIsInSubdir = (substr_count($second, DIRECTORY_SEPARATOR) !== 0);

        if ($firstIsInSubdir) {
            if ($secondIsInSubdir) {
                // both are subdirectories
                return strcmp($first, $second);
            } else {
                // a lies in a subdir of the dir in which b lies,
                // so b comes later.
                return -1;
            }
        } else {
            if ($secondIsInSubdir) {
                // b lies in a subdir of the dir in which a lies,
                // so a comes later.
                return 1;
            } else {
                // both are files
                return strcmp($first, $second);
            }
        }
    }
}
