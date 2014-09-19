<section class=wkhome>
	<h1><?= wfMsg('wikiahome-page-header-heading') ?></h1>
	<h2><?= wfMsg('wikiahome-page-header-subheading') ?></h2>

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
		<a href="<?= wfMsg('wikiahome-community-column1-link') ?>" class=wkhome-hero>
			<img class=wkhome-img src="<?= $wg->BlankImgUrl ?>">
		</a>
		<p><?=wfMsg('wikiahome-community-column1-creative') ?></p>
	</section>

</section>
