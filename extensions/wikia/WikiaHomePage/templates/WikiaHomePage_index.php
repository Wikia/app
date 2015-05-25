<section class="WikiaHomePage WikiaGrid">
	<header class="wikiahomepage-header">
		<div class="wikiahompage-heading-group">
			<h1><?= wfMessage('wikiahome-page-header-heading')->text(); ?></h1>
			<h4><?= wfMessage('wikiahome-page-header-subheading')->text(); ?></h4>
		</div>
		<a class="button create-wiki" href="<?= wfMessage('wikiahome-page-header-create-wiki-button-destination')->text(); ?>">
			<?= wfMessage('wikiahome-page-header-create-wiki-button')->text(); ?>
		</a>
	</header>
	<section class="wikiahomepage-wikis">
		<?= F::app()->renderView('WikiaHomePageController', 'visualization', []); ?>
	</section>
	<div class="wikiahomepage-hubs">
		<? foreach ($hubsSlots as $hubsSlot): ?>
			<? if (!empty($hubsSlot)): ?>
				<?= $app->renderView('WikiaHomePageController', 'renderHubSection', $hubsSlot); ?>
			<? endif; ?>
		<? endforeach; ?>
	</div>
	<div class="wikiahomepage-community">
		<section class="wikiahomepage-community-section grid-2 alpha">
			<h2><?= wfMessage('wikiahome-community-column1-heading')->text(); ?></h2>
			<a href="<?= wfMessage('wikiahome-community-column1-link')->text(); ?>" class="wikiahomepage-community-hero">
				<img
					class="wikiahomepage-community-hero-image wikiahomepage-community-image wikiahomepage-community-image-<?= $lang; ?>"
					src="<?= $wg->BlankImgUrl; ?>">
			</a>

			<p><?= wfMessage('wikiahome-community-column1-creative')->text(); ?></p>
		</section>
		<section class="wikiahomepage-community-section grid-2">
			<h2><?= wfMessage('wikiahome-community-column2-heading')->text(); ?></h2>
			<a href="<?= wfMessage('wikiahome-community-column2-link')->text(); ?>" class="wikiahomepage-community-hero">
				<img
					class="wikiahomepage-community-hero-image wikiahomepage-highlight-image wikiahomepage-highlight-image-<?= $lang; ?>"
					src="<?= $wg->BlankImgUrl; ?>">
			</a>

			<p><?= wfMessage('wikiahome-community-column2-creative')->parse(); ?></p>
		</section>
		<section class="wikiahomepage-community-section grid-2">
			<h2><?= wfMessage('wikiahome-community-column3-heading')->text(); ?></h2>

			<div class="wikiahomepage-community-hero wikiahomepage-community-social-hero">
				<ul class="wikiahomepage-community-social">
					<li>
						<a href="<?= wfMessage('oasis-community-social-twitter-link')->text(); ?>">
							<img class="wikiahomepage-community-social-twitter"
							     src="<?= $wg->BlankImgUrl; ?>"><?= wfMessage('wikiahome-community-social-twitter')->text(); ?>
						</a>
					</li>
					<li>
						<a href="<?= wfMessage('oasis-community-social-facebook-link')->text(); ?>">
							<img class="wikiahomepage-community-social-facebook"
							     src="<?= $wg->BlankImgUrl; ?>"><?= wfMessage('wikiahome-community-social-facebook')->text(); ?>
						</a>
					</li>
					<?
					$message = wfMessage('oasis-community-social-googleplus-link')->text();
					if (!empty($message)):
						?>
						<li>
							<a href="<?= $message; ?>">
								<img class="wikiahomepage-community-social-googleplus"
								     src="<?= $wg->BlankImgUrl; ?>"><?= wfMessage('wikiahome-community-social-googleplus')->text(); ?>
							</a>
						</li>
					<? endif; ?>
				</ul>
			</div>
		</section>
	</div>
</section>
