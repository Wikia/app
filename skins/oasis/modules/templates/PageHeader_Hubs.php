<header id="WikiaPageHeader" class="WikiaPageHeader">
	<?php if (!is_null($tallyMsg)) : ?>
		<div class="tally">
			<?= $tallyMsg ?>
        </div>
	<?php endif ?>

	<div class="social-links">
		<? $fbMsg = wfMessage('wikiahubs-v3-social-facebook-link')->inContentLanguage()->text(); ?>
		<? if (!empty($fbMsg)): ?>
			<a href="<?= $fbMsg ?>"><img src="<?= $wg->BlankImgUrl; ?>" class="facebook" /></a>
		<? endif ?>
		<? $twMsg =  wfMessage('wikiahubs-v3-social-twitter-link')->inContentLanguage()->text()?>
		<? if (!empty($twMsg)): ?>
			<a href="<?= $twMsg ?>"><img src="<?= $wg->BlankImgUrl; ?>" class="twitter" /></a>
		<? endif ?>
		<? $gplusMsg =  wfMessage('wikiahubs-v3-social-googleplus-link')->inContentLanguage()->text()?>
		<? if (!empty($gplusMsg)): ?>
			<a href="<?= $gplusMsg ?>"><img src="<?= $wg->BlankImgUrl; ?>" class="gplus" /></a>
		<? endif ?>
	</div>

	<h1><?= !empty($displaytitle) ? htmlspecialchars($title) : '' ?></h1>
</header>
