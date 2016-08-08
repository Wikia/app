<nav class="activity-nav">
	<ul>
		<?php if ( $loggedIn ): ?>
			<?php if ( $type == 'watchlist' ): ?>
				<li class="watchlist">
					<a href="<?= Skin::makeSpecialUrl( 'WikiActivity/activity' ); ?>">
						<?= wfMessage( 'myhome-activity-feed' )->escaped(); ?>
					</a>
				</li>
			<?php else: ?>
				<li class="watchlist">
					<a href="<?= Skin::makeSpecialUrl( 'WikiActivity/watchlist' ); ?>">
						<?= wfMessage( 'oasis-button-wiki-activity-watchlist' )->escaped(); ?>
					</a>
				</li>
			<?php endif; ?>
		<?php endif; ?>
		<li>
			<a href="<?= Skin::makeSpecialUrl( 'RecentChanges' ); ?>">
				<?= wfMessage( 'oasis-button-wiki-activity-feed' )->escaped(); ?>
			</a>
		</li>
	</ul>
<?php if ( $showDefaultViewSwitch ): // render checkbox select default view ?>
	<p>
		<input type="checkbox" id="wikiactivity-default-view-switch" data-type="<?= $type ?>" disabled="disabled">
		<label for="wikiactivity-default-view-switch">
			<?= wfMessage( 'myhome-default-view-checkbox', wfMessage( "myhome-{$type}-feed" )->plain() )->escaped(); ?>
		</label>
	</p>
<?php endif; ?>
</nav>
