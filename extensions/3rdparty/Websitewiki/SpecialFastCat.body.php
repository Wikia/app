<?php

function errjump( $num )
{
	global $wgOut;

	$wgOut->redirect( 'http://websitewiki.wikia.com/' );
}

class FastCat extends UnlistedSpecialPage {

        /**
         * Constructor
         */
        public function __construct() {
                parent::__construct( 'FastCat' /*class*/ );
        }


function execute( $par ) {
	global $wgUser, $wgOut;

	if ( wfReadOnly() ) {
		$wgOut->readOnlyPage();
	}

  if(!is_object($wgUser) || User::isIP($wgUser->getName()))
    errjump();

  $artid = "";
  $spice = "";
  $artname = "";
  $cat = "";
  
  if(isset($_POST["id"]))
    $artid = $_POST["id"];
  if(isset($_POST["spice"]))
    $spice = $_POST["spice"];
  if(isset($_POST["artname"]))
    $artname = $_POST["artname"];
  if(isset($_POST["cat"]))
    $cat = $_POST["cat"];
  
  if( !$spice || !$artname || !$cat)
    errjump( 1 );

  $myspice = sha1("Kroko-katMeNot-$artid-$artname-NotMekat-Schnapp");
  
  if($spice != $myspice)
    errjump( 2 );
  
  $title = Title::newFromText( $artname );
  if ( !$title ) 
    errjump( 3 );

  $rev = Revision::newFromTitle( $title );

//   echo "cat $cat";
  if( $rev && (strstr($rev->getText(), "[[Kategorie:Keine]]")))
  {
    $newtext = ereg_replace("\[\[Kategorie:Keine\]\]", "[[Kategorie:$cat]]", $rev->getText());

    if(strcmp($newtext, $rev->getText()))
    {
      $article = new Article( $title );
      $article->updateArticle( $newtext, "QuickKat:$cat", false, false );

	$wgOut->redirect( $title->getFullUrl() );
    }
  } else {
	  errjump( 4 );
  }
}

}
