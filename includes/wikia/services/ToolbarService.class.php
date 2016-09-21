<?php

abstract class ToolbarService {

	const PROMOTIONS_UPDATE_TTL = 1800;

	protected $name = '';

	public function __construct() {
		$this->name = 'oasis';
	}


	public function buildListItem( $id, $data = array() ) {
		return array(
			'type' => 'item',
			'id' => $id,
			'data' => $data,
		);
	}

	public function buildMenuListItem( $name, $items, $data = array() ) {
		return array(
			'type' => 'menu',
			'id' => 'Menu:' . $name,
			'data' => $data,
			'items' => $items,
		);
	}


	public function jsonToList( $json ) {
		$result = array();
		foreach ( $json as $v ) {
			$entry = array(
				'type' => 'item',
				'id' => $v['id'],
				'data' => array(),
			);
			if ( $v['defaultCaption'] !== $v['caption'] ) {
				$entry['data']['caption'] = $v['caption'];
			}
			/* FB:42264 - data is corrupt in production, so we have to handle both items list existing condition and isMenu condition*/
			if ( !empty( $v['isMenu'] ) ) {
				$items = isset( $v['items'] ) ? $v['items'] : array();
				$entry['type'] = 'menu';
				$entry['items'] = $this->jsonToList( $items );
			}
			/* end FB:42264 */
			$result[] = $entry;
		}
		return array_values( $result );
	}

	public function stringsToList( $data ) {
		foreach ( $data as $k => $v ) {
			if ( !is_array( $v ) ) {
				$data[$k] = $this->buildListItem( $v );
			}
			if ( isset( $data[$k]['items'] ) ) {
				$data[$k]['items'] = $this->stringsToList( $data[$k]['items'] );
			}
		}
		return $data;
	}

	public function instanceToJson( $data ) {
		foreach ( $data as $k => $v ) {
			$v = $v->getInfo();
			if ( $v ) $data[$k] = $v;
			else unset( $data[$k] );
		}
		return array_values( $data );
	}

	public function instanceToRenderData( $data ) {
		foreach ( $data as $k => $v ) {
			$v = $v->getRenderData();
			if ( $v ) $data[$k] = $v;
			else unset( $data[$k] );
		}
		return array_values( $data );
	}

	public function listToJson( $data ) {
		$data = $this->stringsToList( $data );
		$data = $this->listToInstance( $data );
		$data = $this->instanceToJson( $data );
		return $data;
	}

	public function listToInstance( $data ) {
		$blacklist = $this->getBlacklist();
		$result = array();
		foreach ( $data as $v ) {
			switch ( $v['type'] ) {
				case 'item':
					if ( !in_array( $v['id'], $blacklist ) ) {
						$result[] = $this->getUserCommandsService()->get( $v['id'], isset( $v['data'] ) ? $v['data']:array() );
					}
					break;
				case 'menu':
					$menu = $this->getUserCommandsService()->createMenu( $v['id'], wfMsg( 'oasis-mytools' ), array(
						'imageSprite' => 'mytools',
						'listItemClass' => 'mytools menu',
					) );
					$submenu = $this->listToInstance( $v['items'] );
					foreach ( $submenu as $item )
						$menu->addItem( $item );
					$result[] = $menu;
					break;
			}
		}
		return $result;
	}

	public function sortJsonByCaption( $data ) {
		$assoc = array();
		foreach ( $data as $v )
			$assoc[$v['caption']] = $v;
		ksort( $assoc );
		return array_values( $assoc );
	}


	public function cleanList( $list ) {
		foreach ( $list as $k => $v ) {
			if ( isset( $v['items'] ) ) {
				$list[$k] = $this->cleanList( $v['items'] );
			}
		}
		return array_values( $list );
	}

	protected $userCommandsService = null;

	protected function getUserCommandsService() {
		if ( empty( $this->userCommandsService ) ) {
			$this->userCommandsService = new UserCommandsService();
		}
		return $this->userCommandsService;
	}


	public function getToolbarOptionName() {
		return $this->name . '-toolbar-contents';
	}
	protected function getPromotionsOptionName() {
		return $this->name . '-toolbar-promotions';
	}

	protected function getUpdatePromotionsKey() {
		global $wgUser;
		return wfMemcKey( $this->name . '-toolbar', 'update-promotions', $wgUser->getId() );
	}

