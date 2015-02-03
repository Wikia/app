<?php
/* @var $wikiData WikiDataModel */
/* @var $isAllowedToEdit bool */
?>

<header class="MainPageHeroHeader no-edit-state">
	<h1 class="title-wrap sg-title <?php if ( isset( $wikiData->title ) ) : ?>filled-state<? else : ?>zero-state<?php endif; ?>">
		<div class="edit-box">
			<div class="hero-title" contenteditable="true"><?= htmlspecialchars( $wikiData->title ) ?></div>
		</div>
		<span class="title-text"><?= htmlspecialchars( $wikiData->title ) ?></span>
		<span class="title-default-text"><?= wfMessage('hero-image-default-title')->escaped(); ?></span>
		<? if ($isAllowedToEdit): ?>
			<img class="title-edit-btn" src="/extensions/wikia/NjordPrototype/images/pencil_b.svg">
		<?endif;?>
	</h1>
	<div class="hero-description <?php if ( isset( $wikiData->description ) ) : ?>filled-state<? else : ?>zero-state<?php endif; ?>">
		<div class="edit-box">
			<span class="edited-text sg-main" contenteditable="true"><?= htmlspecialchars( $wikiData->description ) ?></span>
			<div class="btn-bar">
				<div class="new-btn discard-btn sg-sub"><?= wfMessage('hero-image-discard-btn')->escaped(); ?></div>
				<div class="new-btn save-btn sg-sub"><?= wfMessage('hero-image-publish-btn')->escaped(); ?></div>
			</div>
		</div>
		<span class="hero-description-text">
		<?php if ( isset( $wikiData->description ) ) { ?>
			<?= htmlspecialchars( $wikiData->description ) ?>
		<? } ?>
		</span>
		<?php if ( !isset ( $wikiData->description ) ) { ?>
			<span class="hero-description-default-text sg-main"><?= wfMessage('hero-image-default-description')->escaped(); ?></span>
		<? } ?>
	</div>
</header>

