<?php
if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	exit( 1 );
}

class SpecialImportUsers extends SpecialPage {

    function SpecialImportUsers() {
	SpecialPage::SpecialPage('ImportUsers' , 'import_users' );
	wfLoadExtensionMessages('ImportUsers');
    }

    function execute( $par ) {
      global $wgOut, $wgUser;
      $wgOut->setArticleRelated( false );
      if( !$wgUser->isAllowed( 'import_users' ) ) {
        $wgOut->permissionRequired( 'import_users' );
        return;
      }
      $wgOut->setPagetitle( wfMsg( 'importusers' ) );
      if (IsSet($_FILES['users_file'])) {
        $wgOut->addHTML( $this->AnalizeUsers($_FILES['users_file'],IsSet($_POST['replace_present'])) );
      } else {
        $wgOut->addHTML( $this->MakeForm() );
      }
    }

    function MakeForm() {
      $titleObj = Title::makeTitle( NS_SPECIAL, 'ImportUsers' );
      $action = $titleObj->escapeLocalURL();
      $output ='<form enctype="multipart/form-data" method="post"  action="'.$action.'">';
      $output.='<dl><dt>'. wfMsg('importusers-form-file') .'</dt><dd>'. wfMsg('importusers-login-name'). ', '. wfMsg('importusers-password') . ', ' . wfMsg('importusers-email') . ', ' . wfMsg('importusers-realname') . '.</dd></dl>';
      $output.='<fieldset><legend>' . wfMsg('importusers-uploadfile') . '</legend>';
      $output.='<table border=0 a-valign=center width=100%>';
      $output.='<tr><td align=right width=160>'.wfMsg( 'importusers-form-caption' ).': </td><td><input name="users_file" type="file" size=40 /></td></tr>';
      $output.='<tr><td align=right></td><td><input name="replace_present" type="checkbox" />'.wfMsg( 'importusers-form-replace-present' ).'</td></tr>';
      $output.='<tr><td align=right></td><td><input type="submit" value="'.wfMsg( 'importusers-form-button' ).'" /></td></tr>';
      $output.='</table>';
      $output.='</fieldset>';
      $output.='</form>';
      return $output;
    }

    function AnalizeUsers($fileinfo,$replace_present) {
      global $IP, $wgOut;
      require_once "$IP/includes/User.php";
      $summary=array('all'=>0,'added'=>0,'updated'=>0);
      $filedata=explode("\n",rtrim(file_get_contents($fileinfo['tmp_name'])));
      $output='<h2>'.wfMsg( 'importusers-log' ).'</h2>';
      foreach ($filedata as $line=>$newuserstr) {
        $newuserarray=explode(',', trim( $newuserstr ) );
        if (count($newuserarray)<2) {
          $output.=sprintf(wfMsg( 'importusers-user-invalid-format' ) ,$line+1 ).'<br />';
          continue;
        }
        if (!IsSet($newuserarray[2])) $newuserarray[2]='';
        if (!IsSet($newuserarray[3])) $newuserarray[3]='';
        $NextUser=User::newFromName( $newuserarray[0] );
        $NextUser->setEmail( $newuserarray[2] );
        $NextUser->setRealName( $newuserarray[3] );
        $uid=$NextUser->idForName();
        if ($uid===0) {
          $NextUser->addToDatabase();
          $NextUser->setPassword( $newuserarray[1] );
          $NextUser->saveSettings();
          $output.=sprintf(wfMsg( 'importusers-user-added' ) ,$newuserarray[0] ).'<br />';
          $summary['added']++;
        }
        else {
          if ($replace_present) {
            $NextUser->setPassword( $newuserarray[1] );
            $NextUser->saveSettings();
            $output.=sprintf( wfMsg( 'importusers-user-present-update' ) ,$newuserarray[0] ).'<br />';
            $summary['updated']++;
          }
          else $output.=sprintf(wfMsg( 'importusers-user-present-no-update' ) ,$newuserarray[0] ).'<br />';
        }
        $summary['all']++;
      }
      $output.='<b>'.wfMsg( 'importusers-log-summary' ).'</b><br />';
      $output.=wfMsg( 'importusers-log-summary-all' ).' : '.$summary['all'].'<br />';
      $output.=wfMsg( 'importusers-log-summary-added' ).' : '.$summary['added'].'<br />';
      $output.=wfMsg( 'importusers-log-summary-updated' ).' : '.$summary['updated'];
      return $output;
    }
  }
