<?php

function wfSpecialProtectsite() {
	global $wgRequest;
	wfLoadExtensionMessages('SpecialProtectSite');
	$form = new ProtectsiteForm($wgRequest);
}

/* Class that handles the actual Special:Protectsite page */
require 'HTMLForm.php';
class ProtectsiteForm extends HTMLForm
{
  var $mName, $mRequest, $action, $persist_data;

  function ProtectsiteForm (&$request)
  {
    global $wgOut, $wgMessageCache, $wgMemc;

    $titleObj = Title::makeTitle( NS_SPECIAL, 'Protectsite' );
    $this->action = $titleObj->escapeLocalURL();
    $this->mRequest =& $request;
    $this->mName = 'protectsite';

    $wgOut->setPagetitle( wfMsg( $this->mName ) );

    $this->persist_data = new MediaWikiBagOStuff();

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
	$prot = $wgMemc->get('protectsite');
	if( !$prot ) {
		$prot = $this->persist_data->get('protectsite');
	}

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
    global $wgOut, $wgUser, $wgProtectsiteLimit, $wgMemc;

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
      $wgMemc->set('protectsite', $prot, $prot['until']);

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
    global $wgOut, $wgMemc;

    /* Get the request data */
    $request = $this->mRequest->getValues();

    /* Remove the data from the database to disable extension. */
    $this->persist_data->delete('protectsite');
    $wgMemc->delete('protectsite');

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
