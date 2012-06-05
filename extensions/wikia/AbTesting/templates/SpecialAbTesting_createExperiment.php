
<div class='createExperiment'>
	<form method='post' action=''>
		<input type='hidden' name='formName' value='ab_createExperiment'/>
		<h2><?= wfMsg('abtesting-create-experiment-heading'); ?></h2>

		<label for='expName'>
			<?= wfMsg('abtesting-create-experiment-exp-name'); ?>
		</label><br/>
		<input type='text' name='expName' value='<?= $expName; ?>'/><br/>
		
		
		


		<br/>
		<button type='submit' name='submit'><?= wfMsg('abtesting-create-experiment-submit'); ?></button>
	</form>
</div>
