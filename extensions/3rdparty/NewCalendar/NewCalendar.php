<?php
if (!defined('MEDIAWIKI')) die();

$wgExtensionFunctions[] = "wfNewCalendarExtension";
$wgExtensionCredits['parserhook'][] = array(
        'name' => 'New Calendar',
        'author' => 'David McCabe',
        'description' => 'adds "calendar" tag',
        'url' => 'none as yet'
);

function wfNewCalendarExtension() {
    global $wgParser;
    $wgParser->setHook( "calendar", "ncCreateCalendar" );
}

function ncCreateCalendar($input, $params, &$parser)
{
	// TODO: Instead of disabling the cache for pages with calendars at all
	// times, it would be better if we could detect when event pages change
	// and invalidate the cache then.
	$parser->disableCache();

	// Pull the params out of the tag attributes, with defaults.
	// tag names are case-insensitive.
	$cal_category = array_key_exists('category', $params) ?
	                $params['category'] : 'Events';
 	$num_months = array_key_exists('numberofmonths', $params) ?
                  $params['numberofmonths'] : '3';
	$num_months = is_numeric($num_months) ?
	              intval($num_months) : 3;

	$c = new ncUpcomingEvents( $cal_category, $num_months, $parser->mTitle );
	return $c->html();
}

class Event {
	protected $title;
	protected $date;
	protected $description;
	
	function __construct($title, $date) {
		$this->title = $title;
		$this->date = $date;
	}
	
	function save() {
		// it turns out that specialaddevent doesn't even use this class.
		wfDebug("Event::save() is not implemented.");
	}
	
	function title() { return $this->title; }
	function date() { return $this->date; }
	function description() { return $this->description; }
	
	function dateYear()  { $tmp = explode('/', $this->date); return $tmp[0]; }
	function dateMonth() { $tmp = explode('/', $this->date); return $tmp[1]; }
	function dateDay()   { $tmp = explode('/', $this->date); return $tmp[2]; }
	
	static function eventsIn( $category, $onlyAfterToday=false,
		                      $year='___', $month='__', $day='__' ) {
		$year = is_numeric( $year ) ? sprintf('%04d', $year) : $year;
		$month = is_numeric( $month ) ? sprintf('%02d', $month) : $month;
		$day = is_numeric( $day ) ? sprintf('%02d', $day) : $day;
	
		$like_string = "'$year/$month/$day'";

		$date_today = date('Y/m/d');
		$after_today_clause = $onlyAfterToday ?
		                      "AND cat.cl_sortkey >= '$date_today'\n"
		                      : "";

		$dbr =& wfGetDB( DB_SLAVE );
		$sPageTable = $dbr->tableName( 'page' );
		$categorylinks = $dbr->tableName( 'categorylinks' );
		
		/* Two categories SQL (now we use category plus sort key)
		$sql =  <<<ENDSQL
		SELECT page_title, page_namespace, clike1.cl_to catlike1
			FROM $sPageTable
			INNER JOIN $categorylinks AS c1
				ON page_id = c1.cl_from
				AND c1.cl_to='$category'
			INNER JOIN $categorylinks AS clike1
				ON page_id = clike1.cl_from
				AND clike1.cl_to LIKE $like_string
				$after_today_clause
			WHERE page_is_redirect = 0
			ORDER BY clike1.cl_to ASC
ENDSQL;*/

		$sql = <<<ENDSQL
		SELECT page_title, page_namespace, cat.cl_to, cat.cl_sortkey
			FROM $sPageTable
			INNER JOIN $categorylinks AS cat
				ON page_id = cat.cl_from
				AND cat.cl_to = '$category'
				AND cat.cl_sortkey LIKE $like_string
				$after_today_clause
			WHERE page_is_redirect = 0
			ORDER BY cat.cl_sortkey ASC
ENDSQL;
	
		$res = $dbr->query($sql);
		$events = array();
		while ($row = $dbr->fetchObject( $res ))  {
			$title = Title::makeTitle($row->page_namespace, $row->page_title);
//			$events[] = new Event( $title, $row->catlike1 );
			$events[] = new Event( $title, $row->cl_sortkey );
		}

		return $events;
	}
}

