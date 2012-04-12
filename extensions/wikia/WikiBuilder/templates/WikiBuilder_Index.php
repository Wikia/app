<section id="WikiBuilder">
	<h1><?= wfMsg('owb-headline', $userName) ?></h1>

	<ol class="steps">
		<li class="step1 current-step">
			<span class="step-name"><?= wfMsg('owb-step1') ?></span>
			<span class="step-label"><?= wfMsg('owb-step1-label-formatted') ?></span>
			<img src="<?= $wg->BlankImgUrl ?>" class="chevron">
		</li>
		<li class="step2">
			<span class="step-name"><?= wfMsg('owb-step2') ?></span>
			<span class="step-label"><?= wfMsg('owb-step2-label-formatted') ?></span>
		</li>
		<li class="step3">
			<span class="step-name"><?= wfMsg('owb-step3') ?></span>
			<span class="step-label"><?= wfMsg('owb-step3-label-formatted') ?></span>
		</li>
		<li class="step4">
			<span class="step-name"><?= wfMsg('owb-step4') ?></span>
			<span class="step-label"><?= wfMsg('owb-step4-label-formatted') ?></span>
		</li>
	</ol>

	<div class="dialog">
		<div class="step1" >
			<h2><?= wfMsg('owb-step1') ?>: <?= wfMsg('owb-step1-label') ?></h2>
			<p><?= wfMsg('owb-step1-instruction') ?></p>
			<div class="sample">
				<h3><?= wfMsg('owb-step1-sample') ?></h3>
				<img src="<?= $wg->ExtensionsPath?>/wikia/WikiBuilder/images/step1.jpg">
			</div>
			<form name="step1-form">
				<textarea id="Description"></textarea>
				<nav>
					<input type="button" value="<?= wfMsg('owb-button-skip') ?>" class="skip secondary">
					<input type="submit" value="<?= wfMsg('owb-button-save-intro') ?>" class="save">
					<div class="status"></div>
				</nav>
			</form>
		</div>
		<div class="step2" style="display:none" >
			<h2><?= wfMsg('owb-step2') ?>: <?= wfMsg('owb-step2-label') ?></h2>
			<p><?= wfMsg('owb-step2-instruction1') ?></p>
			<p><?= wfMsg('owb-step2-instruction2') ?></p>
			<h3><?= wfMsg('owb-step2-gallery') ?></h3>
			<?= wfRenderModule('ThemeDesigner', 'ThemeTab') ?>
			<nav>
				<input type="button" value="<?= wfMsg('owb-button-skip') ?>" class="skip secondary">
				<input type="button" value="<?= wfMsg('owb-button-save-theme') ?>" class="save">
				<div class="status"></div>
			</nav>
		</div>
		<div class="step3" style="display:none">
			<h2><?= wfMsg('owb-step3') ?>: <?= wfMsg('owb-step3-label') ?></h2>
			<p><?= wfMsg('owb-step3-instruction') ?></p>
			<ul class="examples">
				<li><?= wfMsg('owb-step3-examples2-title') ?></li>
				<?= wfMsg('owb-step3-examples2') ?>
			</ul>
			<ul class="examples">
				<li><?= wfMsg('owb-step3-examples1-title') ?></li>
				<?= wfMsg('owb-step3-examples1') ?>
			</ul>
			<form name="step3-form" id="Pages">
				<label><?= wfMsg('owb-step3-your-pages') ?></label>
				<input type="text">
				<input type="text">
				<input type="text">
				<input type="text">
				<input type="text">
				<nav>
					<input type="button" value="<?= wfMsg('owb-button-skip') ?>" class="skip secondary">
					<input type="button" value="<?= wfMsg('owb-button-save-pages') ?>" class="save">
					<div class="status"></div>
				</nav>
			</form>
		</div>
		<div class="step4" style="display:none">
			<h2><?= wfMsg('owb-step4') ?>: <?= wfMsg('owb-step4-label') ?></h2>
			<p><?= wfMsg('owb-step4-instruction') ?></p>
			<div class="wb-basic box">
				<header>
					<h1>
						<img class="sprite logo" src="<?= $wg->BlankImgUrl ?>" height="15" width="61">
						<span>Basic</span>
					</h1>
					<img src="<?= $wg->BlankImgUrl; ?>" class="banner-corner-right" height="0" width="0">
				</header>
				<details>
					<?= wfMsg('owb-step4-basic-price') ?>
				</details>
				<div class="details">
				<?= wfMsg('owb-step4-basic-details') ?>
				</div>
				<input type="button" value="<?= wfMsg('owb-button-done') ?>" class="wb-basic">
			</div>
			<div class="wb-plus box">
				<header>
					<h1>
						<img class="sprite logo" src="<?= $wg->BlankImgUrl ?>" height="15" width="61">
						<span><em>+</em>Plus!</span>
					</h1>
					<img src="<?= $wg->BlankImgUrl; ?>" class="banner-corner-right" height="0" width="0">
				</header>
				<details>
					<?= wfMsg('owb-step4-plus-price', $wg->WikiPaymentAdsFreePrice) ?>
				</details>
				<div class="details">
				<?= wfMsg('owb-step4-plus-details') ?>
				</div>
				<input type="button" value="<?= wfMsg('owb-button-plus') ?>" class="wb-plus">
				<img src="<?= $wg->StylePath ?>/common/images/ajax.gif" class="throbber">
			</div>
			<div class="status"></div>
		</div>
	</div>

	<img src="<?= $wg->ExtensionsPath ?>/wikia/WikiBuilder/images/new_wiki_builder_1.png" class="collage1">
	<img src="<?= $wg->ExtensionsPath ?>/wikia/WikiBuilder/images/new_wiki_builder_2.png" class="collage2">

</section>
<script>
	var themes = <?= Wikia::json_encode($wg->OasisThemes) ?>;
	var redirect = window.wgArticlePath.replace(/\$1/, window.wgMainpage.replace(/ /g, '_') );
	var messages = <?= json_encode($messages) ?>;
</script>
<img class="ajaxwait" src="/skins/common/images/ajax.gif">