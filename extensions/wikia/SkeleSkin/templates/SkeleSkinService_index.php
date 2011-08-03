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
					<li id="search"><img src="/skins/skeleskin/images/icons/zoom.png"></li>
					<li id="login"><img src="/skins/skeleskin/images/icons/user.png"></li>
					<li id="refreshMe"><img src="/skins/skeleskin/images/icons/refresh.png"></li>
					<li id="prevHeading"><img src="/skins/skeleskin/images/icons/object_11.png"></li>
					<li id="nextHeading"><img src="/skins/skeleskin/images/icons/object_10.png"></li>
				</ul>
			</div>
			<div id="openNavigationContent">
				<ul>
					<li id="search"><img src="/skins/skeleskin/images/icons/zoom.png"></li>
					<li id="login"><img src="/skins/skeleskin/images/icons/user.png"></li>
					<li id="refreshMe"><img src="/skins/skeleskin/images/icons/refresh.png"></li>
					<li id="prevHeading"><img src="/skins/skeleskin/images/icons/object_11.png"></li>
					<li id="nextHeading"><img src="/skins/skeleskin/images/icons/object_10.png"></li>
				</ul>
			</div>
			<div id="loginForm" class="navForm">
				<input type="text" placeholder="Login">
				<input type="password" placeholder="Password">
				<input type="submit">
			</div>
			<div id="searchForm" class="navForm">
				<input type="search" placeholder="Search">
				<input type="submit">
			</div>
			<div id="openToggle"><span id="arrow"></span></div>
		</nav>
		<?= $wikiHeaderContent ;?>
		<?= $pageContent ;?>
		<?= $jsFiles ;?>
	</body>
</html>