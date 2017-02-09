<header id="WikiHeader" class="WikiHeader">
	<?= $app->renderView( 'WikiHeader', 'Wordmark' ) ?>
	<nav class="WikiNav">
		<? if ( $displayHeader ): ?>
			<h2><?= wfMessage( 'oasis-wiki-navigation', $wordmarkText )->escaped() ?></h2>
		<? endif; ?>
		<?= $app->renderView( 'WikiNavigation', 'Index' ) ?>
	</nav>
	<? if ( $displayHeaderButtons ) : ?>
		<div class="buttons">
      <? if ($useAddPageButton) { ?>
        <button id="add-page" class="wds-button wds-is-squished wds-is-secondary">
          <svg class="wds-icon wds-icon-tiny">
            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#wds-icons-plus" />
          </svg>
          <span>Add Page</span>
        </button>
      <? } else { ?>
				<?= $app->renderView('ContributeMenu', 'Index'); ?>
      <? } ?>
		</div>
	<? endif ?>
	<div class="hiddenLinks">
		<a href="<?= Sanitizer::encodeAttribute( $hiddenLinks['watchlist'] ); ?>" accesskey="l"><?= wfMessage( 'watchlist' )->escaped(); ?></a>
		<a href="<?= Sanitizer::encodeAttribute( $hiddenLinks['random'] ); ?>" accesskey="x"><?= wfMessage( 'randompage' )->escaped(); ?></a>
		<a href="<?= Sanitizer::encodeAttribute( $hiddenLinks['recentchanges'] ); ?>" accesskey="r"><?= wfMessage( 'recentchanges' )->escaped(); ?></a>
	</div>
</header>
