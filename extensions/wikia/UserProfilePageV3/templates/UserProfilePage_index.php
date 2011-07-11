<div id="UPPInterviewBox">
	<h2><?= wfMsg( 'userprofilepage-interview-section-title' ); ?></h2>
	<?php if($isUserPageOwner): ?>
		<button id="UPPAnswerQuestions">answer questions</button>
	<?php endif; ?>
	<?php foreach( $questions as $question ): ?>
		<div>
			<em><?=$question->getBody();?></em>
		</div>
		<div>
			<?=$question->getAnswerBody(); ?>
		</div>
	<?php endforeach; ?>
</div>

<div id="UPPStuffBox">
	<h2><?= wfMsg( 'userprofilepage-stuff-section-title' ); ?></h2>
	<p><?= $stuffSectionBody ?></p>
</div>