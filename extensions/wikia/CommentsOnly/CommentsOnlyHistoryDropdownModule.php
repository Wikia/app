<?php

class CommentsOnlyHistoryDropdownModule extends HistoryDropdownModule {

	protected function getTemplatePath() {
		global $wgAutoloadClasses;
		if( wfCommentsOnlyCheck() ) {
			wfLoadExtensionMessages('CommentsOnly');
			return dirname($wgAutoloadClasses['CommentsOnlyHistoryDropdownModule']).'/templates/'.$this->moduleName.'_'.$this->moduleAction.'.php';
		} else {
			return dirname($wgAutoloadClasses['HistoryDropdownModule']).'/templates/'.$this->moduleName.'_'.$this->moduleAction.'.php';
		}
	}
}
