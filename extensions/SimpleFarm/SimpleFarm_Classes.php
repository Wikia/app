<?php
/**
 * 'SimpleFarm' and 'SimpleFarmMember' classes of the 'Simple Farm' extension.
 *
 * @file SimpleFarm_Classes.php
 * @ingroup SimpleFarm
 * 
 * @author Daniel Werner < danweetz@web.de >
*/

/**
 * Contains functions for 'Simple Farm' farm managment.
 * 
 * @since 0.1
 */
class SimpleFarm {	
	/**
	 * If set to a farm member within '$egSimpleFarmMembers' array (see settings file) it meains that
	 * the wiki is not in maintenance mode right now.
	 */
	const MAINTAIN_OFF = false;
	/**
	 * Block simple browser access to the wiki but allow accessing the wiki with 'maintain' url parameter
	 */
	const MAINTAIN_SIMPLE = 1;
	/**
	 * Block all attempts to access wiki except for command-line based maintenance
	 */
	const MAINTAIN_STRICT = 2;
	/**
	 * Block all attempts to access wiki, even command-line
	 */
	const MAINTAIN_TOTAL = 3;
	
	private static $activeMember = null;
	public static $maintenanceIsRunning = false;
	
	/**
	 * Returns the defined main member of the wiki farm.
	 * If $wgSimpleFarmMainMemberDB has not been set yet, this will set $wgSimpleFarmMainMemberDB
	 * to the first member in $wgSimpleFarmMembers
	 * @return SimpleFarmMember or null if no match could be found
	 */
	public static function getMainMember() {
		global $egSimpleFarmMainMemberDB, $egSimpleFarmMembers;
		
		// if variable was not set in config, fill it with first farm member or return null if none is defined:
		if( $egSimpleFarmMainMemberDB === null ) {
			if( (int)$egSimpleFarmMembers )
				$egSimpleFarmMainMemberDB = $egSimpleFarmMembers[0]['db'];
			else
				return null;
		}		
		return SimpleFarmMember::loadFromDatabaseName( $egSimpleFarmMainMemberDB );	
	}
	
