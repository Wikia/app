<div class="trivia">
	<div class="info-panel">
		<div class="score-pane">Score: <span class="score">0</span></div>
		<div class="timer">Time Left <span class="clock"></span></div>
	</div>
	<ol class="question-sets">
		<? foreach ($data['elements'] as $q) { ?>
			<li class="question-set">
				<div class="question-ui">
					<p class="question">
						<?= $q['question'] ?>
					</p>
					<ul class="choices">
						<? foreach ($q['answers'] as $a) { ?>
							<li data-correct="<?= $a['correct'] ?>"><?= $a['text'] ?></li>
						<? } ?>
					</ul>
				</div>
				<div class="next-button">
					Next Question
				</div>
			</li>
		<? } ?>
	</ol>
	<div class="answer-feedback star"></div>
	<div class="answer-feedback wrong"></div>
</div>
<audio id="sound-menu-hover" src="/extensions/wikia/WikiaQuiz/sounds/button-34.mp3" preload="auto"></audio>
<audio id="sound-answer-correct" src="/extensions/wikia/WikiaQuiz/sounds/magic-chime-01.mp3" preload="auto"></audio>
<audio id="sound-answer-wrong" src="/extensions/wikia/WikiaQuiz/sounds/clank.mp3" preload="auto"></audio>