<div class="quiz-panel">
	<div class="title-screen">
		<div class="title">
			How well do you know <span class="splash">Degrassi High?</span>
		</div>
		<div class="start-button">
			PLAY
		</div>
	</div>
	<div class="count-down">
		<div class="cadence">
			READY...
		</div>
		<div class="number">
			3
		</div>
	</div>
	<ul class="questions">
		<? for ($i = 0; $i < count($data['elements']); $i++) { 
			$q = $data['elements'][$i]; ?>
			<li class="question-set">
				<div class="question-label">
					QUESTION <span class="number"><?= $i + 1 ?></span>
				</div>
				<div class="question-bubble">
					<div class="question">
						<?= $q['question'] ?>
					</div>
					<div class="tail">
					</div>
				</div>
				<ul class="answers">
					<? foreach ($q['answers'] as $a) { ?>
						<li class="answer" data-correct="<?= $a['correct'] ?>">
							<img class="answer-pic" src="http://placekitten.com/360/360" height="180" width="180">
							<p><?= $a['text'] ?></p>
						</li>
					<? } ?>
				</ul>
				<div class="answer-explanation correct">
					<p>w00t! You rock!</p>
					<p>Paige dated Walter and blah blah blah.</p>
					<p>67% of the players got this right.</p>
				</div>
				<div class="answer-explanation wrong">
					<p>WRONG</p>
					<p>Paige dated Walter and blah blah blah.</p>
					<p>67% of the players got this right.</p>
				</div>
				<div class="answer-label">
					
				</div>
				<div class="next-button">
					NEXT
				</div>
			</li>
		<? } ?>
	</ul>
	<div class="quiz-result">
		<div class="question-bubble">
			<div class="question">
				<div>Great Job!</div>
				<div>You scored better than 76% of players</div>
			</div>
			<div class="tail">
			</div>
		</div>
		<div class="score-info points">
			<div>
				0
			</div>
			POINTS
		</div>
		<div class="score-info time">
			<div>
				0:00
			</div>
			TIME
		</div>
	</div>
</div>
<div class="quiz-ribbon">
<canvas id="timer" width="76" height="76" class="timer"></canvas>
</div>