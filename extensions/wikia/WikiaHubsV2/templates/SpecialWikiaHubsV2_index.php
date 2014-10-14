<?php
	$app = F::app();
?>
<div id="mw-content-text" lang="<?= $app->wg->contLang->getCode(); ?>">
	<script>var wgWikiaHubType = '<?= htmlspecialchars($wgWikiaHubType); ?>' || '';</script>
	<div class="WikiaGrid WikiaHubs" id="WikiaHubs">
		<div class="grid-3 alpha">
			<h1><?= $verticalName ?></h1>
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