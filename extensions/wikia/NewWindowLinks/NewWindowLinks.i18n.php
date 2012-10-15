<?php
/**
 * @file NewWindowLinks.i18n.php
 * @brief I18n for the NewWindowLinks MediaWiki extension.
 * @author Michał Roszka (Mix) <michal@wikia-inc.com>
 * @date Friday, 30 December 2012 (created)
 * @date Friday, 25 May 2012 (MediaWiki 1.19 merge)
 */
$messages = array();
/**
 * Message documentation.
 */
$messages['qqq'] = array(
    'newwindowlinks-desc' => 'A brief plain text description of the extension used on the Special:Version page.',
    'newwindowlinks-invalid-target' => 'An error message saying that the target for the link is invalid and could not be converted into a working link.'
);
/**
 * English.
 */
$messages['en'] = array(
    'newwindowlinks-desc' => 'Create links to be opened in a new browser window or tab.',
    'newwindowlinks-invalid-target' => 'Could not process the link target.'
);

/**
 * NewWindowLinks: the magic words.
 */
$magicWords = array();
/**
 * Magic word documentation.
 */
$magicWords['qqq'] = array(
    'NewWindowLink' => array( 1, 'A brief descriptive or imperative key phrase for a link that would open in a new browser window or tab.' )
);
/**
 * English
 */
$magicWords['en'] = array(
    'NewWindowLink' => array( 1, 'NewWindowLink' )
);
