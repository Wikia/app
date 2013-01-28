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

$app = F::app();
$dir = dirname( __FILE__ ) . '/';

// Classes
$app->registerClass( 'CategorySelect', $dir . 'CategorySelect.class.php' );
$app->registerClass( 'CategorySelectController', $dir . 'CategorySelectController.class.php' );
$app->registerClass( 'CategorySelectHooksHelper', $dir . 'CategorySelectHooksHelper.class.php' );

// Hooks
$app->registerHook( 'GetPreferences', 'CategorySelectHooksHelper', 'onGetPreferences' );
$app->registerHook( 'MediaWikiPerformAction', 'CategorySelectHooksHelper', 'onMediaWikiPerformAction' );

// Messages
$app->registerExtensionMessageFile( 'CategorySelect', $dir . 'CategorySelect.i18n.php' );

F::build( 'JSMessages' )->registerPackage( 'CategorySelect', array(
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
