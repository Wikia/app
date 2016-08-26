<?php
namespace Wikia\VisualEditorTourExperiment;

class Hooks {

	/**
	 * Hook: BeforePageDisplay
	 * Add VisualEditorTourExperiment assets and config var to pages where the editor can appear
	 * @param \OutputPage $out
	 * @param \Skin $skin
	 * @return bool
	 */
	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		if ( $out->isArticleRelated() ) {
			\Wikia::addAssetsToOutput( 'visual_editor_tour_experiment_js' );
			\Wikia::addAssetsToOutput( 'visual_editor_tour_experiment_scss' );
			$out->addJsConfigVars( 'wgEnableVisualEditorTourExperiment', true );
		}

		return true;
	}

}
