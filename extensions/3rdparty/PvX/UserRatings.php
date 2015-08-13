<?php
if (!defined('MEDIAWIKI'))
    die();
/**
 * A Special Page sample that can be included on a wikipage like
 * {{Special:Inc}} as well as being accessed on [[Special:Inc]]
 *
 * Simple clone of RecentRatings, displays only contributions of the reader.
 * ToDo: Change to a mechanism similar to user contributions to allow checking other user's ratings
 *     -- Hhhippo 13 Jan 2008
 *
 * @addtogroup Extensions
 *
 * @author Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 * @copyright Copyright © 2005, Ævar Arnfjörð Bjarmason
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['specialpage'][] = array('name' => 'User Ratings',
					     'url' => 'http://www.gcardinal.com/',
					     'description' => 'List user ratings.',
					     'author' => 'gcardinal/Hhhippo');
						 
require_once "$IP/includes/SpecialPage.php";
$wgSpecialPages['UserRatings'] = 'UserRatings';
$wgExtensionMessagesFiles['UserRatings'] = dirname(__FILE__) . '/UserRatings.i18n.php';

class UserRatings extends SpecialPage {

	function UserRatings() {
		SpecialPage::SpecialPage('UserRatings');
		$this->includable(true);
	}

        #-- main() ---------------------------------#
	function execute($par = null) {
        #-------------------------------------------#
        global $wgOut;
        global $wgRequest;
        global $wgScript;
        global $wgUser;
	    global $wgParser;
	    global $wgTitle;
		global $wgLang;

        $wgOut->setPageTitle('User ratings');
        if ($this->including()) {
			$out = "I'm being included... :(";
	    }
		else {
		$got_ratings=self::GetRatings();
		if ($got_ratings) {
		    $timeprevious = '';
		    foreach ($got_ratings as $array)
		    {

			if ($array['page_title'])
			{
			    date_default_timezone_set("UTC");

				$timecorrection = $wgUser->getGlobalPreference( 'timecorrection' );
				$timecurent = $wgLang->date( wfTimestamp( TS_MW, $array['timestamp'] ), true, false, $timecorrection );

			    $out = '* ';

			    if ( $timeprevious != $timecurent)
			    {
				$tc = '===' . $timecurent . '===';
				$wgOut->addWikiText($tc);
			    }
			    $timeprevious = $timecurent;
			    $time = $wgLang->time( wfTimestamp( TS_MW, $array['timestamp'] ), true, false, $timecorrection);

			    if ($array['user_name'])
			    {
				$user_link = '[[User:' . $array['user_name'] . '|' . $array['user_name'] . ']]' . ' ' . '(' . '[[User_talk:' . $array['user_name'] . '|Talk]]' . ' | ' . '[[Special:Contributions/' . $array['user_name'] . '|contribs]])';
			    } else {
				$user_link = '';
			    }


			    $page_link = '[[Build:' . $array['page_title'] . '|' . $array['page_title'] . ']]';

			    if ($array['admin_id'])
			    {
				$admin_name = User::newFromId($array['admin_id'])->getName();
				$admin_link = '[[User:' . $admin_name . '|' . $admin_name . ']]';
			    }

			    $out .= $time;
			    $out .= ' . . ';
			    if ($array['rollback']) $out .= '<font color="red"><b>Rollback</b></font> ';
			    if (!$array['rollback'] && $array['reason']) $out .= '<font color="green"><b>Restore</b></font> ';
			    $out .= $page_link;
			    $out .= '; ';


			    $total = $array['rating'][0] * .8 + $array['rating'][1] * .2 + $array['rating'][2] * .0;
			    if ($total < 3.75) $rating = 'Rating: \'\'\'' . $total . '\'\'\' (\'\'trash\'\')';
			    elseif ($total < 4.75) $rating = 'Rating: \'\'\'' . $total . '\'\'\' (\'\'good\'\')';
			    elseif ($total >= 4.75) $rating = 'Rating: \'\'\'' . $total . '\'\'\' (\'\'great\'\')';

			    if ($array['rollback'])
			    {
				#<font color="red">
				$out .= '\'\'\'' . $admin_link . '\'\'\'' . ' removed '
				    . strtolower($rating) . ' posted by: ' . $user_link;
			    } elseif (!$array['rollback'] && $array['reason']) {
				$out .= '\'\'\'' . $admin_link . '\'\'\'' . ' restored '
				    . strtolower($rating) . ' posted by: ' . $user_link;
			    } else {
				$out .= $rating;
				$out .= ' . . ';
				$out .= ' E:' . $array['rating'][0];
				$out .= ' U:' . $array['rating'][1];
				$out .= ' I:' . $array['rating'][2];
				$out .= ' . . ';
				$out .= $user_link;
			    }

			    $wgOut->addWikiText($out);
			}
		    }
		} else {
		    $out = "No ratings found for this user.";
		    $wgOut->addWikiText($out);
		}
	    }
	}


        #-------------------------------------------#
	function GetRatings() {
        #-------------------------------------------#

	    global $wgUser;
	    $dbr = &wfGetDB(DB_SLAVE);
	    $res = $dbr->query("SELECT user_name, R.user_id, page_title, comment, rollback, admin_id, reason, rating1, rating2, rating3, timestamp
			FROM rating AS R
			LEFT JOIN user AS u1 ON R.user_id = u1.user_id
			LEFT JOIN page AS p1 ON R.page_id = p1.page_id
                        WHERE R.user_id=".$wgUser->getID()."
                         AND p1.page_namespace = 100
			ORDER BY R.timestamp DESC
			LIMIT 0 , 200");
	    $count = $dbr->numRows( $res );
	    if( $count > 0 ) {
		# Make list
		while( $row = $dbr->fetchObject( $res ) )
		{
		    $out[] = array('user_name'  => $row->user_name,
				   'comment' 	=> $row->comment,
				   'page_title' => str_replace('_', ' ', $row->page_title),
				   'rollback' 	=> $row->rollback,
				   'admin_id' 	=> $row->admin_id,
				   'reason' 	=> $row->reason,
				   'rating' 	=> array($row->rating1, $row->rating2, $row->rating3),
				   'timestamp'  => $row->timestamp
				     );
		}
	    } else {
		return false;
	    }
	    return $out;
	}
        #----------------------------------------#

} // end class UserRatings
