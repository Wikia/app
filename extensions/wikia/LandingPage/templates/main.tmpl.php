<section class="LandingPage">
	<section class="LandingPageRow">
		<section class="LandingPageWelcome">
			<h1><?= wfMsg('landingpage') ?></h1>
			<?= wfMsgExt('landingpage-secondary-line', array('parse')) ?>
		</section>

		<section class="LandingPageScreenshots">
			<h1>
				<?= wfMsg('landingpage-examples') ?>
				<img src="<?= $wgBlankImgUrl ?>" class="banner-corner-left" width="0" height="0">
			</h1>
			<ul>
<?php
				foreach($wikis as $wiki) {
?>
				<li>
					<a href="<?= $wiki['url'] ?>">
						<img src="<?= $imagesPath . $wiki['image'] ?>" alt="" width="124" height="84">
						<?= $wiki['name'] ?>
					</a>
				</li>
<?php
				}
?>
			</ul>
		</section>
	</section>

	<section class="LandingPageRow LandingPageButtons">
		<ul>
			<li class="item-1">
				<?= wfMsg('landingpage-buttons-about-wikia') ?><br />
				<a href="<?= wfMsg('landingpage-buttons-about-wikia-link') ?>"><?= wfMsg('landingpage-buttons-learn-more') ?></a>
			</li>
			<li class="item-2">
				<?= wfMsg('landingpage-buttons-new-look') ?><br />
				<a href="<?= wfMsg('landingpage-buttons-new-look-link') ?>"><?= wfMsg('landingpage-buttons-faqs') ?></a>
			</li>
			<li class="item-3">
				<?= wfMsg('landingpage-buttons-about-make-the-move') ?><br />
				<a href="<?= wfMsg('landingpage-buttons-about-make-the-move-link') ?>"><?= wfMsg('landingpage-buttons-transition-guide') ?></a>
			</li>
		</ul>
	</section>

	<section class="LandingPageRow">
		<blockquote class="LandingPageQuote">
			<big>"</big>
			<?= wfMsg('landingpage-quote') ?>
		</blockquote>

		<ul class="LandingPageLinks">
			<li>
				<a href="<?= wfMsg('landingpage-facebook-link') ?>"><img src="<?= $imagesPath ?>icon-facebook.png" alt="" width="61" height=^61"></a>
			</li>
			<li>
				<a href="<?= wfMsg('landingpage-wikia-blog-link') ?>"><img src="<?= $imagesPath ?>icon-wikia-blog.png" alt="" width="61" height=^61"></a>
			</li>
			<li>
				<a href="<?= wfMsg('landingpage-twitter-link') ?>"><img src="<?= $imagesPath ?>icon-twitter.png" alt="" width="61" height=^61"></a>
			</li>
		</ul>
	</section>
</section>
