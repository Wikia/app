<?php
 
/**
 * See: http://www.mediawiki.org/wiki/Extension:PreferencesExtension
 *
 * This allows other extensions to add their own preferences to the default preferences display
 *
 * Author: Austin Che <http://openwetware.org/wiki/User:Austin_J._Che>
 */

$wgExtensionFunctions[] = "wfPreferencesExtension";
$wgExtensionCredits['specialpage'][] = array(
    'name' => 'PreferencesExtension',
    'version' => '2008/02/10.2',
    'author' => 'Austin Che',
    'url' => 'http://openwetware.org/wiki/User:Austin_J._Che/Extensions/PreferencesExtension',
    'description' => 'Enables extending user preferences',
);

// This has to be done before wfPreferencesExtension() because the hook is sometimes run before extensions initialize.
$wgHooks['SpecialPage_initList'][] = 'wfOverridePreferences';

// constants for pref types
define('PREF_USER_T', 1);
define('PREF_TOGGLE_T', 2);
define('PREF_TEXT_T', 3);
define('PREF_PASSWORD_T', 4);
define('PREF_INT_T', 5);
define('PREF_DROPDOWN_T', 6);
define('PREF_CUSTOM_HTML_T', 6);
 
// each element of the following should be an array that can have keys:
// name, section, type, size, validate, load, save, html, min, max, default
if (!isset($wgExtensionPreferences))
     $wgExtensionPreferences = array();
 
function wfPreferencesExtension()
{
	wfProfileIn(__METHOD__);
	
//    wfUseMW('1.7');
	
	wfProfileOut(__METHOD__);
}

/**
 * Adds an array of prefs to be displayed in the user preferences
 *
 * @param array $prefs
 */
function wfAddPreferences($prefs)
{
    global $wgExtensionPreferences;
	wfProfileIn(__METHOD__);
 
    foreach ($prefs as $pref)
    {
        $wgExtensionPreferences[] = $pref;
    }
	wfProfileOut(__METHOD__);
}
 
function wfOverridePreferences(&$list)
{
	wfProfileIn(__METHOD__);
	
    // we 'override' the default preferences special page with our own
    $list["Preferences"] = array("SpecialPage", "Preferences", "", true, "wfSpecialPreferencesExtension");
	
	wfProfileOut(__METHOD__);
    return true;
}
 
