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
			<ul class="interlang">
				<?php foreach($flagsLangs as $flag): ?>
					<li><a class="<?= $flag['lang'] ?>" href="<?= $flag['url']; ?>" title="<?= wfMsgForContent('wikiahome-footer-interlang-flag-title') ?>"></a></li>
				<?php endforeach; ?>
			</ul>
		<? endif ?>
	</section>
</footer>