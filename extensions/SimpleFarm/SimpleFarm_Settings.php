<?php
/**
 * File defining the settings for the 'Simple Farm' extension.
 * More info can be found at http://www.mediawiki.org/wiki/Extension:Simple_Farm#Configuration
 *
 * NOTICE:
 * =======
 * Changing one of these settings can be done by copying and placing
 * it in LocalSettings.php, AFTER the inclusion of 'Simple Farm'.
 *
 * @file SimpleFarm_Settings.php
 * @ingroup SimpleFarm
 * @since 0.1
 *
 * @author Daniel Werner < danweetz@web.de >
 */

/**
 * Config var to define members of the wiki farm. The following associative Array keys are obligatory:
 *   db          - String database name
 *   name        - String Wiki name, for $wgSitename
 * AND:
 * (
 *   addresses   - String|String[] one or more server names associated with the wiki. Can be used for
 *                 sub-domain based farm members like 'farm1.mw.org', 'farm2.mw.org'... , 'farmX.mw.org'
 *                 If this method is chosen, $wgScriptPath must be set in 'LocalSettings.php'.
 *                 Even if this method is not chosen, this should contain one address anyway.
 * AND/OR:
 *   scriptpath  - String (Virtual) script path to the particular wiki directory. Can be used for mod-rewrite
 *                 based wiki farm setup. This will set the $wgScriptPath variable. There should be a
 *                 '.htaccess' file in the parent directory of the farm to redirect all paths to the farm
 *                 directory. Example: 'mw.org/farm1', 'mw.org/farm2'... , 'mw.org/farmX', where for the first
 *                 member the value had to be '/farm1', for the second '/farm2' and so on.
 * )
 * 
 * The following keys are optional:
 *   maintain    - Flag whether or not wiki is in maintaining mode right now (optional)
 *                 The following flags are allowed:
 *                 - SimpleFarm::MAINTAIN_OFF / false
 *                 - SimpleFarm::MAINTAIN_SIMPLE
 *                 - SimpleFarm::MAINTAIN_STRICT
 *                 - SimpleFarm::MAINTAIN_TOTAL
 * 
 * Furthermore, it is possible to add custom keys with additional information for each farm member. These information
 * can be accessed later via $simpleFarmMember->getCfgOption() or $simpleFarmMember() (object-function only in PHP 5.3+)
 *
 * @var Array[]
 */ 
$egSimpleFarmMembers = array();

/**
 * Database name of one of the $wgSimpleFarmMembers wikis.
 * If null, it will be set when SimpleFarm::init() was called. The default value is the first key
 * of $wgSimpleFarmMembers then.
 * This main member is important for maintenance since the generic maintenance script will connect
 * to the main member first to have full basic MediaWiki maintenance support.
 *
 * @var String
 */
$egSimpleFarmMainMemberDB = null;

/**
 * allowed sub-domain prefixes that should be ignored when set in front of the
 * allowed addresses per farm member.
 * 
 * @var String[]
 */
$egSimpleFarmIgnoredDomainPrefixes = array( 'www' );

/**
 * Name of the environment variable used to select a wiki via command-line access if only one
 * wiki should be selected directly instead of using the provided maintenace script.
 * The value will be put into the constant 'SIMPLEFARM_ENVVAR' before final initialisation.
 *
 * @var Strings
 */
$egSimpleFarmWikiSelectEnvVarName = 'WIKI';

/**
 * Callback to call a specific function in case no wiki has been found from the requested
 * address (not in case of command-line acces though!).
 * If the return value of this function is of type SimpleFarmMember, this wiki will be loaded.
 * Otherwise the default message will be shown.
 * Possible value to load the default wiki if no wiki was found would be the callback
 * string 'SimpleFarm::getMainMember'.
 *
 * @var Callback
 */
$egSimpleFarmErrorNoMemberFoundCallback = null;

/**
 * @ToDo: More hook-like callback functions, perhaps collected into array $wgSimpleFarmCallbacks 
 *        since we can't use MW hook system which is not loaded when farm is being initialized
 *        during localsettings.
 *        Example: $wgSimpleFarmCallbacks['NoMemberFound']
 */