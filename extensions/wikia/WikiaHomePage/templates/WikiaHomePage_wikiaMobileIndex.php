<section class=wkhome>
	<h1><?= wfMsg('wikiahome-page-header-heading') ?></h1>
	<h2><?= wfMsg('wikiahome-page-header-subheading') ?></h2>
	<? for ( $i = 0; $i < 3; $i++): ?>
		<? if( isset( $hubsSlots[$i] ) ): ?>
			<?= F::app()->renderView('WikiaHomePageController', 'wikiaMobileRenderHubSection', $hubsSlots[$i] ) ?>
		<? endif ?>
	<? endfor ?>
	<section class="wkhome-section wkhome-community  wkhome-community-<?= $lang ?>">
		<a href="<?= wfMsg('wikiahome-community-column1-link') ?>" class=wkhome-hero>
			<img class=wkhome-img src="<?= $wg->BlankImgUrl ?>">
		</a>
		<p><?=wfMsg('wikiahome-community-column1-creative') ?></p>
	</section>

</section>
