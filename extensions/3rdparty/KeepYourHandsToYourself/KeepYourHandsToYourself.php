<?php
/*
 * KeepYourHandsToYourself.php - Keeps users from editing other users pages.
 * @author Jim R. Wilson
 * @version 0.1
 * @copyright Copyright (C) 2007 Jim R. Wilson
 * @license The MIT License - http://www.opensource.org/licenses/mit-license.php
 * -----------------------------------------------------------------------
 * Description:
 *     This is a MediaWiki extension which prevents users from editing other users
 *     pages or subpages.
 * Requirements:
 *     MediaWiki 1.6.x, 1.8.x, 1.9.x or higher
 *     PHP 4.x, 5.x or higher.
 * Installation:
 *     1. Drop this script (KeepYourHandsToYourself.php) in $IP/extensions
 *         Note: $IP is your MediaWiki install dir.
 *     2. Enable the extension by adding this line to your LocalSettings.php:
 *         require_once('extensions/KeepYourHandsToYourself.php');
 * Version Notes:
 *     version 0.1:
 *         Initial release.
 * -----------------------------------------------------------------------
 * Copyright (c) 2007 Jim R. Wilson
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do
 * so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 * -----------------------------------------------------------------------
 */

# Confirm MW environment
if (defined('MEDIAWIKI')) {

# Credits
$wgExtensionCredits['other'][] = array(
    'name'=>'KeepYourHandsToYourself',
    'author'=>'Jim R. Wilson (wilson.jim.r&lt;at&gt;gmail.com)',
    'url'=>'http://jimbojw.com/wiki/index.php?title=KeepYourHandsToYourself',
    'description'=>'Prevents users from editing other users pages.',
    'version'=>'0.1'
);

# Attach Hook
$wgHooks['userCan'][] = 'keepYourHandsToYourself';

/**
 * Reject edit action if user attempts to edit another users page or subpage
 * Usage: $wgHooks['userCan'][] = 'keepYourHandsToYourself';
 * @param Title $title Title of the article. (passed by reference)
 * @param User $user User attempting action on article - presumably $wgUser. (passed by reference)
 * @param String $action Action being taken on article. (passed by value)
 * @param Mixed $result The result of processing. (passed by reference)
 * @return true Always true so other extensions have a chance to process 'userCan'
 */
function keepYourHandsToYourself($title, $user, $action, $result) {

    # Check for Namespace, edit action, and sysopship
    if (
        $title->getNamespace()!=NS_USER ||
        $action!='edit' ||
        in_array('sysop', $user->getGroups() ||
		in_array('jrsysop', $user->getGroups()) ) #FIXME added jrsysop for ffxi, should use wgGroupPermissions instead
    ) return true;

    # Check if the page name matches or starts with the username
    $name = $user->getName();
    $text = $title->getText();
    if (
        $name==$text ||
        preg_match('/^'.preg_quote($name).'\\//', $text)
    ) return true;

    # If we got this far, then it's a user trying to edit another user's page
    $result = false;
    return true;
}

} # End MW Environment wrapper
?>