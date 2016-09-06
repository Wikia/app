<div class="global-navigation-wrapper">
	<nav class="global-navigation" id="globalNavigation">
		<div class="global-navigation-container">
			<div class="wikia-logo-container table-cell">
				<a href="<?= htmlspecialchars( $centralUrl ) ?>"
					class="wikia-logo final-url"
					rel="nofollow"
					data-id="wikia-logo">
					<img src="<?= $wg->BlankImgUrl ?>"
						height="24"
						width="91"
						alt="<?= wfMessage( 'oasis-global-page-header' )->escaped() ?>"
						title="<?= wfMessage( 'oasis-global-page-header' )->escaped() ?>">
					<? if ( $isFandomExposed ): ?>
						<span class="wikia-logo__subtitle"><?= wfMessage( 'global-navigation-home-of-fandom' )->escaped() ?></span>
					<? endif; ?>
				</a >
			</div >
			<?php if ( !empty( $menuContents['hubs'] ) && is_array( $menuContents['hubs'] ) ): ?>
				<div class="table-cell hubs-links" data-visibility="desktop">
					<?php foreach ( $menuContents['hubs'] as $hub ): ?>
						<a class="cell-link top-level" href="<?= $hub['href']; ?>"
						   data-tracking-label="hub-<?= $hub['specialAttr']; ?>">
							<?= $hub['textEscaped']; ?>
						</a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			<div class="table-cell">
				<div class="explore-wikia-entry-point" id="exploreWikiaEntryPoint">
					<a class="cell-link top-level final-url"
						href="<?= $isFandomExposed ? $menuContents['exploreWikia']['href'] : '#' ?>"
						data-tracking-label="<?=  $menuContents['exploreWikia']['trackingLabel']; ?>">
						<?= $menuContents['exploreWikia']['textEscaped'] ?>
						<img class="chevron" src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"/>
					</a>
					<ul class="explore-wikia-dropdown" id="exploreWikiaDropdown">
						<?php if ( !empty( $menuContents['hubs'] ) && is_array( $menuContents['hubs'] ) ): ?>
							<?php foreach ( $menuContents['hubs'] as $hub ): ?>
								<li>
									<a class="cell-link"
									   data-visibility="tablet"
									   href="<?= $hub['href']; ?>"
									   data-tracking-label="hub-<?= $hub['specialAttr']; ?>">
										<?= $hub['textEscaped']; ?>
									</a>
								</li>
							<?php endforeach; ?>
						<?php endif; ?>
						<?php foreach ( $menuContents['exploreDropdown'] as $exploreLink ): ?>
							<li>
								<a class="cell-link"
								   href="<?= $exploreLink['href']; ?>"
								   data-tracking-label="<?= $exploreLink['trackingLabel']; ?>">
									<?= $exploreLink['textEscaped']; ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
			<div class="search-container table-cell">
				<?= $app->renderView( 'GlobalNavigation', 'searchIndex' ); ?>
			</div>
			<div class="account-navigation-container table-cell">
				<?= $app->renderView( 'GlobalNavigationAccountNavigation', 'index' ) ?>
			</div>
			<?php if ( !$isAnon && $notificationsEnabled ): ?>
				<div class="notifications-container table-cell" id="notificationsEntryPoint">
					<?= $app->renderView( 'GlobalNavigationWallNotifications', 'Index' ); ?>
				</div>
			<?php endif; ?>
			<div class="start-wikia-container table-cell">
				<a href="<?= htmlspecialchars( $createWikiUrl ) ?>"
				   class="start-wikia"
				   title="<?= wfMessage( 'global-navigation-create-wiki' )->escaped(); ?>"
				   data-id="start-wikia">
					<span><?= ( wfMessage( 'global-navigation-create-wiki' )->escaped() ); ?></span>
				</a>
			</div>
		</div>
	</nav>
</div>
