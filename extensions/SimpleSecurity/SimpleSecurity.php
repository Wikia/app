<?php
/**
 * SimpleSecurity extension
 * - Extends the MediaWiki article protection to allow restricting viewing of article content
 * - Also adds #ifusercan and #ifgroup parser functions for rendering restriction-based content
 *
 * See http://www.mediawiki.org/Extension:Simple_Security for installation and usage details
 * See http://www.organicdesign.co.nz/Extension_talk:SimpleSecurity.php for development notes and disucssion
 * 
 * Version 4.0 started Oct 2007 - new version for modern MediaWiki's using DatabaseFetchHook
 * Version 4.1 started Jun 2008 - development funded for a slimmed down functional version
 * Version 4.2 started Aug 2008 - fattened up a bit again - $wgPageRestrictions and security info added in again
 * 
 * @package MediaWiki
 * @subpackage Extensions
 * @author Aran Dunkley [http://www.organicdesign.co.nz/nad User:Nad]
 * @copyright © 2007 Aran Dunkley
 * @licence GNU General Public Licence 2.0 or later
 */

if (!defined('MEDIAWIKI'))                     die('Not an entry point.');
if (version_compare($wgVersion, '1.11.0') < 0) die('Sorry, this extension requires at least MediaWiki version 1.11.0');

define('SIMPLESECURITY_VERSION', '4.2.15, 2008-12-14');

# Global security settings
$wgSecurityMagicIf              = "ifusercan";                  # the name for doing a permission-based conditional
$wgSecurityMagicGroup           = "ifgroup";                    # the name for doing a group-based conditional
$wgSecurityLogActions           = array('edit', 'download');    # Actions that should be logged
$wgSecurityAllowUser            = false;                        # Allow restrictions based on user not just group
$wgSecurityAllowUnreadableLinks = false;                        # Should links to unreadable pages be allowed? (MW1.7+)
$wgSecurityRenderInfo           = true;                         # Renders security information for proctected articles
$wgEnableParserCache            = false;                        # Currently the extension fails if caching enabled

# Extra actions to allow control over in protection form
$wgSecurityExtraActions  = array('read' => 'Read');

# Extra groups available in protection form
$wgSecurityExtraGroups   = array();

# Extra group permissions rules
$wgPageRestrictions = array();

# Put SimpleSecurity's setup function before all others
array_unshift($wgExtensionFunctions, 'wfSetupSimpleSecurity');

$wgHooks['LanguageGetMagic'][] = 'wfSimpleSecurityLanguageGetMagic';
$wgExtensionCredits['parserhook'][] = array(
	'name'        => 'SimpleSecurity',
	'author'      => '[http://www.organicdesign.co.nz/User:Nad User:Nad]',
	'description' => 'Extends the MediaWiki article protection to allow restricting viewing of article content',
	'url'         => 'http://www.mediawiki.org/wiki/Extension:SimpleSecurity',
	'version'     => SIMPLESECURITY_VERSION
	);

# SearchEngine is based on $wgDBtype so must be set before it gets changed to DatabaseSimpleSecurity
# - this may be paranoid now since $wgDBtype is changed back after LoadBalancer has initialised
SimpleSecurity::fixSearchType();

# If the database class already exists, add the DB hook now, otherwise wait until extension setup
if (!isset($wgSecurityUseDBHook)) $wgSecurityUseDBHook = false;
if ($wgSecurityUseDBHook && class_exists('Database')) wfSimpleSecurityDBHook();

class SimpleSecurity {

	var $guid  = '';
	var $cache = array();
	var $info  = array();

