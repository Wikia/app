<?php
	$app = F::app();
?>
<div id="mw-content-text" lang="<?= $app->wg->contLang->getCode(); ?>">
	<script>var wgWikiaHubType = '<?= htmlspecialchars($wgWikiaHubType); ?>' || '';</script>
	<div class="WikiaGrid WikiaHubs" id="WikiaHubs">
		<div class="grid-6 alpha hubs-header">
			<div class="grid-3 alpha"><h1><?= $verticalName ?></h1></div>
			<div class="grid-3 alpha social-links">
				<? $fbMsg = wfMessage('wikiahubs-social-facebook-link-' . $canonicalVerticalName)->inContentLanguage()->text(); ?>
				<? if (!empty($fbMsg)): ?>
					<a href="<?= $fbMsg ?>"><img src="<?= $wg->BlankImgUrl; ?>" class="facebook" /></a>
				<? endif ?>
				<? $twMsg =  wfMessage('wikiahubs-social-twitter-link-' . $canonicalVerticalName)->inContentLanguage()->text()?>
				<? if (!empty($twMsg)): ?>
					<a href="<?= $twMsg ?>"><img src="<?= $wg->BlankImgUrl; ?>" class="twitter" /></a>
				<? endif ?>
				<? $gplusMsg =  wfMessage('wikiahubs-social-googleplus-link-' . $canonicalVerticalName)->inContentLanguage()->text()?>
				<? if (!empty($gplusMsg)): ?>
					<a href="<?= $gplusMsg ?>"><img src="<?= $wg->BlankImgUrl; ?>" class="gplus" /></a>
				<? endif ?>
				<div class="search">
					<form method="get" action="<?= $specialSearchUrl; ?>" class="WikiaSearch" id="WikiaSearch">
						<input type="text" value="" accesskey="f" autocomplete="off" placeholder="<?= wfMessage('wikiahubs-search-placeholder')->text(); ?>" name="search" id="HubSearch" />
						<input type="hidden" value="0" name="fulltext" />
						<? if (!empty($searchHubName)): ?>
							<input type="hidden" name="hub" value="<?= $searchHubName; ?>" />
						<? endif; ?>
						<input type="submit" />
						<button class="wikia-button">
							<img width="21" height="17" class="sprite search" src="<?= $wg->BlankImgUrl; ?>" />
						</button>
					</form>
				</div>
			</div>
		</div>
		<div class="grid-3 alpha">
			<section class="grid-3 alpha wikiahubs-slider wikiahubs-module">
				<?= $modules[MarketingToolboxModuleSliderService::MODULE_ID] ?>
			</section>
			<section class="grid-3 alpha wikiahubs-newstabs wikiahubs-module">
				<?= $modules[MarketingToolboxModuleWikiaspicksService::MODULE_ID] ?>
			</section>
		</div>
		<section class="grid-3 wikiahubs-wam wikiahubs-module">
			<?= $modules[MarketingToolboxModuleWAMService::MODULE_ID] ?>
		</section>
		<section class="grid-1 plainlinks wikiahubs-explore wikiahubs-module">
			<?= $modules[MarketingToolboxModuleExploreService::MODULE_ID] ?>
		</section>
		<div class="grid-2 alpha wikiahubs-rail">
			<section class="grid-2 alpha wikiahubs-featured-video wikiahubs-module">
				<?= $modules[MarketingToolboxModuleFeaturedvideoService::MODULE_ID] ?>
			</section>
			<section class="grid-2 alpha wikiahubs-wikitext-module wikiahubs-module">
				<?= $modules[MarketingToolboxModulePollsService::MODULE_ID] ?>
			</section>
		</div>
		<div class="grid-4 alpha wikiahubs-popular-videos wikiahubs-module">
			<?= $modules[MarketingToolboxModulePopularvideosService::MODULE_ID] ?>
		</div>
		<div class="grid-4 alpha wikiahubs-from-the-community wikiahubs-module ">
			<?= $modules[MarketingToolboxModuleFromthecommunityService::MODULE_ID] ?>
		</div>
	</div>
</div>