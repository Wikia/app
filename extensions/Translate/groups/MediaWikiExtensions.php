<?php

class PremadeMediawikiExtensionGroups {
	protected $groups;
	protected $definitionFile = null;
	protected $useConfigure = true;
	protected $idPrefix = 'ext-';

	public function __construct() {
		global $wgTranslateExtensionDirectory;
		$dir = dirname( __FILE__ );
		$this->definitionFile = $dir . '/mediawiki-defines.txt';
		$this->path = $wgTranslateExtensionDirectory;
	}

	public function init() {
		if ( $this->groups !== null ) return;

		global $wgAutoloadClasses, $IP, $wgConfigureExtDir;
		if ( !isset( $wgConfigureExtDir ) ) {
			$wgConfigureExtDir = "$IP/extensions/";
		}
		$wgAutoloadClasses['TxtDef'] = $wgConfigureExtDir . "Configure/load_txt_def/TxtDef.php";
		if ( $this->useConfigure && class_exists( 'TxtDef' ) ) {
			$tmp = TxtDef::loadFromFile( $wgConfigureExtDir . "Configure/settings/Settings-ext.txt" );
			$configureData = array_combine( array_map( array( __CLASS__, 'foldId' ), array_keys( $tmp ) ), array_values( $tmp ) );
		} else {
			$configureData = array();
		}

		$defines = file_get_contents( $this->definitionFile );

		$linefeed = '(\r\n|\n)';

		$sections = array_map( 'trim', preg_split( "/$linefeed{2,}/", $defines, - 1, PREG_SPLIT_NO_EMPTY ) );

		$groups = $fixedGroups = array();

		foreach ( $sections as $section ) {
			$lines = array_map( 'trim', preg_split( "/$linefeed/", $section ) );
			$newgroup = array();

			foreach ( $lines as $line ) {
				if ( $line === '' || $line[0] === '#' ) continue;

				if ( strpos( $line, '=' ) === false ) {
					if ( empty( $newgroup['name'] ) ) {
						$newgroup['name'] = $line;
					} else {
						throw new MWException( "Trying to define name twice: " . $line );
					}
				} else {
					list( $key, $value ) = array_map( 'trim', explode( '=', $line, 2 ) );
					switch ( $key ) {
					case 'file':
					case 'var':
					case 'id':
					case 'descmsg':
					case 'desc':
					case 'magicfile':
					case 'aliasfile':
					case 'aliasvar':
						$newgroup[$key] = $value;
						break;
					case 'optional':
					case 'ignored':
						$values = array_map( 'trim', explode( ',', $value ) );
						if ( !isset( $newgroup[$key] ) ) {
							$newgroup[$key] = array();
						}
						$newgroup[$key] = array_merge( $newgroup[$key], $values );
						break;
					case 'prefix':
						list( $prefix, $messages ) = array_map( 'trim', explode( '|', $value, 2 ) );
						if ( isset( $newgroup['prefix'] ) && $newgroup['prefix'] !== $prefix ) {
							throw new MWException( "Only one prefix supported: {$newgroup['prefix']} !== $prefix" );
						}
						$newgroup['prefix'] = $prefix;

						if ( !isset( $newgroup['mangle'] ) ) $newgroup['mangle'] = array();

						$messages = array_map( 'trim', explode( ',', $messages ) );
						$newgroup['mangle'] = array_merge( $newgroup['mangle'], $messages );
						break;
					default:
						throw new MWException( "Unknown key:" . $key );
					}
				}
			}

			if ( count( $newgroup ) ) {
				if ( empty( $newgroup['name'] ) ) {
					throw new MWException( "Name missing\n" . print_r( $newgroup, true ) );
				}
				$groups[] = $newgroup;
			}
		}


		foreach ( $groups as $g ) {
			if ( !is_array( $g ) ) {
				$g = array( $g );
			}

			$name = $g['name'];

			if ( isset( $g['id'] ) ) {
				$id = $g['id'];
			} else {
				$id = $this->idPrefix . preg_replace( '/\s+/', '', strtolower( $name ) );
			}

			if ( isset( $g['file'] ) ) {
				$file = $g['file'];
			} else {
				$file = preg_replace( '/\s+/', '', "$name/$name.i18n.php" );
			}

			if ( isset( $g['descmsg'] ) ) {
				$descmsg = $g['descmsg'];
			} else {
				$descmsg = str_replace( $this->idPrefix, '', $id ) . '-desc';
			}

			$configureId = self::foldId( $name );
			if ( isset( $configureData[$configureId]['url'] ) ) {
				$url = $configureData[$configureId]['url'];
			} else {
				$url = false;
			}

			$newgroup = array(
				'name' => $name,
				'file' => $file,
				'descmsg' => $descmsg,
				'url' => $url,
			);

			$copyvars = array( 'ignored', 'optional', 'var', 'desc', 'prefix', 'mangle', 'magicfile', 'aliasfile', 'aliasvar' );
			foreach ( $copyvars as $var ) {
				if ( isset( $g[$var] ) ) {
					$newgroup[$var] = $g[$var];
				}
			}

			$fixedGroups[$id] = $newgroup;
		}

		$this->groups = $fixedGroups;
	}

