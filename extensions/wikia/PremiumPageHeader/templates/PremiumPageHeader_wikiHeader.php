<div class="pph-wiki-header">
	<?php // fixme it will not work with wikis without wordmark image  ?>
	<?= $app->renderView( 'WikiHeader', 'Wordmark' ) ?>
	<div class="pph-wordmark-text">
		<a href="<?= Sanitizer::encodeAttribute( $mainPageURL ); ?>"><?= $wordmarkText; ?></a>
	</div>

	<div class="pph-tally-area">
		<div class="pph-tally"><?= $tallyMsg ?></div>

		<a href="<?= $addNewPageHref; ?>" title="<?= isset( $addNewPageTitle ) ? $addNewPageTitle : ''; ?>" class="pph-hollow-button pph-add-new-page createpage">
			<svg width="14" height="16" viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
				<path
					d="M2.667 10H6v1.333H2.667V10zm0-3.333h8V8h-8V6.667zm0-3.334h8v1.334h-8V3.333zM.667 16H8v-4.667c0-.368.299-.666.667-.666h4.666v-10A.667.667 0 0 0 12.667 0h-12A.667.667 0 0 0 0 .667v14.666c0 .368.299.667.667.667z"/>
				<path d="M12.943 12h-3.61v3.61z"/>
			</svg>
			<?= $addNewPageLabel; ?>
		</a>

		<? if ( isset( $adminToolsWikiActivity ) ): ?>
			<a href="<?= $adminToolsWikiActivity['href']; ?>" class="pph-hollow-button pph-admin-tools-wiki-activity" title="<?= $adminToolsWikiActivity['title']; ?>">
				<svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"> <path d="M3.175 14c-.488 0-.948-.229-1.236-.622l-1.65-2.25a1.484 1.484 0 0 1 .343-2.094 1.537 1.537 0 0 1 2.127.338l.24.328 3.03-5.422a1.523 1.523 0 0 1 1.244-.774 1.517 1.517 0 0 1 1.329.622l1.511 2.068L13.141.778A1.534 1.534 0 0 1 15.21.187a1.487 1.487 0 0 1 .6 2.037l-4.19 7.5a1.523 1.523 0 0 1-1.243.773 1.515 1.515 0 0 1-1.33-.622l-1.51-2.069-3.028 5.417A1.524 1.524 0 0 1 3.175 14" /> </svg>
			</a>
		<? endif; ?>
	</div>
	<div class="pph-local-nav">
		<?= $app->renderView( 'PremiumPageHeader', 'navigation' ) ?>
	</div>
</div>
