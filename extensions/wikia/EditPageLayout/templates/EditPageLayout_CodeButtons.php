<?php if ( !empty( $approveCheckbox ) ): ?>
	<label for="wpApprove" class="approve-changes-label">
		<input id='wpApprove' name='wpApprove' type='checkbox' value='1'/>
		<?= wfMessage( 'content-review-edit-page-checkbox-label' )->escaped() ?>
	</label>
<?php endif ?>
<?= F::app()->renderView( 'MenuButton', 'Index', $button ); ?>
