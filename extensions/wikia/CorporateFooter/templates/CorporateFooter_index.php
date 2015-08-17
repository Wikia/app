<footer class="wikiahomepage-footer WikiaGrid">
	<section class="grid-1 alpha">
		<?= wfMessage('wikiahome-footer-wikiainc')->parse() ?>
	</section>
	<section class="grid-1">
		<?= wfMessage('wikiahome-footer-get-started-heading')->parse() ?>
		<p><?= wfMessage('wikiahome-footer-get-started-creative')->text() ?></p>
		<a href="<?= wfMessage('wikiahome-footer-get-started-button')->text() ?>" class="button"><?= wfMessage('cnw-name-wiki-headline')->text() ?></a>
	</section>
	<section class="grid-1">
		<?= wfMessage('wikiahome-footer-follow-us')->parse() ?>
	</section>
	<section class="grid-1">
		<? $wamLink = (!empty($wamPageUrl)) ? "\n" . wfMessage('wikiahome-footer-community-wam')->params([$wamPageUrl])->text() : '' ?>
		<?= wfMessage('wikiahome-footer-community')->params($wamLink)->parse() ?>
	</section>
	<section class="grid-1">
		<?= wfMessage('wikiahome-footer-everywhere')->parse() ?>
	</section>
	<section class="grid-1">
		<?= wfMessage('wikiahome-footer-partner')->parse() ?>
		<? if($interlang): ?>
			<?= F::app()->renderView('MenuButton', 'Index', array(
				'action' => array('text' => ''),
				'class' => $selectedLang.' secondary',
				'image' => '',
				'dropdown' => $dropDownItems,
			)); ?>
		<? endif ?>
	</section>
</footer>
