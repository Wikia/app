<?php

	class MenuUserCommand extends UserCommand {

		protected $defaultRenderType = 'menu';

		protected $overflow = false;

		public function __construct( $id, $caption, $options = array() ) {
			parent::__construct($id);

			$this->available = true;
			$this->enabled = true;
			$this->caption = $caption;
			foreach ($options as $k => $v)
				$this->$k = $v;
		}

		protected function buildData() {}

		protected $items = array();

		protected function getTrackerName() {
			return '';
		}

		public function addItem( $item ) {
			if(!is_object($item)) {				
				Wikia::log(__METHOD__,false,'BugID: 21498 - adding non-object to MenuUserCommand->items');
				Wikia::logBacktrace(__METHOD__);
			}
			
			$this->items[] = $item;
		}

		public function render() {
			if (empty($this->items)) {
				return '';
			}
			return parent::render();
		}

		protected function renderIcon() {
			return '<span class="arrow-icon-ctr"><span class="arrow-icon arrow-icon-single"></span></span>';
		}

		public function renderSubmenu() {
			$html = '';

			$html .= Xml::openElement('ul',array(
				'id' => $this->name . '-menu',
				'class' => 'tools-menu',
			));
			$html .= self::renderList($this->items);
			$html .= Xml::closeElement('ul');

			return $html;
		}


		static protected function renderList( $list ) {
			$html = '';
			foreach ($list as $item)
				$html .= $item->render();
			return $html;
		}

		public function getInfo() {
			$info = parent::getInfo();
			foreach ($this->items as $item) {
				$itemInfo = $item->getInfo();
				if ($itemInfo)
					$info['items'][] = $itemInfo;
			}
			return $info;
		}

		static protected function renderDataList( $list ) {
			$result = array();
			foreach ($list as $v) {
				if(is_object($v)) {
					$item = $v->getRenderData();
					if ($item) {
						$result[] = $item;
					}
				} else {
					Wikia::log(__METHOD__,false,'BugID: 21498');
					Wikia::logBacktrace(__METHOD__);
				}
			}
			return $result;
		}

		public function getRenderData() {
			$data = parent::getRenderData();

			if (is_array($data)) {
				$data['items'] = self::renderDataList($this->items);
			}
			if (empty($data['items'])) {
				return false;
			}

			return $data;
		}

	}