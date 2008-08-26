<?php
/**
 * Created on Jul 20, 2006
 *
 * @author Gregory Szorc <gregory.szorc@gmail.com>
 */

/**
 * Represents a configuration for a specific wiki
 */
class MediaWikiFarmer_Wiki
{
    /**
     * Name of wiki
     */
    protected $_name;

    protected $_title;

    protected $_description;

    /**
     * Username of person who created wiki
     */
    protected $_creator;

    /**
     * Extensions to load for this wiki
     */
    protected $_extensions = array();

    /**
     * Global variables set for this wiki
     */
    protected $_variables = array();

    /**
     * Permissions are so funky, we give them their own variable
     */
    protected $_permissions = array('*'=>array(), 'user'=>array());

    /**
     * Creates a wiki instance from a wiki name
     */
    public function __construct($wiki, $variables = array())
    {
        $this->_name = $wiki;

        $this->_variables = $variables;
    }

    public function __get($key)
    {
        if (substr($key, 0, 2) == 'wg') {
        	return isset($this->_variables[$key]) ? $this->_variables[$key] : null;
        }

        $property = '_' . $key;

        return isset($this->$property) ? $this->$property : null;
    }

    public function __set($k, $v)
    {
        if (in_array($k, array('name', 'title', 'description', 'creator', 'extensions'))) {
            $property = '_' . $k;

            $this->$property = $v;
        } else if (substr($k, 0, 2) == 'wg') {
            $this->_variables[$k] = $v;
        }
    }

    /**
     * How to represent this object as a string
     */
    public function __toString()
    {
        return $this->_name;
    }

    public static function factory($wiki, $variables = array())
    {
        $file = self::_getWikiConfigFile($wiki);

        if (is_readable($file)) {
            $content = file_get_contents($file);

            $obj = unserialize($content);

            if ($obj instanceof MediaWikiFarmer_Wiki) {
                return $obj;
            } else {
                throw new MWException(wfMsgHtml('farmer-error-wikicorrupt'));
            }
        } else {
            return new MediaWikiFarmer_Wiki($wiki, $variables);
        }
    }

    /**
     * Create a new wiki from settings
     */
    public static function create($name, $title, $description, $creator, $variables = array())
    {
        $wiki = self::factory($name, $variables);

        $wiki->title = $title;
        $wiki->description = $description;
        $wiki->creator = $creator;

        $farmer = MediaWikiFarmer::getInstance();

        //save the database prefix accordingly
        $wiki->wgDBprefix = $farmer->getDbTablePrefix($name);
        $wiki->wgDefaultSkin = $farmer->defaultSkin;

        //before we create the database, make sure this database doesn't really exist yet
        if (!$wiki->exists() && !$wiki->databaseExists()) {
            $farmer->createWikiDatabase($wiki);
            $wiki->save();
            $farmer->updateFarmList();
        } else {
            throw new MWException(wfMsgHtml('farmer-error-exists', $name));
        }

    }

    public function save()
    {
        $content = serialize($this);

        if (file_put_contents(self::_getWikiConfigFile($this->_name), $content, LOCK_EX) != strlen($content)) {
            //throw error?
        }
    }

    public function delete()
    {
    	if ($this->exists()) {
    		unlink(self::_getWikiConfigFile($this->_name));
    	}
    }

    /**
     * Returns whether this wiki exists
     *
     * Simply looks for file presence.  We don't have to clear the stat cache
     * because if a file doesn't exist, this isn't stored in the stat cache
     */
    public function exists()
    {
        return file_exists(self::_getWikiConfigFile($this->_name));
    }

    public function databaseExists()
    {
        $db = MediaWikiFarmer::getDatabase($this->_name);
    	return $db->tableExists('page');
    }

    /**
     * Performs actions necessary to initialize the environment so MediaWiki can
     * use this wiki
     */
    public function initialize()
    {
        //loop over defined variables and set them in the global scope
        foreach ($this->_variables as $k=>$v) {
            $GLOBALS[$k] = $v;
        }

        //we need to bring some global variables into scope so we can load extensions properly
        $wgExtensionFunctions = &MediaWikiFarmer::getInstance()->getMWVariable('wgExtensionFunctions');
        $wgExtensionCredits = &MediaWikiFarmer::getInstance()->getMWVariable('wgExtensionCredits');
        $wgGroupPermissions = &MediaWikiFarmer::getInstance()->getMWVariable('wgGroupPermissions');

        //register all the extensions
        foreach ($this->_extensions as $extension) {
            foreach ($extension->includeFiles as $file) {
                require_once $file;
            }
        }

        $GLOBALS['wgSitename'] = $this->_title;

        //we initialize the per-wiki storage root and all related global variables
        $wikiDir = MediaWikiFarmer::getInstance()->getStorageRoot() . $this->name . '/';

        $GLOBALS['wgUploadDirectory'] = $wikiDir . 'uploads';
        $GLOBALS['wgMathDirectory'] = $wikiDir . 'math';
        $GLOBALS['wgTmpDirectory'] = $wikiDir . 'tmp';

        //we allocate permissions to the necessary groups

        foreach ($this->_permissions['*'] as $k=>$v) {
        	$wgGroupPermissions['*'][$k] = $v;
        }

        foreach ($this->_permissions['user'] as $k=>$v) {
        	$wgGroupPermissions['user'][$k] = $v;
        }

        $wgGroupPermissions['sysop']['read'] = true;

        //assign permissions to administrators of this wiki
        $group = '[farmer]['.$this->_name.'][admin]';

        $grantToWikiAdmins = array('read','edit');

        foreach ($grantToWikiAdmins as $v) {
        	$wgGroupPermissions[$group][$v] = true;
        }



    }

    protected static function _getWikiConfigPath()
    {
        $farmer = MediaWikiFarmer::getInstance();
        return $farmer->getConfigPath() . 'wikis/';
    }

    protected static function _getWikiConfigFile($wiki)
    {
        return self::_getWikiConfigPath() . $wiki . '.farmer';
    }

    public static function sanitizeName($name)
    {
        return strtolower(preg_replace('/[^[:alnum:]]/', '', $name));
    }

    public static function sanitizeTitle($title)
    {
        return preg_replace('/[^[:alnum:]]/', '', $title);
    }

    public function isDefaultWiki()
    {
        return $this->_name == MediaWikiFarmer::getInstance()->getDefaultWiki();
    }

    public function setPermission($group, $permission, $value)
    {
    	if (!array_key_exists($group, $this->_permissions)) {
    		$this->_permissions[$group] = array();
    	}

        $this->_permissions[$group][$permission] = $value ? true : false;


    }

    public function setPermissionForAll($permission, $value)
    {
    	$this->setPermission('*', $permission, $value);
    }

    public function setPermissionForUsers($permission, $value)
    {
    	$this->setPermission('user', $permission, $value);
    }

    public function getPermission($group, $permission)
    {
    	return isset($this->_permissions[$group][$permission]) ? $this->_permissions[$group][$permission] : false;
    }

    public function getPermissionForAll($permission)
    {
    	return $this->getPermission('*', $permission);
    }

    public function getPermissionForUsers($permission)
    {
    	return $this->getPermission('user', $permission);
    }

    public function userIsAdmin(User $user)
    {
    	$adminGroup = '[farmer]['.$this->_name.'][admin]';

        return in_array($adminGroup, $user->getGroups());
    }

    public function addExtension(MediaWikiFarmer_Extension $e)
    {
    	$this->_extensions[$e->name] = $e;
    }

    public function hasExtension(MediaWikiFarmer_Extension $e)
    {
    	return array_key_exists($e->name, $this->_extensions);
    }
}
