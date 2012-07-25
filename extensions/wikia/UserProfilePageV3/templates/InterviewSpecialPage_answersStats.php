<h2><?= wfMsg( 'userprofilepage-answers-stats-title' ); ?></h2>
<br />
<?php foreach( $questions as $question ): ?>
	<div>
		<em><?= $question->getBody(); ?></em>
		<div>
			<strong><?= $question->getAnswersCount(); ?></strong>
		</div>
	</div>
<?php endforeach; ?>