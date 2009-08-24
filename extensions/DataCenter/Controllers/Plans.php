<?php
/**
 * Plans Page Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterControllerPlans extends DataCenterController {

	/* Private Members */

	private static $steps = array(
		'plan',
		'rack',
		'object',
	);

	/* Functions */

	public function __construct(
		array $path
	) {
		// Actions
		if ( $path['id'] ) {
			if ( DataCenterPage::userCan( 'remove' ) ) {
				$this->actions['remove'] = array(
					'page' => 'plans',
					'type' => $path['type'],
					'action' => 'remove',
					'id' => $path['id']
				);
			}
			if ( DataCenterPage::userCan( 'change' ) ) {
				$this->actions['configure'] = array(
					'page' => 'plans',
					'type' => $path['type'],
					'action' => 'configure',
					'id' => $path['id']
				);
			}
			$this->actions['view'] = array(
				'page' => 'plans',
				'type' => $path['type'],
				'action' => 'view',
				'id' => $path['id']
			);
		}
		// Trail
		if ( $path['id'] ) {
			$type = $path['type'];
			$id = $path['id'];
		} else if (
			is_array( $path['parameter'] ) &&
			count( $path['parameter'] ) >= 2
		) {
			$type = $path['parameter'][0];
			$id = $path['parameter'][1];
		}
		if ( isset( $id, $type ) ) {
			$include = false;
			foreach ( array_reverse( self::$steps ) as $step ) {
				if ( $step == $type ) {
					$include = true;
				}
				if ( !$include ) {
					continue;
				}
				if ( $step == 'plan' ) {
					$plan = DataCenterDB::getPlan( $id );
					$this->trail[$plan->get( 'name' )] = array(
						'page' => 'plans',
						'type' => 'plan',
						'action' => 'view',
						'id' => $plan->getId(),
					);
				} else {
					$link = DataCenterDB::getLink( 'asset', $id );
					$this->trail[$link->get( 'name' )] = array(
						'page' => 'plans',
						'type' => $step,
						'action' => 'view',
						'id' => $link->getId(),
					);
					$id = $link->get( 'parent_link' );
					if ( $id == null ) {
						$id = $link->get( 'plan' );
					}
				}
			}
			$this->trail = array_reverse( $this->trail );
		}
	}

	public function remove(
		array $data,
		$type
	) {
		if ( !DataCenterPage::userCan( 'remove' ) ) {
			return false;
		}
		// Checks for confirmation
		if (
			!isset( $data['row']['confirm'] ) ||
			( $data['row']['confirm'] != 'yes' )
		) {
			return false;
		}
		switch ( $type ) {
			case 'plan':
				$plan = DataCenterDBPlan::newFromValues( $data['row'] );
				foreach ( $plan->getLinks() as $childLink ) {
					$childLink->delete();
				}
				$plan->delete();
				return true;
			case 'rack':
			case 'object':
				$link = DataCenterDBAssetLink::newFromValues( $data['row'] );
				foreach ( $link->getLinks() as $childLink ) {
					$childLink->delete();
				}
				$link->delete();
				return true;
		}
		return false;
	}

	public function save(
		array $data,
		$type
	) {
		if ( !DataCenterPage::userCan( 'change' ) ) {
			return false;
		}
		switch ( $type ) {
			case 'plan':
				$plan = DataCenterDBPlan::newFromValues( $data['row'] );
				$plan->save();
				return true;
			case 'rack':
			case 'object':
				$link = DataCenterDBAssetLink::newFromValues( $data['row'] );
				$link->save();
				return true;
		}
		return false;
	}

}