<section class=wkhome>
	<h1><?= wfMessage('wikiahome-page-header-heading-mobile')->plain() ?></h1>

	<section class="wkhome-section">
		<a href="http://yearinfandom.wikia.com/wiki/Portal:Community_Choice" class=wkhome-hero>
			<img class=wkhome-img src="<?= $wg->ExtensionsPath ?>/wikia/WikiaHomePage/images/YIF_HomePage_Mobile_R3.jpg">
			<h2><?= wfMessage('wikiahome-page-section-yearinfandom')->plain() ?></h2>
		</a>
	</section>

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
		<a href="<?= wfMessage('wikiahome-community-column1-link')->plain() ?>" class=wkhome-hero>
			<img class=wkhome-img src="<?= $wg->BlankImgUrl ?>">
		</a>
		<p><?=wfMessage('wikiahome-community-column1-creative')->plain() ?></p>
	</section>

</section>
