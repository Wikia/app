<div class="SelfServiceAdvertising" id="SelfServiceAdvertising">
	<h1><?= wfMsg('ssa-splash-h1') ?></h1>
	<h2><?= wfMsg('ssa-splash-h2') ?></h2>
	<img src="<?= $wg->BlankImgUrl ?>" class="headline-gap" />
	<h3><?= wfMsg('ssa-splash-h3') ?></h3>
	<div class="SsaBoxWrapper">
		<div class="description">
			<h4 class="powerful"><?= wfMsg('ssa-splash-leftbox-powerful-title') ?></h4>
			<p><?= wfMsgExt('ssa-splash-leftbox-powerful', array('parse')) ?></p>
			<h4 class="available"><?= wfMsg('ssa-splash-leftbox-available-title') ?></h4>
			<p><?= wfMsgExt('ssa-splash-leftbox-available', array('parse')) ?></p>
			<h4 class="targeting"><?= wfMsg('ssa-splash-leftbox-targeting-title') ?></h4>
			<p><?= wfMsgExt('ssa-splash-leftbox-targeting', array('parse')) ?></p>
			<p class="get-started-wrapper"><a href="<?= wfMsg('ssa-splash-leftbox-selfservice-url') ?>" class="wikia-menu-button big get-started"><?= wfMsg('ssa-splash-leftbox-getstarted') ?></a></p>
		</div>
		<div class="coupon">
			<img src="<?= $wg->BlankImgUrl ?>" />
			<h4><?= wfMsg('ssa-splash-rightbox-title') ?></h4>
			<?= $getCouponForm; ?>
		</div>
	</div>
</div>
