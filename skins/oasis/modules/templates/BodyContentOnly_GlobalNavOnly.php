<?= ( !empty( $wg->EnableDesignSystem ) ) ? $app->renderView( 'DesignSystemGlobalNavigationService', 'index' ) : $app->renderView( 'GlobalNavigation', 'index' ); ?>
<section id="WikiaPage" class="WikiaPage<?= empty( $wg->OasisNavV2 ) ? '' : ' V2' ?>">
	<div id="WikiaPageBackground" class="WikiaPageBackground"></div>
	<div class="WikiaPageContentWrapper">
		<div id="WikiaArticle" class="WikiaArticle">
			<?= $bodytext ?>
		</div>
	</div>
</section>