	public function getSeenPromotions() {
		global $wgUser;
		if ( $wgUser->isAnon() ) {
			return array();
		}

		$seenPromotions = $wgUser->getGlobalPreference( $this->getPromotionsOptionName() );
		$seenPromotions = $seenPromotions ? unserialize( $seenPromotions, [ 'allowed_classes' => false ] ) : array();
		$promotionsDiff = array_intersect( $this->getPromotions(), $seenPromotions );

		return $promotionsDiff;
	}

	protected function setSeenPromotions( $list ) {
		global $wgUser;

		$wgUser->setGlobalPreference( $this->getPromotionsOptionName(), serialize( $list ) );
		$wgUser->saveSettings();
		return true;
	}

	protected function updatePromotions( $forceUpdate = false ) {
		global $wgUser, $wgMemc;
		if ( $wgUser->isAnon() ) {
			return;
		}

		$updated = $wgMemc->get( $this->getUpdatePromotionsKey(), false );
		if ( $forceUpdate || empty( $updated ) ) {
			$seenPromotions = $this->getSeenPromotions();
			$unseenPromotions = array_diff( $this->getPromotions(), $seenPromotions );

			$list = $unseenPromotions;
			$list = $this->stringsToList( $list );
			$list = $this->listToInstance( $list );
			foreach ( $list as $k => $item ) {
				if ( !$item->isAvailable() || !$item->isEnabled() ) {
					unset( $list[$k] );
				}
			}

			// User has unseen promoted tools
			if ( !empty( $list ) ) {
				$newItems = array();
				foreach ( $list as $item ) {
					$newItems[] = $item;
					$seenPromotions[] = $item->getId();
				}
				$this->addItemsAndSave( $newItems );
				$this->setSeenPromotions( $seenPromotions );
			}

			$wgMemc->set( $this->getUpdatePromotionsKey(), true, self::PROMOTIONS_UPDATE_TTL );
		}
	}


	protected function addItemsAndSave( $items ) {
		$items = $this->jsonToList( $this->instanceToJson( $items ) );
		$data = $this->getCurrentList();
		end( $data );
		$myToolsId = key( $data );
		$data[$myToolsId]['items'] = array_merge( $data[$myToolsId]['items'], $items );
		$this->saveToolbarList( $data );
	}

	protected function loadToolbarList() {
		global $wgUser;
		if ( !$wgUser->isAnon() ) {
			$toolbar = $wgUser->getGlobalPreference( $this->getToolbarOptionName() );
			if ( is_string( $toolbar ) ) {
				$toolbar = @unserialize( $toolbar, [ 'allowed_classes' => false ] );
				if ( is_array( $toolbar ) ) {
					/* FB:42264 Fix bad data by switch my-tools to menu if it is item */
					foreach ( $toolbar as $k => $v ) {
						if ( $v['type'] === 'item' && strpos( $v['id'], 'my-tools' ) ) {
							$v['type'] = 'menu';
							$v['items'] = array();
							$toolbar[$k] = $v;
						}
					}
					/* end FB:42264 */
					return $toolbar;
				}
			}
		}

		return false;
	}

	protected function saveToolbarList( $list ) {
		global $wgUser;
		if ( $wgUser->isAnon() ) {
			return false;
		}

//			$list = $this->cleanList($list);
		$wgUser->setGlobalPreference( $this->getToolbarOptionName(), serialize( $list ) );
		$wgUser->saveSettings();
		return true;
	}

	public function load() {
		return $this->loadToolbarList();
	}

	public function save( $list ) {
		return $this->saveToolbarList( $list );
	}

	public function clear() {
		global $wgUser, $wgMemc;
		$wgUser->setGlobalPreference( $this->getPromotionsOptionName(), null );
		$wgUser->setGlobalPreference( $this->getToolbarOptionName(), null );
		$wgUser->saveSettings(); ;

		$wgMemc->delete( $this->getUpdatePromotionsKey() );
	}




	abstract public function getCurrentList();
	abstract public function getDefaultList();


	abstract public function getPromotions();
	abstract public function getAllOptionNames();
	abstract public function getPopularOptionNames();
	abstract public function getBlacklist();
}
