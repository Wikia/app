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

	var $wgStylePath;
	var $wgBlankImgUrl;

	var $action;
	var $actionName;
	var $class;
	var $dropdown;
	var $icon;
	var $iconBefore;
	
	var $wgOut;
	

	public function executeIndex($data) {
		wfProfileIn(__METHOD__);

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

		// default CSS class
		$this->class = 'wikia-button';
		$img_class = 'icon';
		// render icon
		if (isset($data['image'])) {
			switch($data['image']) {
				case self::ADD_ICON:
					$img_class = 'osprite icon-add';
					$height = 10;
					$width = 10;
					break;

				case self::LOCK_ICON:
					$height = 12;
					$width = 9;
					$this->class = 'view-source';
					break;

				case self::EDIT_ICON:
				default:
					$height = 15;
					$width = 15;
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
				switch($key) {
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

}