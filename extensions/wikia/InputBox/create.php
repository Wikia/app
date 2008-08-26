<?php
/*

 This extension defines a new action for use with the InputBox extension.
 After installation, modify the InputBox code so that the creation form has
 action=create instead of action=edit.  Optionally, you may also define
 an extra parameter named "prefix", which will prepend itself to the
 text input upon submission.

 Author: Algorithm [http://meta.wikimedia.org/wiki/User:Algorithm]
 Version 0.1 2/23/06

*/

$wgHooks['UnknownAction'][] = 'actionCreate';
$wgExtensionCredits['parserhook'][] = array(
'name' => 'actionCreate',
'author' => 'Algorithm',
'url' => 'http://meta.wikimedia.org/wiki/User:Algorithm/actionCreate',
);

/* Define default messages; these can be overwritten by MediaWiki: page content */
$wgCreateMessages = array('create' => "Create",
    'createmessage' => "'''ERROR:''' The article you are attempting to create already exists.");

function actionCreate($action, $article)
{
    if($action != 'create') return true;
    global $wgRequest, $wgTitle, $wgOut;
    if($prefix = $wgRequest->getVal('prefix')) {
        $title = $wgRequest->getVal('title');
        if(strpos($title, $prefix)!==0)
            $title = $prefix . $title;
        $title = Title::newFromText( $title );
        if(is_null($title)) {
            $wgTitle = Title::newFromText( wfMsgForContent( 'badtitle' ) );
            $wgOut->errorpage( 'badtitle', 'badtitletext' );
        } else if($title->getArticleID() == 0) {
            acRedirect($title, 'edit');
        } else {
            acRedirect($title, 'create');
        }
    } else if( $wgRequest->getVal('section')=='new' || $article->getID() == 0 ) {
        acRedirect($article->getTitle(), 'edit');
    } else {
        $text = $wgTitle->getPrefixedText();
        $wgOut->setPageTitle( $text );
        $wgOut->setHTMLTitle(wfMsg('pagetitle', $text.' - '.acMsg('create')));
        $text = "<div align='center'>" . acMsg('createmessage') .
            "</div>\n<inputbox>\ntype=create\ndefault=" . $text;
        if($arg = $wgRequest->getVal('preload'))
            $text .= "\npreload=" . $arg;
        if($arg = $wgRequest->getVal('editintro'))
            $text .= "\neditintro=" . $arg;
        $wgOut->addWikiText( $text . "\n</inputbox>" );
    }
    return false;
}

function acMsg($key)
{
    $msg = wfMsg($key);
    if( $msg === "&lt;$key&gt;" ) // NOTE: Replace with wfEmptyMsg when defined
    {
        global $wgCreateMessages;
        return $wgCreateMessages[$key];
    }
    return $msg;
}

function acRedirect($title, $action)
{
    global $wgRequest, $wgOut;
    $query = "action={$action}&section=" . $wgRequest->getVal('section') .
        "&preload=" . $wgRequest->getVal('preload') .
        "&editintro=" . $wgRequest->getVal('editintro');
    $wgOut->setSquidMaxage( 1200 );
    $wgOut->redirect($title->getFullURL( $query ), '301');
}

?>
