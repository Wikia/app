<?php
	$seocounter = 0;
	/* @var $homePageHelper WikiaHomePageHelper */
	$homePageHelper = new WikiaHomePageHelper();
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
			<a href="#" class="wikia-button secondary remix-button <?= ( empty($collectionsList) ? 'chevron-not-visible' : '' ); ?>">
				<img src="<?= $wg->BlankImgUrl; ?>" class="arrow" />
				<?= wfMsg('wikiahome-visualisation-remix-button'); ?>
			</a>
			
			<?php if( !empty($collectionsList) ): ?>
				<a href="#" class="wikia-button collections-button">
					<img class="chevron" src="<?= $wg->BlankImgUrl; ?>">
				</a>
				<ul class="WikiaMenuElement collections-dropdown">
					<?php foreach($collectionsList as $collectionId =>$collection): ?>

						<li class="collection-link" data-collection-id="<?= $collectionId; ?>"><?= $collection['name']; ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
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
		<div class="grid-2 stats" id="WikiaHomePageStats">
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