<?php

	class UserCommandsService {

		protected $cache = array();

		public function __construct() {
		}

		public function clearCache() {
			$this->cache = array();
		}

		/**
		 * @param string $name Command ID
		 * @param array $options (optional)
		 * @return UserCommand
		 */
		public function get( $name, $options = array() ) {
			$hash = $name . ($options ? serialize($options) : '');
			if (empty($this->cache[$hash])) {
				list($type,$data) = explode(':',$name,2);

				$className = false;
				switch ($type) {
					case "SpecialPage":
						$className = "SpecialPageUserCommand";
						break;
					case "PageAction":
						if (in_array($data,array("Share","Follow"))) {
							$className = "{$data}UserCommand";
						} else {
							$className = "PageActionUserCommand";
						}
						break;
					case "Action":
						if (in_array($data,array("CustomizeToolbar", "DevInfo"))) {
							$className = "{$data}UserCommand";
						}
						break;
				}

				$this->cache[$hash] = $className ? new $className( $name, $options ) : null;
			}
			return $this->cache[$hash];
		}

		public function createMenu( $id, $caption, $options = array() ) {
			return new MenuUserCommand( $id, $caption, $options );
		}

	}