	static function foldId( $name ) {
		return preg_replace( '/\s+/', '', strtolower( $name ) );
	}

	public function addAll() {
		global $wgTranslateAC, $wgTranslateEC;
		$this->init();

		if ( !count( $this->groups ) ) return;

		foreach ( $this->groups as $id => $g ) {
			$wgTranslateAC[$id] = array( $this, 'factory' );
			$wgTranslateEC[] = $id;
		}

		$this->addAllMeta();
	}

	protected function addAllMeta() {
		global $wgTranslateAC, $wgTranslateEC;

		$meta = array(
			'ext-0-all'               => 'AllMediawikiExtensionsGroup',
			'ext-0-wikihow'           => 'AllWikihowExtensionsGroup',
			'ext-0-wikimedia'         => 'AllWikimediaExtensionsGroup',
			'ext-0-wikitravel'        => 'AllWikitravelExtensionsGroup',
			'ext-collection-0-all'    => 'AllCollectionExtensionsGroup',
			'ext-flaggedrevs-0-all'   => 'AllFlaggedRevsExtensionsGroup',
			'ext-readerfeedback-0-all' => 'AllReaderFeedbackExtensionsGroup',
			'ext-translate-0-all'     => 'AllTranslateExtensionsGroup',
			'ext-socialprofile-0-all' => 'AllSocialProfileExtensionsGroup',
			'ext-uniwiki-0-all'       => 'AllUniwikiExtensionsGroup',
			'ext-ui-0-all'            => 'AllUsabilityInitiativeExtensionsGroup',
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
		$group->setPath( $this->path );

		if ( isset( $info['prefix'] ) ) {
			$mangler = new StringMatcher( $info['prefix'], $info['mangle'] );
			$group->setMangler( $mangler );
			$info['ignored'] = $mangler->mangle( $info['ignored'] );
			$info['optional'] = $mangler->mangle( $info['optional'] );
		}

		if ( !empty( $info['var'] ) ) $group->setVariableName( $info['var'] );
		if ( !empty( $info['optional'] ) ) $group->setOptional( $info['optional'] );
		if ( !empty( $info['ignored'] ) ) $group->setIgnored( $info['ignored'] );
		if ( isset( $info['desc'] ) ) {
			$group->setDescription( $info['desc'] );
		} else {
			$group->setDescriptionMsg( $info['descmsg'], $info['url'] );
		}

		if ( $group->getDescription() == '' ) {
			global $wgLang;
			$group->setDescription( wfMsg( 'translate-group-desc-nodesc' ) );
		}

		if ( isset( $info['aliasfile'] ) ) $group->setAliasFile( $info['aliasfile'] );
		if ( isset( $info['aliasvar'] ) ) $group->setVariableNameAlias( $info['aliasvar'] );
		if ( isset( $info['magicfile'] ) ) $group->setMagicFile( $info['magicfile'] );

		$group->setType( 'mediawiki' );
		return $group;
	}
}

class AllMediawikiExtensionsGroup extends MessageGroupOld {
	protected $label = 'MediaWiki extensions';
	protected $id    = 'ext-0-all';
	protected $meta  = true;
	protected $type  = 'mediawiki';
	protected $classes = null;
	protected $description = '{{int:translate-group-desc-mediawikiextensions}}';

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
				if ( ( strpos( $class->getId(), 'ext-' ) !== 0 ) || $class->isMeta() || !$class->exists() ) {
					unset( $this->classes[$index] );
				}
			}
		}
	}

	public function load( $code ) {
		$this->init();
		$array = array();
		foreach ( $this->classes as $class ) {
			// Use wfArrayMerge because of string keys
			$array = wfArrayMerge( $array, $class->load( $code ) );
		}
		return $array;
	}

	public function getMessage( $key, $code ) {
		$this->init();
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

	function getBools() {
		$this->init();
		$bools = parent::getBools();
		foreach ( $this->classes as $class ) {
			$newbools = ( $class->getBools() );
			if ( count( $newbools['optional'] ) || count( $newbools['ignored'] ) ) {
				$bools = array_merge_recursive( $bools, $class->getBools() );
			}
		}
		return $bools;
	}

	public function exists() {
		$this->init();
		foreach ( $this->classes as $class ) {
			if ( $class->exists() ) return true;
		}
		return false;
	}
}

