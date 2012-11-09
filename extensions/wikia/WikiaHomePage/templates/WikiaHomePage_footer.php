<footer class="wikiahomepage-footer WikiaGrid">
	<section class="grid-1 alpha">
		<?= wfMsgExt('wikiahome-footer-wikiainc', array('parse','language' => $wg->lang->getCode())) ?>
	</section>
	<section class="grid-1">
		<?= wfMsgExt('wikiahome-footer-get-started-heading', array('parse','language' => $wg->lang->getCode())) ?>
		<p><?= wfMsg('wikiahome-footer-get-started-creative') ?></p>
		<a href="<?= wfMsg('wikiahome-footer-get-started-button') ?>" class="button"><?= wfMsg('cnw-name-wiki-headline') ?></a>
	</section>
	<section class="grid-1">
		<?= wfMsgExt('wikiahome-footer-follow-us', array('parse','language' => $wg->lang->getCode())) ?>
	</section>
	<section class="grid-1">
		<?= wfMsgExt('wikiahome-footer-community', array('parse','language' => $wg->lang->getCode())) ?>
	</section>
	<section class="grid-1">
		<?= wfMsgExt('wikiahome-footer-everywhere', array('parse','language' => $wg->lang->getCode())) ?>
	</section>
	<section class="grid-1">
		<?= wfMsgExt('wikiahome-footer-advertise', array('parse','language' => $wg->lang->getCode())) ?>
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