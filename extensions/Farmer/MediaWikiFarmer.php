<?php
/**
 * @author Gregory Szorc <gregory.szorc@gmail.com>
 */


/**
 * This class exposes functionality for a MediaWiki farm
 *
 * @addtogroup Extension
 */
class MediaWikiFarmer
{

    protected $_parameters = array();

    /**
     * Directory where config files are stored
     */
    protected $_configDirectory;

    /**
     * Parameter to call_user_func which will return a wiki name from the
     * environment
     */
    protected $_matchFunction;

    /**
     * Regular expression to be used by internal _matchByURL* functions
     */
    protected $_matchRegExp;

    /**
     * Array key to return from match in _matchByURL* functions
     */
    protected $_matchOffset;

    protected $_defaultWiki;

    protected $_onUnknownWikiFunction;

    protected $_redirectToURL;

    protected $_dbAdminUser;

    protected $_dbAdminPassword;

    protected $_dbSourceFile;

    protected $_dbTablePrefixSeparator;

    protected $_dbTablePrefix;

    protected $_storageRoot;

    protected $_defaultSkin;

    protected $_defaultMessagesFunction;

    /**
     * Extensions available to Farmer
     */
    protected $_extensions = array();

    protected $_sharedGroups = false;

    protected $_extensionsLoaded = false;

    protected static $_instance = null;

    protected static $_activeWiki = null;

    /**
     * Constructor
     *
     * @param array $params Array of parameters to control behavior
     *
     * @todo Load up special page
     */
    public function __construct($params)
    {
        $this->_configDirectory = $params['configDirectory'];
        $this->_matchFunction = $params['wikiIdentifierFunction'];
        $this->_matchRegExp = $params['matchRegExp'];
        $this->_matchOffset = $params['matchOffset'];
        $this->_matchServerNameSuffix = $params['matchServerNameSuffix'];
        $this->_defaultWiki = $params['defaultWiki'];
        $this->_onUnknownWikiFunction = $params['onUnknownWiki'];
        $this->_redirectToURL = $params['redirectToURL'];
        $this->_dbAdminUser = $params['dbAdminUser'];
        $this->_dbAdminPassword = $params['dbAdminPassword'];
        $this->_dbSourceFile = $params['newDbSourceFile'];
        $this->_dbTablePrefixSeparator = $params['dbTablePrefixSeparator'];
        $this->_dbTablePrefix = $params['dbTablePrefix'];
        $this->_storageRoot = $params['perWikiStorageRoot'];
        $this->_defaultMessagesFunction = $params['defaultMessagesFunction'];
        $this->_defaultSkin = $params['defaultSkin'];

        $this->_parameters = $params;

        //register this object as the static instance
        self::$_instance = $this;

        $wgSharedTables = self::$_instance->getMWVariable('wgSharedTables');

        //if the groups table is being shared
        if (array_key_exists('user_groups', $wgSharedTables)) {
        	$this->_sharedGroups = true;
        }

        if (!is_dir($this->_configDirectory)) {
        	throw new MWException(wfMsgHtml('farmer-error-nodirconfig'). $this->_configDirectory);
        } else {
        	if (!is_dir($this->_configDirectory . '/wikis/')) {
        		mkdir($this->_configDirectory . '/wikis');
        	}
        }

    }

    public function __get($key) {
    	if (array_key_exists($key, $this->_parameters)) {
    		return $this->_parameters[$key];
    	}

        $property = '_' . $key;

        return isset($this->$property) ? $this->$property : null;
    }

    public static function getInstance()
    {
        return self::$_instance;
    }

    public function getActiveWiki()
    {
        return self::$_activeWiki;
    }

    /**
     * Runs MediaWikiFarmer
     *
     * This function does all the fun stuff
     */
    public function run()
    {

        if (!$this->_defaultWiki) {
            throw new MWException(wfMsgHtml('farmer-error-defnotset'));
        }

        //first we try to find the wiki name that was accessed by calling the appropriate function
        if (is_callable($this->_matchFunction)) {
            $wiki = call_user_func($this->_matchFunction);

            //if our function coudln't identify the wiki from the environment
            if (!$wiki) {
                $wiki = $this->_defaultWiki;
            }

            //sanitize wiki name
            //we force to lcase b/c having all types of case combos would just be confusing to end-user
            //besides, hostnames are not case sensitive
            $wiki = strtolower(preg_replace('/[^[:alnum:_\-]]/', '', $wiki));

            //now we have a valid wiki name
            return $this->_doWiki($wiki);

        } else {
            throw new MWException(wfMsgHtml('farmer-error-mapnotfound') . print_r($this->_matchFunction, true));
        }
    }

