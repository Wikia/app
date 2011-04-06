<div class="quiz-panel">
	<ul class="questions">
		<? foreach ($data['elements'] as $q) { ?>
			<li class="question-set">
				<div class="question-label">
					QUESTION <span class="number">1</span>
				</div>
				<div class="question-bubble">
					<div class="question">
						<?= $q['question'] ?>
					</div>
					<div class="tail">
					</div>
				</div>
			</li>
		<? } ?>
	</ul>
</div>