<section class="LandingPage">
	<div class="LandingPageSearch">
		<?= wfRenderPartial("Search", "Index", array ("placeholder" => "Search Wikia", "fulltext" => "0", "wgBlankImgUrl" => $wgBlankImgUrl, "wgTitle" => $wgTitle)); ?>
	</div>

	<ul class="LandingPageLanguageLinks">
<?php
foreach($languageLinks as $item) {
?>
		<li>[<a href="<?= htmlspecialchars($item['href']) ?>"><?= htmlspecialchars($item['text']) ?></a>]</li>
<?php
}
?>
	</ul>

	<ul class="LandingPageSocialLinks">
		<li class="twitter"><a alt="Follow us on Twitter" href="http://www.twitter.com/wikia"></a></li>
		<li class="facebook"><a alt="Wikia on Facebook" href="http://www.facebook.com/wikia"></a></li>
		<li class="blog"><a alt="Read our Blog" href="http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog"></a></li>
	</ul>

	<div class="LandingPageSites">
		<h2><?= wfMsg('landingpage-start-exploring') ?></h2>
		<p><?= wfMsg('landingpage-start-exploring-text') ?></p>
		
		
		<ul>
			<li class="superpower"><a alt="Superpower Wiki" href="http://powerlisting.wikia.com"><img src="<?= $wgBlankImgUrl ?>"></a></li>
			<li class="harrypotter"><a alt="Harry Potter Wiki" href="http://harrypotter.wikia.com"><img src="<?= $wgBlankImgUrl ?>"></a></li>
			<li class="glee"><a alt="Glee Wiki" href="http://glee.wikia.com"><img src="<?= $wgBlankImgUrl ?>"></a></li>
			<li class="medalofhonor"><a alt="Medla of Honor Wiki" href="http://medalofhonor.wikia.com"><img src="<?= $wgBlankImgUrl ?>"></a></li>
			<li class="poptarts"><a alt="Pop Tarts Wiki" href="http://poptarts.wikia.com"><img src="<?= $wgBlankImgUrl ?>"></a></li>
		</ul>
		<a href="http://community.wikia.com/wiki/The_new_look" class="more"><?= wfMsg('landingpage-readfaq') ?></a>
	</div>

	<section class="LandingPageWelcome">
				<h1><?= wfMsg('landingpage') ?></h1>
	</section>

	<section class="LandingPageVideo">
		<iframe class="video" swidth="605" sheight="335" frameborder="0" src="http://player.vimeo.com/video/15645799">		</iframe>
	</section>
		
	
	<p class="LandingPageMain">
		<?= wfMsg('landingpage-text') ?>
		<a href="http://community.wikia.com/wiki/About_Wikia" class="more"><?= wfMsg('landingpage-buttons-learn-more') ?></a>
	</p>
</section>