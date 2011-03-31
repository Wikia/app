<?php 
if (isset($adminQuestion)) {
?>

<section class="user-interview-profile-form-container">
	<nav class="toggle-user-interview-container">
		<a class="toggle-user-interview wikia-button">
			<img class="sprite edit-pencil" src="<?= $wgStylePath ?>/oasis/images/icon_edit.png" class="popout">Answer some questions about yourself!</a>
	</nav>

<form action="<?= $userFormURL ?>" id="user-interview-form" method="post">
	<input type="hidden" id="user-interview-question-ids" value="<?= $questionIDs ?>"/>

	<table class="user-interview-profile-container">
		<tr>
	<?php
	
	$counter = 0;
	if (isset($adminQuestion)) {
		foreach ($adminQuestion as $question) {
			$odd = ($counter%2) ? 'odd' : 'even';
			$oddOposite  = ($odd == 'odd') ? 'even' : 'odd';
?>		
			<td>
				<span class="<?= $odd ?>">
					<blockquote class="question"><h3><?= $question['question'] ?></h3></blockquote>
				</span>
				<span class="<?= $oddOposite ?>">
					<?= $avatarImg ?>
					<blockquote class="answer"><textarea name="<?= $question['id'] ?>"><?php
					if (isset($question['answer'])) {
						echo $question['answer'];
					}
				?></textarea></blockquote>
				</span>
			</td>
			<?php 
		if ($odd == 'odd') { ?>
			</tr>
			<tr>				
				<?php 
			}
			$counter ++;		
		}
	}
?>
		</tr>
		<tr class="submit-column">
			<td colspan="2">
				<input type="submit" id="UserInterviewSave" value="<?=wfMsg('fb-sync-save')?>" />
			</td>
		</tr>
	</table>
</form>
</section>
	<?php
}
?>