
<div class='createExperiment'>
	<form method='post' action=''>
		<input type='hidden' name='formName' value='ab_createExperiment'/>
		<h2><?= wfMsg('abtesting-create-experiment-heading'); ?></h2>

		<label for='expName'>
			<?= wfMsg('abtesting-create-experiment-exp-name'); ?>
		</label><br/>
		<input type='text' name='expName' value='<?= $expName; ?>'/><br/>
		
		<fieldset>
			<legend><?= wfMsg('abtesting-create-experiment-treatment-groups'); ?></legend>
			
			TODO: Rows for a number of Treatment Groups (with a radio button for which one is the control group).
			
		</fieldset>
		
		


		<br/>
		<button type='submit' name='submit'><?= wfMsg('abtesting-create-experiment-submit'); ?></button>
	</form>
</div>
