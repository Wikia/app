<div id="WallVotersModal" class="WallVotersModal wall-voters-delete">
	<h1><?= wfMsg('wall-votes-modal-title') ?></h1>
	<?= wfMsgExt( 'wall-votes-modal-title-desc', array( 'parseinline' ), $count ) ?>
	<ul>
		<?php echo $list; ?>
	</ul>
</div>