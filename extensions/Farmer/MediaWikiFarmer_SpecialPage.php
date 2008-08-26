<?php
/**
 * Created on Jul 20, 2006
 *
 * @author Gregory Szorc <gregory.szorc@gmail.com>
 */

/**
 *
 * @todo Move presentation text into MW messages
 */
class SpecialFarmer extends SpecialPage
{
    /**
     * Class constructor
     */
    public function __construct()
    {
        SpecialPage::SpecialPage('Farmer');
    }

    /**
     * Executes special page
     */
    public function execute($par)
    {
        $wgFarmer = MediaWikiFarmer::getInstance();
        $wgRequest = $wgFarmer->getMWVariable('wgRequest');

        $request = isset($par) ? $par : $wgRequest->getText('request');

        $arr = explode('/', $request);

        if (count($arr) && $arr[0]) {
            if ($arr[0] == 'create') {
                $this->_executeCreate($wgFarmer, isset($arr[1]) ? $arr[1] : null);
            } elseif ($arr[0] == 'manageExtensions') {
                $this->_executeManageExtensions($wgFarmer);
            } elseif ($arr[0] == 'updateList') {
                $this->_executeUpdateList($wgFarmer);
            } elseif ($arr[0] == 'list') {
                $this->_executeList($wgFarmer);
            } elseif ($arr[0] == 'admin') {
                $this->_executeAdminister($wgFarmer);
            } elseif ($arr[0] == 'delete') {
            	$this->_executeDelete($wgFarmer);
            }
        } else {
            //no parameters were given
            //display the main page

            $this->_executeMainPage($wgFarmer);
        }

        $this->setHeaders();
    }

    /**
     * Displays the main page
     */
    protected function _executeMainPage($wgFarmer)
    {
        $wgOut = $wgFarmer->getMWVariable('wgOut');
        $wgUser = $wgFarmer->getMWVariable('wgUser');

        $wgOut->addWikiText( '== ' . wfMsg('farmer-about') . ' ==' );
        $wgOut->addWikiText( wfMsg( 'farmer-about-text' ) );

        $wgOut->addWikiText( '== ' . wfMsg( 'farmer-list-wiki' ). ' ==' );
        $wgOut->addWikiText( '*' . wfMsg( 'farmer-list-wiki-text', 'Special:Farmer/list' ) );

        if ($wgFarmer->getActiveWiki()->isDefaultWiki()) {

            if (MediaWikiFarmer::userCanCreateWiki($wgUser)) {
                $wgOut->addWikiText( '== '. wfMsg( 'farmer-createwiki' ). ' ==' );
                $wgOut->addWikiText( '*' . wfMsg( 'farmer-createwiki-text', 'Special:Farmer/create' ) );
            }

            //if the user is a farmer admin, give them a menu of cool admin tools
            if (MediaWikiFarmer::userIsFarmerAdmin($wgUser)) {
-               $wgOut->addWikiText( '== ' . wfMsg( 'farmer-administration' ).' ==' );
                $wgOut->addWikiText( '=== ' . wfMsg( 'farmer-administration-extension' ).' ===' );
                $wgOut->addWikiText( '*' . wfMsg( 'farmer-administration-extension-text', 'Special:Farmer/manageExtensions' ) );

                $wgOut->addWikiText( '=== ' . wfMsg( 'farmer-admimistration-listupdate' ).' ===' );
                $wgOut->addWikiText( '*' . wfMsg( 'farmer-admimistration-listupdate-text', 'Special:Farmer/updateList' ) );

                $wgOut->addWikiText( '=== ' . wfMsg( 'farmer-administration-delete' ) . ' ===' );
                $wgOut->addWikiText( '*' . wfMsg( 'farmer-administration-delete-text', 'Special:Farmer/delete' ) );

            }
        }

        $wiki = MediaWikiFarmer_Wiki::factory($wgFarmer->getActiveWiki());

        if (MediaWikiFarmer::userIsFarmerAdmin($wgUser) || $wiki->userIsAdmin($wgUser)) {
            $wgOut->addWikiText( '== ' . wfMsg( 'farmer-administer-thiswiki' ). ' ==' );
            $wgOut->addWikiText( '*' . wfMsg( 'farmer-administer-thiswiki-text', 'Special:Farmer/admin' ) );
        }



    }