	/**
	 * Returns the SimpleFarmMember object selected to be loaded for this instance of the farm
	 * or the object that has already been loaded.
	 * If initialisation has not been kicked off yet, this will find the wiki which would be
	 * chosen by self::int(). The result of the function could change after self::intWiki()
	 * was called to initialise another wiki instead.
	 * $wgSimpleFarmWikiSelectEnvVarName should contain its final value when first calling this.
	 * 
	 * @return SimpleFarmMember or null if no match was found
	 */
	public static function getActiveMember() {		
		global $IP, $wgCommandLineMode;
		global $egSimpleFarmMembers, $egSimpleFarmMainMemberDB, $egSimpleFarmWikiSelectEnvVarName;
		
		// return last initialised farm member if available:
		if( self::$activeMember !== null ) {			
			return self::$activeMember;
		}
		
		if( ! defined( 'SIMPLEFARM_ENVVAR' ) ) {
			define( 'SIMPLEFARM_ENVVAR', $egSimpleFarmWikiSelectEnvVarName );		
		}
		// in commandline mode we check for environment variable to stelect a wiki:
		if( $wgCommandLineMode ) {
			/*
			 * if we are in command-line mode but no wiki was selected
			 * and this is not just the initial wiki call to run maintenance
			 * on several wikis
			 */
			$wikiEvn = getenv( SIMPLEFARM_ENVVAR );

			if( $wikiEvn === false ) {
				// running SimpleFarm maintenance script which will maintain all wikis:
				if( self::$maintenanceIsRunning ) {
					$wikiEvn = $egSimpleFarmMainMemberDB;
				} else {
					return null; // commandline-mode for specific wiki but no wiki was chosen!
				}
			}			
			return SimpleFarmMember::loadFromDatabaseName( $wikiEvn );
		}
		// farm member called via browser, find out which member via server name:
		else {
			// only interesting if redirect_url is set, otherwise unlikely to be used anyway
			$currScriptPath = isset( $_SERVER['REDIRECT_URL'] ) ? $_SERVER['REDIRECT_URL'] : $_SERVER['SCRIPT_NAME'];
			/*
			 * in case the script path was called directly and not some page within the directory,
			 * just make sure to add '.' behind the last '/' before getting the directory name
			 * '/bla/' returns '/', '/bla/.' returns '/bla' !
			 */			
			$currScriptPath = dirname( preg_replace( '%[\\/\\\]$%', '/.', $currScriptPath ) );
			
			/*
			 * in case "<domain>/<uri>" without '/' after, the above will return '\' (windows)
			 * or '/' (unix). Take the whole requested URI then since it could be the scriptpath
			 * directory or just a file in the root dir...
			 */
			if( preg_match( '%[\\/\\\]$%', $currScriptPath ) )
				$currScriptPath = $_SERVER['REDIRECT_URL'];
			/*
			echo $currScriptPath . "<br/>";			
			echo "is_dir: " .  is_dir( $_SERVER['DOCUMENT_ROOT'] . $_SERVER['REDIRECT_URL'] ) . "<br/>";
			echo "<html><body><pre>";
			print_r( $_SERVER );
			echo "</pre></br>" . $currScriptPath . "<br/>" . preg_replace( '%[\\/\\\]$%', '/.', $_SERVER['REDIRECT_URL'] ) . "<br/>" . $_SERVER['REQUEST_URI'] . "</body></html>";
			die( 1 );
			*/	
			// walk all farm members and see whether it fullfils criteria to be the loaded one right now:
			foreach( self::getMembers() as $member ) {
				
				switch( $member->getCfgMode() ) {
					
					// configuration uses script path for this one to identify as selected:
					case SimpleFarmMember::CFG_MODE_SCRIPTPATH:						
						if( $member->getScriptPath() === $currScriptPath ) {							
							return $member;
						}
						break;
						
					// configuration uses a set of addresses to identifiy as selected:
					case SimpleFarmMember::CFG_MODE_ADDRESS:
						if( in_array( $_SERVER['HTTP_HOST'], $member->getAddresses(), true ) ) {
							return $member;
						}
						break;
						
					// if not set up properly:
					case SimpleFarmMember::CFG_MODE_NONE:
						continue;
				}
			}			
			return null; // no macht with configuration array!
		}
	}
	
	/**
	 * Initialises the selected member wiki of the wiki farm. This is only possible
	 * once and must be done during localsettings configuration	 * 
	 * This will also modify some global variables, see SimpleFarm::initWiki() for details
	 * 
	 * @return boolean true
	 */
	public static function init() {
		// don't allow multiple calls!
		if( self::$activeMember !== null )
			return true; // for hook use!
		
		global $egSimpleFarmMainMemberDB, $wgCommandLineMode;
		
		// set some main member if not set in config and farm has members:
		if( $egSimpleFarmMainMemberDB === null ) {
			$egSimpleFarmMainMemberDB = self::getMainMember()->getDB();
		}		
		// get selected member for this farm call:
		$wiki = self::getActiveMember();
		
		// if wiki is not in farm list:
		if( $wiki === null ) {
			if( $wgCommandLineMode ) {
				self::dieEarly( 'Environment variable "' . SIMPLEFARM_ENVVAR . '" must be set to an existing farm member database name to select a wiki in command-line mode!' );
			}
			else {
				// wiki not found, try to call user defined callback function and try return value:
				// (can't use hook-system here since it propably isn't loaded at this sage!)
				global $egSimpleFarmErrorNoMemberFoundCallback;				
				
				if( is_callable( $egSimpleFarmErrorNoMemberFoundCallback ) ) {
					$wiki = call_user_func( $egSimpleFarmErrorNoMemberFoundCallback );
				}

				if( ! ( $wiki instanceof SimpleFarmMember ) ) {
					header( $_SERVER["SERVER_PROTOCOL"] . " 404 Not Found" );
					self::dieEarly( 'No wiki farm member found here!' );
				}
			}
		}
		self::initWiki( $wiki );
		return true; // for hook use!
	}
	
