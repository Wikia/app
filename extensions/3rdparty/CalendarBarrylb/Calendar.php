<?php
# Calendar Extension 
#   http://www.mediawiki.org/wiki/Extension:Calendar_%28Barrylb%29
# Creates a calendar for the month and optional 'upcoming events' box beneath
# This extension creates links to my Special:Events page to show the events for a particular day or month
#
# Cool new feature: the calendar can use AJAX to dynamically display the next and previous months
# without refreshing an entire page. There are a few requirements: 
#  - You need to put some code in your MediaWiki:common.js page for this to work (see the above link for the code) 
#  - The Special:Events page must be installed and working
#  - Your calendar must be wrapped in an element with id="p-calendar"
#  - Finally, to enable the feature use: <calendar>ajaxprevnext=on</calendar>
#
# Events must be stored in articles with [[Category:Events]] and a category for the date, eg [[Category:2006/07/12]]
# You can change the Events category to something else using the category=xxx option
#
# To install, add this line to LocalSettings.php: require_once("extensions/Calendar.php");
#
# eg <calendar/> shows current month and upcoming events
# Options:
#   upcoming=off to not show upcoming events
#   calendar=off to not show calendar
#   ajaxprevnext=on to use AJAX for previous/next months
#   category=Name to set which category to lookup for events (eg category=Fundraising)
#
# You may combine multiple parameters (eg upcoming=off and ajaxprevnext=on) by using | between them
# eg <calendar>upcoming=off|ajaxprevnext=on</calendar>
#
 
$wgExtensionFunctions[] = "wfCalendarExtension";
$wgExtensionCredits['parserhook'][] = array(
  'name' => 'Calendar',
  'author' => 'Barrylb',
  'description' => 'adds <calender> tag',
  'url' => 'http://www.mediawiki.org/wiki/Extension:Calendar_%28Barrylb%29'
);
 
/* DO NOT EDIT BEYOND THIS LINE */
 
function wfCalendarExtension() {
  global $wgParser;
  $wgParser->setHook( "calendar", "createmwCalendar" );
}
 
# The callback function for converting the input text to HTML output
function createmwCalendar($input)
{
  /**
    * check if date in $_GET-parameter
    * fallback on default this month
    **/
 
  if(isset($_GET['month'])&&(isset($_GET['year'])))
  {
    $month = intval($_GET['month']);
    $month = ($month<10?"0".$month:$month);
    $year = intval($_GET['year']);
  }
  else
  {
    $month = date("m");
    $year = date("Y");
  }

  $mwCalendar = new mwCalendar();
  $mwCalendar->dateNow($month, $year);
  
  preg_match('/category=([^|]*)/', $input, $matches);
  if (isset($matches[1]))
    $mwCalendar->SetCatName($matches[1]);
  
  if (strpos($input,'ajaxprevnext=on') !== false)
    $mwCalendar->AjaxPrevNext(true);
  else
    $mwCalendar->AjaxPrevNext(false);
  if (strpos($input,'upcoming=off') === false)
    $mwCalendar->ShowUpcoming(true);
  else
    $mwCalendar->ShowUpcoming(false);
  if (strpos($input,'calendar=off') === false)
    $mwCalendar->ShowCalendar(true);
  else
    $mwCalendar->ShowCalendar(false);
  return $mwCalendar->showThisMonth();
}
 
class mwCalendar
{
  var $cal = "CAL_GREGORIAN";
  var $today;
  var $day;
  var $month;
  var $year;
  var $pmonth;
  var $pyear;
  var $nmonth;
  var $nyear;
  var $bShowUpcoming;
  var $bShowCalendar;
  var $catname = 'Events';
  var $bAjaxPrevNext = false; /*use AJAX calls for prev/next month links */
  var $wday_start = 1; /* set to 0 for week starting on Sunday; 1 for Monday */
  var $wday_names = array("S","M","T","W","T","F","S"); 
  var $wmonth_names = array("January","February","March","April","May","June","July","August","September","October","November","December");

  function mwCalendar()
  {
    $this->day = "1";
    $today = "";
    $month = "";
    $year = "";
    $pmonth = "";
    $pyear = "";
    $nmonth = "";
    $nyear = "";
  }

  function ShowUpcoming($b)
  {
    $this->bShowUpcoming = $b;
  }

