<div id="WallVotersModal" class="WallVotersModal wall-voters-delete">
	<?= wfMessage( 'wall-votes-modal-title-desc' )->params( [ $count ] )->parse(); ?>
	<ul>
		<?php echo $list; ?>
	</ul>
</div>