    /**
     * Returns a MediaWiki global variable
     *
     * I refuse to use the 'global' keyword out of principle
     */
    public static function &getMWVariable($var)
    {
        $return =  &$GLOBALS[$var];

        return $return;
    }

    /**
     * Performs actions necessary to run a specified wiki
     *
     * @param string $wiki Wiki to load
     */
    protected function _doWiki($wiki)
    {
        $wiki = MediaWikiFarmer_Wiki::factory($wiki);

        self::$_activeWiki = $wiki;

        if (!$wiki->exists()) {
            //if the default wiki doesn't exist (probably first-time user)
            if ($wiki->name == $this->_defaultWiki) {

                $defaultVariables = array(
                  'wgDBprefix' => $this->getDbTablePrefix($wiki->name)
                );

                //we reinitialize the object with the defaultVariables set
                //normally this gets done during wiki creation
                $wiki = MediaWikiFarmer_Wiki::factory($wiki->name, $defaultVariables);

                $wiki->save();

                if (!$wiki->exists()) {
                    throw new MWException(wfMsgHtml('farmer-error-nofileconfwrite'));
                } else {
                    $wiki->initialize();
                }
            } else {
                //we are not dealing with the default wiki

                //we invoke the function to be called when an unknown wiki is accessed
                if (is_callable($this->_onUnknownWikiFunction)) {
                    call_user_func($this->_onUnknownWikiFunction, $wiki);
                } else {
                    throw new MWException(wfMsgHtml('farmer-error-funcnotcall') . print_r($this->_onUnknownFunction, true));
                }
            }
        } else {
            //the wiki exists!
            //we initialize this wiki
            $wiki->initialize();
        }

    }

    /**
     * Returns the database table prefix, as suitable for $wgDBprefix
     */
    public function getDbTablePrefix($wiki)
    {
        return $this->_dbTablePrefix . $wiki . $this->_dbTablePrefixSeparator;
    }

    /**
     * Matches a URL to a wiki by comparing a URL to a regular expression
     * pattern
     *
     * This function applies the regular expression as defined by the
     * defaultWikiIdentifierRegExp parameter and feeds it into preg_match
     * against the URL.  From the matches array, the defaultWikiIdentifierOffset
     * key from that array is returned.  False is returns upon failure to match
     *
     * @param string $url URL that was accessed.  Probably $_SERVER
     * ['REQUEST_URI']
     *
     * @return string Wiki identifier.  Return null, false, or nothing if you
     * want to use the default wiki, as specified by the 'defaultWiki'
     * parameter.
     */
    protected function _matchByURLRegExp($url)
    {
        if (preg_match($this->_matchRegExp, $url, $matches) === 1) {
            if (array_key_exists($this->_matchOffset, $matches)) {
                return $matches[$this->_matchOffset];
            }
        }

        return false;
    }

    /**
     * Matches a URL to a wiki by looking at the hostname
     *
     * First, parses the URL and extracts the hostname.  Then, we do a
     * preg_match against the hostname with the pattern defined by the
     * matchRegExp parameter.  If it matches, we return the matchOffset key from
     * the matching array, if that key exists.  Else we return false
     *
     * @param string $url URL to match to a wiki
     * @return string|bool Wiki name on success.  false on failure
     */
    protected function _matchByURLHostname($url)
    {
        if ($result = parse_url($url)) {
            if ($host = $result['host']) {
                if (preg_match($this->_matchRegExp, $host, $matches) === 1) {
                    if (array_key_exists($this->_matchOffset, $matches)) {
                        return $matches[$this->_matchOffset];
                    }
                }
            }
        }

        return false;
    }

    /**
     * Returns a wiki name by matching against the server name
     *
     * Valuable for wildcard DNS farms, like wiki1.mydomain, wiki2.mydomain, etc
     *
     * Will look at the server name and return everything before the first
     * period
     *
     */
    protected function _matchByServerName()
    {
        $serverName = $_SERVER['SERVER_NAME'];

        //if string ends with the suffix specified
        if (substr($serverName, -strlen($this->_matchServerNameSuffix)) == $this->_matchServerNameSuffix
            && $serverName != $this->_matchServerNameSuffix) {
            return substr($serverName, 0, -strlen($this->_matchServerNameSuffix) - 1);
        }

        return false;

    }

    /**
     * Sends HTTP redirect to URL
     *
     * This function is called by default when an unknown wiki is accessed.
     *
     * @param string $wiki Unknown wiki that was accessed
     */
    protected function _redirectTo($wiki)
    {
        $urlTo = str_replace('$1', $wiki->name, $this->_redirectToURL);

        header('Location: ' . $urlTo);
        exit;
    }

