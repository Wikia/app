<?php
/**
 * Renders edit buttons (with dropdown)
 *
 * @author Maciej Brencz
 */

class MenuButtonModule extends Module {

	const ADD_ICON = 1;
	const EDIT_ICON = 2;
	const LOCK_ICON = 3;
	const BLOG_ICON = 4;
	const MESSAGE_ICON = 5;

	var $wgStylePath;
	var $wgBlankImgUrl;

	var $action;
	var $actionName;
	var $actionAccessKey;
	var $class;
	var $dropdown;
	var $icon;
	var $iconBefore;
	var $loginURL;
	var $loginTitle;
	
	var $wgOut;
	var $wgUser;

	public function executeIndex($data) {
		global $wgTitle, $wgUser;

		wfProfileIn(__METHOD__);
	
		$this->loginURL = $this->createLoginURL();

		if (isset($data['action'])) {
			$this->action = $data['action'];
		}

		// action ID for tracking
		if (isset($data['name'])) {
			$this->actionName = $data['name'];
		}
		else {
			$this->actionName = 'edit';
		}

		$this->actionAccessKey = MenuButtonModule::accessKey($this->actionName);

		// prompt for login to edit?
		$this->promptLogin = ( !$wgTitle->userCanEdit() && $wgUser->isAnon() );

		// default CSS class
		$this->class = 'wikia-button';
		$img_class = 'icon';
		// render icon
		if (isset($data['image'])) {
			switch($data['image']) {
				case self::ADD_ICON:
					$img_class = 'sprite message';
					$height = 16;
					$width = 21;
					break;

				case self::LOCK_ICON:
					$img_class = 'sprite lock';
					$height = 12;
					$width = 9;
					$this->class = 'view-source';
					break;

				case self::BLOG_ICON:
					$img_class = 'sprite blog';
					$height = 16;
					$width = 22;
					break;

				case self::MESSAGE_ICON:
					$img_class = 'sprite message';
					$height = 16;
					$width = 22;
					break;

				case self::EDIT_ICON:
				default:
					$img_class = 'sprite edit-pencil';
					$height = 16;
					$width = 22;
					break;
			}

			$image = Xml::element('img', array(
				'alt' => '',
				'class' => $img_class,
				'height' => $height,
				'src' => "{$this->wgBlankImgUrl}",
				'width' => $width,
			));

			// show lock icon before the link
			if ($data['image'] == self::LOCK_ICON) {
				$this->iconBefore = $image;
			}
			else {
				$this->icon = $image;
			}

		}

		if (!empty($data['dropdown'])) {
			$this->dropdown = $data['dropdown'];

			// add accesskeys for dropdown items
			foreach($this->dropdown as $key => &$item) {
				$accesskey = MenuButtonModule::accessKey($key);

				if ($accesskey != false) {
					$item['accesskey'] = $accesskey;
				}
			}
			#print_pre($this->dropdown);

			$this->class = 'wikia-menu-button';
		}

		#print_pre($this);
		wfProfileOut(__METHOD__);
	}
	
	public function createLoginURL() {
		global $wgUser, $wgTitle;
		
		/** create login URL **/
		$skin = $wgUser->getSkin();
		$returnto = "returnto={$skin->thisurl}";
		if( $skin->thisquery != '' ) {
			$returnto .= "&returntoquery={$skin->thisquery}";
		}
		
		//$signUpHref = Skin::makeSpecialUrl('Signup', $returnto);
		$signUpHref = $returnto;
		$signUpHref .= "&type=login";
		//$this->loginTitle = Skin::makeSpecialUrl('Signup'); // the linker just expects a page-name here.
		return $signUpHref;
	}
	
	private static function accessKey($key) {
		$accesskey = false;
		switch($key) {
			case 'addtopic':
				$accesskey = 'a';
				break;
			case 'edit':
				$accesskey = 'e';
				break;
			case 'editprofile':
				$accesskey = 'e';
				break;
			case 'move':
				$accesskey = 'm';
				break;

			case 'protect':
			case 'unprotect':
				$accesskey = '=';
				break;

			case 'delete':
			case 'undelete':
				$accesskey = 'd';
				break;

			default:
				$accesskey = false;
		}
		return $accesskey;
	}

}
