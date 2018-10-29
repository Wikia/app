<div class="language-wiki-index">
	<div class="language-wiki-index__intro"><?= wfMessage( 'languagewikisindex-intro' )->escaped(); ?></div>
	<div class="language-wiki-index__list-intro">
		<span class="wds-midlight-aqua"><?= wfMessage( 'languagewikisindex-list-intro' )->escaped(); ?></span>
	</div>
	<div class="language-wiki-index__list">
		<?php foreach ( $langWikis as $langWiki ): ?>
		<div class="language-wiki-index__list-language language-<?= Sanitizer::encodeAttribute( $langWiki['city_lang'] ); ?>">
			<a href="<?= Sanitizer::encodeAttribute( wfHttpToHttps( $langWiki['city_url'] ) ); ?>"><?= htmlspecialchars( Language::getLanguageName( $langWiki['city_lang'] ) ); ?> &middot; <?= htmlspecialchars( $langWiki['city_title'] ); ?></a>
		</div>
		<?php endforeach; ?>
	</div>
	<div class="language-wiki-index__create-wiki">
		<span class="language-wiki-index__create-wiki-question">
			<?= wfMessage( 'languagewikisindex-cnw-question' )->escaped(); ?>
		</span>
		<a href="<?= Sanitizer::encodeAttribute( $cnwLink ); ?>" class="language-wiki-index__create-wiki-link">
			<?= wfMessage( 'languagewikisindex-cnw-link-text' )->escaped(); ?>
			<?= DesignSystemHelper::renderSvg( 'wds-icons-arrow',
				'wds-icon wds-icon-small language-wiki-index__create-wiki-link-icon' ) ?>
		</a>
	</div>
	<hr />
	<div class="language-wiki-index__links">
		<?php
		/**
		 * Message keys used here:
		 *     languagewikisindex-links-cnw
		 *     languagewikisindex-links-fandom
		 *     languagewikisindex-links-help
		 */
		foreach ( $links as $messageKey => $link ):
		?>
		<a href="<?= Sanitizer::encodeAttribute( $link ); ?>" class="language-wiki-index__links-item">
			<?= wfMessage( "languagewikisindex-links-{$messageKey}" )->escaped(); ?>
		</a>
		<?php endforeach; ?>
	</div>
</div>
