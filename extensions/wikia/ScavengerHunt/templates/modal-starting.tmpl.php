<?php
$imgSprite = $game->getStartPopupSprite();
$hasSprite = ( !empty( $imgSprite['X'] ) || !empty( $imgSprite['X1'] ) || !empty( $imgSprite['X2'] )
	|| !empty( $imgSprite['Y'] ) || !empty( $imgSprite['Y1'] ) || !empty( $imgSprite['Y2'] ) ); ?>
<div id="scavengerConflictMessage"><?= wfMsg('scavengerhunt-switch-game-content') ?></div>
<?= $game->getStartingClueText() ?>
<div class="scavenger-clue-button" >
	<a id="ScavengerHuntModalCancelButton" class="button secondary">
		<?= wfMsg('scavengerhunt-quit-game-button-cancel') ?>
	</a>
	<a id="ScavengerHuntModalConfirmButton" class="button" href="<?= $game->getStartingClueButtonTarget() ?>">
		<?= $game->getStartingClueButtonText() ?>
	</a>
</div>
<?php
if ( $hasSprite ) { ?>
	<div id="scavenger-ingame-image"
	     class="scavenger-ingame-image"
	     style="background-image: url('<?= $game->getSpriteImg() ?>');
			cursor: default;
			left: <?= $imgSprite['X'] ?>px;
			top: <?= $imgSprite['Y'] ?>px;
			width: <?= $imgSprite['X2'] - $imgSprite['X1'] ?>px;
			height: <?= $imgSprite['Y2'] - $imgSprite['Y1'] ?>px;
			z-index: 1001;
			background-position: <?= -$imgSprite['X1'] ?>px <?= -$imgSprite['Y1'] ?>px;"></div>
<?php } ?>