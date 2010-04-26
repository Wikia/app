<?php
 
/**
 * Special page to display events.
 * Events much be stored in articles with [[Category:Events]] and a category for the date, eg [[Category:2006/07/12]]
 * The article can use any name, for example using subpages "Events/2006/07/12/Party at my house". Only the last part of the name is shown when displaying the title.
 * This special page also uses my calendar extension to display a calendar.
 *
 * To install, add this line to LocalSettings.php: require_once("extensions/SpecialEvents.php");
 *
 */
 
if( defined( 'MEDIAWIKI' ) ) {
 
  require_once( 'SpecialPage.php' );

  $wgExtensionFunctions[] = 'efEventsExtn';
  $wgExtensionCredits['specialpage'][] = array( 'name' => 'Events', 'author' => 'Barrylb', 'url' => 'http://www.mediawiki.org/wiki/Extension:Calendar_%28Barrylb%29' );

  function efEventsExtn() {
    global $wgMessageCache;
    SpecialPage::addPage( new EventsExtn() );
    $wgMessageCache->addMessage( 'events', 'Events' );
    $wgMessageCache->addMessage( 'events-header', '' );
  }

  class EventsExtn extends IncludableSpecialPage {

    function EventsExtn() {
      SpecialPage::SpecialPage( 'Events', '', true, false, 'default', true );
    }

    function execute( $par ) {
      global $wgOut, $wgRequest, $wgParser, $wgTitle, $wgUser;
      
      $year = isset($_GET['year']) ? intval($_REQUEST['year']) : null;
      $month = isset($_GET['month']) ? intval($_REQUEST['month']) : null;
      $day = isset($_GET['day']) ? intval($_REQUEST['day']) : null;
      if ($year == "")
        $year = date("Y"); 
      if ($month == "")
        $month = date("m");
        
      if (isset($_GET['category']))
        $catname = htmlspecialchars($_GET['category']);
      else
        $catname = 'Events';
        
      if (isset($_GET['ajax'])) {
        require_once 'Calendar.php';
        $mwCalendar = new mwCalendar();
        $mwCalendar->dateNow($month, $year);
        $mwCalendar->SetCatName($catname);
        $mwCalendar->AjaxPrevNext(true);
        if (isset($_GET['upcoming']) && ($_GET['upcoming'] == 'off'))
          $mwCalendar->ShowUpcoming(false);
        else
          $mwCalendar->ShowUpcoming(true);
        $mwCalendar->ShowCalendar(true);
        echo $mwCalendar->showThisMonth();
        exit;
      }
      
      # Don't show the navigation if we're including the page               
      if( !$this->mIncluding ) {
        $this->setHeaders();
        $wgOut->addWikiText( wfMsg( 'events-header' ) );
      }

      if ($day == "") {
        $wgOut->AddWikiText('<calendar>upcoming=off|ajaxprevnext=off|category=' . $catname . '</calendar>');
        $day = "__";
      }

      //build the SQL query
      $dbr =& wfGetDB( DB_SLAVE );
      $sPageTable = $dbr->tableName( 'page' );
      $categorylinks = $dbr->tableName( 'categorylinks' );
      $sSqlSelect = "SELECT page_namespace, page_title, page_id, clike1.cl_to AS catlike1 ";
      $sSqlSelectFrom = "FROM $sPageTable INNER JOIN $categorylinks AS c1 ON page_id = c1.cl_from AND c1.cl_to='$catname' INNER JOIN $categorylinks " . 
        "AS clike1 ON page_id = clike1.cl_from AND clike1.cl_to LIKE '$year/$month/$day'";
      $sSqlWhere = ' WHERE page_is_redirect = 0 ';
      $sSqlOrderby = ' ORDER BY catlike1 ASC';

      //DEBUG: output SQL query 
      //$wgOut->addHTML('[' . $sSqlSelect . $sSqlSelectFrom . $sSqlWhere . $sSqlOrderby . ']'); 

      $res = $dbr->query($sSqlSelect . $sSqlSelectFrom . $sSqlWhere . $sSqlOrderby);

      $sk =& $wgUser->getSkin();

      while ($row = $dbr->fetchObject( $res ) ) 
      {
        $title = Title::makeTitle( $row->page_namespace, $row->page_title);
        $wgOut->addHTML('<div class="eventsblock">');

        $title_text = $title->getSubpageText();
        $wgOut->addHTML('<b>' .  $sk->makeKnownLinkObj($title, $title_text) . '</b><br>');

        $wl_article = new Article ( $title ) ;
        $wl = $wl_article->getContent();

        $parserOptions = ParserOptions::newFromUser( $wgUser );
        $parserOptions->setEditSection( false );
        $parserOptions->setTidy(true);
        $parserOutput = $wgParser->parse( $wl , $title, $parserOptions );
        $previewHTML = $parserOutput->getText();                        

        $wgOut->addHTML($previewHTML);

        $wgOut->addHTML('</div>');
      }
    }         

  }
 
} else {
  echo( "This is an extension to the MediaWiki package and cannot be run standalone.\n" );
  die( -1 );
}
