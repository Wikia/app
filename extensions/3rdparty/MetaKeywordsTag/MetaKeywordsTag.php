<?php //{{MediaWikiExtension}}<source lang="php">
/*
 * MetaKeywordsTag.php - A MediaWiki tag extension for adding <meta> keywords to a page.
 * @author Jim R. Wilson
 * @version 0.1
 * @copyright Copyright (C) 2007 Jim R. Wilson
 * @license The MIT License - http://www.opensource.org/licenses/mit-license.php 
 * -----------------------------------------------------------------------
 * Description:
 *     This is a MediaWiki extension which adds support for injecting <meta> keyword tags
 *     into the page header.
 * Requirements:
 *     MediaWiki 1.6.x, 1.8.x, 1.9.x or higher
 *     PHP 4.x, 5.x or higher
 * Installation:
 *     1. Drop this script (MetaKeywordsTag.php) in $IP/extensions
 *         Note: $IP is your MediaWiki install dir.
 *     2. Enable the extension by adding this line to your LocalSettings.php:
 *         require_once('extensions/MetaKeywordsTag.php');
 * Usage:
 *     Once installed, you may utilize MetaKeywordsTag by adding the <keywords> tag to articles:
 *         <keywords content="example, data" />
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
    'name'=>'MetaKeywordsTag',
    'author'=>'Jim Wilson - wilson.jim.r&lt;at&gt;gmail.com',
    'url'=>'http://jimbojw.com/wiki/index.php?title=MetaKeywordsTag',
    'description'=>'Tag to inject meta keywords into page header.',
    'version'=>'0.1'
);

# Add Extension Function
$wgExtensionFunctions[] = 'setupMetaKeywordsTagParserHooks';

/**
 * Sets up the MetaKeywordsTag Parser hook and system messages
 */
function setupMetaKeywordsTagParserHooks() {
	global $wgParser, $wgMessageCache;
	$wgParser->setHook( 'keywords', 'renderMetaKeywordsTag' );
    $wgMessageCache->addMessage(
        'metakeywordstag-missing-content', 
        'Error: &lt;keywords&gt; tag must contain a &quot;content&quot; attribute.'
    );
}

/**
 * Renders the <keywords> tag.
 * @param String $text Incomming text - should always be null or empty (passed by value).
 * @param Array $params Attributes specified for tag - must contain 'content' (passed by value).
 * @param Parser $parser Reference to currently running parser (passed by reference).
 * @return String Always empty.
 */
function renderMetaKeywordsTag( $text, $params = array(), &$parser ) {

    # Short-circuit with error message if content is not specified.
    if (!isset($params['content'])) {
        return
            '<div class="errorbox">'.
            wfMsgForContent('metakeywordstag-missing-content').
            '</div>';
    }
    
    # Return encoded content
    return '<!-- META_KEYWORDS '.base64_encode($params['content']).' -->';
}

# Attach post-parser hook to extract metadata and alter headers
$wgHooks['OutputPageBeforeHTML'][] = 'insertMetaKeywords';

/**
 * Adds the <meta> keywords to document head.
 * Usage: $wgHooks['OutputPageBeforeHTML'][] = 'insertMetaKeywords';
 * @param OutputPage $out Handle to an OutputPage object - presumably $wgOut (passed by reference).
 * @param String $text Output text.
 * @return Boolean Always true to allow other extensions to continue processing.
 */
function insertMetaKeywords( $out, $text ) {

    # Extract meta keywords
    if (preg_match_all(
        '/<!-- META_KEYWORDS ([0-9a-zA-Z\\+\\/]+=*) -->/m', 
        $text, 
        $matches)===false
    ) return true;
    $data = $matches[1];
    
    # Merge keyword data into OutputPage as meta tags
    foreach ($data AS $item) {
        $content = @base64_decode($item);
        if ($content) $out->addMeta( 'keywords', $content );
    }
    return true;
}

} # End MW env wrapper
//</source>
?>