	/**
	 * Function to set all setup options to load a specific wiki of the wiki farm.
	 * Should only be called while 'LocalSettings.php' is running and after
	 * SimpleFarm extension has been initialised.
	 * 
	 * This will modify the following globals:
	 * 
	 *   $wgSitename        = SimpleFarmMember::getName();
	 *   $wgDBname          = SimpleFarmMember::getDB();
	 *   $wgScriptPath      = SimpleFarmMember::getScriptPath();
	 *   $wgUploadDirectory = "{$IP}/images/images_{$wgDBname}";
	 *   $wgUploadPath      = "{$wgScriptPath}/images/images_{$wgDBname}";
	 *   $wgLogo            = "{$wgScriptPath}/images/logos/{$wgDBname}.png";
	 *   $wgFavicon         = "{$wgScriptPath}/images/logos/{$wgDBname}.ico";
	 * 
	 * @param $wiki SimpleFarmMember to initialise
	 */
	public static function initWiki( SimpleFarmMember $wiki ) {
		global $IP;
		// globals to be configured:
		global $wgSitename, $wgDBname, $wgScriptPath, $wgUploadDirectory, $wgUploadPath, $wgLogo, $wgFavicon;
				
		$wgSitename = $wiki->getName();
		
		// check for maintain mode:
		if( $wiki->isInMaintainMode() && ! $wiki->userIsMaintaining() ) {
			self::dieEarly( "$wgSitename is in maintain mode currently! Please try again later." );
		}		
		self::$activeMember = $wiki;
		
		$wgScriptPath = $wiki->getScriptPath(); //in case of 'scriptpath' config and mod-rewrite, otherwise same value anyway
		$wgDBname = $wiki->getDB();
		$wgUploadDirectory = "{$IP}/images/images_{$wgDBname}";
		$wgUploadPath      = "{$wgScriptPath}/images/images_{$wgDBname}";
		if( ! is_dir( $wgUploadDirectory ) ) {
			mkdir( $wgUploadDirectory, 0777 );
		}
				
		$wgLogo    = "{$wgScriptPath}/images/logos/{$wgDBname}.png";
		$wgFavicon = "{$wgScriptPath}/images/logos/{$wgDBname}.ico";
		
		/*
		 * it's no good loading an individual config file here since it wouldn't
		 * be in the global scope and all globals had to be defined as global first...
		 * Hacking around this is too dirty (reading all globals in local scope and then
		 * transferring local scope back to global scope).
		 * 
		 * There is an easy way to allow custom config files in LocalSettings directly though:
		 * 
		 *   if( file_exists( "$IP/wikiconfigs/$wgDBname.php" ) ) {
		 *       include( "$IP/wikiconfigs/$wgDBname.php" );
		 *   }
		 */
		return true;
	}
	
	/**
	 * Return an array with all members as SimpleFarmMember objects. The key of each array item
	 * is the database name of the wiki farm member.
	 * 
	 * @return SimpleFarmMember[]
	 */
	public static function getMembers() {
		global $egSimpleFarmMembers;
		$members = array();
		foreach( $egSimpleFarmMembers as $member ) {
			$members[ $member['db'] ] = new SimpleFarmMember( $member );
		}
		return $members;
	}
	
	/**
	 * Use instead of wfDie() because global functions are loaded after localsettings.php
	 * and in some cases this could happen during localsettings is still running!
	 * 
	 * @param $dieMsg string message
	 */
	private static function dieEarly( $dieMsg = '' ) {
		echo $dieMsg;
		die( 1 );
	}
}


/**
 * Represents a SimpleFarm member wiki.
 * 
 * @since 0.1
 */
class SimpleFarmMember {
	
	private $siteOpt;		
	
	const CFG_MODE_NONE = 0;
	const CFG_MODE_ADDRESS = 1;
	const CFG_MODE_SCRIPTPATH = 2;
	
	public function __construct( $siteOptions ) {
		$this->siteOpt = $siteOptions;
	}
	
	/**
	 * Load new SimpleFarmMember from its database name.
	 * If not successful null will be returned.
	 * 
	 * @param $dbName string name of the database, case-insensitive
	 * 
	 * @return SimpleFarmMember|null
	 */
	public static function loadFromDatabaseName( $dbName ) {
		global $egSimpleFarmMembers;
		
		foreach( $egSimpleFarmMembers as $siteOpt ) {
			if( strtolower( $siteOpt['db'] ) === strtolower( trim( $dbName ) ) ) {
				return new SimpleFarmMember( $siteOpt );
			}
		}
		return null;
	}
	
