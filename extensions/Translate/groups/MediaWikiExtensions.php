<?php

class PremadeMediawikiExtensionGroups {
	protected $groups;

	public function init() {
		if ( $this->groups !== null ) return;

		$dir = dirname( __FILE__ );
		$defines = file_get_contents( $dir . '/mediawiki-defines.txt' );

		$linefeed = '(\r\n|\n)';

		$sections = array_map( 'trim', preg_split( "/$linefeed{2,}/", $defines, -1, PREG_SPLIT_NO_EMPTY ) );

		$groups = $fixedGroups = array();

		foreach ( $sections as $section ) {
			$lines = array_map( 'trim', preg_split( "/$linefeed/", $section ) );
			$newgroup = array();

			foreach ( $lines as $line ) {
				if ( $line === '' ) continue;

				if ( strpos( $line, '=' ) === false ) {
					if ( empty($newgroup['name']) ) {
						$newgroup['name'] = $line;
					} else {
						throw new MWException( "Trying to define name twice: " . $line );
					}
				} else {
					list( $key, $value ) = array_map( 'trim', explode( '=', $line, 2 ) );
					switch ($key) {
					case 'file':
					case 'var':
					case 'id':
					case 'descmsg':
					case 'desc':
						$newgroup[$key] = $value;
						break;
					case 'optional':
					case 'ignored':
						$values = array_map( 'trim', explode( ',', $value ) );
						if ( !isset($newgroup[$key]) ) {
							$newgroup[$key] = array();
						}
						$newgroup[$key] = array_merge( $newgroup[$key], $values );
						break;
					default:
						throw new MWException( "Unknown key:" . $key );
					}
				}
			}

			if ( count($newgroup) ) {
				if ( empty($newgroup['name']) ) {
					throw new MWException( "Name missing\n" . print_r($newgroup, true) );
				}
				$groups[] = $newgroup;
			}
		}


		foreach ( $groups as $g ) {
			if ( !is_array($g) ) {
				$g = array($g);
			}

			$name = $g['name'];

			if ( isset($g['id']) ) {
				$id = $g['id'];
			} else {
				$id = 'ext-' . preg_replace( '/\s+/', '', strtolower( $name ) );
			}

			if ( isset($g['file']) ) {
				$file = $g['file'];
			} else {
				$file = preg_replace( '/\s+/', '', "$name/$name.i18n.php" );
			}

			if ( isset($g['descmsg']) ) {
				$descmsg = $g['descmsg'];
			} else {
				$descmsg = str_replace( 'ext-', '', $id) . '-desc';
			}

			$newgroup = array(
				'name' => $name,
				'file' => $file,
				'descmsg' => $descmsg,
			);

			$copyvars = array( 'ignored', 'optional', 'var', 'desc' );
			foreach ( $copyvars as $var ) {
				if ( isset($g[$var]) ) {
					$newgroup[$var] = $g[$var];
				}
			}

			$fixedGroups[$id] = $newgroup;
		}

		$this->groups = $fixedGroups;
	}

	public function addAll() {
		global $wgTranslateAC, $wgTranslateEC;
		$this->init();

		if ( !count($this->groups) ) return;

		foreach ( $this->groups as $id => $g ) {
			$wgTranslateAC[$id] = array( $this, 'factory' );
			$wgTranslateEC[] = $id;
		}

		$meta = array(
			'ext-0-all'             => 'AllMediawikiExtensionsGroup',
			'ext-0-wikia'           => 'AllWikiaExtensionsGroup',
			'ext-0-wikihow'         => 'AllWikihowExtensionsGroup',
			'ext-0-wikimedia'       => 'AllWikimediaExtensionsGroup',
			'ext-0-wikitravel'      => 'AllWikitravelExtensionsGroup',
			'ext-flaggedrevs-0-all' => 'AllFlaggedRevsExtensionsGroup',
		);

		foreach ( $meta as $id => $g ) {
			$wgTranslateAC[$id] = $g;
			$wgTranslateEC[] = $id;
		}

	}

