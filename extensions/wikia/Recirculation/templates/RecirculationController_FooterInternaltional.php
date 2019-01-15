<div id="mixed-content-footer" class="mcf-international" data-number-of-wiki-articles="<?= $numberOfWikiArticles ?>">
	<div class="mcf-content">
		<h1 class="mcf-header"><?= wfMessage( 'recirculation-impact-footer-title' )
				->inContentLanguage()
				->escaped() ?></h1>
		<div class="mcf-mosaic">
			<div class="mcf-column">
				<? if ( !empty( $topWikiArticles ) ): ?>
					<?= F::app()->renderPartial( 'Recirculation', 'wikiArticles', [
						'recirculationArticlesMore' => wfMessage( 'recirculation-articles-more' )
							->params( $sitename )
							->inContentLanguage()
							->escaped(),
						'communityHeaderBackground' => $communityHeaderBackground,
						'wikiArticles' => $topWikiArticles,
					] ); ?>
				<? else: ?>
					<div class="mcf-card-wiki-placeholder" data-tracking="footer-card-1"></div>
				<? endif; ?>
				<? if ( $canShowDiscussions ): ?>
					<div class="mcf-discussions-placeholder"></div>
				<? else: ?>
					<div class="mcf-card-wiki-placeholder" data-tracking="footer-card-4"></div>
					<div class="mcf-card-wiki-placeholder" data-tracking="footer-card-7"></div>
				<? endif; ?>
				<div class="mcf-card-wiki-placeholder" data-tracking="footer-card-10"></div>
				<div class="mcf-card-wiki-placeholder" data-tracking="footer-card-13"></div>
			</div>

			<div class="mcf-column">
				<div class="mcf-card-wiki-placeholder" data-tracking="footer-card-2"></div>
				<div class="mcf-card-wiki-placeholder" data-tracking="footer-card-5"></div>
				<div class="mcf-card-wiki-placeholder" data-tracking="footer-card-8"></div>
				<div class="mcf-card-wiki-placeholder" data-tracking="footer-card-11"></div>
				<div class="mcf-card-wiki-placeholder" data-tracking="footer-card-14"></div>
			</div>

			<div class="mcf-column">
				<div class="mcf-card-wiki-placeholder" data-tracking="footer-card-3"></div>
				<div class="mcf-card-wiki-placeholder" data-tracking="footer-card-6"></div>
				<div class="mcf-card-wiki-placeholder" data-tracking="footer-card-9"></div>
				<div class="mcf-card-wiki-placeholder" data-tracking="footer-card-12"></div>
				<?= F::app()->renderPartial( 'Recirculation', 'exploreWikis', [
					'recirculationExploreWikis' => wfMessage( 'recirculation-explore-wikis' )
						->inContentLanguage()
						->escaped(),
					'items' => $wikiRecommendations,
				] ); ?>
			</div>
		</div>
	</div>
</div>

