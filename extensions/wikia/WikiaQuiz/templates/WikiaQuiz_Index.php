<? if (!empty($quiz)) { ?>
<section class="WikiaQuiz" data-id="<?= $quiz->getId() ?>">
<? if ($data['titlescreentext']) { ?>
<p>Title screen text: <?= $data['titlescreentext'] ?></p>
<? } ?>
<? if ($data['fbrecommendationtext']) { ?>
<p><?= wfMsg('wikiaquiz-fbrecommendationtext-label') ?>: <?= $data['fbrecommendationtext'] ?></p>
<? } ?>
<? if (sizeof($data['images'])) { ?>
<ul>
<?	foreach ($data['images'] as $image) { ?>
	<li><img src="<?= $image ?>" /></li>
<?	} ?>
</ul>
<? } ?>
<? if ($data['moreinfoheading']) { ?>
<p>More Info heading: <?= $data['moreinfoheading'] ?></p>
<? } ?>
<? if (sizeof($data['moreinfo'])) { ?>
<h3>More Info articles</h3>
<ul>
<? foreach ($data['moreinfo'] as $moreinfo) { ?>
	<li><a href="<?=$moreinfo['url']?>"><?=$moreinfo['text']?$moreinfo['text']:$moreinfo['article']?></a></li>
<? } ?>
</ul>
<? } ?>

<h3>Questions</h3>
<ul>
<? foreach ($data['elements'] as $element) { ?>
	<li>
	<p><a href="<?=$element['url'] ?>"><?=$element['question'] ?></a></p>
	</li>
<?	} ?>
</ul>
</section>
<? } ?>