    /**
     * Obtain a database connection suitable for interfacing with wiki $name
     *
     * @param $name Name of wiki.  Used to establish table prefix
     */
    public static function &getDatabase($name)
    {
        $dbServer = self::$_instance->getMWVariable('wgDBserver');
        $dbUser = self::$_instance->_dbAdminUser;
        $dbPass = self::$_instance->_dbAdminPassword;
        $dbDb = self::$_instance->getMWVariable('wgDBname');
        $dbPrefix = self::$_instance->getDbTablePrefix($name);

        $db = new Database($dbServer, $dbUser, $dbPass, $dbDb, false, 0, $dbPrefix);

        return $db;
    }

    /**
     * Creates a new wiki in the database
     *
     * @todo Error check to make sure tables don't exist
     */
    public function createWikiDatabase(MediaWikiFarmer_Wiki &$wiki)
    {
        $db = self::getDatabase($wiki->name);

        $this->_createTablesForWiki($wiki->name, $db);
        $this->_createMainPageForWiki($wiki->name, $db);
        $this->_populateMessagesForWiki($wiki->name, $db);

        $this->_populateInterwiki($wiki, $db);

        $this->_populateUserGroups($wiki, $db);
    }

    /**
     * Creates the tables for a specified wiki
     *
     * @param string $wiki Wiki to for whom to create tables
     * @param $db Database object to use (pre-set with table prefix)
     */
    protected function _createTablesForWiki($wiki, &$db = null)
    {
        if (!$db) {
           $db = self::getDatabase($wiki);
        }

        $db->sourceFile($this->_dbSourceFile);
    }

    protected function _createMainPageForWiki($wiki, &$db = null)
    {
        if (!$db) {
            $db = self::getDatabase($wiki);
        }

        $titleobj = Title::newFromText( wfMsgNoDB( "mainpage" ) );
        $article = new Article( $titleobj );
        $newid = $article->insertOn( $db );
        $revision = new Revision( array(
            'page'      => $newid,
            'text'      => wfMsg('farmernewwikimainpage'),
            'comment'   => '',
            'user'      => 0,
            'user_text' => 'MediaWiki default',
        ) );
        $revid = $revision->insertOn($db);
        $article->updateRevisionOn( $db, $revision );

        //site_stats table entry
        $db->insert( 'site_stats',
                array( 'ss_row_id'        => 1,
                       'ss_total_views'   => 0,
                       'ss_total_edits'   => 0,
                       'ss_good_articles' => 0 ) );

    }

    protected function _populateMessagesForWiki($wiki, &$db = null)
    {
        if (!$db) {
            $db = self::getDatabase($wiki);
        }

        $defaultMessages = array();

        //if we have specified a function to get the default messages,
        if (is_callable($this->_defaultMessagesFunction)) {
            $defaultMessages = call_user_func($this->_defaultMessagesFunction);

        } else {

            //fall back to getting the default English messages
	$defautlMessages = StubContLang::_newObject();
        }

        $wgContLang = $this->getMWVariable('wgContLang');

        //loop through the messages and add them to the database
        foreach ($defaultMessages as $k=>$v) {
            $titleObj = Title::newFromText( $wgContLang->ucfirst( $k ), NS_MEDIAWIKI );
            $title = $titleObj->getDBkey();


            $article = new Article( $titleObj );
            $newid = $article->insertOn( $db );
            $revision = new Revision( array(
                'page'      => $newid,
                'text'      => $v,
                'user'      => 0,
                'user_text' => 'MediaWiki default',
                'comment'   => '',
                ) );
            $revid = $revision->insertOn( $db );
            $article->updateRevisionOn( $db, $revision );
        }
    }

    /**
     * Create interwiki
     *
     * @todo Finish implementing
     */
    protected function _populateInterwiki(MediaWikiFarmer_Wiki $wiki, &$db = null)
    {
        if (!$db) {
            $db = self::getDatabase($wiki);
        }

        $query = 'INSERT INTO ' . $db->tableName('interwiki') . ' (iw_prefix, iw_url, iw_local) VALUES (';

        $query .= '\'' . strtolower($wiki->title) .'\', ';
        $query .= '\'' . wfMsg('farmerinterwikiurl', $wiki->name, '$1') . '\', ';
        $query .= '1';

        $query .= ')';

        $db->query($query);

    }

    protected function _populateUserGroups(MediaWikiFarmer_Wiki $wiki, &$db = null)
    {
    	if (!$db) {
    		$db = self::getDatabase($wiki);
    	}

        if ($wiki->creator) {
        	$user = User::newFromname($wiki->creator);

            $group = '[farmer]['.$wiki->name.'][admin]';

            $user->addGroup($group);
        }
    }

