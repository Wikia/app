<?php
 
/**
 * This allows other extensions to add their own preferences to the default preferences display
 *
 * Author: Austin Che <http://openwetware.org/wiki/User:Austin>
 */
 
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'PreferencesExtension',
	'svn-date' => '$LastChangedDate: 2008-10-11 18:39:40 +0200 (sob, 11 paź 2008) $',
	'svn-revision' => '$LastChangedRevision: 41971 $',
	'author' => 'Austin Che',
	'url' => 'http://openwetware.org/wiki/User:Austin/Extensions/PreferencesExtension',
	'description' => 'Enables extending user preferences',
);
$wgHooks['SpecialPage_initList'][] = 'wfOverridePreferences';
 
// constants for pref types
define('PREF_USER_T', 1);
define('PREF_TOGGLE_T', 2);
define('PREF_TEXT_T', 3);
define('PREF_PASSWORD_T', 4);
define('PREF_INT_T', 5);
define('PREF_OPTIONS_T', 6);
 
// each element of the following should be an array that can have keys:
// name, section, type, size, validate, load, save, html, min, max, default
if (!isset($wgExtensionPreferences))
     $wgExtensionPreferences = array();
 
function wfOverridePreferences(&$list)
{
    // we 'override' the default preferences special page with our own
    $list["Preferences"] = array("SpecialPage", "Preferences", "", true, "wfSpecialPreferencesExtension");
    return true;
}
 
function wfSpecialPreferencesExtension()
{
    // override the default preferences form
    class SpecialPreferencesExtension extends PreferencesForm
    {
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
 
            foreach ($wgExtensionPreferences as $pref)
            {
                $name = isset($pref['name']) ? $pref['name'] : "";
                if (! $name)
                    continue;
 
                $value = $wgRequest->getVal($name);
                $type = isset($pref['type']) ? $pref['type'] : PREF_USER_T;
                switch ($type)
                {
                    case PREF_TOGGLE_T:
                        if (isset($pref['save']))
                            $pref['save']($name, $value);
                        else
                            $wgUser->setOption($name, $wgRequest->getCheck("wpOp{$name}"));
                        break;
 
                    case PREF_INT_T:
                        $min = isset($pref['min']) ? $pref['min'] : 0;
                        $max = isset($pref['max']) ? $pref['max'] : 0x7fffffff;
                        if (isset($pref['save']))
                            $pref['save']($name, $value);
                        else
                            $wgUser->setOption($name, $this->validateIntOrNull($value, $min, $max));
                        break;
 
                    case PREF_PASSWORD_T:
                    case PREF_TEXT_T:
                    case PREF_USER_T:
                    default:
                        if (isset($pref['validate']))
                            $value = $pref['validate']($value);
                        if (isset($pref['save']))
                            $pref['save']($name, $value);
                        else
                            $wgUser->setOption($name, $value);
                        break;
                }
            }
 
            // call parent's function which saves the normal prefs and writes to the db
            parent::savePreferences();
        }
 
        function mainPrefsForm( $status , $message = '' )
        {
            global $wgOut, $wgRequest, $wgUser;
            global $wgExtensionPreferences;
 
            // first get original form, then hack into it new options
            parent::mainPrefsForm($status, $message);
            $html = $wgOut->getHTML();
            $wgOut->clearHTML();
 
            $sections = array();
            foreach ($wgExtensionPreferences as $pref)
            {
                if (! isset($pref['section']) || ! $pref['section'])
                    continue;
                 $section = $pref['section'];
 
                $name = isset($pref['name']) ? $pref['name'] : "";
                $value = "";
                if ($name)
                {
                    if (isset($pref['load']))
                        $value = $pref['load']($name);
                    else
                        $value = $wgUser->getOption($name);
                }
                if ($value === '' && isset($pref['default']))
                    $value = $pref['default'];
 
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
                        $addhtml = "<fieldset><legend>$sectext</legend></fieldset>";
                        $html = preg_replace("/(<div id='prefsubmit'.*)/s", "$addhtml $1", $html);
                    }
 
                }
 
                $type = isset($pref['type']) ? $pref['type'] : PREF_USER_T;
                switch ($type)
                {
		case PREF_TOGGLE_T:
                        $addhtml = $this->getToggle($name);
                        break;
 
		case PREF_INT_T:
		case PREF_TEXT_T:
		case PREF_PASSWORD_T:
                        $size = isset($pref['size']) && $pref['size'] ? "size=\"{$pref['size']}\"" : "";
                        $caption = isset($pref['caption']) && $pref['caption'] ? $pref['caption'] : wfMsg($name);
                        if ($type == PREF_PASSWORD_T)
                            $type = "password";
                        else
                            $type = "text";
                        $addhtml = "<table>" . 
                            $this->addRow("<label for=\"{$name}\">$caption</label>",
                                          "<input type=\"$type\" name=\"{$name}\" value=\"{$value}\" $size />") . "</table>" ;
                        break; 
		case PREF_OPTIONS_T:
			$caption = isset($pref['caption']) && $pref['caption'] ? $pref['caption'] : wfMsg($name);
			$addhtml="$caption <select name=\"$name\" id=\"$name\">";
			if(isset($pref['options'])) {
				$optval=$wgUser->getOption($name);
				$defaultSet=!empty($optval);
				foreach($pref['options'] as $option=>$optionlabel) {
					$sel='';
					if(!$defaultSet && !$option) $sel="SELECTED";
					if($defaultSet && $optval==$option) $sel="SELECTED";
					$addhtml.="<option value=\"$option\" $sel>$optionlabel</option>";				
				}
			}
			$addhtml.="</select>";
			break;
		case PREF_USER_T:
                    default:
                        $addhtml = preg_replace("/@VALUE@/", $value, isset($pref['html']) ? $pref['html'] : "");
                        break;
                }
 
                // the section exists
                $html = preg_replace($regex, "$1 $addhtml $2", $html);
            }
 
            $wgOut->addHTML($html);
 
            // debugging
            //$wgOut->addHTML($wgUser->encodeOptions());
        }
    }
 
    global $wgRequest;
	$prefs = new SpecialPreferencesExtension($wgRequest);
	$prefs->execute();
}