	/**
	 * Constructor
	 */
	function __construct() {
		global $wgParser, $wgHooks, $wgLogTypes, $wgLogNames, $wgLogHeaders, $wgLogActions, $wgMessageCache,
			$wgSecurityMagicIf, $wgSecurityMagicGroup, $wgSecurityExtraActions, $wgSecurityExtraGroups,
			$wgRestrictionTypes, $wgRestrictionLevels, $wgGroupPermissions,
			$wgSecurityRenderInfo, $wgSecurityAllowUnreadableLinks;

		# $wgGroupPermissions has to have its default read entry removed because Title::userCanRead checks it directly
		if ($this->default_read = (isset($wgGroupPermissions['*']['read']) && $wgGroupPermissions['*']['read']))
			$wgGroupPermissions['*']['read'] = false;

		# Add our hooks
		$wgHooks['UserGetRights'][] = $this;
		if ($wgSecurityMagicIf)    $wgParser->setFunctionHook($wgSecurityMagicIf,    array($this, 'ifUserCan'));
		if ($wgSecurityMagicGroup) $wgParser->setFunctionHook($wgSecurityMagicGroup, array($this, 'ifGroup'));
		if ($wgSecurityAllowUnreadableLinks) $wgHooks['BeforePageDisplay'][] = $this;
		if ($wgSecurityRenderInfo)           $wgHooks['OutputPageBeforeHTML'][] = $this;

		# Add a new log type
		$wgLogTypes[]                  = 'security';
		$wgLogNames  ['security']      = 'securitylogpage';
		$wgLogHeaders['security']      = 'securitylogpagetext';
		$wgLogActions['security/deny'] = 'securitylogentry';

		# Extend protection form groups, actions and messages
		$wgMessageCache->addMessages(array('protect-unchain' => "Modify actions individually"));
		$wgMessageCache->addMessages(array('badaccess-group1' => wfMsg('badaccess-group0')));
		$wgMessageCache->addMessages(array('badaccess-group2' => wfMsg('badaccess-group0')));
		$wgMessageCache->addMessages(array('badaccess-groups' => wfMsg('badaccess-group0')));

		foreach ($wgSecurityExtraActions as $k => $v) {
			if (empty($v)) $v = ucfirst($k);
			$wgRestrictionTypes[] = $k;
			$wgMessageCache->addMessages(array( "restriction-$k" => $v ));
			#$wgGroupPermissions['sysop'][$k] = true; # Ensure sysops have the right to perform this extra action
		}
		
		# Ensure the new groups show up in rights management
		# - note that 1.13 does a strange check in the ProtectionForm::buildSelector
		#   $wgUser->isAllowed($key) where $key is an item from $wgRestrictionLevels
		#   this requires that we treat the extra groups as an action and make sure its allowed by the user
		foreach ($wgSecurityExtraGroups as $k => $v) {
			if (empty($v)) $v = ucfirst($k);
			$wgRestrictionLevels[] = $k;
			$wgMessageCache->addMessages(array( "protect-level-$k" => $v ));
			$wgGroupPermissions[$k][$k] = true;
		}
	}

	/**
	 * Process the ifUserCan conditional security directive
	 */
	public function ifUserCan(&$parser, $action, $pagename, $then, $else = '') {
		return Title::newFromText($pagename)->userCan($action) ? $then : $else;
	}

	/**
	 * Process the ifGroup conditional security directive
	 * - evaluates to true if current uset belongs to any of the comma-separated users and/or groups in the first parameter
	 */
	public function ifGroup(&$parser, $groups, $then, $else = '') {
		global $wgUser;
		$intersection = array_intersect(array_map('strtolower', split(',', $groups)), $wgUser->getEffectiveGroups());
		return count($intersection) > 0 ? $then : $else;
	}

	/**
	 * Convert the urls with guids for hrefs into non-clickable text of class "unreadable"
	 */
	public function onBeforePageDisplay(&$out) {
		$out->mBodytext = preg_replace_callback(
			"|<a[^>]+title=\"(.+?)\".+?>(.+?)</a>|",
			array($this, 'unreadableLink'),
			$out->mBodytext
		);
		return true;
	}
	
	/**
	 * Render security info if any restrictions on this title
	 */
	public function onOutputPageBeforeHTML(&$out, &$text) {
		global $wgTitle, $wgUser;
		# Render security info if any
		if (is_object($wgTitle) && $wgTitle->exists() && count($this->info['LS'])+count($this->info['PR'])) {

			$rights = $wgUser->getRights();
			$wgTitle->getRestrictions(false);
			$reqgroups = $wgTitle->mRestrictions;
			$sysop = in_array('sysop', $wgUser->getGroups());

			# Build restrictions text
			$itext = "<ul>\n";
			foreach ($this->info as $source => $rules) if (!($sysop && $source === 'CR')) {
				foreach ($rules as $info) {
					list($action, $groups, $comment) = $info;
					$gtext = $this->groupText($groups);
					$itext .= "<li>".wfMsg('security-inforestrict', "<b>$action</b>", $gtext)." $comment</li>\n";
				}
			}
			if ($sysop) $itext .= "<li>".wfMsg('security-infosysops')."</li>\n";
			$itext .= "</ul>\n";

			# Add some javascript to allow toggling the security-info
			$out->addScript("<script type='text/javascript'>
				function toggleSecurityInfo() {
					var info = document.getElementById('security-info');
					info.style.display = info.style.display ? '' : 'none';
				}</script>"
			);
 
			# Add info-toggle before title and hidden info after title
			$link = "<a href='javascript:'>".wfMsg('security-info-toggle')."</a>";
			$link = "<span onClick='toggleSecurityInfo()'>$link</span>";
			$info = "<div id='security-info-toggle'>".wfMsg('security-info', $link)."</div>\n";
			$text = "$info<div id='security-info' style='display:none'>$itext</div>\n$text";
		}

		return true;
	}

