<?php
/**
 * NewWindowLinks: setup.
 * 
 * Usage:
 * 
 * general: {{ #NewWindowLink: linked resource | link text }}
 * 
 * local links: {{ #NewWindowLink: Special:Version | software and installed extensions }}
 * external links: {{ #NewWindowLink: http://mediawiki.org/ | MediaWiki }}
 * interwiki links: {{ #NewWindowLink: Wikipedia:MediaWiki | Wikipedia article about MediaWiki }}
 * mailto links: {{ #NewWindowLink: mailto:john@example.com | mail John }}
 * 
 * The second parameter - link text - is optional.  If not given, the link to the resource will be used as a link text.
 * 
 * general: {{ #NewWindowLink: linked resource }}
 * 
 * local links: {{ #NewWindowLink: Special:Version }}
 * external links: {{ #NewWindowLink: http://mediawiki.org/ }}
 * interwiki links: {{ #NewWindowLink: Wikipedia:MediaWiki }}
 * mailto links: {{ #NewWindowLink: mailto:john@example.com }}
 * 
 */

/**
 * Extension credits.
 */
$wgExtensionCredits['parserhook'][] = array(
    'path'              => __FILE__,
    'name'              => 'NewWindowLinks',
    'description'       => 'Create links to be opened in a new browser window or tab.',
    'descriptionmsg'    => 'newwindowlinks-desc',
    'version'           => '1.0',
    'author'            => array( '[http://community.wikia.com/wiki/User:Mroszka Michał Roszka (Mix)]' ),
    'url'               => 'http://www.mediawiki.org/wiki/Extension:NewWindowLinks',
);

/**
 * Classes to be loaded.
 */
$wgAutoloadClasses['NewWindowLinks'] = dirname( __FILE__ ) . '/NewWindowLinks.class.php';

/**
 * Internationalisation: messages and magic words.
 */
$wgExtensionMessagesFiles['NewWindowLinks'] = dirname( __FILE__ ) . '/NewWindowLinks.i18n.php';

/**
 * Hooks.
 */
$wgHooks['ParserFirstCallInit'][]   = 'NewWindowLinks::hookParserFirstCallInit';