<?php
$wgExtensionFunctions[] = "wfTimeline";

function wfTimeline() {
    global $wgParser, $wgOut;
    $wgParser->setHook( "timeline", "TimelineConstruct" );
}

function TimelineConstruct( $input, $args, &$parser ){
	global $wgUser, $wgTitle, $wgOut;

	$lines = explode("\n", $input);
	
	foreach( $lines as $line ){
		
		$line_array = explode("|", $line);
		 
		//invalid line
		if( count( $line_array ) < 2 ){
			continue;
		}
	
		$time = strtotime( $line_array[0] );
		
		//invalid date
		if( !$time ){
			continue;
		}
		
		//the data might have | in it, so lets combine the rest of the array
		unset($line_array[0]);
		$data = implode("|", $line_array);
		
		$events[] = array ( 
					"time" => $time,
					"month_name" => date( "F", $time ), 
					"month" => date( "n", $time ),
					"year" => date( "Y", $time ),
					"day" => date( "j", $time ),
					"data" => $parser->recursiveTagParse($data)
				);
	}
	
	usort( $events , "TimelineSort" );
	
	$output = TimelineRender($events);
	
	return $output;
}

function TimelineRender( $events ){
	$last_year = 0;
	$last_month = 0;
	$output = "";
	foreach( $events as $event ){
	
		if( $event["year"] != $last_year ){
			$last_month = 0;
			if( $last_year != 0 ) $output .= "</div><div class=\"cleared\"></div></div><div class=\"cleared\"></div></div>\n"; //close out month, year, data containers from previous
			$output .= "<div class=\"timeline-year-container\">\n";
			$output .= 	"<div class=\"timeline-year\">{$event["year"]}</div>\n";
			$output .= 	"<div class=\"timeline-month-container\">\n";
		}
		
		if( $event["month"] != $last_month ){
			if( $last_month != 0 ) $output .= "</div><div class=\"cleared\"></div>\n"; //close previous month
			$output .= "<div class=\"timeline-month\">{$event["month_name"]}</div>\n<div class=\"timeline-data-container\">\n";
		}
		
		if( $event["day"] < 10) $event["day"] = "0" . $event["day"];
		$output .= "<div class=\"timeline-data\"><span class=\"timeline-day\">{$event["day"]}</span> {$event["data"]}</div>\n";
		
		$last_year = $event["year"];
		$last_month = $event["month"];
	}
	
	if( $output ) $output .= "</div><div class=\"cleared\"></div></div><div class=\"cleared\"></div></div>"; //close out month, year, data containers from last item;
	
	return $output;
}

function TimelineSort($x, $y){
	if( $x["time"] == $y["time"] ){
		return 0;	
	}else if ( $x["time"] > $y["time"] ){
		return -1;
	}else{
		return 1;
	}
}


?>