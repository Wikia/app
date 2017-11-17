<div id="mixed-content-footer" class="mcf-en" data-number-of-wiki-articles="<?= $numberOfWikiArticles ?>"
     data-number-of-ns-articles="<?= $numberOfNSArticles ?>">
	<div class="mcf-content">
		<h1 class="mcf-header"><?= wfMessage( 'recirculation-impact-footer-title' )->inContentLanguage()->escaped() ?>
		</h1>
		<div class="mcf-mosaic">
			<div class="mcf-column">
				<? if ( !empty( $topWikiArticles ) ): ?>
					<?= F::app()->renderPartial(
						'Recirculation',
						'wikiArticles',
						[
							'recirculationArticlesMore' => wfMessage( 'recirculation-articles-more' )->params(
									$sitename
								)->inContentLanguage()->escaped(),
							'communityHeaderBackground' => $communityHeaderBackground,
							'wikiArticles' => $topWikiArticles,
						]
					); ?>
				<? else: ?>
					<div class="mcf-card-ns-placeholder" data-tracking="card-1"></div>
				<? endif; ?>

				<? if ( $canShowDiscussions ): ?>
					<div class="mcf-discussions-placeholder"></div>
				<? else: ?>
					<div class="mcf-card-ns-placeholder" data-tracking="card-4"></div>
					<div class="mcf-card-wiki-placeholder" data-tracking="card-7"></div>
				<? endif; ?>
				<div class="mcf-card-ns-placeholder mcf-card-tall" data-tracking="card-10"></div>
				<div class="mcf-card-wiki-placeholder" data-tracking="card-13"></div>
				<div class="mcf-card-ns-placeholder" data-tracking="card-16"></div>
				<div class="mcf-card-wiki-placeholder mcf-card-tall" data-tracking="card-19"></div>
			</div>

			<div class="mcf-column">
				<div class="mcf-card-ns-placeholder" data-tracking="card-2"></div>
				<div class="mcf-card-ns-placeholder" data-tracking="card-5"></div>
				<div class="mcf-card-ns-placeholder" data-tracking="card-8"></div>
				<div class="mcf-card-wiki-placeholder" data-tracking="card-11"></div>
				<div class="mcf-card-ns-placeholder" data-tracking="card-14"></div>
				<div class="mcf-card-wiki-placeholder" data-tracking="card-17"></div>
				<?= F::app()->renderPartial(
					'Recirculation',
					'exploreWikis',
					[
						'recirculationExploreWikis' => wfMessage( 'recirculation-explore-wikis' )
							->inContentLanguage()
							->escaped(),
						'items' => $wikiRecommendations
					]
				); ?>
			</div>

			<div class="mcf-column">
				<div class="mcf-card-wiki-placeholder" data-tracking="card-3"></div>
				<div class="mcf-card-wiki-placeholder mcf-card-tall" data-tracking="card-6"></div>
				<div class="mcf-card-wiki-placeholder" data-tracking="card-9"></div>
				<div class="mcf-card-ns-placeholder" data-tracking="card-12"></div>
				<div class="mcf-card-wiki-placeholder mcf-card-tall" data-tracking="card-15"></div>
				<div class="mcf-card-ns-placeholder" data-tracking="card-18"></div>
				<div class="mcf-card-ns-placeholder" data-tracking="card-21"></div>
			</div>
		</div>
	</div>
</div>
