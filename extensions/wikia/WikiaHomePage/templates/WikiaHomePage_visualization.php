<?php $seocounter = 0; ?>
<div id="visualization">
	<div class="grid-6 alpha">
		<div class="grid-1 alpha remix">
			<h2><?= wfMsg('wikiahome-visualisation-remix-mixitup'); ?></h2>
			<h3><?= wfMsg('wikiahome-visualisation-remix-mixituptext'); ?></h3>
			<a href="#" class="wikia-button secondary">
				<img src="<?= $wg->BlankImgUrl; ?>" class="arrow" />
				<?= wfMsg('wikiahome-visualisation-remix-button'); ?>
			</a>		
		</div>
		<a href="<?= $seoSample[$seocounter]['url']; ?>" title="<?= $seoSample[$seocounter++]['title']; ?>" class="grid-2 wikia-slot slot-medium">
			<img src="<?= $wg->BlankImgUrl; ?>" />
		</a>
		<div class="grid-1">
			<a href="<?= $seoSample[$seocounter]['url']; ?>" title="<?= $seoSample[$seocounter++]['title']; ?>" class="grid-1 alpha wikia-slot slot-small">
				<img src="<?= $wg->BlankImgUrl; ?>" />
			</a>
			<a href="<?= $seoSample[$seocounter]['url']; ?>" title="<?= $seoSample[$seocounter++]['title']; ?>" class="grid-1 alpha wikia-slot slot-small">
				<img src="<?= $wg->BlankImgUrl; ?>" />
			</a>
		</div>
		<div class="grid-2 stats">
			<?= F::app()->renderView( 'WikiaHomePageController', 'getStats' ); ?>
		</div>
	</div>
	<div class="grid-6 alpha">
		<div class="grid-1 alpha">
			<a href="<?= $seoSample[$seocounter]['url']; ?>" title="<?= $seoSample[$seocounter++]['title']; ?>" class="grid-1 alpha wikia-slot slot-small">
				<img src="<?= $wg->BlankImgUrl; ?>" />
			</a>
			<a href="<?= $seoSample[$seocounter]['url']; ?>" title="<?= $seoSample[$seocounter++]['title']; ?>" class="grid-1 alpha wikia-slot slot-small">
				<img src="<?= $wg->BlankImgUrl; ?>" />
			</a>
			<a href="<?= $seoSample[$seocounter]['url']; ?>" title="<?= $seoSample[$seocounter++]['title']; ?>" class="grid-1 alpha wikia-slot slot-small">
				<img src="<?= $wg->BlankImgUrl; ?>" />
			</a>
			<a href="<?= $seoSample[$seocounter]['url']; ?>" title="<?= $seoSample[$seocounter++]['title']; ?>" class="grid-1 alpha wikia-slot slot-small">
				<img src="<?= $wg->BlankImgUrl; ?>" />
			</a>
		</div>
		<div class="grid-1 alpha">
			<a href="<?= $seoSample[$seocounter]['url']; ?>" title="<?= $seoSample[$seocounter++]['title']; ?>" class="grid-1 wikia-slot slot-small">
				<img src="<?= $wg->BlankImgUrl; ?>" />
			</a>
			<a href="<?= $seoSample[$seocounter]['url']; ?>" title="<?= $seoSample[$seocounter++]['title']; ?>" class="grid-1 wikia-slot slot-small">
				<img src="<?= $wg->BlankImgUrl; ?>" />
			</a>
			<a href="<?= $seoSample[$seocounter]['url']; ?>" title="<?= $seoSample[$seocounter++]['title']; ?>" class="grid-1 wikia-slot slot-small">
				<img src="<?= $wg->BlankImgUrl; ?>" />
			</a>
			<a href="<?= $seoSample[$seocounter]['url']; ?>" title="<?= $seoSample[$seocounter++]['title']; ?>" class="grid-1 wikia-slot slot-small">
				<img src="<?= $wg->BlankImgUrl; ?>" />
			</a>
		</div>
		<div class="grid-2">
			<div class="grid-2">
				<a href="<?= $seoSample[$seocounter]['url']; ?>" title="<?= $seoSample[$seocounter++]['title']; ?>" class="grid-1 alpha wikia-slot slot-small">
					<img src="<?= $wg->BlankImgUrl; ?>" />
				</a>
				<a href="<?= $seoSample[$seocounter]['url']; ?>" title="<?= $seoSample[$seocounter++]['title']; ?>" class="grid-1 wikia-slot slot-small">
					<img src="<?= $wg->BlankImgUrl; ?>" />
				</a>
			</div>
			<a href="<?= $seoSample[$seocounter]['url']; ?>" title="<?= $seoSample[$seocounter++]['title']; ?>" class="grid-2 wikia-slot slot-big">
				<img src="<?= $wg->BlankImgUrl; ?>" />
			</a>
		</div>
		<div class="grid-2">
			<a href="<?= $seoSample[$seocounter]['url']; ?>" title="<?= $seoSample[$seocounter++]['title']; ?>" class="grid-2 wikia-slot slot-big">
				<img src="<?= $wg->BlankImgUrl; ?>" />
			</a>
			<div class="grid-2">
				<a href="<?= $seoSample[$seocounter]['url']; ?>" title="<?= $seoSample[$seocounter++]['title']; ?>" class="grid-1 alpha wikia-slot slot-small">
					<img src="<?= $wg->BlankImgUrl; ?>" />
				</a>
				<a href="<?= $seoSample[$seocounter]['url']; ?>" title="<?= $seoSample[$seocounter++]['title']; ?>" class="grid-1 wikia-slot slot-small">
					<img src="<?= $wg->BlankImgUrl; ?>" />
				</a>
			</div>
		</div>
	</div>
</div>