    public function deleteWiki(MediaWikiFarmer_Wiki $wiki)
    {
    	$db = self::getDatabase($wiki->name);

        $this->_deleteWikiTables($wiki, $db);
        $wiki->delete();

        $this->_deleteWikiGroups($wiki, $db);
        $this->_deleteInterWiki($wiki, $db);

        $this->updateFarmList();
    }

    protected function _deleteWikiTables(MediaWikiFarmer_Wiki $wiki, &$db)
    {
        $result = $db->query('SHOW TABLES');

        $prefix = $this->getDbTablePrefix($wiki->name);

        while ($row = $db->fetchRow($result)) {
        	if (strpos($row[0], $prefix) === 0) {
        		$query = 'DROP TABLE `'. $row[0] . '`';

                $db->query($query);
        	}
        }
    }

    protected function _deleteWikiGroups(MediaWikiFarmer_Wiki $wiki, &$db)
    {
    	$query = 'DELETE FROM ' . $db->tableName('user_groups') . ' WHERE ug_group LIKE ';
        $query .= '\'[farmer]['.$wiki->name.']%\'';

        $db->query($query);
    }

    protected function _deleteInterwiki(MediaWikiFarmer_Wiki $wiki, &$db)
    {
    	$query = 'DELETE FROM ' . $db->tableName('interwiki') . ' WHERE iw_prefix=\''.strtolower($wiki->title) . '\'';

        $db->query($query);
    }

    /**
     * Determines whether use can create a wiki
     *
     * @param User $user User object
     * @param string $wiki Wiki name (optional)
     *
     * @return bool true or false
     */
    public static function userCanCreateWiki(User $user, $wiki = null)
    {
        return $user->isAllowed('createwiki');
    }

    public static function userIsFarmerAdmin(User $user)
    {
        return $user->isAllowed('farmeradmin');
    }

    /**
     * Gets file holding extensions definitions
     */
    protected function _getExtensionFile()
    {
        return $this->_configDirectory . 'extensions';
    }

    /**
     * Gets extensions objects
     */
    public function getExtensions($forceReload = false)
    {
        if ($this->_extensionsLoaded && !$forceReload) {
            return $this->_extensions;
        }

        if (is_readable($this->_getExtensionFile())) {
            $contents = file_get_contents($this->_getExtensionFile());

            $extensions = unserialize($contents);

            if (is_array($extensions)) {
                $this->_extensions = $extensions;
            }
        } else {
            //perhaps we should throw an error or something?
        }

        $extensionsLoaded = true;
        return $this->_extensions;
    }

    public function registerExtension(MediaWikiFarmer_Extension $e)
    {
        //force reload of file
        $this->getExtensions(true);

        $this->_extensions[$e->name] = $e;

        $this->_writeExtensions();
    }

    /**
     * Writes out extension definitions to file
     */
    protected function _writeExtensions()
    {
        $file = $this->_getExtensionFile();

        $content = serialize($this->_extensions);

        if (file_put_contents($file, $content, LOCK_EX) != strlen($content)) {
            throw new MWException(wfMsgHtml('farmer-error-noextwrite') . $file);
        }
    }

    public function getConfigPath()
    {
        return $this->_configDirectory;
    }

    public function getStorageRoot()
    {
        return $this->_storageRoot;
    }

    /**
     * Looks for wiki configuration files and updates the farm digest file
     */
    public function updateFarmList()
    {
        $directory = new DirectoryIterator($this->_configDirectory . '/wikis/');
        $wikis = array();

        foreach ($directory as $file) {
            if (!$file->isDot() && !$file->isDir()) {
                if (substr($file->getFilename(), -7) == '.farmer') {
                    $base = substr($file->getFileName(), 0, -7);
                    $wikis[$base] = MediaWikiFarmer_Wiki::factory($base);
                }
            }
        }

        $farmList = array();

        foreach ($wikis as $k=>$v) {
            $arr = array();
            $arr['name'] = $v->name;
            $arr['title'] = $v->title;
            $arr['description'] = $v->description;

            $farmList[$k] = $arr;

        }

        file_put_contents($this->_getFarmListFile(), serialize($farmList), LOCK_EX);
    }

    public function getFarmList()
    {
        return unserialize(file_get_contents($this->_getFarmListFile()));
    }

    protected function _getFarmListFile()
    {
        return $this->_configDirectory . '/farmlist';
    }

    public function getDefaultWiki()
    {
        return $this->_defaultWiki;
    }

    public function sharingGroups()
    {
    	return $this->_sharedGroups;
    }
}