	public function factory( $id ) {

		$info = $this->groups[$id];
		$group = ExtensionMessageGroup::factory( $info['name'], $id );
		$group->setMessageFile( $info['file'] );
		if ( !empty($info['var']) ) $group->setVariableName( $info['var'] );
		if ( !empty($info['optional']) ) $group->setOptional( $info['optional'] );
		if ( !empty($info['ignored']) ) $group->setIgnored( $info['ignored'] );
		if ( isset($info['desc']) ) {
			$group->setDescription( $info['desc'] );
		} else {
			$group->setDescriptionMsg( $info['descmsg'] );
		}
		$group->setType('mediawiki');
		return $group;
	}

}

class AllMediawikiExtensionsGroup extends ExtensionMessageGroup {
	protected $label = 'MediaWiki extensions';
	protected $id    = 'ext-0-all';
	protected $meta  = true;
	protected $type  = 'mediawiki';
	protected $classes = null;

	public function getProblematic( $code ) {
		$this->init();
		$array = array();
		foreach ( $this->classes as $class ) {
			// Use array_merge because of numeric keys
			$array = array_merge( $array, $class->getProblematic( $code ) );
		}
		return $array;
	}

	// Don't add the (mw ext) thingie
	public function getLabel() { return $this->label; }

	protected function init() {
		if ( $this->classes === null ) {
			$this->classes = MessageGroups::singleton()->getGroups();
			foreach ( $this->classes as $index => $class ) {
				if ( (strpos( $class->getId(), 'ext-' ) !== 0) || $class->isMeta() ) {
					unset( $this->classes[$index] );
				}
			}
		}
	}

	public function load( $code ) {
		return null; // no-op
	}

	public function getMessage( $key, $code ) {
		$msg = null;
		foreach ( $this->classes as $class ) {
			$msg = $class->getMessage( $key, $code );
			if ( $msg !== null ) return $msg;
		}
		return null;
	}

	function getDefinitions() {
		$this->init();
		$array = array();
		foreach ( $this->classes as $class ) {
			// Use wfArrayMerge because of string keys
			$array = wfArrayMerge( $array, $class->getDefinitions() );
		}
		return $array;
	}

	function fill( MessageCollection $messages ) {
		$this->init();
		foreach ( $this->classes as $class ) {
			$class->fill( $messages );
		}
	}

	function getBools() {
		$this->init();
		$bools = parent::getBools();
		foreach ( $this->classes as $class ) {
			$newbools = ( $class->getBools() );
			if ( count($newbools['optional']) || count($newbools['ignored']) ) {
				$bools = array_merge_recursive( $bools, $class->getBools() );
			}
		}
		return $bools;
	}
}

class AllWikiaExtensionsGroup extends AllMediawikiExtensionsGroup {
	protected $label = 'MediaWiki extensions used by Wikia'; // currently using 1.12.0
	protected $id    = 'ext-0-wikia';
	protected $meta  = true;

	protected $classes = null;

	protected $wikiaextensions = array(
		'ext-inputbox', // to be completed
	);

	protected function init() {
		if ( $this->classes === null ) {
			$this->classes = array();
			$classes = MessageGroups::singleton()->getGroups();
			foreach ( $this->wikiaextensions as $key ) {
				$this->classes[$key] = $classes[$key];
			}
		}
	}

	public function wikiaextensions() {
		return $this->wikiaextensions;
	}
}

class AllWikihowExtensionsGroup extends AllMediawikiExtensionsGroup {
	protected $label = 'MediaWiki extensions used by Wikihow'; // currently using 1.9.3
	protected $id    = 'ext-0-wikihow';
	protected $meta  = true;

	protected $classes = null;

	protected $wikihowextensions = array(
		'ext-inputbox', // to be completed
	);

	protected function init() {
		if ( $this->classes === null ) {
			$this->classes = array();
			$classes = MessageGroups::singleton()->getGroups();
			foreach ( $this->wikihowextensions as $key ) {
				$this->classes[$key] = $classes[$key];
			}
		}
	}

	public function wikihowextensions() {
		return $this->wikihowextensions;
	}
}

class AllWikimediaExtensionsGroup extends AllMediawikiExtensionsGroup {
	protected $label = 'MediaWiki extensions used by Wikimedia';
	protected $id    = 'ext-0-wikimedia';
	protected $meta  = true;

