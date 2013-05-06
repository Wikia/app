<?php
/**
 * View Review
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

// Include PEAR Text_Highlighter only if present.
@include_once 'Text/Highlighter.php';
@include_once 'Text/Highlighter/Renderer/Html.php';

/**
 * CbViewReview
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
class CbViewReview extends CbViewAbstract
{
    /**
     * Highlight mapping.
     *
     * @var Array
     */
    protected $_phpHighlightColorMap;

    /**
     * Default constructor
     *
     * Highlighting strings are set.
     *
     * @param String $templateDir   The directory containing the templates.
     * @param String $outputDir     The directory where the reviews should be.
     * @param CbIOHelper $ioHelper  The CbIOHelper object to use for I/O.
     */
    public function __construct($templateDir, $outputDir, $ioHelper)
    {
        parent::__construct($templateDir, $outputDir, $ioHelper);
        $this->_phpHighlightColorMap = array(
            ini_get('highlight.string')  => 'string',
            ini_get('highlight.comment') => 'comment',
            ini_get('highlight.keyword') => 'keyword',
            ini_get('highlight.default') => 'default',
            ini_get('highlight.html')    => 'html',
        );
    }

    /**
     * Generating the Html code browser view for a given file.
     *
     * Issuelist for each file will be marked in source code.
     * Source code is highlighted.
     * Generated Html source code is be saved as Html.
     *
     * @param Array  $issueList        The issue list for given file
     * @param String $filePath         The path to file the should be generated
     * @param String $commonPathPrefix The prefix path all given files have
     *                                 in common
     * @param Array  $issueCounts      Files with issue counts sorted by
     *                                 severity.
     *
     * @return void
     *
     * @see self::_formatIssues
     * @see self::_formatSourceCode
     * @see self::_generateJSCode
     */
    public function generate(Array $issueList, $fileName, $commonPathPrefix)
    {
        $issues           = $this->_formatIssues($issueList);
        $shortFilename    = substr($fileName, strlen($commonPathPrefix));
        $data['issues']   = $issueList;
        $data['filepath'] = $shortFilename;
        $data['source']   = $this->_formatSourceCode($fileName, $issues);

        $depth            = substr_count($shortFilename, DIRECTORY_SEPARATOR);
        $data['csspath']  = str_repeat('../', $depth - 1 >= 0 ? $depth - 1 : 0);

        $this->_ioHelper->createFile(
            $this->_outputDir . $shortFilename . '.html',
            $this->_render('review', $data)
        );
    }

    /**
     * Source code is highlighted an formatted.
     *
     * Besides highlighting, whole lines will be marked with different colors
     * and JQuery functions (like tooltips) are integrated.
     *
     * @param String $filename     The file to format
     * @param Array  $outputIssues Sorted issueList by line number
     *
     * @return String Html formatted string
     */
    private function _formatSourceCode($filename, $outputIssues)
    {
        $sourceDom  = $this->_highlightCode($filename);
        $xpath      = new DOMXPath($sourceDom);
        $lines      = $xpath->query('//ol/li');

        // A shortcut to prevent possible trouble with log(0)
        // Note that this is exactly what will happen anyways.
        if ($lines->length === 0) {
            return $sourceDom->saveHTML();
        }

        $lineNumber = 0;
        $linePlaces = floor(log($lines->length, 10)) + 1;
        foreach ($lines as $line) {
            ++$lineNumber;
            $line->setAttribute('id', 'line_' . $lineNumber);

            $lineClasses = array(
                ($lineNumber % 2) ? 'odd' : 'even'
            );

            if (isset($outputIssues[$lineNumber])) {
                $lineClasses[] = 'hasIssues';
                $message = '|';
                foreach ($outputIssues[$lineNumber] as $issue) {
                    $message .= sprintf(
                        '
                        <div class="tooltip">
                            <div class="title %s">%s</div>
                            <div class="text">%s</div>
                        </div>
                        ',
                        $issue->foundBy,
                        $issue->foundBy,
                        $issue->description
                    );
                }
                $line->setAttribute('title', utf8_encode($message));
            }

            // Add line number
            $nuSpan = $sourceDom->createElement('span');
            $nuSpan->setAttribute('class', 'lineNumber');
            for ($i = 0; $i < $linePlaces - strlen($lineNumber); $i++) {
                $nuSpan->appendChild($sourceDom->createEntityReference('nbsp'));
            }
            $nuSpan->appendChild($sourceDom->createTextNode($lineNumber));
            $nuSpan->appendChild($sourceDom->createEntityReference('nbsp'));
            $line->insertBefore($nuSpan, $line->firstChild);

            //create anchor for the new line
            $anchor = $sourceDom->createElement('a');
            $anchor->setAttribute('name', 'line_' . $lineNumber);
            $line->appendChild($anchor);

            // set li css class depending on line errors
            switch ($tmp = (isset($outputIssues[$lineNumber])
                    ? count($outputIssues[$lineNumber])
                    : 0)) {
                case 0 :
                    break;
                case 1 :
                    $lineClasses[] = $outputIssues[$lineNumber][0]->foundBy;
                    break;
                case 1 < $tmp :
                    $lineClasses[] = 'moreErrors';
                    break;
                // This can't happen, count always returns >= 0
                // @codeCoverageIgnoreStart
                default:
                    break;
                // @codeCoverageIgnoreEnd
            }
            $line->setAttribute('class', implode(' ', $lineClasses));
        }
        return $sourceDom->saveHTML();
    }

    /**
     * Highlighter method for PHP source code
     *
     * The source code is highlighted by PHP native method.
     * Afterwords a DOMDocument will be generated with each
     * line in a seperate node.
     *
     * @param String $sourceCode The PHP source code
     *
     * @return DOMDocument
     */
    protected function _highlightPhpCode($sourceCode)
    {
        $code = highlight_string($sourceCode, true);

        $sourceDom = new DOMDocument();
        $sourceDom->loadHTML($code);

        //fetch <code>-><span>->children from php generated html
        $sourceElements = $sourceDom->getElementsByTagname('code')->item(0)
                                    ->childNodes->item(0)->childNodes;

        //create target dom
        $targetDom  = new DOMDocument();
        $targetNode = $targetDom->createElement('ol');
        $targetNode->setAttribute('class', 'code');
        $targetDom->appendChild($targetNode);

        $li = $targetDom->createElement('li');
        $targetNode->appendChild($li);

        // iterate through all <span> elements
        foreach ($sourceElements as $sourceElement) {
            if (!$sourceElement instanceof DOMElement) {
                $span = $targetDom->createElement('span');
                $span->nodeValue = htmlspecialchars($sourceElement->wholeText);
                $li->appendChild($span);
                continue;
            }

            if ('br' === $sourceElement->tagName) {
                // create new li and new line
                $li = $targetDom->createElement('li');
                $targetNode->appendChild($li);
                continue;
            }

            $elementClass = $this->_mapPhpColors(
                $sourceElement->getAttribute('style')
            );

            foreach ($sourceElement->childNodes as $sourceChildElement) {
                if ($sourceChildElement instanceof DOMElement
                && 'br' === $sourceChildElement->tagName) {
                    // create new li and new line
                    $li = $targetDom->createElement('li');
                    $targetNode->appendChild($li);
                } else {
                    // apend content to current li element
                    // apend content to urrent li element
                    $span = $targetDom->createElement('span');
                    $span->nodeValue = htmlspecialchars(
                        $sourceChildElement->wholeText
                    );
                    $span->setAttribute('class', $elementClass);
                    $li->appendChild($span);
                }
            }
        }
        return $targetDom;
    }

    /**
     * Return colors defined in ini files.
     *
     * @param String $style The given style name, e.g. "comment"
     *
     * @return String
     */
    protected function _mapPhpColors($style)
    {
        $color = substr($style, 7);
        return $this->_phpHighlightColorMap[$color];
    }

    /**
     * Highlighting source code of given file.
     *
     * Php code is using native php highlighter.
     * If PEAR Text_Highlighter is installed all defined files in $highlightMap
     * will be highlighted as well.
     *
     * @param String $file The filename / realpath to file
     *
     * @return String Html representation of parsed source code
     */
    protected function _highlightCode($file)
    {
        $highlightMap = array(
            '.js'   => 'JAVASCRIPT',
            '.html' => 'HTML',
            '.css'  => 'CSS',
        );

        $extension = strrchr($file, '.');
        $sourceCode = $this->_ioHelper->loadFile($file);

        if ('.php' === $extension) {
            return $this->_highlightPhpCode($sourceCode);
        } else if (class_exists('Text_Highlighter', false)
        && isset($highlightMap[$extension])) {
            $renderer = new Text_Highlighter_Renderer_Html(array(
                'numbers' => HL_NUMBERS_LI,
                'tabsize' => 4,
                'class_map' => array(
                    'comment'    => 'comment',
                    'main'       => 'code',
                    'table'      => 'table',
                    'gutter'     => 'gutter',
                    'brackets'   => 'brackets',
                    'builtin'    => 'keyword',
                    'code'       => 'code',
                    'default'    => 'default',
                    'identifier' => 'default',
                    'inlinedoc'  => 'inlinedoc',
                    'inlinetags' => 'inlinetags',
                    'mlcomment'  => 'mlcomment',
                    'number'     => 'number',
                    'quotes'     => 'string',
                    'reserved'   => 'keyword',
                    'special'    => 'special',
                    'string'     => 'string',
                    'url'        => 'url',
                    'var'        => 'var',
                )
            ));
            $highlighter = Text_Highlighter::factory($highlightMap[$extension]);
            $highlighter->setRenderer($renderer);

            $doc = new DOMDocument();
            $doc->loadHTML($highlighter->highlight($sourceCode));
            return $doc;
        } else {
            $sourceCode = preg_replace(
                '/.*/', '<li>$0</li>',
                htmlentities($sourceCode)
            );
            $sourceCode = '<div class="code"><ol class="code">'
                        . $sourceCode.'</ol></div>';

            $doc = new DOMDocument();
            $doc->loadHTML($sourceCode);

            return $doc;
        }
    }

    /**
     * Sorting a list of issues combining issues matching same line number
     * for each file.
     *
     * @param Array $issueList List of issues
     *
     * @return Array
     */
    private function _formatIssues($issueList)
    {
        $outputIssues = array();
        foreach ($issueList as $issue) {
            for ($i = $issue->lineStart; $i <= $issue->lineEnd; $i++) {
                $outputIssues[$i][] = $issue;
            }
        }
        return $outputIssues;
    }

}
