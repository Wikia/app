<section id="LandingPageSmurfs" class="LandingPageSmurfs<?= ucfirst($langCode) ?>">
	<a href="#" class="smurfs-link-enter"><?= wfMsg('landingpagesmurfs-enternow'); ?></a>
	<a href="<?= wfMsg('landingpagesmurfs-facebook-url'); ?>" class="smurfs-link-fb">facebook</a>
	<?= str_replace('<a', '<a class="smurfs-link-wiki"', wfMsgExt('landingpagesmurfs-wikia-site-link', array('parseinline'))); ?>
	<a href="<?= wfMsg('landingpagesmurfs-site-url'); ?>" class="smurfs-link-trailer">trailer</a>
</section>