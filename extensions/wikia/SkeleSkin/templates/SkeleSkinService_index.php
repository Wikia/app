<!DOCTYPE html>
<html lang="<?= $languageCode ;?>" dir="<?= $languageDirection ;?>"<? if ( !empty( $appCacheManifestPath ) ) :?> manifest="<?= $appCacheManifestPath ;?>"<? endif ;?>>
	<head>
		<title><?= htmlspecialchars( $pageTitle ) ;?></title>
		<? if( !$showAllowRobotsMetaTag ): ?>
			<meta name="robots" content="noindex, nofollow"/>
		<?endif; ?>
		<meta http-equiv="Content-Type" content="<?= $mimeType ;?>; charset=<?= $charSet ;?>"/>
		<meta name="HandheldFriendly" content="true" />
		<meta name="MobileOptimized" content="width" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />	
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<link rel="alternate" media="handeld" href="" />
		<?= $headLinks ;?>
		<?= $cssLinks ;?>
	</head>
	<body>
		<nav id="navigation">
			<div id="closeNavigationContent">
				<ul>
					<li><img src="http://images.jolek.wikia-dev.com/__cb20080717214219/wowwiki/images/f/fa/IconSmall_Deathknight.gif"></li>
					<li><img src="http://images.jolek.wikia-dev.com/__cb20050912092650/wowwiki/images/4/4a/IconSmall_Warrior.gif"></li>
					<li><img src="http://images.jolek.wikia-dev.com/__cb20050912092529/wowwiki/images/7/77/IconSmall_Paladin.gif"></li>
					<li id="prevHeading"><img src="/skins/skeleskin/images/icons/object_11.png"></li>
					<li id="nextHeading"><img src="/skins/skeleskin/images/icons/object_10.png"></li>
				</ul>
			</div>
			<div id="openNavigationContent">
				open
			</div>
			<div id="openToggle"><span id="arrow"></span></div>
		</nav>
		<?= $wikiHeaderContent ;?>
		<?= $pageContent ;?>
		<?= $jsFiles ;?>
	</body>
</html>