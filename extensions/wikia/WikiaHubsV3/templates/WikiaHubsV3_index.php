<?php
	$app = F::app();
?>
<div id="mw-content-text" lang="<?= $app->wg->contLang->getCode(); ?>">
	<script>var wgWikiaHubType = '<?= htmlspecialchars($wgWikiaHubType); ?>' || '';</script>

	<div class="WikiaGrid WikiaHubs" id="WikiaHubs">
		<div class="grid-3 alpha">
			<section class="grid-3 alpha wikiahubs-slider wikiahubs-module">
				<?= $modules[WikiaHubsModuleSliderService::MODULE_ID] ?>
			</section>
			<section class="grid-3 alpha wikiahubs-newstabs wikiahubs-module">
				<?= $modules[WikiaHubsModuleWikiaspicksService::MODULE_ID] ?>
			</section>
		</div>
		<section class="grid-3 wikiahubs-wam wikiahubs-module">
			<?= $modules[WikiaHubsModuleWAMService::MODULE_ID] ?>
		</section>
		<section class="grid-1 plainlinks wikiahubs-explore wikiahubs-module">
			<?= $modules[WikiaHubsModuleExploreService::MODULE_ID] ?>
		</section>
		<div class="grid-2 alpha wikiahubs-rail">
			<section class="grid-2 alpha wikiahubs-featured-video wikiahubs-module">
				<?= $modules[WikiaHubsModuleFeaturedvideoService::MODULE_ID] ?>
			</section>
			<section class="grid-2 alpha wikiahubs-wikitext-module wikiahubs-module">
				<?= $modules[WikiaHubsModulePollsService::MODULE_ID] ?>
			</section>
		</div>
		<div class="grid-4 alpha wikiahubs-popular-videos wikiahubs-module">
			<?= $modules[WikiaHubsModulePopularvideosService::MODULE_ID] ?>
		</div>
		<div class="grid-4 alpha wikiahubs-from-the-community wikiahubs-module ">
			<?= $modules[WikiaHubsModuleFromthecommunityService::MODULE_ID] ?>
		</div>
	</div>
</div>
