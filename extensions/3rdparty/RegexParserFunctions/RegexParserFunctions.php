<?php
/*
 * RegexParserFunctions.php - Allows regular expression search and replace within a string
 * @author Jim R. Wilson
 * @version 0.1
 * @copyright Copyright (C) 2007 Jim R. Wilson
 * @license The MIT License - http://www.opensource.org/licenses/mit-license.php 
 * -----------------------------------------------------------------------
 * Description:
 *     This is a MediaWiki extension which adds a parser function for performing
 *     regular expression searches and replacements.
 * Requirements:
 *     MediaWiki 1.6.x, 1.9.x, 1.10.x or higher
 *     PHP 4.x, 5.x or higher.
 * Installation:
 *     1. Drop this script (RegexParserFunctions.php) in $IP/extensions
 *         Note: $IP is your MediaWiki install dir.
 *     2. Enable the extension by adding this line to your LocalSettings.php:
 *         require_once('extensions/RegexParserFunctions.php');
 * Version Notes:
 *     version 0.1:
 *         Initial release.
 * -----------------------------------------------------------------------
 * Copyright (c) 2007 Jim R. Wilson
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy 
 * of this software and associated documentation files (the "Software"), to deal 
 * in the Software without restriction, including without limitation the rights to 
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of 
 * the Software, and to permit persons to whom the Software is furnished to do 
 * so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all 
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, 
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES 
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND 
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT 
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, 
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING 
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR 
 * OTHER DEALINGS IN THE SOFTWARE. 
 * -----------------------------------------------------------------------
 */
 
# Confirm MW environment
if (defined('MEDIAWIKI')) {
 
# Credits
$wgExtensionCredits['parserhook'][] = array(
    'name'=>'RegexParserFunctions',
    'author'=>'Jim R. Wilson - wilson.jim.r&lt;at&gt;gmail.com',
    'url'=>'http://jimbojw.com/wiki/index.php?title=RegexParserFunctions',
    'description'=>'Adds a parser function for search and replace using regular expressions.',
    'version'=>'0.1'
);
 
 
/**
 * Wrapper class for encapsulating Regexp related parser methods
 */
class RegexParserFunctions {
 
    /**
     * Performs regular expression search or replacement.
     * @param Parser $parser Instance of running Parser.
     * @param String $subject Input string to evaluate.
     * @param String $pattern Regular expression pattern - must use /, | or % delimiter
     * @param String $replacement Regular expression replacement.
     * @return String Result of replacing pattern with replacement in string, or matching text if replacement was omitted.
     */
    function regexParserFunction( $parser, $subject=null, $pattern=null, $replacement=null ) {
        if ($subject===null || $pattern===null) return '';
        $acceptable = '/^([\\/\\|%]).*\\1[imsu]*$/';
        if (!preg_match($acceptable, $pattern)) return wfMsg('regexp-unacceptable',$pattern);
        if ($replacement===null) {
            return (preg_match($pattern, $subject, $matches) ? $matches[0] : '');
        } else {
            return preg_replace($pattern, $replacement, $subject);
        }
    }
    
    /**
     * Adds magic words for parser functions
     * @param Array $magicWords
     * @param $langCode
     * @return Boolean Always true
     */
    function regexParserFunctionMagic( &$magicWords, $langCode ) {
        $magicWords['regex'] = array( 0, 'regex' );
        $magicWords['regexp'] = array( 0, 'regexp' );
        return true;
    }
    
    /**
     * Sets up parser functions
     */
    function regexParserFunctionSetup( ) {
    	global $wgParser, $wgMessageCache;
    	$wgParser->setFunctionHook( 'regex', array($this, 'regexParserFunction') );
    	$wgParser->setFunctionHook( 'regexp', array($this, 'regexParserFunction') );
        $wgMessageCache->addMessage('regexp-unacceptable', 'The regular expression &quot;<tt><nowiki>$1</nowiki></tt>&quot; is unacceptable.');
 
    }
    
}
 
# Create global instance and wire it up
$wgRegexParserFunctions = new RegexParserFunctions();
$wgHooks['LanguageGetMagic'][] = array($wgRegexParserFunctions, 'regexParserFunctionMagic');
$wgExtensionFunctions[] = array($wgRegexParserFunctions, 'regexParserFunctionSetup');
 
} # End MW Environment wrapper
