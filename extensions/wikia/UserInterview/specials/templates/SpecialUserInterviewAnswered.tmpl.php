<?php 
if (isset($userAnswers)) {
?>
	<table class="user-interview-profile-container">
		<tr>
	<?php
	
	$counter = 0;
	foreach ($userAnswers as $answer) {
		$odd = ($counter%2) ? 'odd' : 'even';
		$oddOposite  = ($odd == 'odd') ? 'even' : 'odd';
?>
			<td>
				<span class="<?= $odd ?>">
					<blockquote class="question"><h3><?= $answer['question'] ?></h3></blockquote>
				</span>
				<span class="<?= $oddOposite ?>">
					<?= $avatarImg ?>
					<blockquote class="answer"><?= $answer['answer'] ?></blockquote>
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
?>
		</tr>
	</table>
<?php
}
?>