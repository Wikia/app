<section class="WikiaHomePage WikiaGrid">
	<header class="wikiahomepage-header">
		<div class="wikiahompage-heading-group">
			<h1><?= WfMessage('wikiahome-page-header-heading')->text(); ?></h1>
			<h4><?= WfMessage('wikiahome-page-header-subheading')->text() ?></h4>
		</div>
		<a class="button create-wiki" href="<?= wfMsg('wikiahome-page-header-create-wiki-button-destination') ?>"><?= wfMsg('wikiahome-page-header-create-wiki-button') ?></a>
		<?= F::app()->renderView('Search', 'Index', array('noautocomplete' => true, 'nonamespaces' => true)) ?>
	</header>
	<section class="wikiahomepage-wikis">
		<?= F::app()->renderView('WikiaHomePageController', 'visualization', array()); ?>
	</section>
	<div class="wikiahomepage-hubs">
		<? if( isset( $hubsSlots[0] ) ): ?>
			<?= F::app()->renderView('WikiaHomePageController', 'renderHubSection', $hubsSlots[0] ) ?>
		<? endif ?>
		<? if( isset( $hubsSlots[1] ) ): ?>
			<?= F::app()->renderView('WikiaHomePageController', 'renderHubSection', $hubsSlots[1] ) ?>
		<? endif ?>
		<? if( isset( $hubsSlots[2] ) ): ?>
			<?= F::app()->renderView('WikiaHomePageController', 'renderHubSection', $hubsSlots[2] ) ?>
		<? endif ?>
	</div>
	<div class="wikiahomepage-community">
		<section class="wikiahomepage-community-section grid-2 alpha">
			<h2><?= WfMessage('wikiahome-community-column1-heading')->text() ?></h2>
			<a href="<?= WfMessage('wikiahome-community-column1-link')->text() ?>" class="wikiahomepage-community-hero">
				<img class="wikiahomepage-community-hero-image wikiahomepage-community-image wikiahomepage-community-image-<?= $lang ?>" src="<?= $wg->BlankImgUrl ?>">
			</a>
			<p><?= WfMessage('wikiahome-community-column1-creative')->text() ?></p>
		</section>
		<section class="wikiahomepage-community-section grid-2">
			<h2><?= WfMessage('wikiahome-community-column2-heading')->text() ?></h2>
			<a href="<?= WfMessage('wikiahome-community-column2-link')->text() ?>" class="wikiahomepage-community-hero">
				<img class="wikiahomepage-community-hero-image wikiahomepage-highlight-image wikiahomepage-highlight-image-<?= $lang ?>" src="<?= $wg->BlankImgUrl ?>">
			</a>
			<p><?= wfMessage('wikiahome-community-column2-creative')->parse() ?></p>
		</section>
		<section class="wikiahomepage-community-section grid-2">
			<h2><?= WfMessage('wikiahome-community-column3-heading')->text() ?></h2>
			<div class="wikiahomepage-community-hero wikiahomepage-community-social-hero">
				<ul class="wikiahomepage-community-social">
					<li>
						<a href="<?= WfMessage('wikiahome-community-social-wikia-blog-link')->text() ?>">
							<img class="wikiahomepage-community-social-wikia-blog" src="<?= $wg->BlankImgUrl ?>"><?= wfMsg('wikiahome-community-social-wikia-blog') ?>
						</a>
					</li>
					<li>
						<a href="<?= WfMessage('oasis-community-social-twitter-link')->text() ?>">
							<img class="wikiahomepage-community-social-twitter" src="<?= $wg->BlankImgUrl ?>"><?= wfMsg('wikiahome-community-social-twitter') ?>
						</a>
					</li>
					<li>
						<a href="<?= WfMessage('oasis-community-social-facebook-link')->text() ?>">
							<img class="wikiahomepage-community-social-facebook" src="<?= $wg->BlankImgUrl ?>"><?= wfMsg('wikiahome-community-social-facebook') ?>
						</a>
					</li>
					<?php
						$message = WfMessage('oasis-community-social-googleplus-link')->text();
						if(!empty($message)):
					?>
					<li>
						<a href="<?= $message ?>">
							<img class="wikiahomepage-community-social-googleplus" src="<?= $wg->BlankImgUrl ?>"><?= wfMsg('wikiahome-community-social-googleplus') ?>
						</a>
					</li>
					<?php endif; ?>
				</ul>
			</div>
		</section>
	</div>
</section>
