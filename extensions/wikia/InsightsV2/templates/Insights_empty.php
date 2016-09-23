<div class="insights-container-nav <?= $themeClass ?>">
	<?= $app->renderView( 'Insights', 'insightsList', [ 'type' => $type ] ) ?>
</div>
<div class="insights-container-main <?= $themeClass ?>">
	<div class="insights-header insights-icon-<?= Sanitizer::encodeAttribute( $type ) ?> clearfix">
		<h2 class="insights-header-subtitle"><?= wfMessage( InsightsHelper::INSIGHT_SUBTITLE_MSG_PREFIX . $type )->escaped() ?></h2>
		<p class="insights-header-description"><?= wfMessage( InsightsHelper::INSIGHT_DESCRIPTION_MSG_PREFIX . $type )->parse() ?></p>
	</div>
	<p><?= $emptyMessage ?></p>
</div>
