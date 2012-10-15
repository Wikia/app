<section class="WikiaHomePage WikiaGrid">
	<header class="wikiahomepage-header">
		<div class="wikiahompage-heading-group">
			<h1><?= wfMsg('wikiahome-page-header-heading'); ?></h1>
			<h4><?= wfMsg('wikiahome-page-header-subheading') ?></h4>
		</div>
		<a class="button create-wiki" href="<?= wfMsg('wikiahome-page-header-create-wiki-button-destination') ?>"><?= wfMsg('wikiahome-page-header-create-wiki-button') ?></a>
		<?= F::app()->renderView('Search', 'Index', array('noautocomplete' => true)) ?>
	</header>
	<section class="wikiahomepage-wikis">
		<?= F::app()->renderView('WikiaHomePageController', 'visualization', array()); ?>
		<?= F::app()->renderView('WikiaHomePageController', 'getList', array()); ?>
	</section>
	<div class="wikiahomepage-hubs">
		<?= F::app()->renderView('WikiaHomePageController', 'renderHubSection', array(
			'classname' => 'videogames',
			'heading' => wfMsg('wikiahome-hubs-videogames-heading'),
			'heroimageurl' => $hubImages['Video_Games'],
			'herourl' => wfMsg('wikiahome-hubs-videogames-url'),
			'creative' => wfMsg('wikiahome-hubs-videogames-creative'),
			'moreheading' => wfMsg('wikiahome-hubs-videogames-more-heading'),
			'morelist' => wfMsgExt('wikiahome-hubs-videogames-more-list', 'parse'),
		)) ?>
		<?= F::app()->renderView('WikiaHomePageController', 'renderHubSection', array(
			'classname' => 'entertainment',
			'heading' => wfMsg('wikiahome-hubs-entertainment-heading'),
			'heroimageurl' => $hubImages['Entertainment'],
			'herourl' => wfMsg('wikiahome-hubs-entertainment-url'),
			'creative' => wfMsg('wikiahome-hubs-entertainment-creative'),
			'moreheading' => wfMsg('wikiahome-hubs-entertainment-more-heading'),
			'morelist' => wfMsgExt('wikiahome-hubs-entertainment-more-list', 'parse'),
		)) ?>
		<?= F::app()->renderView('WikiaHomePageController', 'renderHubSection', array(
			'classname' => 'lifestyle',
			'heading' => wfMsg('wikiahome-hubs-lifestyle-heading'),
			'heroimageurl' => $hubImages['Lifestyle'],
			'herourl' => wfMsg('wikiahome-hubs-lifestyle-url'),
			'creative' => wfMsg('wikiahome-hubs-lifestyle-creative'),
			'moreheading' => wfMsg('wikiahome-hubs-lifestyle-more-heading'),
			'morelist' => wfMsgExt('wikiahome-hubs-lifestyle-more-list', 'parse'),
		)) ?>
	</div>
	<div class="wikiahomepage-community">
		<section class="wikiahomepage-community-section grid-2 alpha">
			<h2><?= wfMsg('wikiahome-community-column1-heading') ?></h2>
			<a href="<?= wfMsg('wikiahome-community-column1-link') ?>" class="wikiahomepage-community-hero">
				<img class="wikiahomepage-community-hero-image wikiahomepage-community-image wikiahomepage-community-image-<?= $lang ?>" src="<?= $wg->BlankImgUrl ?>">
			</a>
			<p><?= wfMsg('wikiahome-community-column1-creative') ?></p>
		</section>
		<section class="wikiahomepage-community-section grid-2">
			<h2><?= wfMsg('wikiahome-community-column2-heading') ?></h2>
			<a href="<?= wfMsg('wikiahome-community-column2-link') ?>" class="wikiahomepage-community-hero">
				<img class="wikiahomepage-community-hero-image wikiahomepage-highlight-image wikiahomepage-highlight-image-<?= $lang ?>" src="<?= $wg->BlankImgUrl ?>">
			</a>
			<p><?= wfMsg('wikiahome-community-column2-creative') ?></p>
		</section>
		<section class="wikiahomepage-community-section grid-2">
			<h2><?= wfMsg('wikiahome-community-column3-heading') ?></h2>
			<div class="wikiahomepage-community-hero wikiahomepage-community-social-hero">
				<ul class="wikiahomepage-community-social">
					<li>
						<a href="<?= wfMsg('wikiahome-community-social-wikia-blog-link') ?>">
							<img class="wikiahomepage-community-social-wikia-blog" src="<?= $wg->BlankImgUrl ?>"><?= wfMsg('wikiahome-community-social-wikia-blog') ?>
						</a>
					</li>
					<li>
						<a href="<?= wfMsg('wikiahome-community-social-twitter-link') ?>">
							<img class="wikiahomepage-community-social-twitter" src="<?= $wg->BlankImgUrl ?>"><?= wfMsg('wikiahome-community-social-twitter') ?>
						</a>
					</li>
					<li>
						<a href="<?= wfMsg('wikiahome-community-social-facebook-link') ?>">
							<img class="wikiahomepage-community-social-facebook" src="<?= $wg->BlankImgUrl ?>"><?= wfMsg('wikiahome-community-social-facebook') ?>
						</a>
					</li>
					<?php
						$message = wfMsg('wikiahome-community-social-googleplus-link');
						if(!empty($message)):
					?>
					<li>
						<a href="<?= wfMsg('wikiahome-community-social-googleplus-link') ?>">
							<img class="wikiahomepage-community-social-googleplus" src="<?= $wg->BlankImgUrl ?>"><?= wfMsg('wikiahome-community-social-googleplus') ?>
						</a>
					</li>
					<?php endif; ?>
				</ul>
			</div>
		</section>
	</div>
</section>
