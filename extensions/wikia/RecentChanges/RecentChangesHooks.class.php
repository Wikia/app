<?php

class RecentChangesHooks {

	public static function onGetNamespaceCheckbox( &$html, $selected = '', $all = null ) {
		$app = F::app();

		if ( $app->wg->User->isAnon() ) {
			return true;
		}

		if ( $app->wg->Title->isSpecial('RecentChanges') ) {
			return true;
		}

		$selectedArray = empty( $selected ) ? array() : array($selected);

		$response = $app->sendRequest( 'RecentChangesController', 'dropdownNamespaces', array( 'all' => $all, 'selected' => $selectedArray ) );
		$html = $response->getVal( 'html', '' );
		return true;
	}

	public static function onGetRecentChangeQuery( &$conds, &$tables, &$join_conds, $opts ) {
		$app = F::app();

		if ( $app->wg->User->isAnon() ) {
			return true;
		}

		if ( $app->wg->Title->isSpecial('RecentChanges') ) {
			return true;
		}

		if ( $opts['invert'] !== false ) {
			return true;
		}

		if ( (! isset( $opts['namespace'] ) ) || empty( $opts['namespace'] ) ) {
			$rcfs = new RecentChangesFiltersStorage($app->wg->User);
			$selected = $rcfs->get();

			if ( empty($selected) ) {
			    return true;
			}

			$db = wfGetDB( DB_SLAVE );
			$cond = 'rc_namespace IN ('.$db->makeList( $selected ).')';

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
		}

		return true;
	}
}
