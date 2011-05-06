<section class="WikiaQuiz" data-id="<?= $quiz->getId() ?>">
<? foreach ($data['elements'] as $element) { ?>
	<li>
	<p><a href="<?=$element['url'] ?>"><?=htmlentities($element['question']) ?></a></p>
	</li>
<?	} ?>
</section>
