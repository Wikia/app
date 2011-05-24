<fb:like class="fblike" href="" send="true" layout="button_count" width="300" show_faces="false" font="" height="50"></fb:like>
<section id="WikiaQuiz" class="WikiaQuiz">
	<div class="quiz-frame">
	</div>
	<div class="title-screen">
		<h1 class="title quiz-bubble">
			<?= $data['name'] ?>
		</h1>
	</div>
	<div class="count-down" id="CountDown">
		<div class="number quiz-circle">
			3
		</div>
		<div class="cadence">
			<?= wfMsg('wikiaquiz-game-cadence-3') ?>
		</div>
	</div>
	<ul class="questions">
		
		<? 
		$numOfQuestions = count($data['elements']);
		for ($i = 0; $i < $numOfQuestions; $i++) { 
			$q = $data['elements'][$i]; ?>
			<li class="question-set">
				<div class="question-number">
					<?= $i + 1 ?>
				</div>
				<? if(!empty($q['image'])) { ?>
				<img class="question-image" src="<?= $q['image'] ?>">
				<? } ?>
				<div class="question-label">
					<?= wfMsg('wikiaquiz-game-question-label') ?> <span class="number"><?= $i + 1 ?></span>
				</div>
				<div class="question-bubble quiz-bubble">
					<div class="question">
						<?= $q['question'] ?>
					</div>
				</div>
				<ul class="answers">
					<? $correctAnswerLabel = ''; ?>
					<? foreach ($q['answers'] as $a) { ?>
						<? if(!empty($a['correct'])) { $correctAnswerLabel = $a['text']; } ?>
						<li class="answer" data-correct="<?= $a['correct'] ?>">
							<? if (empty($a['image'])) { ?>
								<div class="representation"><?= $a['text'] ?></div>
							<? } else { ?>
								<img class="representation" src="<?= $a['image'] ?>" height="155" width="155">
							<? } ?>
							<p class="answer-label" data-label="<?= $a['text'] ?>"><?= empty($a['image']) ? '' : $a['text'] ?></p>
							<div class="anchor-hack">&nbsp;</div>
						</li>
					<? } ?>
				</ul>
				<div class="explanation">
					<div class="answer-response quiz-bubble">
					</div>
					<div class="correct-answer">
						<?= $correctAnswerLabel ?>
					</div>
					<div class="answer-explanation">
						<?= $q['explanation'] ?>
					</div>
					<button><?= $i + 1 == $numOfQuestions ? wfMsg('wikiaquiz-game-finish-button') :wfMsg('wikiaquiz-game-next-button') ?></button>
				</div>
			</li>
		<? } ?>
	</ul>
	<div class="quiz-end">
		<div class="congratulations quiz-bubble">
			<?= wfMsg('wikiaquiz-game-congratulations', $username) ?>
		</div>
		<div class="score-panel">
			<?= wfMsg ('wikiaquiz-game-your-score') ?>
			<div class="score" id="FinalScore">
				0
			</div>
			<button class="continue"><?= wfMsg('wikiaquiz-game-continue-button') ?></button>
		</div>
	</div>
	<div class="quiz-thanks">
		<div class="thanks quiz-bubble">
			<?= wfmsg('wikiaquiz-game-thanks') ?>
		</div>
		<div class="more-info">
			<h2>Get the dish on the new season on the Degrassi Wiki</h2>
			<ul>
				<li>Filler Static Content</li>
				<li>Static Content</li>
				<li>Static Content</li>
			</ul>
		</div>
	</div>
</section>
<div id="QuizStatus" class="QuizStatus">
	<? if(!empty($wordmarkUrl)) { ?>
		<img src="<?= $wordmarkUrl ?>" alt="<?= $wordmarkText ?>" height="55">
	<? } ?>
	<button id="StartButton"><?= wfMsg('wikiaquiz-game-start-button') ?></button>
	<div class="leftcorner"></div>
	<div class="rightcorner"></div>
</div>
<script>
	WikiaQuizVars = {
		cadence: ['<?= wfMsg('wikiaquiz-game-cadence-3') ?>', '<?= wfMsg('wikiaquiz-game-cadence-2') ?>', '<?= wfMsg('wikiaquiz-game-cadence-1') ?>'],
		correctLabel: '<?= wfMsg('wikiaquiz-game-correct-label') ?>',
		incorrectLabel: '<?= wfMsg('wikiaquiz-game-incorrect-label') ?>'
	};
</script>