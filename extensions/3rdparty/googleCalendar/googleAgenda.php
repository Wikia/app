<?php
# Google Agendas
#
# Tag :
#   <googleagenda>docid</googleagenda>
# Ex :
#   from url http://calendar.google.com/calendarplay?docid=6444586097901795775
#   <googleagenda>6444586097901795775</googleagenda>
#
# Enjoy !

$wgExtensionFunctions[] = 'wfGoogleAgenda';
$wgExtensionCredits['parserhook'][] = array(
        'name' => 'Google Agenda',
        'description' => 'Display Google Agenda',
        'author' => 'Kasper Souren', 'James Smith',
        'url' => 'http://wiki.couchsurfing.com/en/Google_Calendar_MediaWiki_plugin');

function wfGoogleAgenda() {
        global $wgParser;
        $wgParser->setHook('googleagenda', 'renderGoogleAgenda');
}

# The callback function for converting the input text to HTML output
function renderGoogleAgenda($input) {
        $input = htmlspecialchars($input);
        //$input = "6444586097901795775"
        $width = 425;
        $height = 350;

        $output = '<iframe src="http://www.google.com/calendar/embed?showTitle=0&showNav=0&showTabs=0&showCurrentTime=0&mode=AGENDA&height=350&wkst=1&bgcolor=%23FFFFFF&src='.$input.'&color=%23B1365F" style=" border-width:0 " width="240" height="350" frameborder="0" scrolling="no"></iframe>';

        /*

        $output = '<embed style="width:'.$width.'px; height:'.$height.'px;" '
                .'id="CalendarPlayback" type="application/x-shockwave-flash" '
                .'src="http://calendar.google.com/googleplayer.swf?docId='
                .$input.'"> </embed>';
        */
        return $output;
}
?>