	/** 
	 * Load new SimpleFarmMember from one of its addresses.
	 * 
	 * @ToDo: More flexible and allowing other ways of forking farm members!
	 * 
	 * @param $url String url or domain to datermine one of the registered server names/url for
	 *        this wiki-farm member. For example 'www.farm1.wikifarm.org' @ToDo: or 'http://foo.org/wiki1'.
	 *        Value is case-insensitive.
	 * @param $scriptPath String farm member script path as second criteria in addition to address
	 * 
	 * @return SimpleFarmMember if not successful null will be returned
	 */
	public static function loadFromAddress( $url, $scriptPath = null ) {
		global $egSimpleFarmMembers, $egSimpleFarmIgnoredDomainPrefixes;
		
		if( $scriptPath !== null ) {
			$scriptPath = str_replace( "\\", "/", trim( $scriptPath ) );
		}
		
		// url to domain name. Trim url scheme,
		$pref = implode( '|', $egSimpleFarmIgnoredDomainPrefixes ); // no escaping necessary
		$url = str_replace( "\\", "/", strtolower( $url ) ); // for windows-style paths
		$address = preg_replace( '%^(?:.*://)?(?:(?:' . $pref . ')\.)?%', '', $url );
		$address = preg_replace( '%/.*%', '', $address );
		
		$members = SimpleFarm::getMembers();
		foreach( $members as $member ) {
			// if url matches:
			if( in_array( $address, $member->getAddresses() ) ) {
				// if script path is required, then check for it too:
				if( $scriptPath !== null ) {
					if( trim( $scriptPath ) === $member->getScriptPath() ) {
						return $member;
					}
				}
				else {
					return $member;
				}
			}
		}
		return null;
	}
	
	/**
	 * Load new SimpleFarmMember from its 'scriptpath' config value.
	 * 
	 * @param $scriptPath String configured script path of the farm member which should be returend.
	 * 
	 * @return SimpleFarmMember if not successful null will be returned
	 */
	public static function loadFromScriptPath( $scriptPath ) {
		$members = SimpleFarm::getMembers();
		foreach( $members as $member ) {
			if( $scriptPath !== null ) {
				if( trim( $scriptPath ) === $member->getScriptPath() ) {
					return $member;
				}
			} else {
				return $member;
			}
		}
	}
	
	/**
	 * Whether the wiki is set to maintaining mode right now.
	 * Returns the maintaining strictness.
	 * 
	 * @return integer
	 */
	public function isInMaintainMode() {
		if( empty( $this->siteOpt['maintain'] ) ) {
			return SimpleFarm::MAINTAIN_OFF;
		} else {
			return $this->siteOpt['maintain'];
		}
	}
	
	/**
	 * Returns whether the user is a maintainer or not. A maintainer is the current user
	 * if he accesses the wiki via command-line or if he has the 'maintainer' url parameter set.
	 * 
	 * @param User $user the user we want to know whether he is a maintainer right now.
	 *        If not set, the information will be returned for the current user.
	 *        This will only work after 'LocalSettings.php' since $wgUser is undefined ealrier!
	 * 
	 * @return boolean
	 */
	public function userIsMaintaining( User $user = null ) {
		global $wgUser, $wgCommandLineMode;
		
		// if $user is not the current user, he can't be maintaining anything right now
		if( $user === null ) {
			// $wgUser still null during localsettings.php config
			$user = $wgUser;
		}
		if( $wgUser !== null && $user->getId() !== $wgUser->getId() ) {
			return false;
		}
		
		// commandline usually is maintainer, so is the user if maintainer parameter is set in url
		switch( $this->isInMaintainMode() ) {
			// no break, step by step!			
			case SimpleFarm::MAINTAIN_SIMPLE:
				if( isset( $_GET['maintainer'] ) || isset( $_GET['maintain'] ) ) {					
					return true;
				}
				// no break!
				
			case SimpleFarm::MAINTAIN_STRICT:
				if( $wgCommandLineMode ) {
					return true;
				}
				// no break!
				
			case SimpleFarm::MAINTAIN_TOTAL:
			default:
				return false;
		}
	}
	
