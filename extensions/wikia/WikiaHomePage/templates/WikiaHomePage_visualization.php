<?php
	$seocounter = 0;
	/* @var $homePageHelper WikiaHomePageHelper */
	$homePageHelper = F::build('WikiaHomePageHelper');
?>
<div id="WikiPreviewInterstitialMask" class="WikiPreviewInterstitialMask hidden">
	<section class="WikiPreviewInterstitial" class="hidden">
		<div class="content-area">
			<!-- Content area hook for javascript and css -->
		</div>
		<img src="<?= F::app()->wg->StylePath ?>/oasis/images/icon_close.png" class="close-button wikia-chiclet-button" alt="Close">
	</section>
</div>
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
		<div class="grid-2 wikia-slot slot-medium">
			<a href="<?= $seoSample[$seocounter]['url']; ?>" data-wikiurl="<?= $seoSample[$seocounter]['url']; ?>" title="<?= $seoSample[$seocounter++]['title']; ?>">
				<img width="<?= $homePageHelper->getRemixMediumImgWidth() ?>" height="<?= $homePageHelper->getRemixMediumImgHeight() ?>" src="<?= $wg->BlankImgUrl; ?>" class="slotWikiImage" />
			</a>
		</div>
		<div class="grid-1">
			<div class="grid-1 alpha wikia-slot slot-small">
				<a href="<?= $seoSample[$seocounter]['url']; ?>" data-wikiurl="<?= $seoSample[$seocounter]['url']; ?>" title="<?= $seoSample[$seocounter++]['title']; ?>">
					<img width="<?= $homePageHelper->getRemixSmallImgWidth() ?>" height="<?= $homePageHelper->getRemixSmallImgHeight() ?>" src="<?= $wg->BlankImgUrl; ?>" class="slotWikiImage" />
				</a>
			</div>
			<div class="grid-1 alpha wikia-slot slot-small">
				<a href="<?= $seoSample[$seocounter]['url']; ?>" data-wikiurl="<?= $seoSample[$seocounter]['url']; ?>" title="<?= $seoSample[$seocounter++]['title']; ?>">
					<img width="<?= $homePageHelper->getRemixSmallImgWidth() ?>" height="<?= $homePageHelper->getRemixSmallImgHeight() ?>" src="<?= $wg->BlankImgUrl; ?>" class="slotWikiImage" />
				</a>
			</div>
		</div>
		<div class="grid-2 stats">
			<?= F::app()->renderView( 'WikiaHomePageController', 'getStats' ); ?>
		</div>
	</div>
	<div class="grid-6 alpha">
		<div class="grid-1 alpha">
			<div class="grid-1 alpha wikia-slot slot-small">
				<a href="<?= $seoSample[$seocounter]['url']; ?>" data-wikiurl="<?= $seoSample[$seocounter]['url']; ?>" title="<?= $seoSample[$seocounter++]['title']; ?>">
					<img width="<?= $homePageHelper->getRemixSmallImgWidth() ?>" height="<?= $homePageHelper->getRemixSmallImgHeight() ?>" src="<?= $wg->BlankImgUrl; ?>" class="slotWikiImage" />
				</a>
			</div>
			<div class="grid-1 alpha wikia-slot slot-small">
				<a href="<?= $seoSample[$seocounter]['url']; ?>" data-wikiurl="<?= $seoSample[$seocounter]['url']; ?>" title="<?= $seoSample[$seocounter++]['title']; ?>">
					<img width="<?= $homePageHelper->getRemixSmallImgWidth() ?>" height="<?= $homePageHelper->getRemixSmallImgHeight() ?>" src="<?= $wg->BlankImgUrl; ?>" class="slotWikiImage" />
				</a>
			</div>
			<div class="grid-1 alpha wikia-slot slot-small">
				<a href="<?= $seoSample[$seocounter]['url']; ?>" data-wikiurl="<?= $seoSample[$seocounter]['url']; ?>" title="<?= $seoSample[$seocounter++]['title']; ?>">
					<img width="<?= $homePageHelper->getRemixSmallImgWidth() ?>" height="<?= $homePageHelper->getRemixSmallImgHeight() ?>" src="<?= $wg->BlankImgUrl; ?>" class="slotWikiImage" />
				</a>
			</div>
			<div class="grid-1 alpha wikia-slot slot-small">
				<a href="<?= $seoSample[$seocounter]['url']; ?>" data-wikiurl="<?= $seoSample[$seocounter]['url']; ?>" title="<?= $seoSample[$seocounter++]['title']; ?>">
					<img width="<?= $homePageHelper->getRemixSmallImgWidth() ?>" height="<?= $homePageHelper->getRemixSmallImgHeight() ?>" src="<?= $wg->BlankImgUrl; ?>" class="slotWikiImage" />
				</a>
			</div>
		</div>
		<div class="grid-1 alpha">
			<div class="grid-1 wikia-slot slot-small">
				<a href="<?= $seoSample[$seocounter]['url']; ?>" data-wikiurl="<?= $seoSample[$seocounter]['url']; ?>" title="<?= $seoSample[$seocounter++]['title']; ?>">
					<img width="<?= $homePageHelper->getRemixSmallImgWidth() ?>" height="<?= $homePageHelper->getRemixSmallImgHeight() ?>" src="<?= $wg->BlankImgUrl; ?>" class="slotWikiImage" />
				</a>
			</div>
			<div class="grid-1 wikia-slot slot-small">
				<a href="<?= $seoSample[$seocounter]['url']; ?>" data-wikiurl="<?= $seoSample[$seocounter]['url']; ?>" title="<?= $seoSample[$seocounter++]['title']; ?>">
					<img width="<?= $homePageHelper->getRemixSmallImgWidth() ?>" height="<?= $homePageHelper->getRemixSmallImgHeight() ?>" src="<?= $wg->BlankImgUrl; ?>" class="slotWikiImage" />
				</a>
			</div>
			<div class="grid-1 wikia-slot slot-small">
				<a href="<?= $seoSample[$seocounter]['url']; ?>" data-wikiurl="<?= $seoSample[$seocounter]['url']; ?>" title="<?= $seoSample[$seocounter++]['title']; ?>">
					<img width="<?= $homePageHelper->getRemixSmallImgWidth() ?>" height="<?= $homePageHelper->getRemixSmallImgHeight() ?>" src="<?= $wg->BlankImgUrl; ?>" class="slotWikiImage" />
				</a>
			</div>
			<div class="grid-1 wikia-slot slot-small">
				<a href="<?= $seoSample[$seocounter]['url']; ?>" data-wikiurl="<?= $seoSample[$seocounter]['url']; ?>" title="<?= $seoSample[$seocounter++]['title']; ?>">
					<img width="<?= $homePageHelper->getRemixSmallImgWidth() ?>" height="<?= $homePageHelper->getRemixSmallImgHeight() ?>" src="<?= $wg->BlankImgUrl; ?>" class="slotWikiImage" />
				</a>
			</div>
		</div>
		<div class="grid-2">
			<div class="grid-2">
				<div class="grid-1 alpha wikia-slot slot-small">
					<a href="<?= $seoSample[$seocounter]['url']; ?>" data-wikiurl="<?= $seoSample[$seocounter]['url']; ?>" title="<?= $seoSample[$seocounter++]['title']; ?>">
						<img width="<?= $homePageHelper->getRemixSmallImgWidth() ?>" height="<?= $homePageHelper->getRemixSmallImgHeight() ?>" src="<?= $wg->BlankImgUrl; ?>" class="slotWikiImage" />
					</a>
				</div>
				<div class="grid-1 wikia-slot slot-small">
					<a href="<?= $seoSample[$seocounter]['url']; ?>" data-wikiurl="<?= $seoSample[$seocounter]['url']; ?>" title="<?= $seoSample[$seocounter++]['title']; ?>">
						<img width="<?= $homePageHelper->getRemixSmallImgWidth() ?>" height="<?= $homePageHelper->getRemixSmallImgHeight() ?>" src="<?= $wg->BlankImgUrl; ?>" class="slotWikiImage" />
					</a>
				</div>
			</div>
			<div class="grid-2 wikia-slot slot-big">
				<a href="<?= $seoSample[$seocounter]['url']; ?>" data-wikiurl="<?= $seoSample[$seocounter]['url']; ?>" title="<?= $seoSample[$seocounter++]['title']; ?>">
					<img width="<?= $homePageHelper->getRemixBigImgWidth() ?>" height="<?= $homePageHelper->getRemixBigImgHeight() ?>" src="<?= $wg->BlankImgUrl; ?>" class="slotWikiImage" />
				</a>
			</div>
		</div>
		<div class="grid-2">
			<div class="grid-2 wikia-slot slot-big">
				<a href="<?= $seoSample[$seocounter]['url']; ?>" data-wikiurl="<?= $seoSample[$seocounter]['url']; ?>" title="<?= $seoSample[$seocounter++]['title']; ?>">
					<img width="<?= $homePageHelper->getRemixBigImgWidth() ?>" height="<?= $homePageHelper->getRemixBigImgHeight() ?>" src="<?= $wg->BlankImgUrl; ?>" class="slotWikiImage" />
				</a>
			</div>
			<div class="grid-2">
				<div class="grid-1 alpha wikia-slot slot-small">
					<a href="<?= $seoSample[$seocounter]['url']; ?>" data-wikiurl="<?= $seoSample[$seocounter]['url']; ?>" title="<?= $seoSample[$seocounter++]['title']; ?>">
						<img width="<?= $homePageHelper->getRemixSmallImgWidth() ?>" height="<?= $homePageHelper->getRemixSmallImgHeight() ?>" src="<?= $wg->BlankImgUrl; ?>" class="slotWikiImage" />
					</a>
				</div>
				<div class="grid-1 wikia-slot slot-small">
					<a href="<?= $seoSample[$seocounter]['url']; ?>" data-wikiurl="<?= $seoSample[$seocounter]['url']; ?>" title="<?= $seoSample[$seocounter++]['title']; ?>">
						<img width="<?= $homePageHelper->getRemixSmallImgWidth() ?>" height="<?= $homePageHelper->getRemixSmallImgHeight() ?>" src="<?= $wg->BlankImgUrl; ?>" class="slotWikiImage" />
					</a>
				</div>
			</div>
		</div>
	</div>
</div>