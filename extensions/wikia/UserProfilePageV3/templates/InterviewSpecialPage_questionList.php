<?php if( !empty($questions) ): ?>
	<?php
		$index = 1;
		$questionsNum = count( $questions );
	?>
	<?php foreach($questions as $question): ?>
		<div>
			<?php if( $index > 1 ): ?>
				<button class="question-up-button">up</button>
			<?php endif; ?>
			<?php if( $index < $questionsNum ): ?>
				<button class="question-down-button">down</button>
			<?php endif; ?>
			<?= $index; ?>.
			<span id="UPPQuestionBodyContainer-<?= $question->getId(); ?>"><?= $question->getBody(); ?></span>
			<button class="question-edit-button" id="UPPQuestionEditButton-<?= $question->getId(); ?>" data-question-id="<?= $question->getId(); ?>">edit</button>
			<button class="question-delete-button" id="UPPQuestionDeleteButton-<?= $question->getId(); ?>" data-question-id="<?= $question->getId(); ?>">delete</button>
		</div>
		<?php $index++; ?>
	<?php endforeach; ?>
<?php else: ?>
	<i><?= wfMsg( 'userprofilepage-question-list-empty' ); ?></i>
<?php endif; ?>
