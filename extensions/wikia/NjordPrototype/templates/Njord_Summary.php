<?php
/* @var $wikiData WikiDataModel */
/* @var $isAllowedToEdit bool */
?>

<header class="MainPageHeroHeader no-edit-state">
	<div class="hero-description <?php if ( isset( $wikiData->description ) ) : ?>filled-state<? else : ?>zero-state<?php endif; ?>">
		<div class="edit-box">
			<span class="edited-text sg-main" placeholder="<?= wfMessage('hero-image-default-description')->escaped();
			?>" contenteditable="true"><?= htmlspecialchars(
					$wikiData->description ) ?></span>
			<div class="btn-bar">
				<button class="new-btn discard-btn sg-sub"><?= wfMessage('hero-image-discard-btn')->escaped(); ?></button>
				<button class="new-btn save-btn sg-sub"><?= wfMessage('hero-image-publish-btn')->escaped(); ?></button>
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
		<? if ($isAllowedToEdit): ?>
			<span class="title-edit-btn">
				<img alt="" class="sprite edit-pencil" height="16" src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" width="22">
				<?= wfMessage('hero-image-edit-btn')->escaped(); ?>
			</span>
		<?endif;?>
	</div>
</header>

