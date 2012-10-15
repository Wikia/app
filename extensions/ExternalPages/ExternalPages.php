<?php
/**
 * A Special Page extension to retrieve and display a page
 * from a specified external WMF site, with optional year,
 * project and language parameters
 *
 * @file
 * @ingroup Extensions
 * @version 0.1
 * @author Ariel Glenn <ariel@wikimedia.org>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 3.0 or later
 */

/** Configuration */

/**
 * Expiry time for the server-side source cache and the squid cache, in seconds
 */
$wgExternalPagesCacheExpiry = 600;

/**
 * Allowed page configuration.
 * This should be a map of local subpage name to a remote page info structure.
 * Valid keys in the remote page structure are:
 *    site:  A site as specified in $wgExternalPagesSites
 *    title: The full page title, as you would use in an internal link
 *
 * For example:
 *
 *   $wgExternalPages = array(
 *      'news' => array( 
 *          'site' => 'wmf',
 *          'title' => 'Current events'
 *      )
 *   );
 *
 * Then this page becomes accessible via [[Special:ExternalPages/news]].
 */
$wgExternalPages = array();

/**
 * Site configuration
 * Allowed keys are:
 *   scriptUrl: the URL of index.php
 *
 * Example:
 *
 *     $wgExternalPagesSites = array(
 *         'wmf' => array( 'scriptUrl' => 'http://wikimediafoundation.org/w/index.php' )
 *     );
 */
$wgExternalPagesSites = array();

/** Registration */

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'ExternalPages',
	'version' => '0.1',
	'author' => 'Ariel Glenn',
	'url' => 'https://www.mediawiki.org/wiki/Extension:ExternalPages',
	'descriptionmsg' => 'externalpages-desc',
);

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['ExternalPages'] = $dir . 'ExternalPages.i18n.php';
$wgExtensionMessagesFiles['ExternalPagesAlias'] = $dir . 'ExternalPages.alias.php';

$wgAutoloadClasses['ExternalPages'] = $dir . 'ExternalPages_body.php';

$wgSpecialPages['ExternalPages'] = 'ExternalPages';
