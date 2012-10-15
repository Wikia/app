<nav class="activity-nav">
	<ul>
		<?php if ( $loggedIn ) {
			if ( $type == 'watchlist' ){
				?><li class="watchlist"><?= Wikia::specialPageLink('WikiActivity/activity', 'myhome-activity-feed') ?></li><?
			} else {
				?><li class="watchlist"><?= Wikia::specialPageLink('WikiActivity/watchlist', 'oasis-button-wiki-activity-watchlist') ?></li><?
			}
		} ?>
		<li><?= Wikia::specialPageLink('RecentChanges', 'oasis-button-wiki-activity-feed') ?></li>
	</ul>
<?php
	// render checkbox select default view
	if ($showDefaultViewSwitch) {
?>
	<p>
		<input type="checkbox" id="wikiactivity-default-view-switch" data-type="<?= $type ?>" disabled="disabled">
		<label for="wikiactivity-default-view-switch"><?= wfMsg('myhome-default-view-checkbox', wfMsg("myhome-{$type}-feed")) ?></label>
	</p>
<?php
	}
?>
</nav>
