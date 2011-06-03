<section id="WikiaQuiz" class="WikiaQuiz">
	<div class="quiz-frame">
	</div>
	<div class="title-screen">
		<img src="<?= $data['images'][0] ?>" class="title-image image1" height="205" width="205">
		<img src="<?= $data['images'][1] ?>" class="title-image image2" height="250" width="250">
		<img src="<?= $data['images'][2] ?>" class="title-image image3" height="205" width="205">
		<h1 class="title quiz-bubble">
			<?= $data['titlescreentext'] ?>
		</h1>
	</div>
	<div class="count-down" id="CountDown">
		<img src="<?= $data['images'][0] ?>" class="title-image image1" height="205" width="205">
		<img src="<?= $data['images'][1] ?>" class="title-image image2" height="250" width="250">
		<img src="<?= $data['images'][2] ?>" class="title-image image3" height="205" width="205">
		<div class="number quiz-circle">
			3
		</div>
		<div class="cadence">
			<?= wfMsg('wikiaquiz-game-cadence-3') ?>
		</div>
	</div>
	<ul class="questions" id="Questions">
		
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
								<div class="representation text"><?= $a['text'] ?></div>
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
			<? if($wgUser->isAnon()) {
					echo wfMsg('wikiaquiz-game-congratulations-anon', $username);
			   } else {
					echo wfMsg('wikiaquiz-game-congratulations', $username);
			   } 
			?>
		</div>
		<div class="score-panel">
			<?= wfMsg ('wikiaquiz-game-your-score') ?>
			<div class="score" id="FinalScore">
				<span class="number">0</span><span class="percentage">%</span>
			</div>
			<button class="continue"><?= wfMsg('wikiaquiz-game-continue-button') ?></button>
		</div>
	</div>
	<div class="quiz-thanks">
		<img src="<?= $data['images'][0] ?>" class="title-image image1" height="205" width="205">
		<img src="<?= $data['images'][1] ?>" class="title-image image2" height="250" width="250">
		<img src="<?= $data['images'][2] ?>" class="title-image image3" height="205" width="205">
		<div class="thanks quiz-bubble">
			<?= wfmsg('wikiaquiz-game-thanks') ?>
		</div>
		<div class="more-info">
			<h2><?= $data['moreinfoheading'] ?></h2>
			<ul>
				<? foreach ($data['moreinfo'] as $line) { ?>
					<li><a href="<?= $line['url'] ?>" target="_blank"><?= $line['text'] ?></a></li>
				<? } ?>
			</ul>
		</div>
	</div>
	<div id="CorrectIcon" class="correct-icon effect"></div>
	<div id="WrongIcon" class="wrong-icon effect"></div>
	<label id="MuteToggle" class="mute-control"><input type="checkbox"><?= wfMsg('wikiaquiz-game-mute') ?></label>
</section>
<div id="QuizStatus" class="QuizStatus">
	<? if(!empty($wordmarkUrl)) { ?>
		<img src="<?= $wordmarkUrl ?>" alt="<?= $wordmarkText ?>" height="55">
	<? } ?>
	<button id="StartButton"><?= wfMsg('wikiaquiz-game-start-button') ?></button>
	<div id="ProgressBar" class="progress-bar">
		<? for ($i = 0; $i < $numOfQuestions; $i++) { ?>
			<div class="indicator"></div>
		<? } ?>
	</div>
	<div class="leftcorner"></div>
	<div class="rightcorner"></div>
</div>
<div class="quiz-facebook">
	<div class="challenge">
		<?= wfMsg('wikiaquiz-game-challenge') ?>
	</div>
	<fb:like class="fblike" href="" send="true" width="530" show_faces="true" font="" height="75" action="recommend"></fb:like>
</div>
<script>
	WikiaQuizVars = {
		cadence: ['<?= wfMsg('wikiaquiz-game-cadence-3') ?>', '<?= wfMsg('wikiaquiz-game-cadence-2') ?>', '<?= wfMsg('wikiaquiz-game-cadence-1') ?>'],
		correctLabel: '<?= wfMsg('wikiaquiz-game-correct-label') ?>',
		incorrectLabel: '<?= wfMsg('wikiaquiz-game-incorrect-label') ?>'
	};
</script>
<audio id="SoundAnswerCorrect" src="<?= $wgExtensionsPath ?>/wikia/WikiaQuiz/sounds/correct.mp3" preload="auto"></audio>
<audio id="SoundAnswerWrong" src="<?= $wgExtensionsPath ?>/wikia/WikiaQuiz/sounds/wrong.mp3" preload="auto"></audio>
<audio id="SoundApplause" src="<?= $wgExtensionsPath ?>/wikia/WikiaQuiz/sounds/applause.mp3" preload="auto"></audio>