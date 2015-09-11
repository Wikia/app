<?php if ( !empty( $approveCheckbox ) ): ?>
	<label>
		<input id='wpApprove' name='wpApprove' type='checkbox' value='1' />
		Set this script revision as approved
	</label>
<?php endif ?>
<?= F::app()->renderView('MenuButton',
	'Index',
	$button
) ?>
