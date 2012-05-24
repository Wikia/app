<?php 

class RecentChangesHooks {

	public static function onGetNamespaceCheckbox( &$html, $selected = '', $all = null, $element_name = 'namespace', $label = null ) {
		$app = F::app();

		if ( $app->wg->User->isAnon() ) {
			return true;
		}

		if ( $app->wg->Title->isSpecial('RecentChanges') ) {
			return true;
		}

		$response = $app->sendRequest( 'RecentChangesController', 'dropdownNamespaces', array( 'all' => $all, 'selected' => $selected ) );
		$html = $response->getVal( 'html', '' );

		return true;
	}

	public function onGetRecentChangeQuery( &$conds, &$tables, &$join_conds, $opts ) {
		$app = F::app();

		if ( $app->wg->User->isAnon() ) {
			return true;
		}

		if ( $app->wg->Title->isSpecial('RecentChanges') ) {
			return true;
		}
		
		if ( $opts['namespace'] === '' ) {
	//		return true;
		}

		$rcfs = new RecentChangesFiltersStorage($app->wg->User);
		$selected = $rcfs->get();
	
		if(!empty($selected)) {
			$namespaces = array_keys($selected);
			if ( $opts['invert'] === false ) {
				$cond = 'rc_namespace IN ('.implode( ',', $namespaces ).')';
			} else {
				$cond = 'rc_namespace NOT IN ('.implode( ',', $namespaces ).')';
			}		
		}
		
		$flag = true;
		foreach( $conds as $key => &$value ) {
			if ( strpos($value, 'rc_namespace') !== false ) {
				$value = $cond;
				$flag = false;
				break;
			}
		}
		
		if ( $flag ) {
			$conds[] = $cond;
		}

		return true;
	}
}