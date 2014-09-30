<?

class MediaGalleryHooks {

	/**
	 * Add extension enabled flag to JS
	 * @param array $vars
	 * @return bool
	 */
	public static function onMakeGlobalVariablesScript(Array &$vars) {
		$vars['wgEnableMediaGalleryExt'] = !empty( F::app()->wg->EnableMediaGalleryExt );
		return true;
	}
}