    /**
     * Displays form to create wiki
     */
    protected function _executeCreate($wgFarmer, $wiki)
    {
        $wgOut = $wgFarmer->getMWVariable('wgOut');
        $wgUser = $wgFarmer->getMWVariable('wgUser');
        $wgTitle = $wgFarmer->getMWVariable('wgTitle');
        $wgRequest = $wgFarmer->getMWVariable('wgRequest');
	$confirmaccount = wfMsg('farmer-button-confirm');

        if (!$wgFarmer->getActiveWiki()->isDefaultWiki()) {
            $wgOut->addWikiText('== '.wfMsg('farmer-notavailable').' ==');
            $wgOut->addWikiText(wfMsg('farmer-notavailable-text'));
            return;
        }

        if (!MediaWikiFarmer::userCanCreateWiki($wgUser, $wiki)) {
            $wgOut->addWikiText(wfMsg('farmercantcreatewikis'));
            return;
        }

        //if something was POST'd
        if ($wgRequest->wasPosted()) {
            $name = MediaWikiFarmer_Wiki::sanitizeName($wgRequest->getVal('name'));
            $title = MediaWikiFarmer_Wiki::sanitizeTitle($wgRequest->getVal('wikititle'));
            $description = $wgRequest->getVal('description');

            //we create the wiki if the user pressed 'Confirm'
            if ($wgRequest->getVal('confirm') == $confirmaccount) {
                $wgUser = $wgFarmer->getMWVariable('wgUser');

                MediaWikiFarmer_Wiki::create($name, $title, $description, $wgUser->getName());

                $wgOut->addWikiText('== '.wfMsg('farmer-wikicreated').' ==');
                $wgOut->addWikiText( wfMsg( 'farmer-wikicreated-text', wfMsg('farmerwikiurl', $name) ) );
                $wgOut->addWikiText( wfMsg( 'farmer-default', '[['.$title.':Special:Farmer|Special:Farmer]]' ) );
                return;
            }

            if ($name && $title && $description) {

                $wiki = new MediaWikiFarmer_Wiki($name);

                if ($wiki->exists() || $wiki->databaseExists()) {
                    $wgOut->addWikiText('== '.wfMsg('farmer-wikiexists').' ==');
                    $wgOut->addWikiText(wfMsg('farmer-wikiexists-text', $name));
                    return;
                }



                $wgOut->addWikiText('== '.wfMsg('farmer-confirmsetting').' ==');
                $wgOut->addWikiText('; '.wfMsg('farmer-confirmsetting-name', $name));
                $wgOut->addWikiText('; '.wfMsg('farmer-confirmsetting-title', $title));
                $wgOut->addWikiText('; '.wfMsg('farmer-confirmsetting-description', $description));

                $wgOut->addWikiText(wfMsg('farmer-confirmsetting-text', $name, $title));
		$nameaccount = htmlspecialchars($name);
		$nametitle = htmlspecialchars($title);
		$namedescript = htmlspecialchars($description);
                $wgOut->addHTML("

<form id=\"farmercreate2\" method=\"post\">
<input type=\"hidden\" name=\"name\" value={$nameaccount} />
<input type=\"hidden\" name=\"wikititle\" value={$nametitle} />
<input type=\"hidden\" name=\"description\" value=\"{$namedescript}\" />
<input type=\"submit\" name=\"confirm\" value={$confirmaccount} />
</form>"
                );

                return;

            }
        }

        if ($wiki && !$name) {
            $name = $wiki;
        }

        $wgOut->addWikiText('= '.wfMsg('farmer-createwiki-form-title').' =');

        $wgOut->addWikiText(wfMsg('farmer-createwiki-form-text1'));

        $wgOut->addWikiText('== '.wfMsg('farmer-createwiki-form-help').' ==');
        $wgOut->addWikiText(wfMsg('farmer-createwiki-form-text2'));
        $wgOut->addWikiText(wfMsg('farmer-createwiki-form-text3'));
        $wgOut->addWikiText(wfMsg('farmer-createwiki-form-text4'));


        $formURL = wfMsgHTML('farmercreateurl');
        $formSitename = wfMsgHTML('farmercreatesitename');
        $formNextStep = wfMsgHTML('farmercreatenextstep');

        $token = htmlspecialchars( $wgUser->editToken() );

        $wgOut->addHTML( "
<form id='farmercreate1' method='post' action=\"$action\">
    <table>
        <tr>
            <td align=\"right\">". wfMsg('farmer-createwiki-user') . "</td>
            <td align=\"left\"><b>{$wgUser->getName()}</b></td>
        </tr>
        <tr>
            <td align='right'>". wfMsg('farmer-createwiki-name') . "</td>
            <td align='left'><input tabindex='1' type='text' size='20' name='name' value=\"" . htmlspecialchars($name) . "\" /></td>
    </tr>
    <tr>
        <td align='right'>". wfMsg('farmer-createwiki-title') ."</td>
        <td align='left'><input tabindex='1' type='text' size='20' name='wikititle' value=\"" . htmlspecialchars($title) . "\"/></td>
    </tr>
    <tr>
         <td align='right'>". wfMsg('farmer-createwiki-description') ."</td>
         <td align='left'><textarea tabindex='1' cols=\"40\" rows=\"5\" name='description'>" . htmlspecialchars($description) . "</textarea></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td align='right'><input type='submit' name='submit' value=\"". wfMsg('farmer-button-submit') . "\" /></td>
        </tr>
    </table>
    <input type='hidden' name='token' value=\"$token\" />
</form>");

    }

    protected function _executeUpdateList(&$wgFarmer)
    {
        $wgUser = $wgFarmer->getMWVariable('wgUser');
        $wgOut = $wgFarmer->getMWVariable('wgOut');
        /*
        if (!MediaWikiFarmer::userIsFarmerAdmin($wgUser)) {
            $wgOut->addWikiText('==Permission Denied==');

            return;
        }
        */
        $wgFarmer->updateFarmList();

        $wgOut->addWikiText('== '.wfMsg('farmer-updatedlist').' ==');
    }

    protected function _executeDelete(&$wgFarmer)
    {
        $wgOut = $wgFarmer->getMWVariable('wgOut');
        $wgUser = $wgFarmer->getMWVariable('wgUser');

        if (!$wgFarmer->getActiveWiki()->isDefaultWiki()) {
        	$wgOut->addWikiText('== '.wfMsg('farmer-notaccessible').' ==');
            $wgOut->addWikiText(wfMsg('farmer-notaccessible-test'));
            return;
        }

        if (!MediaWikiFarmer::userIsFarmerAdmin($wgUser)) {
        	$wgOut->addWikiText('== '.wfMsg('farmer-permissiondenied').' ==');
            $wgOut->addWikiText(wfMsg('farmer-permissiondenied-text'));
            return;
        }

        $wgRequest = $wgFarmer->getMWVariable('wgRequest');

        if ( ($wiki = $wgRequest->getVal('wiki')) && $wiki != '-1') {
            $wgOut->addWikiText('== '.wfMsg('farmer-deleting', $wiki) .' ==');

            $deleteWiki = MediaWikiFarmer_Wiki::factory($wiki);

            $wgFarmer->deleteWiki($deleteWiki);
        }

        $list = $wgFarmer->getFarmList();

        $wgOut->addWikiText('== '.wfMsg('farmer-delete-title').' ==');
        $wgOut->addWikiText(wfMsg('farmer-delete-text'));

        $wgOut->addHTML('<form method="post" name="deleteWiki"><select name="wiki"><option value="-1">'.wfMsg('farmer-delete-form').'</option>');

        foreach ($list as $wiki) {
        	if ($wiki['name'] != $wgFarmer->getDefaultWiki()) {
                $wgOut->addHTML('<option value="'.$wiki['name'].'">'.$wiki['name'] . ' - ' . $wiki['title'] . '</option>');
            }
        }

        $wgOut->addHTML('</select><input type="submit" name="submit" value="'.wfMsg('farmer-delete-form-submit').'" /></form>');

    }

    protected function _executeList(&$wgFarmer)
    {
        $list = $wgFarmer->getFarmList();

        $wgOut = $wgFarmer->getMWVariable('wgOut');

        $wgOut->addWikiText('== '.wfMsg('farmer-listofwikis').' ==');

        foreach ($list as $wiki) {
            $wgOut->addWikiText('; [[' . $wiki['title'] .':'.wfMsg('farmer-mainpage').'|'.$wiki['title'].']] : ' . $wiki['description']);
        }
    }

    protected function _executeAdminister(&$wgFarmer)
    {
        $wgUser = $wgFarmer->getMWVariable('wgUser');
        $wgOut = $wgFarmer->getMWVariable('wgOut');
        $wgRequest = $wgFarmer->getMWVariable('wgRequest');

        $currentWiki = MediaWikiFarmer_Wiki::factory($wgFarmer->getActiveWiki());

        $action = Title::makeTitle(NS_SPECIAL, 'Farmer/admin')->escapeLocalURL();

        if (!(MediaWikiFarmer::userIsFarmerAdmin($wgUser) || $currentWiki->userIsAdmin($wgUser))) {
            $wgOut->addWikiText('== '.wfMsg('farmer-permissiondenied').' ==');
            $wgOut->addWikiText(wfMsg('farmer-permissiondenied-text1'));
            return;
        }

        $wgOut->addWikiText('== '.wfMsg('farmer-basic-title').' ==');

        $wiki = $wgFarmer->getActiveWiki();

        if ($title = $wgRequest->getVal('wikiTitle')) {
            $wiki->title = MediaWikiFarmer_Wiki::sanitizeTitle($title);
            $wiki->save();
            $wgFarmer->updateFarmList();
        }

        if ($description = $wgRequest->getVal('wikiDescription')) {
        	$wiki->description = $description;
            $wiki->save();
            $wgFarmer->updateFarmList();
        }

        if ($permissions = $wgRequest->getArray('permission')) {
        	foreach ($permissions['*'] as $k=>$v) {
        		$wiki->setPermissionForAll($k, $v);
        	}

            foreach ($permissions['user'] as $k=>$v) {
            	$wiki->setPermissionForUsers($k, $v);
            }

            $wiki->save();
        }

        if (!$wiki->title) {
            $wgOut->addWikiText('=== '.wfMsg('farmer-basic-title1').' ===');
            $wgOut->addWikiText(wfMsg('farmer-basic-title1-text'));

            $wgOut->addHTML('<form method="post" name="wikiTitle" action="'.$action.'">' .
                    '<input name="wikiTitle" size="30" value="'. $wiki->title . '" />' .
                    '<input type="submit" name="submit" value="'.wfMsg('farmer-button-submit').'" />' .
                    '</form>'
                   );
        }

        $wgOut->addWikiText('=== '.wfMsg('farmer-basic-description').' ===');
        $wgOut->addWikiText(wfMsg('farmer-basic-description-text'));

        $wgOut->addHTML('<form method="post" name="wikiDescription" action="'.$action.'">'.
            '<textarea name="wikiDescription" rows="5" cols="30">'.htmlspecialchars($wiki->description).'</textarea>'.
            '<input type="submit" name="submit" value="'.wfMsg('farmer-button-submit').'" />'.
            '</form>'
            );

        $wgOut->addWikiText('== '.wfMsg('farmer-basic-permission').' ==');
        $wgOut->addWikiText(wfMsg('farmer-basic-permission-text'));

        $wgOut->addHTML('<form method="post" name="permissions" action="'.$action.'">');

        $wgOut->addWikiText('=== '.wfMsg('farmer-basic-permission-visitor').' ===');
        $wgOut->addWikiText(wfMsg('farmer-basic-permission-visitor-text'));

        $doArray = array(
            array('read', wfMsg('farmer-basic-permission-view')),
            array('edit', wfMsg('farmer-basic-permission-edit')),
            array('createpage', wfMsg('farmer-basic-permission-createpage')),
            array('createtalk', wfMsg('farmer-basic-permission-createtalk'))
        );

        foreach ($doArray as $arr) {
        	$this->_doPermissionInput($wgOut, $wiki, '*', $arr[0], $arr[1]);
        }

        $wgOut->addWikiText('=== '.wfMsg('farmer-basic-permission-user').' ===');
        $wgOut->addWikiText(wfMsg('farmer-basic-permission-user-text'));

        $doArray = array(
            array('read', wfMsg('farmer-basic-permission-view')),
            array('edit', wfMsg('farmer-basic-permission-edit')),
            array('createpage', wfMsg('farmer-basic-permission-createpage')),
            array('createtalk', wfMsg('farmer-basic-permission-createtalk')),
            array('move', wfMsg('farmer-basic-permission-move')),
            array('upload', wfMsg('farmer-basic-permission-upload')),
            array('reupload', wfMsg('farmer-basic-permission-reupload')),
            array('minoredit', wfMsg('farmer-basic-permission-minoredit'))
        );

        foreach ($doArray as $arr) {
        	$this->_doPermissionInput($wgOut, $wiki, 'user', $arr[0], $arr[1]);
        }

        $wgOut->addHTML('<input type="submit" name="setPermissions" value="'.wfMsg('farmer-setpermission').'" />');

        $wgOut->addHTML("</form>\n\n\n");


        $wgOut->addWikiText("== ".wfMsg('farmer-defaultskin')." ==");

        if ($newSkin = $wgRequest->getVal('defaultSkin')) {
        	$wiki->wgDefaultSkin = $newSkin;
            $wiki->save();
        }

        $defaultSkin = $wgFarmer->getActiveWiki()->wgDefaultSkin;

        if (!$defaultSkin) {
            $defaultSkin = 'MonoBook';
        }

        $skins = Skin::getSkinNames();
        $skipSkins = $wgFarmer->getMWVariable('wgSkipSkins');

        foreach ($skipSkins as $skin) {
            if (array_key_exists($skin, $skins)) {
                unset($skins[$skin]);
            }
        }

        $wgOut->addHTML('<form method="post" name="formDefaultSkin" action="'.$action.'">');

        foreach ($skins as $k=>$skin) {
        	$toAdd = '<input type="radio" name="defaultSkin" value="'.$k.'"';

            if ($k == $defaultSkin) {
            	$toAdd .= ' checked="checked" ';
            }

            $toAdd .= '/>' . $skin;

            $wgOut->addHTML($toAdd . "<br />\n");
        }

        $wgOut->addHTML('<input type="submit" name="submitDefaultSkin" value="'.wfMsg('farmer-defaultskin-button').'" />');

        $wgOut->addHTML('</form>');

        /**
         * Manage active extensions
         */
        $wgOut->addWikiText('== '.wfMsg('farmer-extensions').' ==');

        $extensions = $wgFarmer->getExtensions();

        //if we post a list of new extensions, wipe the old list from the wiki
        if ($wgRequest->getVal('submitExtension')) {
        	$wiki->extensions = array();
        }

        //go through all posted extensions and add the appropriate ones
        foreach ((array)$wgRequest->getArray('extension') as $k=>$e) {

            if (array_key_exists($k, $extensions)) {
        		$wiki->addExtension($extensions[$k]);
        	}
        }

        $wiki->save();


        $wgOut->addHTML('<form method="post" name="formActiveExtensions" action="'.$action.'">');

        foreach ($extensions as $extension) {
        	$toAdd = '<input type="checkbox" name="extension['.$extension->name.']" ';

            if ($wiki->hasExtension($extension)) {
            	$toAdd .= 'checked="checked" ';
            }

            $toAdd .=' /><strong>'.htmlspecialchars($extension->name) . '</strong> - ' . htmlspecialchars($extension->description) . "<br />\n";

            $wgOut->addHTML($toAdd);
        }

        $wgOut->addHTML('<input type="submit" name="submitExtension" value="'.wfMsg('farmer-extensions-button').'" />');

        $wgOut->addHTML('</form>');

    }

    /**
     * Handles page to manage extensions
     */
    protected function _executeManageExtensions(&$wgFarmer)
    {
        $wgUser = $wgFarmer->getMWVariable('wgUser');
        $wgOut = $wgFarmer->getMWVariable('wgOut');

        //quick security check
        if (!MediaWikiFarmer::userIsFarmerAdmin($wgUser)) {
            $wgOut->addWikiText('== '.wfMsg('farmer-permissiondenied').' ==');
            $wgOut->addWikiText(wfMsg('farmer-extensions-extension-denied'));
            return;
        }

        //look and see if a new extension was registered
        $wgRequest = $wgFarmer->getMWVariable('wgRequest');

        if ($wgRequest->wasPosted()) {
            $name = $wgRequest->getVal('name');
            $description = $wgRequest->getVal('description');
            $include = $wgRequest->getVal('include');

            $extension = new MediaWikiFarmer_Extension($name, $description, $include);

            if (!$extension->isValid()) {
            	$wgOut->addWikiText('== '.wfMsg('farmer-extensions-invalid').' ==');
                $wgOut->addWikiText(wfMsg('farmer-extensions-invalid-text'));
            } else {
                $wgFarmer->registerExtension($extension);
            }
        }


        $wgOut->addWikiText('== '.wfMsg('farmer-extensions-available').' ==');

        $extensions = $wgFarmer->getExtensions();

        if (count($extensions) === 0) {
            $wgOut->addWikiText(wfMsg('farmer-extensions-noavailable'));
        } else {
            foreach ($wgFarmer->getExtensions() as $extension) {
                $wgOut->addWikiText('; ' . htmlspecialchars($extension->name) . ' : ' . htmlspecialchars($extension->description));
            }
        }

        $wgOut->addWikiText('== '.wfMsg('farmer-extensions-register').' ==');
        $wgOut->addWikiText(wfMsg('farmer-extensions-register-text1'));

        $wgOut->addWikiText(wfMsg('farmer-extensions-register-text2'));
        $wgOut->addWikiText(wfMsg('farmer-extensions-register-text3'));

        $wgOut->addWikiText(wfMsg('farmer-extensions-register-text4'));

        foreach (explode(PATH_SEPARATOR, get_include_path()) as $path) {
            $wgOut->addWikiText('*' . $path);
        }

        $wgOut->addHTML("
<form id=\"registerExtension\" method=\"post\">
    <table>
        <tr>
            <td align=\"right\">".wfMsg('farmer-extensions-register-name')."</td>
            <td align=\"left\"><input type=\"text\" size=\"20\" name=\"name\" value=\"\" /></td>
        </tr>
        <tr>
            <td align=\"right\">".wfMsg('farmer-description')."</td>
            <td align=\"left\"><input type=\"text\" size=\"50\" name=\"description\" value=\"\" /></td>
        </tr>
        <tr>.
            <td align=\"right\">".wfMsg('farmer-extensions-register-includefile')."</td>
            <td align=\"left\"><input type=\"text\" size=\"50\" name=\"include\" value=\"\" /></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td align=\"right\"><input type=\"submit\" name=\"submit\" value=\"".wfMsg('farmer-button-submit')."\" /></td>
        </tr>
    </table>
</form>");

    }

    /**
     * Creates form element representing an individual permission
     */
    protected function _doPermissionInput(&$wgOut, &$wiki, $group, $permission, $description)
    {
    	$value = $wiki->getPermission($group, $permission);

        $wgOut->addHTML('<p>' . $description . ': ');

        $input = "<input type=\"radio\" name=\"permission[$group][$permission]\" value=\"1\" ";

        if ($wiki->getPermission($group, $permission)) {
        	$input .= 'checked="checked" ';
        }

        $input .= ' />'.wfMsg('farmer-yes').'&nbsp;&nbsp;';

        $wgOut->addHTML($input);

        $input = "<input type=\"radio\" name=\"permission[$group][$permission]\" value=\"0\" ";

        if (!$wiki->getPermission($group, $permission)) {
            $input .= 'checked="checked" ';
        }

        $input .= ' />'.wfMsg('farmer-no');

        $wgOut->addHTML($input . '</p>');

    }

}