class AllWikihowExtensionsGroup extends AllMediawikiExtensionsGroup {
	protected $label = 'Extensions used by Wikihow'; // currently using 1.12.0
	protected $id    = 'ext-0-wikihow';
	protected $meta  = true;

	protected $classes = null;
	protected $description = '{{int:translate-group-desc-wikihowextensions}}';

	protected $wikihowextensions = array(
		'ext-antispoof',
		'ext-blocktitles',
		'ext-checkuser',
		'ext-cite',
		'ext-confirmedit',
		'ext-formatemail',
		'ext-imagemap',
		'ext-importfreeimages',
		'ext-multiupload',
		'ext-openid',
		'ext-parserfunctions',
		'ext-postcomment',
		'ext-renameuser',
		'ext-spamblacklist',
		'ext-spamdifftool',
		'ext-syntaxhighlightgeshi',
		'ext-youtubeauthsub',
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
	protected $label = 'Extensions used by Wikimedia';
	protected $id    = 'ext-0-wikimedia';
	protected $meta  = true;

	protected $classes = null;
	protected $description = '{{int:translate-group-desc-wikimediaextensions}}';

	protected $wmfextensions = array(
		'ext-abusefilter',
		'ext-antibot',  // anti spam and such (usually all wikis)
		'ext-antispoof',
		'ext-assertedit', // bots
		'ext-categorytree',
		'ext-centralauth',
		'ext-centralnotice',
		'ext-charinsert',
		'ext-checkuser',
		'ext-cite',
		'ext-citespecial',
		'ext-clientside', // usability.wikimedia.org
		'ext-codereview', // MediaWiki.org
		'ext-collection-core',
		'ext-collection-other',
		'ext-communityvoice', // usability.wikimedia.org
		'ext-confirmedit',
		'ext-confirmeditfancycaptcha',
		'ext-contactpage', // on nl.wp and wikimediafoundation.org
		'ext-contributionreporting', // wikimediafoundation.org
		'ext-contributiontracking', // wikimediafoundation.org
		'ext-crossnamespacelinks',
		'ext-di-pfpg', // wikimediafoundation.org
		'ext-dismissablesitenotice',
		'ext-doublewiki', // Wikisource
		'ext-drafts', // test.wikipedia.org
		'ext-expandtemplates',
		'ext-extensiondistributor', // MediaWiki.org
		'ext-externalpages', // 2009-11-30: test.wikipedia.org
		'ext-flaggedrevs-flaggedrevs',
		'ext-flaggedrevs-oldreviewedpages',
		'ext-flaggedrevs-problemchanges',
		'ext-flaggedrevs-qualityoversight',
		'ext-flaggedrevs-reviewedpages',
		'ext-flaggedrevs-reviewedversions',
		'ext-flaggedrevs-stabilization',
		'ext-flaggedrevs-stablepages',
		'ext-flaggedrevs-unreviewedpages',
		'ext-flaggedrevs-unstablepages',
		'ext-flaggedrevs-validationstatistics',
		'ext-fundraiserportal', // 2009-10-08: test.wikipedia.org
		'ext-gadgets',
		'ext-geolite', // 2009-11-13: meta.wikimedia.org
		'ext-globalblocking',
		'ext-globalusage', // 2009-11-11: commons.wikimedia.org
		'ext-honeypotintegration', // 2009-08-13: test.wikipedia.org
		'ext-imagemap',
		'ext-inputbox',
		'ext-intersection',
		'ext-labeledsectiontransclusion', // Wikisource
		'ext-liquidthreads', // 2009-11-11: MediaWiki.org and some *.labs.wikimedia.org
		'ext-mwreleases', // 2009-09-29: MediaWiki.org
		'ext-mwsearch',
		'ext-newusermessage',
		'ext-nuke',
		'ext-oai',
		'ext-ogghandler',
		'ext-opensearchxml',
		'ext-oversight',
		'ext-parserfunctions',
		'ext-pdfhandler',
		'ext-poem',
		'ext-proofreadpage', // Wikisource
		'ext-quiz',
		'ext-readerfeedback-ratedpages',
		'ext-readerfeedback-ratinghistory',
		'ext-readerfeedback-readerfeedback',
		'ext-renameuser',
		'ext-scanset',
		'ext-securepoll',
		'ext-simpleantispam',
		'ext-sitematrix',
		'ext-skinperpage', // Wikimediafoundation.org
		'ext-spamblacklist',
		'ext-syntaxhighlightgeshi',
		'ext-timeline',
		'ext-titleblacklist',
		'ext-titlekey',
		'ext-torblock',
		'ext-trustedxff',
		'ext-ui-clicktracking',
		'ext-ui-optin',
		'ext-ui-optinlink',
		'ext-ui-prefstats',
		'ext-ui-usabilityinitiative',
		'ext-ui-userdailycontribs',
		'ext-ui-vector',
		'ext-ui-vector-editwarning',
		'ext-ui-vector-simplesearch',
		'ext-ui-wikieditor',
		'ext-ui-wikieditor-highlight',
		'ext-ui-wikieditor-preview',
		'ext-ui-wikieditor-publish',
		'ext-ui-wikieditor-templateeditor',
		'ext-ui-wikieditor-toc',
		'ext-ui-wikieditor-toolbar',
		'ext-uploadblacklist',
		'ext-wikihiero',
		'ext-wikimediamessages',
		'ext-wikimedialicensetexts', // commons.wikimedia.org
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
	protected $label = 'Extensions used by Wikitravel'; // currently using 1.11.2
	protected $id    = 'ext-0-wikitravel';
	protected $meta  = true;

	protected $classes = null;
	protected $description = '{{int:translate-group-desc-wikitravelextensions}}';

	protected $wikitravelextensions = array(
		'ext-charinsert',
		'ext-inputbox',
		'ext-microid',
		'ext-openid',
		'ext-parserfunctions',
		'ext-renameuser',
		'ext-stringfunctions',
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

class AllCollectionExtensionsGroup extends AllMediawikiExtensionsGroup {
	protected $label = 'Collection';
	protected $id    = 'ext-collection-0-all';
	protected $meta  = true;

	protected $classes = null;
	protected $description = '{{int:translate-group-desc-collection}}';

	protected $collectionextensions = array(
		'ext-collection-core',
		'ext-collection-other',
	);

	protected function init() {
		if ( $this->classes === null ) {
			$this->classes = array();
			$classes = MessageGroups::singleton()->getGroups();
			foreach ( $this->collectionextensions as $key ) {
				$this->classes[$key] = $classes[$key];
			}
		}
	}
}

class AllFlaggedRevsExtensionsGroup extends AllMediawikiExtensionsGroup {
	protected $label = 'FlaggedRevs';
	protected $id    = 'ext-flaggedrevs-0-all';
	protected $meta  = true;

	protected $classes = null;
	protected $description = '{{int:translate-group-desc-flaggedrevs}}';

	protected $flaggedrevsextensions = array(
		'ext-flaggedrevs-flaggedrevs',
		'ext-flaggedrevs-oldreviewedpages',
		'ext-flaggedrevs-problemchanges',
		'ext-flaggedrevs-qualityoversight',
		'ext-flaggedrevs-reviewedpages',
		'ext-flaggedrevs-reviewedversions',
		'ext-flaggedrevs-stabilization',
		'ext-flaggedrevs-stablepages',
		'ext-flaggedrevs-unreviewedpages',
		'ext-flaggedrevs-unstablepages',
		'ext-flaggedrevs-validationstatistics',
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

class AllReaderFeedbackExtensionsGroup extends AllMediawikiExtensionsGroup {
	protected $label = 'ReaderFeedback';
	protected $id    = 'ext-readerfeedback-0-all';
	protected $meta  = true;

	protected $classes = null;
	protected $description = '{{int:translate-group-desc-readerfeedback}}';

	protected $flaggedrevsextensions = array(
		'ext-readerfeedback-readerfeedback',
		'ext-readerfeedback-ratedpages',
		'ext-readerfeedback-ratinghistory',
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

class AllSocialProfileExtensionsGroup extends AllMediawikiExtensionsGroup {
	protected $label = 'Social Profile';
	protected $id    = 'ext-socialprofile-0-all';
	protected $meta  = true;

	protected $classes = null;
	protected $description = '{{int:translate-group-desc-socialprofile}}';

	protected $socialprofileextensions = array(
		'ext-socialprofile-systemgifts',
		'ext-socialprofile-useractivity',
		'ext-socialprofile-userboard',
		'ext-socialprofile-usergifts',
		'ext-socialprofile-userprofile',
		'ext-socialprofile-userrelationship',
		'ext-socialprofile-userstats',
		'ext-socialprofile-userwelcome',
		'ext-yui',
	);

	protected function init() {
		if ( $this->classes === null ) {
			$this->classes = array();
			$classes = MessageGroups::singleton()->getGroups();
			foreach ( $this->socialprofileextensions as $key ) {
				$this->classes[$key] = $classes[$key];
			}
		}
	}
}

class AllTranslateExtensionsGroup extends AllMediawikiExtensionsGroup {
	protected $label = 'Translate';
	protected $id    = 'ext-translate-0-all';
	protected $meta  = true;

	protected $classes = null;
	protected $description = '{{int:translate-group-desc-translate}}';

	protected $translateprofileextensions = array(
		'ext-translate-core',
		'ext-translate-pagetranslation',
	);

	protected function init() {
		if ( $this->classes === null ) {
			$this->classes = array();
			$classes = MessageGroups::singleton()->getGroups();
			foreach ( $this->translateprofileextensions as $key ) {
				$this->classes[$key] = $classes[$key];
			}
		}
	}
}

class AllUniwikiExtensionsGroup extends AllMediawikiExtensionsGroup {
	protected $label = 'Uniwiki';
	protected $id    = 'ext-uniwiki-0-all';
	protected $meta  = true;

	protected $classes = null;
	protected $description = '{{int:translate-group-desc-uniwiki}}';

	protected $uniwikiextensions = array(
		'ext-uniwiki-authors',
		'ext-uniwiki-autocreatecategorypages',
		'ext-uniwiki-catboxattop',
		'ext-uniwiki-createpage',
		'ext-uniwiki-csshooks',
		'ext-uniwiki-customtoolbar',
		'ext-uniwiki-formatchanges',
		'ext-uniwiki-formatsearch',
		'ext-uniwiki-genericeditpage',
		'ext-uniwiki-javascript',
		'ext-uniwiki-layouts',
		'ext-uniwiki-mootools12core',
	);

	protected function init() {
		if ( $this->classes === null ) {
			$this->classes = array();
			$classes = MessageGroups::singleton()->getGroups();
			foreach ( $this->uniwikiextensions as $key ) {
				$this->classes[$key] = $classes[$key];
			}
		}
	}
}

class AllUsabilityInitiativeExtensionsGroup extends AllMediawikiExtensionsGroup {
	protected $label = 'Usability Initiative';
	protected $id    = 'ext-ui-0-all';
	protected $meta  = true;

	protected $classes = null;
	protected $description = '{{int:translate-group-desc-ui}}';

	protected $usabilityinitiativeextensions = array(
		'ext-ui-clicktracking',
		'ext-ui-optin',
		'ext-ui-optinlink',
		'ext-ui-prefstats',
		'ext-ui-usabilityinitiative',
		'ext-ui-userdailycontribs',
		'ext-ui-vector',
		'ext-ui-vector-editwarning',
		'ext-ui-vector-simplesearch',
		'ext-ui-wikieditor',
		'ext-ui-wikieditor-highlight',
		'ext-ui-wikieditor-preview',
		'ext-ui-wikieditor-publish',
		'ext-ui-wikieditor-templateeditor',
		'ext-ui-wikieditor-toc',
		'ext-ui-wikieditor-toolbar',
	);

	protected function init() {
		if ( $this->classes === null ) {
			$this->classes = array();
			$classes = MessageGroups::singleton()->getGroups();
			foreach ( $this->usabilityinitiativeextensions as $key ) {
				$this->classes[$key] = $classes[$key];
			}
		}
	}
}
