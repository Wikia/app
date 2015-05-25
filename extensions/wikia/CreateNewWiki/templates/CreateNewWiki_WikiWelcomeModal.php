<div id="WikiWelcome" class="WikiWelcome">
	<h1><?= wfMsg('cnw-welcome-headline', $wg->Sitename) ?></h1>
	<p><?= wfMsg('cnw-welcome-instruction1') ?></p>
	<?= Wikia::specialPageLink('CreatePage', 'button-createpage', 'wikia-button createpage', 'blank.gif', 'oasis-create-page', 'sprite new'); ?>
	<p class="help"><?= wfMsg('cnw-welcome-help') ?></p>
</div>