	/**
	 * Callback function for unreadable link replacement
	 */
	private function unreadableLink($match) {
		global $wgUser;
		return $this->userCanReadTitle($wgUser, Title::newFromText($match[1]), $error)
			? $match[0] : "<span class=\"unreadable\">$match[2]</span>";
	}

	/**
	 * User::getRights returns a list of rights (allowed actions) based on the current users group membership
	 * Title::getRestrictions returns a list of groups who can perform a particular action
	 * So getRights should filter out any title-based restriction's actions which require groups that the user is not a member of
	 * - Allows sysop access
	 * - clears and populates the info array
	 */
	public function onUserGetRights(&$user, &$rights) {
		global $wgGroupPermissions, $wgTitle, $wgRequest, $wgPageRestrictions;

		# Hack to prevent specialpage operations on unreadable pages
		if (!is_object($wgTitle)) return true;
		$title = $wgTitle;
		$ns = $title->getNamespace();
		if ($ns == NS_SPECIAL) {
			list($name, $par) = explode('/', $title->getDBkey().'/', 2);
			if ($par) $title = Title::newFromText($par);
			elseif ($wgRequest->getVal('target'))   $title = Title::newFromText($wgRequest->getVal('target'));
			elseif ($wgRequest->getVal('oldtitle')) $title = Title::newFromText($wgRequest->getVal('oldtitle'));
		}
		if (!is_object($title)) return true;   # If still no usable title bail

		$this->info['LS'] = array();           # security info for rules from LocalSettings ($wgPageRestrictions)
		$this->info['PR'] = array();           # security info for rules from protect tab
		$this->info['CR'] = array();           # security info for rules which are currently in effect
		$groups = $user->getEffectiveGroups();

		# Put the anon read right back in $wgGroupPermissions if it was there initially
		# - it had to be removed because Title::userCanRead short-circuits with it
		if ($this->default_read) {
			$wgGroupPermissions['*']['read'] = true;
			$rights[] = 'read';
		}

		# Filter rights according to $wgPageRestrictions
		# - also update LS (rules from local settings) items to info array
		$this->pageRestrictions($rights, $groups, $title, true);

		# Add PR (rules from article's protect tab) items to info array
		# - allows rules in protection tab to override those from $wgPageRestrictions
		if (!$title->mRestrictionsLoaded) $title->loadRestrictions();
		foreach ($title->mRestrictions as $a => $g) if (count($g)) {
			$this->info['PR'][] = array($a, $g, wfMsg('security-desc-PR'));
			if (array_intersect($groups, $g)) $rights[] = $a;
		}

		# If title is not readable by user, remove the read and move rights
		if (!in_array('sysop', $groups) && !$this->userCanReadTitle($user, $title, $error)) {
			foreach ($rights as $i => $right) if ($right === 'read' || $right === 'move') unset($rights[$i]);
			#$this->info['CR'] = array('read', '', '');
		}
				
		return true;
	}

	/**
	 * Patches SQL queries to ensure that the old_id field is present in all requests for the old_text field
	 * otherwise the title that the old_text is associated with can't be determined
	 */
	static function patchSQL($match) {
		if (!preg_match("/old_text/", $match[0])) return $match[0];
		$fields = str_replace(" ", "", $match[0]);
		return ($fields == "*" || preg_match("/old_id/", $fields)) ? $fields : "$fields,old_id";
	}

	/**
	 * Validate the passed database row and replace any invalid content
	 * - called from fetchObject hook whenever a row contains old_text
	 * - old_id is guaranteed to exist due to patchSQL method
	 * - bails if sysop
	 */
	public function validateRow(&$row) {
		global $wgUser;
		$groups = $wgUser->getEffectiveGroups();
		if (in_array('sysop', $groups) || empty($row->old_id)) return;

		# Obtain a title object from the old_id
		$dbr   =& wfGetDB(DB_SLAVE);
		$tbl   = $dbr->tableName('revision');
		$rev   = $dbr->selectRow($tbl, 'rev_page', "rev_text_id = {$row->old_id}", __METHOD__);
		$title = Title::newFromID($rev->rev_page);

		# Replace text content in the passed database row if title unreadable by user
		if (!$this->userCanReadTitle($wgUser, $title, $error)) $row->old_text = $error;
	}

