<?php

/**
 * CategorySelect
 *
 * A CategorySelect extension for MediaWiki
 * Provides an interface for managing categories in article without editing whole article
 *
 * @author Maciej Błaszkowski (Marooned) <marooned@wikia-inc.com>
 * @author Kyle Florence <kflorence@wikia-inc.com>
 */

$wgExtensionCredits[ 'other' ][] = array(
	'name' => 'CategorySelect',
	'author' => array(
		'[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]',
		'Kyle Florence',
	),
	'description' => 'Provides an interface for managing categories in article without editing whole article.',
	'description-msg' => 'categoryselect-desc',
);

$dir = dirname( __FILE__ ) . '/';

// Classes
$wgAutoloadClasses[ 'CategorySelectController'] =  $dir . 'CategorySelectController.class.php' ;
$wgAutoloadClasses[ 'CategorySelectHelper'] =  $dir . 'CategorySelectHelper.class.php' ;
$wgAutoloadClasses[ 'CategorySelectHooksHelper'] =  $dir . 'CategorySelectHooksHelper.class.php' ;

// Hooks
$wgHooks['GetPreferences'][] = 'CategorySelectHooksHelper::onGetPreferences';
$wgHooks['MediaWikiPerformAction'][] = 'CategorySelectHooksHelper::onMediaWikiPerformAction';

// Messages
$wgExtensionMessagesFiles['CategorySelect'] = $dir . 'CategorySelect.i18n.php' ;

JSMessages::registerPackage( 'CategorySelect', array(
	'categoryselect-button-save',
	'categoryselect-category-add',
	'categoryselect-category-edit',
	'categoryselect-category-remove',
	'categoryselect-error-category-name-length',
	'categoryselect-error-duplicate-category-name',
	'categoryselect-error-empty-category-name',
	'categoryselect-modal-category-name',
	'categoryselect-modal-category-sortkey',
	'categoryselect-tooltip-add',
));