	protected $classes = null;

	protected $wmfextensions = array(
		'ext-inputbox', // used on all wikis by all users
		'ext-wikimediamessages',
		'ext-cite',
		'ext-citespecial',
		'ext-newuserlog',
		'ext-confirmedit',
		'ext-confirmeditfancycaptcha',
		'ext-categorytree',
		'ext-dismissablesitenotice',
		'ext-expandtemplates',
		'ext-parserfunctions',
		'ext-crossnamespacelinks',
		'ext-ogghandler',
		'ext-imagemap',
		'ext-labeledsectiontransclusion',
		'ext-mwsearch',
		'ext-linksearch',
		'ext-sitematrix',
		'ext-gadgets',
		'ext-fixedimage',
		'ext-centralauth',
		'ext-syntaxhighlightgeshi', // limited UI use (Special:Version and errors in usage mostly)
		'ext-timeline',
		'ext-wikihiero',
		'ext-oai',
		'ext-poem',
		'ext-universaleditbutton',
		'ext-doublewiki',
		'ext-intersection',
		'ext-proofreadpage',
		'ext-quiz',
		'ext-scanset',
		'ext-skinperpage',
		'ext-antispoof', // anti spam and such (usually all wikis)
		'ext-spamblacklist',
		'ext-simpleantispam',
		'ext-titleblacklist',
		'ext-titlekey',
		'ext-torblock',
		'ext-usernameblacklist',
		'ext-deletedcontribs', // sysop or higher only
		'ext-checkuser',
		'ext-nuke',
		'ext-oversight',
		'ext-renameuser',
		'ext-assertedit', // bots
		'ext-centralnotice', // used rarely
		'ext-parserdifftest', // used rarely (still needed?)
		'ext-boardvote', // used rarely
	);

	protected function init() {
		if ( $this->classes === null ) {
			$this->classes = array();
			$classes = MessageGroups::singleton()->getGroups();
			foreach ( $this->wmfextensions as $key ) {
				$this->classes[$key] = $classes[$key];
			}
		}
	}

	public function wmfextensions() {
		return $this->wmfextensions;
	}
}

class AllWikitravelExtensionsGroup extends AllMediawikiExtensionsGroup {
	protected $label = 'MediaWiki extensions used by Wikitravel'; // currently using 1.11.2
	protected $id    = 'ext-0-wikitravel';
	protected $meta  = true;

	protected $classes = null;

	protected $wikitravelextensions = array(
		'ext-inputbox', // to be completed
	);

	protected function init() {
		if ( $this->classes === null ) {
			$this->classes = array();
			$classes = MessageGroups::singleton()->getGroups();
			foreach ( $this->wikitravelextensions as $key ) {
				$this->classes[$key] = $classes[$key];
			}
		}
	}

	public function wikitravelextensions() {
		return $this->wikitravelextensions;
	}
}

class AllFlaggedRevsExtensionsGroup extends AllMediawikiExtensionsGroup {
	protected $label = 'All FlaggedRevs messages';
	protected $id    = 'ext-flaggedrevs-0-all';
	protected $meta  = true;

	protected $classes = null;

	protected $flaggedrevsextensions = array(
		'ext-flaggedrevs-flaggedrevs',
		'ext-flaggedrevs-flaggedrevsaliases',
		'ext-flaggedrevs-oldreviewedpages',
		'ext-flaggedrevs-qualityoversight',
		'ext-flaggedrevs-problempages',
		'ext-flaggedrevs-ratinghistory',
		'ext-flaggedrevs-reviewedpages',
		'ext-flaggedrevs-stabilization',
		'ext-flaggedrevs-stablepages',
		'ext-flaggedrevs-stableversions',
		'ext-flaggedrevs-unreviewedpages',
	);

	protected function init() {
		if ( $this->classes === null ) {
			$this->classes = array();
			$classes = MessageGroups::singleton()->getGroups();
			foreach ( $this->flaggedrevsextensions as $key ) {
				$this->classes[$key] = $classes[$key];
			}
		}
	}
}