	/**
	 * Return bool for whether or not passed user has read access to the passed title
	 * - if there are read restrictions in place for the title, check if user a member of any groups required for read access
	 */
	public function userCanReadTitle(&$user, &$title, &$error) {
		$groups = $user->getEffectiveGroups();
		if (!is_object($title) || in_array('sysop', $groups)) return true;

		# Retrieve result from cache if exists (for re-use within current request)
		$key = $user->getID().'\x07'.$title->getPrefixedText();
		if (array_key_exists($key, $this->cache)) {
			$error = $this->cache[$key][1];
			return $this->cache[$key][0];
		}

		# Determine readability based on $wgPageRestrictions
		$rights = array('read');
		$this->pageRestrictions($rights, $groups, $title);
		$readable = count($rights) > 0;

		# If there are title restrictions that prevent reading, they override $wgPageRestrictions readability
		$whitelist = $title->getRestrictions('read');
		if (count($whitelist) > 0 && !count(array_intersect($whitelist, $groups)) > 0) $readable = false;

		$error = $readable ? "" : wfMsg('badaccess-read', $title->getPrefixedText());
		$this->cache[$key] = array($readable, $error);
		return $readable;
	}

	/**
	 * Returns a textual description of the passed list
	 */
	private function groupText(&$groups) {
		$gl = $groups;
		$gt = array_pop($gl);
		if (count($groups) > 1) $gt = wfMsg('security-manygroups', "<b>".join("</b>, <b>", $gl)."</b>", "<b>$gt</b>");
		else $gt = "the <b>$gt</b> group";
		return $gt;
	}

	/**
	 * Reduce the passed list of rights based on $wgPageRestrictions and the passed groups and title
	 * $wgPageRestrictions contains category and namespace based permissions rules
	 * the format of the rules is [type][action] = group(s)
	 * also adds LS items and currently active LS to info array
	 */
	private function pageRestrictions(&$rights, &$groups, &$title, $updateInfo = false) {
		global $wgPageRestrictions;
		$cats = array();
		foreach ($wgPageRestrictions as $k => $restriction) if (preg_match('/^(.+?):(.*)$/', $k, $m)) {
			$type = ucfirst($m[1]);
			$data = $m[2];
			$deny = false;

			# Validate rule against the title based on its type
 			switch ($type) {
 				
				case "Category":

					# If processing first category rule, build a list of cats this article belongs to
					if (count($cats) == 0) {
						$dbr = &wfGetDB(DB_SLAVE);
						$cl  = $dbr->tableName('categorylinks');
						$id  = $title->getArticleID();
						$res = $dbr->select($cl, 'cl_to', "cl_from = '$id'", __METHOD__, array('ORDER BY' => 'cl_sortkey'));
						while ($row = $dbr->fetchRow($res)) $cats[] = $row[0];
						$dbr->freeResult($res);
						}

					$deny = in_array($data, $cats);
					break;
					
				case "Namespace":
					$deny = $data == $title->getNamespace();
					break;
			}

			# If the rule applies to this title, check if we're a member of the required groups,
			# remove action from rights list if not (can be mulitple occurences)
			# - also update info array with page-restriction that apply to this title (LS), and rules in effect for this user (CR)
			if ($deny) {
				foreach ($restriction as $action => $reqgroups) {
					if (!is_array($reqgroups)) $reqgroups = array($reqgroups);
					if ($updateInfo) $this->info['LS'][] = array($action, $reqgroups, wfMsg('security-desc-LS', strtolower($type), $data));
					if (!in_array('sysop', $groups) && !array_intersect($groups, $reqgroups)) {
						foreach ($rights as $i => $right) if ($right === $action) unset($rights[$i]);
						#$this->info['CR'][] = array($action, $reqgroups, wfMsg('security-desc-CR'));
					}
				}
			}
		}
	}

	/**
	 * Updates passed LoadBalancer's DB servers to secure class
	 */
	static function updateLB(&$lb) {
		$lb->closeAll();
		foreach ($lb->mServers as $i => $server) $lb->mServers[$i]['type'] = 'SimpleSecurity';
	}

	/**
	 * Hack to ensure proper search class is used
	 * - $wgDBtype determines search class unless already defined in $wgSearchType
	 * - just copied method from SearchEngine::create()
	 */
	static function fixSearchType() {
		global $wgDBtype, $wgSearchType;
		if ($wgSearchType) return;
		elseif ($wgDBtype == 'mysql')    $wgSearchType = 'SearchMySQL4';
		elseif ($wgDBtype == 'postgres') $wgSearchType = 'SearchPostgres';
		elseif ($wgDBtype == 'oracle')   $wgSearchType = 'SearchOracle';
		else                             $wgSearchType = 'SearchEngineDummy';
	}
}

