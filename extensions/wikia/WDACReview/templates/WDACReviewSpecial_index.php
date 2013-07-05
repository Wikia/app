<header id="WDACReviewSpecialPageHeader">
	<h1><?= $toolName ?></h1>
	<p><?= wfMessage('wdacreview-tool-description')->escaped() ?></p>
</header>

<div id="WDACReviewPage">

	<?= $paginator ?>
	<form action="<?= $submitUrl ?>" method="post" id="WDACReviewForm">
		<fieldset>
			<legend><?= wfMessage('wdacreview-filter-change-title')->escaped() ?></legend>
			<span><?= wfMessage('wdacreview-filter-change-description')->escaped() ?></span>
			<input type="button" value="<?= wfMessage('wdacreview-approve')->escaped() ?>" id="wdac-approve-all"/>
			<input type="button" value="<?= wfMessage('wdacreview-disapprove')->escaped() ?>" id="wdac-disapprove-all"/>
			<input type="button" value="<?= wfMessage('wdacreview-undetermined')->escaped() ?>" id="wdac-undetermined-all"/>
		</fieldset>

		<ul class="wdac-review-list">
		<?php
		if ( is_array($aCities) && count($aCities) > 0) {
		?>
			<?php
			foreach($aCities as $id => $city) {
				$name = "city-{$id}";
			?>

				<li class="state-">
					<h3><?= $city['t'] ?></h3>
					<a href="<?= $city['u']?>"><?= $city['u'] ?></a>
					<input type="radio" name="<?= $name ?>" value="<?= WDACReviewSpecialController::FLAG_APPROVE ?>" id="<?= $name ?>-true"/><label for="<?= $name ?>-true"><?= wfMessage('wdacreview-approve')->escaped() ?></label>

					<input type="radio" name="<?= $name ?>" value="<?= WDACReviewSpecialController::FLAG_DISAPPROVE ?>" id="<?= $name ?>-false"/><label for="<?= $name ?>-false"><?= wfMessage('wdacreview-disapprove')->escaped() ?></label>

					<input type="radio" name="<?= $name ?>" value="<?= WDACReviewSpecialController::FLAG_UNDETERMINED ?>" id="<?= $name ?>-undetermined"/><label for="<?= $name ?>-undetermined"><?= wfMessage('wdacreview-undetermined')->escaped() ?></label>
				</li>

			<?php
			}
			?>
		</ul>

		<input id="nextButton"  type="submit" class="wikia-button" value="<?= wfMessage('wdacreview-confirm-review')->escaped() ?>" />

		<?php
		} else {
		?>
			<p><?= wfMessage( 'wdacreview-noresults' )->escaped() ?></p>
			<?= Xml::element( 'a', array( 'href' => $baseUrl, 'class' => 'wikia-button', 'style' => 'float: none' ), wfMessage( 'wdacreview-refresh-page' )->escaped() ) ?>
		<?php
		}
		?>

	</form>
	<?= $paginator ?>

</div>
