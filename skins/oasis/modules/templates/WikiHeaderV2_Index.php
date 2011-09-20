<header id="WikiHeader" class="WikiHeaderRestyle">
	<h1 class="wordmark <?= $wordmarkSize ?> <?= $wordmarkType ?>">
		<a accesskey="z" href="<?= htmlspecialchars($mainPageURL) ?>">
			<? if (!empty($wordmarkUrl)) { ?>
				<img src="<?= $wordmarkUrl ?>" alt="<?= htmlspecialchars($wordmarkText) ?>">
			<? } else { ?>
				<?= htmlspecialchars($wordmarkText) ?>
			<? } ?>
		</a>
	</h1>
	<nav>
		<h1><?= wfMsg( 'oasis-wiki-navigation', $wordmarkText ); ?></h1>
		<?php
			// render wiki navigation
			echo wfRenderModule('WikiNavigation');
		?>
	</nav>
	<div class="buttons">
		<?php
			// render "Contribute" menu
			echo wfRenderModule('ContributionMenu');
		?>
	</div>

	<div style="position: absolute; top: -1000px">
			<?= Wikia::specialPageLink('Watchlist', 'watchlist', array('accesskey' => 'l')) ?>
			<?= Wikia::specialPageLink('RecentChanges', 'recentchanges', array('accesskey' => 'r')) ?>
	</div>
	<img class="shadow-mask" src="<?= $wgBlankImgUrl ?>" width="0" height="0">
</header>
