<?php

	abstract class UserCommand {

		protected $id = null;
		protected $type = null;
		protected $name = null;
		protected $data = null;

		public function __construct( $id, $data = array() ) {
			$this->id = $id;
			list( $this->type, $this->name ) = explode(':',$this->id,2);
			$this->data = $data;
		}

		public function getId() {
			return $this->id;
		}

		public function getInfo() {
			$defaultCaption = $this->getAbstractCaption();
			$caption = !empty($this->data['caption']) ? $this->data['caption'] : $defaultCaption;
			return array(
				'id' => $this->getId(),
				'defaultCaption' => $defaultCaption,
				'caption' => $caption,
			);
		}

		public function isAvailable() {
			$this->needData();
			return $this->available;
		}

		public function isEnabled() {
			$this->needData();
			return $this->enabled;
		}

		protected $overflow = true;
		protected $defaultRenderType = 'link';

		protected $available = false;
		protected $enabled = false;

		protected $imageSprite = false;
		protected $imageUrl = false;


		protected $listItemId = '';
		protected $listItemClass = '';
		protected $linkId = '';
		protected $linkClass = '';
		protected $accessKey = false;

		protected $href = '#';
		protected $caption = null;
		protected $description = null;

		protected $abstractCaption = null;
		protected $abstractDescription = null;

		protected function getAbstractCaption() {
			$this->needData();
			return $this->abstractCaption;
		}

		protected function getAbstractDescription() {
			$this->needData();
			return $this->description;
		}

		protected function getListItemAttributes() {
			$attributes = array();
			if ($this->listItemId) $attributes['id'] = $this->listItemId;
			$listItemClass = trim($this->listItemClass . ( $this->overflow ? ' overflow' : '' ));
			if ($listItemClass) $attributes['class'] = $listItemClass;
			return $attributes;
		}

		protected function getLinkAttributes() {
			$attributes = array();
			$attributes['data-tool-id'] = $this->id;
			$attributes['data-name'] = $this->getTrackerName();
			if ($this->href) $attributes['href'] = $this->href;
			if ($this->linkId) $attributes['id'] = $this->linkId;
			if ($this->linkClass) $attributes['class'] = $this->linkClass;
			if ($this->accessKey) $attributes['accesskey'] = $this->accessKey;
			return $attributes;
		}

		protected function getTrackerName() {
			return strtolower($this->name);
		}

		public function render() {
			$this->needData();

			if (!$this->available) {
				return '';
			}

			$html = '';
			$html .= Xml::openElement('li',$this->getListItemAttributes());

			$html .= $this->renderIcon();

			if ($this->enabled) {
				$html .= Xml::element('a',$this->getLinkAttributes(),$this->caption);
				$html .= $this->renderSubmenu();
			} else {
				$spanAttributes = array(
					'title' => $this->getDisabledMessage(),
				);
				$html .= Xml::element('span',$spanAttributes,$this->caption);
			}

			$html .= Xml::closeElement('li');
			return $html;
		}

		public function getRenderData() {
			$this->needData();
			if (!$this->available)
				return false;

			$data = array(
				'type' => $this->defaultRenderType,
				'caption' => $this->caption,
				'tracker-name' => $this->getTrackerName(),
			);
			if ($this->enabled) {
				$data['href'] = $this->href;
			} else {
				$data['type'] = 'disabled';
				$data['error-message'] = $this->getDisabledMessage();
			}

			return $data;
		}

		protected function renderIcon() {
			return '';
		}

		public function renderSubmenu() {
			return '';
		}

		protected function getDisabledMessage() {
			return wfMsg('oasis-toolbar-for-admins-only');
		}


		protected $dataBuilt = false;

		protected function needData() {
			if (!$this->dataBuilt) {
				$this->buildData();
				$this->abstractCaption = $this->caption;
				if (!empty($this->data['caption']))
					$this->caption = $this->data['caption'];
				$this->dataBuilt = true;
			}
		}

		abstract protected function buildData();

		static protected $skinData = null;

		static public function setSkinData( $skinData ) {
			self::$skinData = $skinData;
		}

		static public function needSkinData() {
			if (is_null(self::$skinData)) {
				$skinTemplateObj = F::app()->getSkinTemplateObj();
				if ( $skinTemplateObj ) {
					self::$skinData = array(
						'content_actions' => $skinTemplateObj->get('content_actions'),
						'nav_urls' => $skinTemplateObj->get('nav_urls'),
					);
				} else {
					/** @var $context RequestContext */
					$context = RequestContext::getMain();
					/** @var $skin WikiaSkin */
					$skin = $context->getSkin();

					if (!isset($skin->iscontent)) {
						$title = $skin->getTitle();

						if ( in_array( $title->getNamespace(), array( NS_SPECIAL, NS_FILE ) ) ) {
							$skin->getOutput()->setArticleRelated(false);
						}
						$skin->thispage = $title->getPrefixedDBkey();
						$skin->loggedin = $context->getUser()->isLoggedIn();
					}

					self::$skinData = array(
						'content_actions' => $skin->buildContentActionUrls( $skin->buildContentNavigationUrls() ),
						'nav_urls' => $skin->buildNavUrls(),
					);
				}
			}
		}
	}
