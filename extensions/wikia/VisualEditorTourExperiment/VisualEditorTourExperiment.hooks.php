<?php
namespace Wikia\VisualEditorTourExperiment;

class Hooks {

	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		\Wikia::addAssetsToOutput( 'visual_editor_tour_experiment_js' );
		\Wikia::addAssetsToOutput( 'visual_editor_tour_experiment_scss' );
		return true;
	}

	public function onMakeGlobalVariablesScript( array &$aVars ) {
		$aVars['wgEnableVisualEditorTourExperiment'] = true;
		return true;
	}

}
