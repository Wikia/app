<section class=wkhome>
	<h1><?= wfMessage('wikiahome-page-header-heading-mobile')->escaped() ?></h1>

	<? foreach ( $hubsSlots as $hubsSlot ): ?>
		<? if ( !empty($hubsSlot) ): ?>
			<section class="wkhome-section <?= $hubsSlot['classname']?>">
				<a href="<?= $hubsSlot['herourl'] ?>" class=wkhome-hero>
					<img class=wkhome-img src=<?= $hubsSlot['heroimageurl'] ?>>
					<h2><?= $hubsSlot['heading'] ?></h2>
				</a>
			</section>
		<? endif ?>
	<? endforeach ?>

	<section class="wkhome-section wkhome-community  wkhome-community-<?= $lang ?>">
		<a href="<?= wfMessage('wikiahome-community-column1-link')->escaped() ?>" class=wkhome-hero>
			<img class=wkhome-img src="<?= $wg->BlankImgUrl ?>">
		</a>
		<p><?=wfMessage('wikiahome-community-column1-creative')->escaped() ?></p>
	</section>

</section>
