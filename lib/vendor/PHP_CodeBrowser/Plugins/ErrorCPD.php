<?php
/**
 * Copy paste detection
 *
 * PHP Version 5.2.6
 *
 * Copyright (c) 2007-2009, Mayflower GmbH
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
 * @category   PHP_CodeBrowser
 * @package    PHP_CodeBrowser
 * @subpackage Plugins
 * @author     Elger Thiele <elger.thiele@mayflower.de>
 * @author     Michel Hartmann <michel.hartmann@mayflower.de>
 * @copyright  2007-2010 Mayflower GmbH
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    SVN: $Id$
 * @link       http://www.phpunit.de/
 * @since      File available since  0.1.0
 */

/**
 * CbErrorCPD
 *
 * @category   PHP_CodeBrowser
 * @package    PHP_CodeBrowser
 * @subpackage Plugins
 * @author     Elger Thiele <elger.thiele@mayflower.de>
 * @author     Michel Hartmann <michel.hartmann@mayflower.de>
 * @copyright  2007-2010 Mayflower GmbH
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: 0.9.0
 * @link       http://www.phpunit.de/
 * @since      Class available since  0.1.0
 */
class CbErrorCPD extends CbPluginsAbstract
{
    public $pluginName = 'pmd-cpd';

    /**
     * Mapper method for this plugin.
     *
     * @param SingleXMLElement $element The XML plugin node with its errors
     *
     * @return array
     */
    public function mapIssues(DOMNode $element, $filename)
    {
        $parentNode = $element->parentNode;
        $files      = $this->_issueXml->query(
            'file[@path="'.$filename.'"]', $parentNode
        );
        $lineCount  = (int)$parentNode->getAttribute('lines');

        $result = array();
        foreach ($files as $file) {
            $result[] = new CbIssue(
                $file->getAttribute('path'),
                (int) $file->getAttribute('line'),
                (int) $file->getAttribute('line') + $lineCount,
                'Duplication',
                htmlentities(
                    $this->_CPDgetDescription($parentNode->childNodes, $file)
                ),
                'notice'
            );
        }
        return $result;
    }

    public function getFilesWithIssues()
    {
        $filenames = array();
        $nodes = $this->_issueXml->query(
            '/*/'.$this->pluginName.'/*/file[@path]'
        );

        foreach ($nodes as $node) {
            $filenames[] = $node->getAttribute('path');
        }

        return array_unique($filenames);
    }

    /**
     * Get all DOMNodes that represent issues for a specific file.
     *
     * @param String $filename Name of the file to get nodes for.
     * @return DOMNodeList
     */
    protected function _getIssueNodes($filename)
    {
        return $this->_issueXml->query(
            '/*/'.$this->pluginName.'/*/file[@path="'.$filename.'"]'
        );
    }

    /**
     * We need another version of getDescription, as we need $allNodes
     * to find duplicates.
     */
    protected function _CPDgetDescription(DOMNodeList $allNodes,
                                          DOMNode $currentNode)
    {
        $source = array();
        foreach ($allNodes as $node) {
            if ($node instanceof DOMElement
                    && !$node->isSameNode($currentNode)) {
                $source[] = sprintf(
                    '%s (%d)',
                    $node->getAttribute('path'),
                    $node->getAttribute('line')
                );
            }
        }
        return "Copy paste from:\n".implode("\n", $source);
    }

    /**
     * Make sure this is never called.
     * @codeCoverageIgnoreStart
     * This cannot be called because of other overridden methods in this class.
     */
    protected function _getDescription(DOMElement $element)
    {
        throw new Exception('ErrorCPD does not support getDescription()!');
    }
    //@codeCoverageIgnoreEnd
}
