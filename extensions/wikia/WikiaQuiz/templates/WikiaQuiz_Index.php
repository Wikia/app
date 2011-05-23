<section class="WikiaQuiz" data-id="<?= $quiz->getId() ?>">
<? if ($data['titlescreentext']) { ?>
<p>Title screen text: <?= $data['titlescreentext'] ?></p>
<? } ?>
<? if (sizeof($data['images'])) { ?>
<ul>
<?	foreach ($data['images'] as $image) { ?>
	<li><img src="<?= $image ?>" /></li>
<?	} ?>
</ul>
<? } ?>
<h3>Questions</h3>
<ul>
<? foreach ($data['elements'] as $element) { ?>
	<li>
	<p><a href="<?=$element['url'] ?>"><?=htmlentities($element['question']) ?></a></p>
	</li>
<?	} ?>
</ul>
</section>