	/**
	 * Returns the Database name
	 * 
	 * @return string
	 */
	public function getDB() {
		return $this->siteOpt['db'];
	}
	
	/**
	 * Returns the wiki name
	 * 
	 * @return string
	 */
	public function getName() {
		global $egSimpleFarmMembers;		
		return $this->siteOpt['name'];
	}
	
	/**
	 * Returns all domains of the wiki (either from $wgSimpleFarmMembers or in case
	 * 'scriptpath' is used, from the server directly.
	 * 
	 * @return string[] or null in case of command-line access and missing 'address'
	 *         key in $wgSimpleFarmMembers config array.
	 */
	public function getAddresses() {
		// if addresses are not configured, return the server name:
		if( isset( $this->siteOpt['addresses'] ) ) {
			$addr = $this->siteOpt['addresses'];
		}
		elseif( isset( $_SERVER['HTTP_HOST'] ) ) {
			return array( $_SERVER['HTTP_HOST'] );
		}
		else {
			// in case arr option is not set and we are in commandline-mode!
			return null;
		}
			
		if( is_array( $addr ) ) {
			return $addr;
		} else {
			return array( $addr );
		}
	}
	
	/**
	 * Convenience function to just return the first defined address instead of all
	 * addresses as self::getAddresses() would return it.
	 *
	 * @return string
	 */
	public function getFirstAddress() {
		$addr = $this->getAddresses();
		return $addr[0];
	}
	
	/**
	 * returns the configured script path if set.
	 * Otherwise the value of $wgScriptPath
	 * 
	 * @return string
	 */
	public function getScriptPath() {
		if( isset( $this->siteOpt['scriptpath'] ) ) {
			$scriptPath = $this->siteOpt['scriptpath'];
		} else {
			global $wgScriptPath;
			$scriptPath = $wgScriptPath;
		}
		return str_replace( "\\", "/", trim( $scriptPath ) );
	}
	
	/**
	 * returns the config mode this farm member uses to be selected as active wiki.
	 * 
	 * @return integer flag self::CFG_MODE_SCRIPTPATH, self::CFG_MODE_ADDRESS or
	 *         self::CFG_MODE_NONE if not set up properly.
	 */
	public function getCfgMode() {
		if( isset( $this->siteOpt['scriptpath'] ) ) {
			return self::CFG_MODE_SCRIPTPATH;
		}
		elseif( isset( $this->siteOpt['addresses'] ) ) {
			return self::CFG_MODE_ADDRESS; //address can be given even if 'scriptpath' is
		}
		else {
			return self::CFG_MODE_NONE;
		}
	}
	
	/**
	 * Whether or not this member wiki has been declared the main member.
	 * The main member is important for maintenance reasons only.
	 * 
	 * @return boolean
	 */
	public function isMainMember() {
		return ( $this->getDB() === SimpleFarm::getMainMember()->getDB() );
	}
	
	/**
	 * Whether the farm member wiki is the wiki currently accessed in this run.
	 * 
	 * @return boolean
	 */
	public function isActive() {
		return ( $this->getDB() === SimpleFarm::getActiveMember()->getDB() );
	}
	
	/**
	 * Returns an value previously set for this object via $wgSimpleFarmMembers configuration.
	 * 
	 * @param $name string name of the array key representing an option
	 *        within the $wgSimpleFarmMembers sub-array for this object
	 * @param $default mixed default value if config key $name was not set for farm member
	 * 
	 * @return mixed
	 */
	public function getCfgOption( $name, $default = false ) {
		if( array_key_exists( $name, $this->siteOpt ) ) {
			return $this->siteOpt[ $name ];
		} else {
			return $default;
		}
	}
	
	/**
	 * Same as SimpleFarmMember::getCfgOption
	 * This requires PHP 5.3!
	 * 
	 * @return mixed
	 */
	public function __invoke( $name, $default = false ) {
		return $this->getCfgOption( $name, $default );
	}
}