/**
	array( array( 'm'=>numeric month as string,
	              'Y'=>numeric year as string ),
	 	   ... )
*/
function ncUpcomingMonths($n, $start_month = null, $start_year = null) {
	// Assure that we have real live integers. TODO: verify robustness (*snort*) of this.
	$m = $start_month? (is_string($start_month) ? intval($start_month) : $start_month) : intval(date('m'));
	$y = $start_year? (is_string($start_year) ? intval($start_year) : $start_year) : intval(date('Y'));
	if( $y<100 ) $y += 2000; // two-digit years.

	$results = array();
	foreach( range(0, $n-1) as $not_used ) {
		$results[] = array('m'=>sprintf( '%02d', $m ),
		                   'Y'=>sprintf( '%04d', $y ));
		$m++;
		if ( $m > 12 ) {
			$m = 1; $y++;
		}
	}
	return $results;
}

class ncUpcomingEvents {

	/** Category to which articles belong if they are to belong to this calendar. */
	var $calendar_category;
	
	/** How many months to show */
	var $number_of_months;

	/** TODO probably already internationalized somewhere. */
	static $month_names = array("zeroeth month","January","February",
	                                  "March","April","May","June",
   									  "July","August","September","October",
									  "November","December");
	
	
	function __construct( $calendar_category, $number_of_months, $page_title ) {
		$this->calendar_category = $calendar_category;
		$this->number_of_months = $number_of_months;
		$this->page_title = $page_title;
	}
	
	protected function elem($kind, $class=null) {
		if ($class) return "<$kind class=\"upcoming_events_$class\">";
		else return "<$kind>";
	}
	
	function html() {
		global $wgUser, $wgStylePath, $wgOut;
		$sk =& $wgUser->getSkin();
		
		// this breaks the "return some html" model, but what can we do?
		$wgOut->addScript( "<link rel=\"stylesheet\" type=\"text/css\"
			href=\"{$wgStylePath}/common/calendar_extension.css\" />\n" );
		
		$output = array(); // to be joined into one string in the end.
		
		$output[] = '<!-- Upcoming Events -->';
		$output[] = '<div class="upcoming_events">';
		$output[] = '<h4>Upcoming Events</h4>';
		$output[] = $this->elem('ul', 'list');
		
		foreach( ncUpcomingMonths($this->number_of_months) as $date ) {
			$y = $date['Y']; $m = $date['m'];
			$events = Event::eventsIn( $this->calendar_category,
				true, $y, $m );
			
			$output[] = $this->elem('li', 'month_name');
			$output[] = self::$month_names[(int)$m];
			$output[] = '</li>';

			$output[] = $this->elem('ul', 'month_sublist');
			if( count($events) == 0 ) {
				$output[] = $this->elem('li', 'event') .
				            $this->elem('em', 'no_event_message') .
				            'No events.</em></li>';
			}
			/*else*/ foreach( $events as $e ) {
				$output[] = $this->elem('li', 'event');
				
				$output[] = $this->elem('strong', 'day') .
						$e->dateDay() .
						': </strong>';
				
				$output[] = $sk->makeKnownLinkObj($e->title(),
					$e->title()->getText());

				$output[] = '</li>';
			}
			$output[] = '</ul>';
		}
		
		$add_event_title = Title::newFromText('Special:AddEvent');
		$query = 'came_from=' . $this->page_title->getPrefixedURL() .
		         '&category=' . $this->calendar_category;
		$output[] = $this->elem('li', 'add_event');
		$output[] = $sk->makeKnownLinkObj($add_event_title,
			'Add an Event', $query);
		$output[] = '</li>';

		$output[] = '</ul>';
		$output[] = '</div>';
		$output[] = '<!-- / Upcoming Events -->';
	
		return join('', $output);
	}
}

?>
