<div id="UPPAddQuestionBox">
	<?php if( $isAddingAllowed ): ?>
		<strong><?= wfMsg( 'userprofilepage-add-question'); ?></strong><br />
		<br />
		<textarea id="UPPQuestionBody"></textarea>
		<div id="UPPSubmitQuestion">
			<button><?= wfMsg( 'userprofilepage-question-save' ); ?></button>
		</div>
		<hr />
	<?php else: ?>
		<span><?= wfMsg( 'userprofilepage-no-more-questions-allowed' ); ?></span>
	<?php endif; ?>
</div>

<?= wfMsg( 'userprofilepage-question-list-title', $questionsNum, $maxQuestionsNum ); ?><br />

<div id="UPPQuestionList">
	<?= $questionList; ?>
</div>
