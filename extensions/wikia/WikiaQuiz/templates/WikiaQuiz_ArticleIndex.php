<section class="WikiaQuizArticle" data-id="<?= $quizElement->getId() ?>">
<p>(in the quiz <a href="<?=$data['quizUrl']?>"><?= htmlentities($data['quiz']) ?></a>)</p>
<? if ($data['image']) { ?>
<img src="<?= $data['image'] ?>" />
<? } ?>
<? if (is_array($data['answers'])) { ?>
<h3>Answers</h3>
<ul>
	<? foreach ($data['answers'] as $answer) { ?>
	<li<? if ($answer['correct']) { ?> class="correct-answer"<? } ?>>
		<? if ($answer['image']) { ?>
		<img src="<?= $answer['image'] ?>" />
		<? } ?>
		<p><?=htmlentities($answer['text']) ?></p>
	</li>
<?	} ?>
</ul>
<? } ?>
<? if ($data['explanation']) { ?>
<h3>Explanation</h3>
<p><?= htmlentities($data['explanation']) ?></p>
<? } ?>
</section>
