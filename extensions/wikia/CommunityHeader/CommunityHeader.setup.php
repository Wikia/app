<?php
$dir = dirname( __FILE__ ) . '/';

// Hooks
$wgAutoloadClasses['CommunityHeaderHooks'] = $dir . 'CommunityHeaderHooks.class.php';
$wgHooks['BeforePageDisplay'][] = 'CommunityHeaderHooks::onBeforePageDisplay';
$wgHooks['EditPageLayoutModifyPreview'][] = 'CommunityHeaderHooks::onEditPageLayoutModifyPreview';
$wgHooks['EditPageLayoutModifyPreview'][] = 'CommunityHeaderHooks::onEditPageLayoutModifyPreview';
$wgHooks['EditPageMakeGlobalVariablesScript'][] = 'CommunityHeaderHooks::onEditPageMakeGlobalVariablesScript';
$wgHooks['MessageCacheReplace'][] = 'CommunityHeaderHooks::onMessageCacheReplace';

// Controllers
$wgAutoloadClasses['CommunityHeaderService'] = $dir . 'CommunityHeaderService.class.php';

// Classes
$wgAutoloadClasses['Wikia\CommunityHeader\Counter'] = $dir . 'Counter.class.php';
$wgAutoloadClasses['Wikia\CommunityHeader\Label'] = $dir . 'Label.class.php';
$wgAutoloadClasses['Wikia\CommunityHeader\Link'] = $dir . 'Link.class.php';
$wgAutoloadClasses['Wikia\CommunityHeader\Image'] = $dir . 'Image.class.php';
$wgAutoloadClasses['Wikia\CommunityHeader\Navigation'] = $dir . 'Navigation.class.php';
$wgAutoloadClasses['Wikia\CommunityHeader\Sitename'] = $dir . 'Sitename.class.php';
$wgAutoloadClasses['Wikia\CommunityHeader\WikiButton'] = $dir . 'WikiButton.class.php';
$wgAutoloadClasses['Wikia\CommunityHeader\WikiButtons'] = $dir . 'WikiButtons.class.php';
$wgAutoloadClasses['Wikia\CommunityHeader\Wordmark'] = $dir . 'Wordmark.class.php';