  function ShowCalendar($b)
  {
    $this->bShowCalendar = $b;
  } 

  function AjaxPrevNext($b)
  {
    $this->bAjaxPrevNext = $b;
  } 

  function SetCatName($cn)
  {
    $this->catname = $cn;
  }   
  
  function dateNow($month,$year)
  {
    $this->month = $month;
    $this->year = $year;
    $this->today = strftime("%d",time());
    $this->pmonth = $this->month - 1;
    $this->pyear = $this->year - 1;
    $this->nmonth = $this->month + 1;
    $this->nyear = $this->year + 1;
  }

  function showThisMonth()
  {
    global $wgScript, $wgArticlePath, $wgUser;

    $lastyear = ($this->month==1?$this->year - 1:$this->year);
    $nextyear = ($this->month==12?$this->year + 1:$this->year);
    $lastmonth = ($this->month==1? 12 : $this->month - 1);
    $nextmonth = ($this->month==12? 1 : $this->month + 1);

    $lastmonth = ($lastmonth<10?"0".$lastmonth:$lastmonth);
    $nextmonth = ($nextmonth<10?"0".$nextmonth:$nextmonth);

    $sk =& $wgUser->getSkin();

    $dbr =& wfGetDB( DB_SLAVE );
    $sPageTable = $dbr->tableName( 'page' );
    $categorylinks = $dbr->tableName( 'categorylinks' );

    $res = $dbr->query(
      "SELECT page_title, clike1.cl_to AS catlike1 " . 
      "FROM $sPageTable INNER JOIN $categorylinks AS c1 ON page_id = c1.cl_from AND c1.cl_to='" . $this->catname . "' INNER JOIN $categorylinks " . 
            "AS clike1 ON page_id = clike1.cl_from AND clike1.cl_to LIKE '" . $this->year . "/" . $this->month . "/__' " .
      "WHERE page_is_redirect = 0");
    while ($row = $dbr->fetchObject( $res ) ) 
    {
      $dbDay = substr($row->catlike1,8,2);
      if (isset($eventsByDay[$dbDay]) == '') 
        $eventsByDay[$dbDay] = substr($row->page_title, 0, 200);
      else
        $eventsByDay[$dbDay] = '*multiple events*';                
    }

    if ($this->bShowCalendar)
    {
      /**
       * Show calendar
       **/
      $output = '';
      $output .= '<table align="center" border="0" cellpadding="0" cellspacing="0" class="calendar">';
      for($i=0;$i<7;$i++)
        if (((($i + $this->wday_start) % 7) == 6) || ((($i + $this->wday_start) % 7) == 0))
          $output .= '<col class="cal-weekend"/>';
        else
          $output .= '<col/>';
      
      if (!$this->bShowUpcoming)
        $showupcoming_href = '&upcoming=off';
      else
        $showupcoming_href= '';
      if ($this->catname != 'Events')
        $catname_href = '&category=' . $this->catname;
      else
        $catname_href = '';
      $output .= '<tr class="calendarTop"><td><a href="'. str_replace('$1', "Special:Events?year=".$lastyear."&month=".$lastmonth.$catname_href, $wgArticlePath) . '"';
      if ($this->bAjaxPrevNext)
        $output .= ' onclick="makeRequest(\'' . str_replace('$1', "Special:Events?year=".$lastyear."&month=".$lastmonth.$showupcoming_href.$catname_href, $wgArticlePath) . '&ajax\'); return false;"';
      $output .= '>&lt;</a></td><td colspan="5" class="cal-header"><center>'. 
        '<a href="'. str_replace('$1', "Special:Events?year=".$this->year."&month=".$this->month.$catname_href, $wgArticlePath) .'">' . $this->wmonth_names[$this->pmonth] . ' ' .$this->year .'</a></center></td><td><a href="'. 
        str_replace('$1', "Special:Events?year=".$nextyear."&month=".$nextmonth.$catname_href, $wgArticlePath) .'"';
      if ($this->bAjaxPrevNext)
        $output .= ' onclick="makeRequest(\'' . str_replace('$1', "Special:Events?year=".$nextyear."&month=".$nextmonth.$showupcoming_href.$catname_href, $wgArticlePath) . '&ajax\'); return false;"';
      $output .= '>&gt;</a></td></tr>';
      $output .= '<tr class="calendarDayNames">';
      for($i=0;$i<7;$i++)
        $output .= '<td>'. $this->wday_names[($i + $this->wday_start) % 7]. '</td>';
      $output .= '</tr>';
      
      $wday = date("w",mktime(0,0,0,$this->month,1,$this->year)); // get day of week  0-6 of first day of month (0 = Sunday thru 6=Saturday)
      $wday = $wday - $this->wday_start;
      if ($wday < 0)
        $wday = 7 + $wday;

      $no_days = date("t",mktime(0,0,0,$this->month,1,$this->year)); // number of days in month
      $count = 1;
      $output .= '<tr>';
      for($i=1;$i<=$wday;$i++)
      {
        $output .= '<td> </td>';
        $count++;
      }
      /**
       * every day is a link to that day
       **/
      $todaysMonth = date("m");
      $todaysYear = date('Y');
      for($i=1;$i<=$no_days;$i++)
      {
        if ($count == 1)
          $output .= '<tr>';
          
        $dayNr = ($i<10?"0".$i:$i);
        $alinkedit = str_replace('$1', "Special:Events?year=".$this->year."&month=".$this->month."&day=".$dayNr.$catname_href, $wgArticlePath);

        if (isset($eventsByDay[$dayNr]))
          $full_link = '<a title="' . str_replace('_',' ',$eventsByDay[$dayNr]) . '" href="'.$alinkedit.'">' . $i . '</a>';
        else
          $full_link = $i;

        $cell_class = '';
        if (($i == $this->today) && ($this->month == $todaysMonth) && ($this->year == $todaysYear))
          $cell_class .= ' cal-today'; 
        if (isset($eventsByDay[$dayNr]))
          $cell_class .= ' cal-eventday';
        if ($cell_class != '')
          $cell_class = ' class="' . $cell_class . '"';
          
        $output .= '<td ' . $cell_class . '>' . $full_link . '</td>';
        
        if ($count > 6) {
          $output .= '</tr>';
          $count = 1;
        }
        else
          $count++;
      }
      if ($count > 1) {
        for($i=$count;$i<=7;$i++)
          $output .= "<td> </td>";
        $output .= '</tr>';
      }
      $output .= '</table>';
    } // end if show calendar

    if ($this->bShowUpcoming)
    {
      /**
       * Show upcoming events
       **/
      $output .= '<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" class="calendarupcoming">' .
        '<tr><td class="calendarupcomingTop">Events Upcoming</td></tr>';
      $sql =  "SELECT page_title, page_namespace, clike1.cl_to AS catlike1 " . 
        "FROM $sPageTable INNER JOIN $categorylinks AS c1 ON page_id = c1.cl_from AND c1.cl_to='" . $this->catname . "' INNER JOIN $categorylinks " . 
        "AS clike1 ON page_id = clike1.cl_from AND clike1.cl_to LIKE '____/__/__' AND clike1.cl_to >= '" . date('Y/m/d') . "' " .
        "WHERE page_is_redirect = 0 " .
        "ORDER BY clike1.cl_to ASC " .
        "LIMIT 5";
      $res = $dbr->query($sql);
      $rowClass = "calendarupcomingRow1";
      while ($row = $dbr->fetchObject( $res ) ) 
      {
        $title = Title::makeTitle($row->page_namespace, $row->page_title);

        $title_text = $title->getSubpageText();
        $title_text = str_replace('_',' ',$title_text);
        $eventDate =  substr($row->catlike1,8,2) . '-' . substr($row->catlike1,5,2) . '-' . substr($row->catlike1,0,4);
        $output .= '<tr><td class="' . $rowClass . '">' . $sk->makeKnownLinkObj($title, "&raquo; " . $title_text . '<br>' . $eventDate) . '</td></tr>';
        $rowClass = "calendarupcomingRow2";
      }

      $output .= '<tr><td class="calendarupcomingBottom">';
      if ($this->catname != 'Events') 
        $output .= '<a href="'. str_replace('$1', 'Special:Events?category=' . $this->catname, $wgArticlePath) . '">More &raquo;</a>';
      else
        $output .= '<a href="'. str_replace('$1', 'Special:Events', $wgArticlePath) . '">More &raquo;</a>';

      $output .= '</tr></table>';
    }
    return $output;
  }
}
