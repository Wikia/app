<header id="WDACReviewSpecialPageHeader">
	<h2><?= $toolName ?></h2>
</header>

<form action="<?= $submitUrl ?>" method="post" id="WDACReviewForm">

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
				<a href="$city['u']"><?= $city['u'] ?></a>
				<label for="">Yes</label><input type="radio" name="<?= $name ?>" value="1" id="<?= $name ?>-true"/>
				<label for="">No</label><input type="radio" name="<?= $name ?>" value="0" id="<?= $name ?>-false"/>
			</li>

		<?php
		}
		?>
	</ul>

	<input id="nextButton"  type="submit" class="wikia-button" value="Review selected" />

	<?php
	} else {
		echo wfMsg( 'wdacreview-noresults' )."<br>";
		echo Xml::element( 'a', array( 'href' => $fullUrl, 'class' => 'wikia-button', 'style' => 'float: none' ), 'Refresh page' );
	}
	?>

</form>