/**
 * Hook into Database::query and Database::fetchObject of database instances
 * - this can't be executed from within a method because PHP doesn't like nested class definitions
 * - it needs an eval because the class statement isn't allowed to contain strings
 * - the hooks aren't called if $wgSimpleSecurity doesn't exist yet
 * - hooks are added in a sub-class of the database type specified in $wgDBtype called DatabaseSimpleSecurity
 * - $wgDBtype is changed so that new DB instances are based on the sub-class
 * - query method is overriden to ensure that old_id field is returned for all queries which read old_text field
 * - only SELECT statements are ever patched
 * - fetchObject method is overridden to validate row content based on old_id
 */
function wfSimpleSecurityDBHook() {
	global $wgDBtype, $wgSecurityUseDBHook, $wgOldDBtype;
	$wgOldDBtype = $wgDBtype;
	$oldClass = ucfirst($wgDBtype);
	$wgDBtype = 'SimpleSecurity';
	eval("class Database{$wgDBtype} extends Database{$oldClass}".' {
		public function query($sql, $fname = "", $tempIgnore = false) {
			global $wgSimpleSecurity;
			$count = false;
			if (is_object($wgSimpleSecurity))
				$patched = preg_replace_callback("/(?<=SELECT ).+?(?= FROM)/", array("SimpleSecurity", "patchSQL"), $sql, 1, $count);
			return parent::query($count ? $patched : $sql, $fname, $tempIgnore);
		}
		function fetchObject(&$res) {
			global $wgSimpleSecurity;
			$row = parent::fetchObject($res);
			if (is_object($wgSimpleSecurity) && isset($row->old_text)) $wgSimpleSecurity->validateRow($row);
			return $row;
		}
	}');
	$wgSecurityUseDBHook = false;
}

/**
 * Register magic words
 */
function wfSimpleSecurityLanguageGetMagic(&$magicWords, $langCode = 0) {
	global $wgSecurityMagicIf, $wgSecurityMagicGroup;
	$magicWords[$wgSecurityMagicIf]    = array($langCode, $wgSecurityMagicIf);
	$magicWords[$wgSecurityMagicGroup] = array($langCode, $wgSecurityMagicGroup);
	return true;
}

/**
 * Called from $wgExtensionFunctions array when initialising extensions
 */
function wfSetupSimpleSecurity() {
	global $wgSimpleSecurity, $wgLanguageCode, $wgMessageCache, $wgSecurityUseDBHook,  $wgLoadBalancer, $wgDBtype, $wgOldDBtype;

	# Instantiate the SimpleSecurity singleton now that the environment is prepared
	$wgSimpleSecurity = new SimpleSecurity();

	# If the DB hook couldn't be set up early, do it now
	# - but now the LoadBalancer exists and must have its DB types changed
	if ($wgSecurityUseDBHook) {
		wfSimpleSecurityDBHook();
		if (function_exists('wfGetLBFactory')) wfGetLBFactory()->forEachLB(array('SimpleSecurity', 'updateLB'));
		elseif (is_object($wgLoadBalancer)) SimpleSecurity::updateLB($wgLoadBalancer);
		else die("Can't hook in to Database class!");
	}

	# Request a DB connection to ensure the LoadBalancer is initialised,
	# then change back to old DBtype since it won't be used for making connections again but can affect other operations
	# such as $wgContLang->stripForSearch which is called by SearchMySQL::parseQuery
	wfGetDB( DB_MASTER );
	$wgDBtype = $wgOldDBtype;

	# Add messages
	if ($wgLanguageCode == 'en') {
		$wgMessageCache->addMessages(array(
			'security'                 => "Security log",
			'security-logpage'         => "Security log",
			'security-logpagetext'     => "This is a log of actions blocked by the [[MW:Extension:SimpleSecurity|SimpleSecurity extension]].",
			'security-logentry'        => "",
			'badaccess-read'           => "\nWarning: \"$1\" is referred to here, but you do not have sufficient permisions to access it.\n",
			'security-info'            => "There are $1 on this article",
			'security-info-toggle'     => "security restrictions",
			'security-inforestrict'    => "$1 is restricted to $2",
			'security-desc-LS'         => "<i>(applies because this article is in the <b>$2 $1</b>)</i>",
			'security-desc-PR'         => "<i>(set from the <b>protect tab</b>)</i>",
			'security-desc-CR'         => "<i>(this restriction is <b>in effect now</b>)</i>",
			'security-infosysops'      => "No restrictions are in effect because you are a member of the <b>sysop</b> group",
			'security-manygroups'      => "groups $1 and $2"
		));
	}
}

