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
			<div id="openNavigationContent">
				<ul id="navigationMenu">
					<li class="openMenu">Menu</li>
					<li>Explore</li>
					<li>Search</li>
					<li>Login</li>
				</ul>
		
			</div>
			<div id="openToggle"><span id="arrow"></span></div>
		</nav>
		<?= $wikiHeaderContent ;?>
		<?= $pageContent ;?>
		<?= $jsFiles ;?>
	</body>
</html>