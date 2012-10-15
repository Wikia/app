<? $app = F::app(); ?>
<section class="WikiaHubs">
	<?= $app->renderView('SpecialWikiaHubsV2', 'slider', $app->wg->request->getValues()); ?>
	<?= $app->renderView('SpecialWikiaHubsV2', 'pulse', $app->wg->request->getValues()); ?>
	<?= $app->renderView('SpecialWikiaHubsV2', 'featuredvideo', $app->wg->request->getValues()); ?>
	<?= $app->renderView('SpecialWikiaHubsV2', 'tabber', $app->wg->request->getValues()); ?>
	<?= $app->renderView('SpecialWikiaHubsV2', 'popularvideos', $app->wg->request->getValues()); ?>
</section>
<?= $app->renderView('SpecialWikiaHubsV2', 'explore', $app->wg->request->getValues()); ?>
<?= $app->renderView('SpecialWikiaHubsV2', 'wikitextmodule', $app->wg->request->getValues()); ?>
<?= $app->renderView('SpecialWikiaHubsV2', 'fromthecommunity', $app->wg->request->getValues()); ?>
<?= $app->renderView('SpecialWikiaHubsV2', 'topwikis', $app->wg->request->getValues()); ?>
