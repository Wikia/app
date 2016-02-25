<div id="WallVotersModal" class="WallVotersModal wall-voters-delete">
	<?= wfMessage( 'wall-votes-modal-title-desc' )->params( [ ${WallConst::count} ] )->parse(); ?>
	<ul>
		<?php echo ${WallConst::LIST_CONST}; ?>
	</ul>
</div>
