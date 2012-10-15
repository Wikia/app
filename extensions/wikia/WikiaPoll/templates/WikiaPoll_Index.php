<section class="WikiaPoll<?= $embedded ? ' WikiaPollEmbedded' : '' ?>" data-id="<?= $poll->getId() ?>">
<?php
	if ($embedded) {
?>
	<h2><?= htmlspecialchars(wfMsg('wikiapoll-question', $poll->getTitle())) ?></h2>
<?php
	}
?>
	<form>
		<ul>
<?php
	foreach($data['answers'] as $n => $answer) {
		$class = $n % 2 ? ' class="odd"' : '';
?>
			<li<?= $class ?>>
				<label>
					<input type="radio" value="<?= $n ?>" name="wpAnswer" />
					<?= htmlspecialchars($answer['text']) ?>
				</label>
				<span class="bar" style="width: <?= $answer['percentage'] ?>%">
					<span class="percentage"><?= $answer['percentage'] ?>%</span>
					<span class="votes">
<?php
	echo wfMsgExt('wikiapoll-votes', array('parsemag'), $wg->Lang->formatNum( $answer['votes']) );
?>
					</span>
				</span>
			</li>
<?php
	}
?>
		</ul>
		<div class="details">
			<span class="votes"><?= wfMsgExt( 'wikiapoll-people-voted', array( 'parsemag' ), $wg->Lang->formatNum( $data['votes'] ) ) ?></span>
			<input type="submit" name="wpVote" value="<?= wfMsg('wikiapoll-vote') ?>" style="display:none" />
		</div>
	</form>

	<span class="progress"><?= wfMsg('wikiapoll-thanks-for-vote') ?></span>

<?php /*<pre><?= print_r($data, true) ?></pre> */ ?>

</section>
