<?php
/**
 * This Extension provides Special:Protectsite, which makes it possible for
 * users with protectsite permissions to quickly lock down and restore various
 * privileges for anonymous and registered users on a wiki.
 *
 * Knobs:
 * 'protectsite' - Group permission to use the special page.
 * $wgProtectsiteLimit - Maximum time allowed for protection of the site.
 * $wgProtectsiteDefaultTimeout - Default protection time.
 */

if(defined('MEDIAWIKI'))
{
  /* Required Includes */
  require_once($IP.'/includes/BagOStuff.php');
  require_once('HTMLForm.php');

  /* Set the group access permissions */
  $wgGroupPermissions['bureaucrat']['protectsite'] = true;

  /* Register the new user rights level */
  $wgAvailableRights[] = 'protectsite';

  /* Add this Special page to the Special page listing array */
  $wgSpecialPages['Protectsite'] = array('SpecialPage','Protectsite','protectsite');

  /* Register initialization function */
  $wgExtensionFunctions[] = 'wfSetupProtectsite';

  /* Extension Credits.  Splarka wants me to be so UN:VAIN!  Haet haet hat! */
  $wgExtensionCredits['specialpage'][] = array(
    'name'        => 'Protect Site',
    'version'     => '0.1',
    'description' => 'allows a site administrator to temporarily block various site modifications',
    'author'      => '[mailto:e.wolfie@gmail.com Eric Johnston] ' .
                     '<nowiki>[</nowiki>' .
                     '[http://uncyclopedia.org/wiki/User:Dawg Uncyclopedia:Dawg]' .
                     '<nowiki>]</nowiki>',
  );

  /* Set the default timeout if not set in the configuration. */
  if (!isset($wgProtectsiteDefaultTimeout))
  { $wgProtectsiteDefaultTimeout = '1 hour'; }

  /**
   * Function needed to load the Special:Protectsite page object and execute it.
   * This function is expected to be defined, and if not defined, the Special
   * Pages object will try to require_once a php file in /includes/.  We do not
   * want this to happen, so we declare the function here and call the class
   * from within.
   */
  function wfSpecialProtectsite()
  {
    global $wgRequest;
    $form = new ProtectsiteForm($wgRequest);
  }

  /* Class that handles the actual Special:Protectsite page */
  class ProtectsiteForm extends HTMLForm
  {
    var $mName, $mRequest, $action, $persist_data;

    function ProtectsiteForm (&$request)
    {
      global $wgMessageCache;

      $titleObj = Title::makeTitle( NS_SPECIAL, 'Protectsite' );
      $this->action = $titleObj->escapeLocalURL();
      $this->mRequest =& $request;
      $this->mName = 'protectsite';
      $this->persist_data = new MediaWikiBagOStuff('objectcache');

      /**
       * These are dynamically created here because they don't need to vary
       * from the common messages and they save on the total count.
       */
      $wgMessageCache->addMessages(
        array(
          'protectsite-createaccount-0' => wfMsg('protectsite-allowall'),
          'protectsite-createaccount-1' => wfMsg('protectsite-allowusersysop'),
          'protectsite-createaccount-2' => wfMsg('protectsite-allowsysop'),
          'protectsite-createpage-0' => wfMsg('protectsite-allowall'),
          'protectsite-createpage-1' => wfMsg('protectsite-allowusersysop'),
          'protectsite-createpage-2' => wfMsg('protectsite-allowsysop'),
          'protectsite-edit-0' => wfMsg('protectsite-allowall'),
          'protectsite-edit-1' => wfMsg('protectsite-allowusersysop'),
          'protectsite-edit-2' => wfMsg('protectsite-allowsysop'),
          'protectsite-move-0' => wfMsg('protectsite-allowusersysop'),
          'protectsite-move-1' => wfMsg('protectsite-allowsysop'),
          'protectsite-upload-0' => wfMsg('protectsite-allowusersysop'),
          'protectsite-upload-1' => wfMsg('protectsite-allowsysop')
        )
      );

      /* Get data into the value variable/array */
      $prot = $this->persist_data->get('protectsite');

      /* If this was a GET request */
      if (!$this->mRequest->wasPosted())
      {
        /* If $value is an array, protection is set, allow unsetting */
        if (is_array($prot))
        { $this->unProtectsiteForm($prot); }
        else
        /* If $value is not an array, protection is not set */
        { $this->setProtectsiteForm(); }
      }
      else
      /* If this was a POST request, process the data sent */
      {
        if ($this->mRequest->getVal('protect'))
        { $this->setProtectsite(); }
        else
        { $this->unProtectsite(); }
      }
    }

    function setProtectsite()
    {
      global $wgOut, $wgUser, $wgProtectsiteLimit;

      /* Get the request data */
      $request = $this->mRequest->getValues();

      /* Check to see if the time limit exceeds the limit. */
      $curr_time = time();
      if ((($until =strtotime('+' . $request['timeout'], $curr_time)) === false) ||
         ($until < $curr_time))
      {
        $wgOut->addWikiText(wfMsg($this->mName . '-timeout-error'));
        $this->setProtectsiteForm();
      }
      else
      {
        /* Set the array values */
        $prot['createaccount'] = $request['createaccount'];
        $prot['createpage'] = $request['createpage'];
        $prot['edit'] = $request['edit'];
        $prot['move'] = $request['move'];
        $prot['upload'] = $request['upload'];
        $prot['comment'] = isset($request['comment']) ? $request['comment'] : '';

        if (isset($wgProtectsiteLimit) &&
           ($until > strtotime('+' . $wgProtectsiteLimit, $curr_time)))
        { $request['timeout'] = $wgProtectsiteLimit; }

        /* Set the limits */
        $prot['until'] =   strtotime('+' . $request['timeout'], $curr_time);
        $prot['timeout'] = $request['timeout'];

        /* Write the array out to the database */
        $this->persist_data->set('protectsite', $prot, $prot['until']);

        /* Create a log entry */
        $log = new LogPage('protect');
        $log->addEntry('protect', Title::makeTitle(NS_SPECIAL, 'Allpages'),
          $prot['timeout'] .
          (strlen($prot['comment']) > 0 ? '; ' . $prot['comment'] : ''));

        /* Call the Unprotect Form function to display the current state. */
        $this->unProtectsiteForm($prot);
      }
    }

    function unProtectsite()
    {
      global $wgOut;

      /* Get the request data */
      $request = $this->mRequest->getValues();

      /* Remove the data from the database to disable extension. */
      $this->persist_data->delete('protectsite');

      /* Create a log entry */
      $log = new LogPage('protect');
      $log->addEntry('unprotect', Title::makeTitle(NS_SPECIAL, 'Allpages'),
        $request['ucomment']);

      /* Call the Protect Form function to display the current state. */
      $this->setProtectsiteForm();
    }

    /* Override the broken function in the HTMLForm class
     * This was fixed in r16320 of the MW source; WM bugzilla bug #7188.
     * Remove from source once 1.8+ is required for use of this extension.
     */
    function radiobox($varname, $fields)
    {
      $s = '';
      foreach ($fields as $value => $checked)
      {
        $s .= "<div><label><input type='radio' name=\"{$varname}\" value=\"{$value}\"" .
          ($checked ? ' checked="checked"' : '') . " />" .
          wfMsg($this->mName . '-' . $varname . '-' . $value) .
          "</label></div>\n";
      }

      return $this->fieldset($varname, $s);
    }

    /* Overridden textbox method, allowing for the inclusion of something
     * after the text box itself.
     */
    function textbox($varname, $value='', $append='')
    {
      if ($this->mRequest->wasPosted())
      { $value = $this->mRequest->getText( $varname, $value ); }

      $value = htmlspecialchars( $value );
      return "<div><label>". wfMsg( $this->mName.'-'.$varname ) .
             "<input type='text' name=\"{$varname}\" value=\"{$value}\"" .
             " /> " . $append . "</label></div>\n";
    }

    /* This function outputs the field status. */
    function showField($name, $state)
    {
      return '<b>' . wfMsg($this->mName . '-' . $name) . ' - <i>' .
             '<span style="color: ' . (($state > 0) ? 'red' : 'green') . '">' .
             wfMsg($this->mName . '-' . $name . '-' . $state) . '</span>' .
             "</i></b><br />\n";
    }

    function unProtectsiteForm($prot)
    {
      global $wgOut, $wgLang;

      /* Construct page data and add to output. */
      $wgOut->addWikiText(wfMsg('protectsite-text-unprotect'));
      $wgOut->addHTML(
        '<form name="unProtectsite" action="' . $this->action . '" method="post">' . "\n" .
          $this->fieldset('title',
            $this->showField('createaccount', $prot['createaccount']) .
            $this->showField('createpage', $prot['createpage']) .
            $this->showField('edit', $prot['edit']) .
            $this->showField('move', $prot['move']) .
            $this->showField('upload', $prot['upload']) .
            '<b>' . wfMsg($this->mName . '-timeout') . '</b> ' .
            '<i>' . $wgLang->timeAndDate(wfTimestamp(TS_MW, $prot['until']), true) . '</i>' .
            '<br />' .
            ($prot['comment'] != '' ?
            '<b>' . wfMsg($this->mName . '-comment') . '</b> ' .
            '<i>' . $prot['comment'] . '</i>' .
            "<br />" : '') .
            "<br />\n" .
            $this->textbox('ucomment') .
            '<br />' .
            wfElement('input', array(
              'type'  => 'submit',
              'name'  => 'unprotect',
              'value' => wfMsg($this->mName . '-unprotect'))
            )
          ) .
        '</form>'
      );
    }

    function setProtectsiteForm()
    {
      global $wgOut, $wgProtectsiteDefaultTimeout, $wgProtectsiteLimit;

      $request = $this->mRequest->getValues();
      $createaccount = array(0 => false, 1 => false, 2 => false);
      $createaccount[(isset($request['createaccount']) ? $request['createaccount'] : 0)] = true;
      $createpage = array(0 => false, 1 => false, 2 => false);
      $createpage[(isset($request['createpage']) ? $request['createpage'] : 0)] = true;
      $edit = array(0 => false, 1 => false, 2 => false);
      $edit[(isset($request['edit']) ? $request['edit'] : 0)] = true;
      $move = array(0 => false, 1 => false);
      $move[(isset($request['move']) ? $request['move'] : 0)] = true;
      $upload = array(0 => false, 1 => false);
      $upload[(isset($request['upload']) ? $request['upload'] : 0)] = true;

      /* Construct page data and add to output. */
      $wgOut->addWikiText(wfMsg('protectsite-text-protect'));
      $wgOut->addHTML(
        '<form name="Protectsite" action="' . $this->action . '" method="post">' . "\n" .
          $this->fieldset('title',
            $this->radiobox('createaccount', $createaccount) .
            $this->radiobox('createpage', $createpage) .
            $this->radiobox('edit', $edit) .
            $this->radiobox('move', $move) .
            $this->radiobox('upload', $upload) .
            $this->textbox('timeout', $wgProtectsiteDefaultTimeout,
            (isset($wgProtectsiteLimit) ?
              ' (' . wfMsg('protectsite-maxtimeout') . $wgProtectsiteLimit . ')' :
              ''
            )) .
            "\n<br />" .
            (isset($request['comment']) ? $this->textbox('comment', $request['comment']) : '') .
            "\n<br />" .
            wfElement('input', array(
              'type'  => 'submit',
              'name'  => 'protect',
              'value' => wfMsg($this->mName . '-protect'))
            )
          ) .
        '</form>'
      );
    }
  }

  /**
   * This function does all the initialization work for the extension.
   * Persistent data is unserialized from a record in the objectcache table
   * which is set in the Special page.  It will change the permissions for
   * various functions for anonymous and registered users based on the data
   * in the array.  The data expires after the set amount of time, just like
   * a block.
   */
  function wfSetupProtectsite()
  {
    /* Globals */
    global $wgOut, $wgMessageCache, $wgUser, $wgGroupPermissions, $wgVersion;

    /* Set Page Name/Title */
    $wgMessageCache->addMessages(
      array(
        'protectsite' => 'Protect site',
        'protectsite-text-protect' => '<!-- Instructions/Comments/Policy for use -->',
        'protectsite-text-unprotect' => '<!-- Instructions/Comments when protected -->',
        'protectsite-title' => 'Site protection settings',
        'protectsite-allowall' => 'All users',
        'protectsite-allowusersysop' => 'Registered users and sysops',
        'protectsite-allowsysop' => 'Sysops only',
        'protectsite-createaccount' => 'Allow creation of new accounts by',
        'protectsite-createpage' => 'Allow creation of pages by',
        'protectsite-edit' => 'Allow editing of pages by',
        'protectsite-move' => 'Allow moving of pages by',
        'protectsite-upload' => 'Allow file uploads by',
        'protectsite-timeout' => 'Timeout: ',
        'protectsite-timeout-error' => "'''Invalid Timeout.'''",
        'protectsite-maxtimeout' => 'Maximum: ',
        'protectsite-comment' => 'Comment: ',
        'protectsite-ucomment' => 'Unprotect comment: ',
        'protectsite-until' => 'Protected until: ',
        'protectsite-protect' => 'Protect',
        'protectsite-unprotect' => 'Unprotect',
      )
    );

    /* Initialize Object */
    $persist_data = new MediaWikiBagOStuff('objectcache');

    /* Get data into the prot hash */
    $prot = $persist_data->get('protectsite');

    /* Chop a single named value out of an array and return the new array.
     * This is required for 1.7 compatibility.
     * Remove from source once 1.8+ is required for use of this extension.
     */
    function chop_array($arr,$value)
    {
      if (in_array($value, $arr))
      {
        foreach ($arr as $val)
        {
          if ($val != $value)
          { $ret[] = $val; }
        }
        return $ret;
      }
      else
      { return $arr; }
    }

    /* Logic to disable the selected user rights */
    if (is_array($prot))
    {
      /* MW doesn't timout correctly, this handles it */
      if (time() >= $prot['until'])
      { $persist_data->delete('protectsite'); }

      /* Protection-related code */
      if (version_compare($wgVersion,'1.8','>='))
      {
        /* Code for MediaWiki 1.8 */
        $wgGroupPermissions['*']['createaccount'] = !($prot['createaccount'] >= 1);
        $wgGroupPermissions['user']['createaccount'] = !($prot['createaccount'] == 2);

        $wgGroupPermissions['*']['createpage'] = !($prot['createpage'] >= 1);
        $wgGroupPermissions['*']['createtalk'] = !($prot['createpage'] >= 1);
        $wgGroupPermissions['user']['createpage'] = !($prot['createpage'] == 2);
        $wgGroupPermissions['user']['createtalk'] = !($prot['createpage'] == 2);

        $wgGroupPermissions['*']['edit'] = !($prot['edit'] >= 1);
        $wgGroupPermissions['user']['edit'] = !($prot['edit'] == 2);
        $wgGroupPermissions['sysop']['edit'] = true;

        $wgGroupPermissions['user']['move'] = !($prot['move'] == 1);
        $wgGroupPermissions['user']['upload'] = !($prot['upload'] == 1);
        $wgGroupPermissions['user']['reupload'] = !($prot['upload'] == 1);
        $wgGroupPermissions['user']['reupload-shared'] = !($prot['upload'] == 1);
      }
      else
      {
        /* Code for MediaWiki 1.7 (and possibly below) */
        if (!in_array('sysop',$wgUser->mGroups) &&
            !in_array('bureaucrat',$wgUser->mGroups))
        {
          if ($wgUser->mId == 0)
          {
            if ($prot['createaccount'] >= 1)
            { $wgUser->mRights = chop_array($wgUser->mRights,'createaccount'); }

            if ($prot['createpage'] >= 1)
            {
              $wgUser->mRights = chop_array($wgUser->mRights,'createpage');
              $wgUser->mRights = chop_array($wgUser->mRights,'createtalk');
            }

            if ($prot['edit'] >= 1)
            { $wgUser->mRights = chop_array($wgUser->mRights,'edit'); }
          }
          else
          {
            if ($prot['createaccount'] == 2)
            { $wgUser->mRights = chop_array($wgUser->mRights,'createaccount'); }

            if ($prot['createpage'] == 2)
            {
              $wgUser->mRights = chop_array($wgUser->mRights,'createpage');
              $wgUser->mRights = chop_array($wgUser->mRights,'createtalk');
            }

            if ($prot['edit'] == 2)
            { $wgUser->mRights = chop_array($wgUser->mRights,'edit'); }

            if ($prot['move'] == 1)
            { $wgUser->mRights = chop_array($wgUser->mRights,'move'); }

            if ($prot['upload'] == 1)
            {
              $wgUser->mRights = chop_array($wgUser->mRights,'upload');
              $wgUser->mRights = chop_array($wgUser->mRights,'reupload');
              $wgUser->mRights = chop_array($wgUser->mRights,'reupload-shared');
            }
          }
        }
      }
    }
  }
}

?>