function wfSpecialPreferencesExtension()
{
	wfProfileIn(__METHOD__);

	global $IP;
    require_once($IP . '/includes/specials/SpecialPreferences.php');
 
    // override the default preferences form
    class SpecialPreferencesExtension extends PreferencesForm
    {
		// overload to add new field by hook
    	function __construct( &$request ) {
			global $wgExtensionPreferences, $wgUser;
			parent::__construct($request);
			wfRunHooks( 'initPreferencesExtensionForm', array( $wgUser, &$wgExtensionPreferences ) );
		}
        // unlike parent, we don't load in posted form values in constructor
        // until savePreferences when we need it
        // we also don't need resetPrefs, instead loading the newest values when displaying the form
        // finally parent's execute function doesn't need overriding
        // this leaves only two functions to override
        // one for displaying the form and one for saving the values
 
        function savePreferences() 
        {
            // handle extension prefs first
            global $wgUser, $wgRequest;
            global $wgExtensionPreferences;
			wfProfileIn(__METHOD__);
 
            foreach ($wgExtensionPreferences as $p)
            {
                $name = isset($p['name']) ? $p['name'] : "";
                if (! $name) {
					continue;
                }
 
                $value = $wgRequest->getVal($name);
                $type = isset($p['type']) ? $p['type'] : PREF_USER_T;
                
                if ( !empty($p['int-type']) ) {
                	$type = $p['int-type'];
                }
                
                switch ($type)
                {
                    case PREF_TOGGLE_T:
                        if (isset($p['save']))
                            $p['save']($name, $value);
                        else
                            $wgUser->setOption($name, $wgRequest->getCheck("wpOp{$name}"));
                        break;
 
                    case PREF_INT_T:
                        $min = isset($p['min']) ? $p['min'] : 0;
                        $max = isset($p['max']) ? $p['max'] : 0x7fffffff;
                        if (isset($p['save']))
                            $p['save']($name, $value);
                        else
                            $wgUser->setOption($name, $this->validateIntOrNull($value, $min, $max));
                        break;
 
                    case PREF_DROPDOWN_T:
                        if (isset($p['save']))
                            $p['save']($name, $value);
                        else
                            $wgUser->setOption($name, $value);
                        break;
 
                    case PREF_PASSWORD_T:
                    case PREF_TEXT_T:
                    case PREF_USER_T:
                    default:
                        if (isset($p['validate']))
                            $value = $p['validate']($value);
                        if (isset($p['save']))
                            $p['save']($name, $value);
                        else
                            $wgUser->setOption($name, $value);
                        break;
                }
            }
 
            // call parent's function which saves the normal prefs and writes to the db
            parent::savePreferences();

			wfProfileOut(__METHOD__);
        }

        function mainPrefsForm( $status , $message = '' )
        {
            global $wgOut, $wgRequest, $wgUser;
            global $wgExtensionPreferences;
			wfProfileIn(__METHOD__);
 
            // first get original form, then hack into it new options
            parent::mainPrefsForm($status, $message);
            $html = $wgOut->getHTML();
            $wgOut->clearHTML();
            $sections = array();
            foreach ($wgExtensionPreferences as $p)
            {
                if (! isset($p['section']) || ! $p['section'])
                    continue;
                 $section = $p['section'];
 
                $name = isset($p['name']) ? $p['name'] : "";
                
                $value = "";
                if ($name)
                {
                    if (isset($p['load']))
                        $value = $p['load']($name);
                    else
                        $value = $wgUser->getOption($name);
                }
                if ($value === '' && isset($p['default']))
                    $value = $p['default'];
 
                $sectext = htmlspecialchars(wfMsg($section));
                $regex = "/(<fieldset>\s*<legend>\s*" . preg_quote($sectext) . 
                    "\s*<\/legend>.*?)(<\/fieldset>)/s";
 
                // check if $section exists in prefs yet
                // cache the existence of sections
                if (!isset($sections[$section]))
                {
                    $sections[$section] = true;
 
                    if (! preg_match($regex, $html, $m))
                    {
                        // doesn't exist so add an empty section to end
                        $addhtml = "<fieldset><legend>$sectext</legend></fieldset>\n";
                        $html = preg_replace("/(<(div|table) id='prefsubmit'.*)/s", "$addhtml $1", $html);
                    }

                }

                $type = isset($p['type']) ? $p['type'] : PREF_USER_T;
                
                if ( !empty($p['int-type']) ) {
                	$type = $p['int-type'];
                }

                $pos = isset($p['pos']) ? $p['pos'] : '';
                switch ($type)
                {                    
                	case PREF_TOGGLE_T:
                        $addhtml = $this->getToggle($name);
                        break;

                    case PREF_INT_T:
                    case PREF_TEXT_T:
                    case PREF_PASSWORD_T:
                        $size = isset($p['size']) && $p['size'] ? "size=\"{$p['size']}\"" : "";
                        $caption = isset($p['caption']) && $p['caption'] ? $p['caption'] : wfMsg($name);
                        if ($type == PREF_PASSWORD_T)
                            $type = "password";
                        else
                            $type = "text";
 
                        if ($pos == 'first' || $pos == '')
                            $addhtml = "\n<table>\n";
                        else
                            $addhtml = '';
                        $addhtml .= $this->addRow("<label for=\"{$name}\">$caption</label>",
                                                  "<input type=\"$type\" id=\"{$name}\" name=\"{$name}\" value=\"{$value}\" $size />")."\n";
                        if ($pos == 'last' || $pos == '')	
                            $addhtml .="</table>\n";
                        break;
 
                    case PREF_DROPDOWN_T:
                        $caption = isset($p['caption']) && $p['caption'] ? $p['caption'] : wfMsg($name);
                        $onchange = isset($p['onchange']) && $p['onchange'] ? (" onchange='" . $p['onchange'] . "'") : ''; 
                        $row = "\n      <select id=\"{$name}\"$onchange name=\"{$name}\">\n";
                        $options = is_array($p['options']) ? $p['options'] : array();
                        foreach($options as $option)
                        {
                            $row .= "        <option>$option</option>\n";
                        }
                        $row .= "      </select>";
 
                        if ($pos == 'first' || $pos == '')
                            $addhtml = "\n<table>\n";
                        else
                            $addhtml = '';
                        $addhtml .= $this->addRow("<label for=\"{$name}\">$caption</label>", $row)."\n";
                        if ($pos == 'last' || $pos == '') 
                            $addhtml .="</table>\n";
                        break;
 
                    case PREF_USER_T:
                    default:
                        $addhtml = preg_replace("/@VALUE@/", $value, isset($p['html']) ? $p['html'] : "");
                        break;
                }
 
                // the section exists
                $html = preg_replace($regex, "$1 $addhtml $2", $html);
            }

            $wgOut->addHTML($html);

            // debugging
            //$wgOut->addHTML($wgUser->encodeOptions());
			wfProfileOut(__METHOD__);
        }
    }

    global $wgRequest;
    $prefs = new SpecialPreferencesExtension($wgRequest);
    $prefs->execute();
	
	wfProfileOut(__METHOD__);
}
