<section class="LandingPage">
	<section class="LandingPageRow">
		<section class="LandingPageWelcome">
			<h1><?= wfMsg('landingpage') ?></h1>
			<h2><?= wfMsgExt('landingpage-secondary-line', array('parse')) ?></h2>
			
			<?php if ($loggedIn == true && $current_skin == "oasis") { ?>
				<h3><?= wfMsgExt('landingpage-dive-in', array('parse')) ?></h3>
			<?php }
			else { ?>
				<h3><?= wfMsgExt('landingpage-secondary-2', array('parse')) ?></h3>
				<h3><?= wfMsgExt('landingpage-secondary-3', array('parse')) ?></h3>
			
			<?php
			}
			?>
			
			
<?php	if ($loggedIn == false || ( $loggedIn == true && $current_skin != "oasis")) { ?>
			<section class="LandingPageButtonUpdate">
				<a href="<?= $button_url ?>" <?= $logInClass ?>>
				
					<button id="landing-update">
						<?= wfMsg('landingpage-buttons-update-me') ?>
					</button>
				</a>
			</section>
	<?php } ?>

<?php if ($loggedIn == true && $current_skin == "oasis") {	?>
			<section class="LandingPageExamples">	
					<ul>
			<?php foreach($wikis as $wiki) { ?>
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
	<?php } ?>
			<section class="LandingPageSwitchBack">
				<h3><a href="<?= wfMsg('landingpage-change-back-link') ?>"><?= wfMsg('landingpage-change-back-text') ?></a></h3>
			
			</section>
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
				<?= wfMsg('landingpage-buttons-new-user') ?><br />
				<a href="<?= wfMsg('landingpage-buttons-new-user-link') ?>"><?= wfMsg('landingpage-buttons-new-user-more') ?></a>
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

