<?php
$wgExtensionMessagesFiles['ArticleVideo'] = __DIR__ . '/ArticleVideo.i18n.php';
$wgAutoloadClasses['ArticleVideoHooks'] = __DIR__ . '/ArticleVideo.hooks.php';
$wgAutoloadClasses['ArticleVideoController'] = __DIR__ . '/ArticleVideoController.class.php';

$wgHooks['BeforePageDisplay'][] = 'ArticleVideoHooks::onBeforePageDisplay';
$wgHooks['MakeGlobalVariablesScript'][] = 'ArticleVideoHooks::onMakeGlobalVariablesScript';
$wgHooks['SkinAfterBottomScripts'][] = 'ArticleVideoHooks::onSkinAfterBottomScripts';


// cityId => articleId => videoDetails
$wgVideoMVPArticles = [
	'509' => [
		3581 => [
			'time' => '2:39',
			'title' => 'Top 5 Best Spells in the Wizarding World',
			'videoId' => 'hwM2FkOTE6R_fZR9uu5jvOy9FHm3NS1O',
			'thumbnailPath' => '/wikia/ArticleVideo/images/list-of-spells-thumb.jpg',
		],
	],
	'1265146' => [
		325 => [
			'time' => '2:39',
			'title' => 'Top 5 Best Spells in the Wizarding World',
			'videoId' => 'hwM2FkOTE6R_fZR9uu5jvOy9FHm3NS1O',
			'thumbnailPath' => '/wikia/ArticleVideo/images/list-of-spells-thumb.jpg',
		],
		298 => [
			'time' => '2:39',
			'title' => 'Top 5 Best Spells in the Wizarding World',
			'videoId' => 'hwM2FkOTE6R_fZR9uu5jvOy9FHm3NS1O',
			'thumbnailPath' => '/wikia/ArticleVideo/images/list-of-spells-thumb.jpg',
		],
		288 => [
			'time' => '2:39',
			'title' => 'Top 5 Best Spells in the Wizarding World',
			'videoId' => 'hwM2FkOTE6R_fZR9uu5jvOy9FHm3NS1O',
			'thumbnailPath' => '/wikia/ArticleVideo/images/list-of-spells-thumb.jpg',
		],
		292 => [
			'time' => '2:39',
			'title' => 'Top 5 Best Spells in the Wizarding World',
			'videoId' => 'hwM2FkOTE6R_fZR9uu5jvOy9FHm3NS1O',
			'thumbnailPath' => '/wikia/ArticleVideo/images/list-of-spells-thumb.jpg',
		],
		167 => [
			'time' => '2:39',
			'title' => 'Top 5 Best Spells in the Wizarding World',
			'videoId' => 'hwM2FkOTE6R_fZR9uu5jvOy9FHm3NS1O',
			'thumbnailPath' => '/wikia/ArticleVideo/images/list-of-spells-thumb.jpg',
		],
		158 => [
			'time' => '2:39',
			'title' => 'Top 5 Best Spells in the Wizarding World',
			'videoId' => 'hwM2FkOTE6R_fZR9uu5jvOy9FHm3NS1O',
			'thumbnailPath' => '/wikia/ArticleVideo/images/list-of-spells-thumb.jpg',
		],
	],
	'1046' => [
		2618 => [
			'time' => '2:39',
			'title' => 'Top 5 Best Spells in the Wizarding World',
			'videoId' => 'hwM2FkOTE6R_fZR9uu5jvOy9FHm3NS1O',
			'thumbnailPath' => '/wikia/ArticleVideo/images/list-of-spells-thumb.jpg',
		],
	],
];
