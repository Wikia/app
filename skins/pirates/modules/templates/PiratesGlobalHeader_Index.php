<? if ( !empty($isGameStarLogoEnabled )): ?>
	<div class="gamestar-wrapper">
		<div class="gamestar-container">
			<div class="gamestar"></div>
		</div>
	</div>
<? endif; ?>
<header class="WikiaHeader v2 hide-new-wiki" id="WikiaHeader">
	<div class="wikia-header-mask">
		<div class="page-width-container">
			<nav>
				<ul>
					<li id="GlobalNavigationMenuButton">Menu</li><li class="WikiaLogo">
						<a rel="nofollow" href="http://www.wikia.com/Wikia"><img width="91" height="23" alt="Wikia" class="sprite logo" src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"></a>
					</li>
					<li class="start-a-wiki">
						<a class="wikia-button" href="http://www.lukaszk.wikia-dev.com/Special:CreateNewWiki">Create a wiki</a>
					</li>
					<li class="global-search no-verticals">
						<form class="search-form" method="get" action="http://www.lukaszk.wikia-dev.com/Special:Search">
							<input type="text" class="search-box" accesskey="f" autocomplete="off" name="search" placeholder="Search...">
							<input type="hidden" name="resultsLang" value="en"><input type="hidden" name="fulltext" value="Search">
							<input type="submit" class="search-button" value="Search this Wikia">
							<input type="submit" class="search-button alternative" value="Search all Wikia">
						</form>
					</li>
				</ul>
			</nav>
			<?= $app->renderView('AccountNavigation', 'Index') ?>
			<?= $app->renderView('WallNotifications', 'Index') ?>
		</div>
	</div>
</header>
