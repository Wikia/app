<?php
/**
 * An extension that let your users review article quality.
 *
 * @addtogroup Extensions
 * @todo document
 *
 * @author Magnus Manske <magnusmanske@googlemail.com>
 * @copyright Copyright © 2005, Magnus Manske
 * @license <Please enter the license here>
 *
 */

/*
                          README

To activate the extension, you will have to configure your MediaWiki
installation. In your LocalSettings.php append:

    include ( "extensions/Review/Review.php" ) ;

Optionally, you can activate a different CSS stylesheet using the REVIEW_CSS
define (it should be done *before* the 'include' statement):

    define( 'REVIEW_CSS' , 'http://yourhost.com/name/wiki/my_stylesheets/stylesheet.css' );


*/

if( !defined( 'MEDIAWIKI' ) ) die();
if( !defined( 'REVIEW_CSS' ) ) define('REVIEW_CSS', $wgScriptPath.'/extensions/Review/review.css' );

$wgExtensionCredits['other'][] = array(
	'name' => 'Review',
	'description' => 'The resurrected validation feature.',
	'descriptionmsg' => 'review-desc',
	'author' => 'Magnus Manske',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Review'
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['Review'] = $dir . 'Review.i18n.php';
$wgExtensionFunctions[] = 'wfReviewExtensionFunction';

# Hooks
$wgHooks['MonoBookTemplateToolboxEnd'][] = 'wfReviewExtensionAfterToolbox';

# Global variables
$wgReviewExtensionInitMessages = false ;
$wgReviewExtensionTopics = array () ;
$wgReviewFeatureSingleUserMode = false ;

# ______________________________________________________________________________
# Functions

/**
* Does this extension apply to this namespace?
*/
function wfReviewExtensionDoesNamespaceApply ( $namespace ) {
	if ( $namespace == 0 ) return true ;
	return false ;
}

/**
* Initialize messages for this extension
*/
function wfReviewExtensionInitMessages () {
	global $wgUserTogglesEn, $wgDefaultUserOptions, $wgReviewExtensionTopics, $wgReviewExtensionInitMessages, $wgOut;
	if( $wgReviewExtensionInitMessages ) {
		# Been there, done that
		return;
	}
	wfLoadExtensionMessages( 'Review' );
	$wgReviewExtensionInitMessages = true;


	# Set the CSS
	$wgOut->addLink(array(
		'rel'	=> 'stylesheet',
		'type'	=> 'text/css',
		'media'	=> 'screen,projection',
		'href'	=> REVIEW_CSS,
	));



	# Now parsing the topics
	$s = explode ( "\n" , wfMsg ( 'review_topics' ) ) ;
	$wgReviewExtensionTopics = array () ;
	foreach ( $s AS $v ) {
		$v = explode ( ':' , trim ( $v ) ) ;
		if ( count ( $v ) != 5 ) continue ; # Some other line, ignore it
		$x = array();
		$x['key'] = (int) trim ( array_shift ( $v ) ) ;
		$x['name'] = trim ( array_shift ( $v ) ) ;
		$x['range'] = (int) trim ( array_shift ( $v ) ) ;
		$x['left'] = trim ( array_shift ( $v ) ) ;
		$x['right'] = trim ( array_shift ( $v ) ) ;
		if ( $x['key'] == 0 ) continue ; # Paranoia
		if ( $x['range'] < 2 ) continue ; # Paranoia
		if ( $x['name'] == "" ) continue ; # Paranoia
		$wgReviewExtensionTopics[$x['key']] = $x ;
	}
}

/**
* Generate the radio fields for the form
* @param $topic Topic object (one topic only)
* @return HTML string with radio fields
*/
function wfReviewExtensionGetTopicForm ( $topic , $fullpage = false ) {
	# Dummy value
	if ( !isset ( $topic->value ) )
		$topic->value = 0 ;
	
	$tkey = "review_topic[" . $topic['key'] . "]" ;
	$ret = "" ;
	if ( $fullpage )
		$ret .= "<td align='center'>" ;
	$ret .= '<input id="review_radio_no_opinion" type="radio" name="' . $tkey . '" value="0"' ;
	$ret .= $topic->value == 0 ? " checked" : "" ;
	if ( $fullpage )
		$ret .= "/></td>" ;
	else
		$ret .= '/>&nbsp;' ;
	if ( $topic['range'] == 2 ) { # Yes/No
		if ( $fullpage )
			$ret .= "<td/><td nowrap>" ;
		$ret .= '<input type="radio" name="' . $tkey . '" value="1" id="review_radio_1_of_2"' ;
		$ret .= $topic->value == 1 ? " checked" : "" ;
		$ret .= '></input>' . $topic['left'] . ' ' ;
		$ret .= '<input type="radio" name="' . $tkey . '" value="2" id="review_radio_2_of_2"' ;
		$ret .= $topic->value == 2 ? " checked" : "" ;
		$ret .= '/>' . $topic['right'] ;
		if ( $fullpage )
			$ret .= "</td><td/><td>" ;
	} else { # Range
		if ( $fullpage )
			$ret .= "<td align='right' nowrap>" . $topic['left'] . "</td><td nowrap>" ;
		for ( $a = 1 ; $a <= $topic['range'] ; $a++ ) {
			$ret .= '<input type="radio" name="' . $tkey . '" value="' . $a . '"' ;
			$ret .= " id='review_radio_" . $a . "_of_" . $topic['range'] . "'" ; # This doesn't show for some weird reason...
			$ret .= $topic->value == $a ? " checked" : "" ;
			$ret .= '/>' ;
		}
		if ( $fullpage )
			$ret .= "</td><td nowrap>" . $topic['right'] . "</td><td width='100%'>" ;
	}
	if ( $fullpage ) {
		$ret .= "<input type='text' style='width:100%' name='review_comment[" . $topic['key'] . "]' value='" . htmlentities ( $topic->comment ) . "'/>" ;
		$ret .= "</td>\n" ;
	}
	return $ret ;
}

/**
* Sets the search condition for the WHERE clause in an SQL query
* @param $user User object (will not be changed by this function)
* @param $conds Conditions array, will be extended to include the condition
*/
function wfReviewExtensionSetUserCondition ( &$user , &$conds ) {
	if ( $user->getID() == 0 ) {
		# Anon
		$conds['val_ip'] = $user->getName() ;
	} else {
		# User with account
		$conds['val_user'] = $user->getID() ;
	}
}

/**
* Returns the ratings for a user for a specific page
* @param $title Title object (will not be changed by this function)
* @param $user User object (will not be changed by this function)
* @param $revision If set, the function fill return only the ratings for that revision
* @return array [revision] => ( array [topic number] => object with data )
*/
function wfReviewExtensionGetUserRatingsForPage ( &$title , &$user , $revision = "" ) {
	$ret = array () ;
	if ( !$title->exists() ) return $ret ; # No such page

	$fname = 'wfReviewExtensionGetUserRatingsForPage' ;
	$dbr =& wfGetDB( DB_SLAVE );
	$conds = array () ;
	$conds['val_page'] = $title->getArticleID() ;
	wfReviewExtensionSetUserCondition ( $user , $conds ) ;

	# Search for a special revision?
	if ( $revision != "" )
		$conds['val_revision'] = $revision ;

	# Query
	$res = $dbr->select(
			/* FROM   */ 'validate',
			/* SELECT */ '*',
			/* WHERE  */ $conds,
			$fname
	);

	while ( $line = $dbr->fetchObject( $res ) ) {
		# Create the revision array, if necessary
		if ( !isset ( $ret[$line->val_revision] ) )
			$ret[$line->val_revision] = array () ;
		# Store the data
		$ret[$line->val_revision][$line->val_type] = $line ;
	}
	return $ret ;
}

/**
* Pre-fills values into a topics list
* @param $topics Topics array (array [topic number] => topic data object)
* @param $ratings Rating array (array [
*/
function wfReviewExtensionPresetForm ( &$topics , &$ratings ) {
	$tk = array_keys ( $topics ) ;
	foreach ( $tk AS $key ) {
		if ( isset ( $ratings[$key] ) ) {
			# User rating exists
			$topics[$key]->value = $ratings[$key]->val_value ;
			$topics[$key]->comment = $ratings[$key]->val_comment ;
		} else {
			# Dummy value
			$topics[$key]->value = 0 ;
			$topics[$key]->comment = "" ;
		}
	}
}

/**
* Checks for form data, integrates them and stores them in the database
* @param $ratings Array of ratings for this article from this user, read from database
* @param $merge_others can be called with "false" to prevent merging with other ratings
* @return bool : Did it apply form data?
*/
function wfReviewExtensionReadLastForm ( &$ratings , $title , $merge_others = true ) {
	global $wgUser, $wgRequest ;
	
	# Was there a form?
	if ( $wgRequest->getText ( 'save_review' , "" ) == "" )
		return false ;

	$fname = 'wfReviewExtensionReadLastForm' ;
	$dbw =& wfGetDB( DB_MASTER );
	# Avoid user/ip tuplet unique index collisions
	$user_ip = $wgUser->getID() == 0 ? $wgUser->getName() : NULL ;

	# Read form values
	$oldrev = $wgRequest->getInt ( 'review_oldid' ) ;
	$topics = $wgRequest->getArray ( 'review_topic' ) ;
	$comments = $wgRequest->getArray ( 'review_comment' ) ;
	
	# Sort revisions, latest first
	krsort ( $ratings ) ;

	# Finding old values
	$old = array () ;
	if ( $merge_others ) {
		foreach ( $ratings AS $revision => $rev_data ) {
			if ( $revision == $oldrev ) continue ;
			foreach ( $rev_data AS $key => $value ) {
				if ( isset ( $old[$key] ) ) continue ;
				$old[$key] = $value ;
			}
		}
	}

	# Merging
	$new_data = array () ;
	foreach ( $topics AS $key => $value ) {
		if ( $value > 0 ) {
			# Already set a value
			$new_data[$key] = "" ;
			$new_data[$key]->val_user = $wgUser->getID() ;
			$new_data[$key]->val_page = $title->getArticleID() ;
			$new_data[$key]->val_revision = $oldrev ;
			$new_data[$key]->val_type = $key ;
			$new_data[$key]->val_value = $value ;
			$new_data[$key]->val_comment = isset ( $comments[$key] ) ? $comments[$key] : "" ;
			$new_data[$key]->val_ip = $user_ip ;
			continue ;
		}
		if ( !$merge_others ) continue ; # No merging
		if ( !isset ( $old[$key] ) ) continue ; # No old value either
		# Set old value
		$new_data[$key] = $old[$key] ;
	}

	if ( $merge_others ) {
		# Remove old ratings
		$ratings = array () ;
		$ratings[$oldrev] = $new_data ;

		# Delete *all* old ratings from the database
		$conds = array () ;
		$conds['val_page'] = $title->getArticleID() ;
		wfReviewExtensionSetUserCondition ( $wgUser , $conds ) ;
		$dbw->delete ( 'validate' , $conds , $fname ) ;
	} else {
		# Just replace the ones for this revision
		$ratings[$oldrev] = $new_data ;
	
		# Delete old ratings for this revision from the databasewfReviewExtensionPresetForm
		$conds = array () ;
		$conds['val_page'] = $title->getArticleID() ;
		$conds['val_revision'] = $oldrev ;
		wfReviewExtensionSetUserCondition ( $wgUser , $conds ) ;
		$dbw->delete ( 'validate' , $conds , $fname ) ;
	}

	# Insert new ratings into the database
	if ( count ( $new_data ) > 0 ) {
		$dbw->begin() ;
		foreach ( $new_data AS $key => $value ) {
			$data = array (
				'val_user' => $value->val_user ,
				'val_page' => $value->val_page ,
				'val_revision' => $value->val_revision ,
				'val_type' => $value->val_type ,
				'val_value' => $value->val_value ,
				'val_comment' => $value->val_comment ,
				'val_ip' => $value->val_ip ,
			) ;
			$name = $value->val_user ? 'val_user' : 'val_ip';
			
			$dbw->replace( 'validate', array( array($name,'val_revision','val_type') ), $data ) ;
		}
		$dbw->commit();
	}

	return true ;
}

/**
* Display in sidebar
* @param $tpl The used template
*/
function wfReviewExtensionAfterToolbox( &$tpl ) {
	global $wgTitle, $wgUser , $wgReviewExtensionTopics, $wgArticle, $action, $wgRequest;

	# Do we care?
	if( !wfReviewExtensionDoesNamespaceApply ( $wgTitle->getNamespace() )
	    or $wgUser->isBlocked()
	    or ( $action != "view" )
	) return true;

	# Initialize
	$do_merge = $wgRequest->getBool ( 'do_merge' , false ) ;
	$skin =& $wgUser->getSkin() ;
	$revision = $wgArticle->getRevIdFetched() ;
	wfReviewExtensionInitMessages () ;
	$ratings = wfReviewExtensionGetUserRatingsForPage ( $wgTitle , $wgUser ) ;
	$did_update_review = wfReviewExtensionReadLastForm ( $ratings , $wgTitle , $do_merge ) ;
	if ( !isset ( $ratings[$revision] ) ) # Construct blank dummy, if necessary
		$ratings[$revision] = array () ;
	wfReviewExtensionPresetForm ( $wgReviewExtensionTopics , $ratings[$revision] ) ;

?>

			</ul>
		</div>
	</div>
	<div class="portlet" id="p-tasks">
		<h5>
<?php
	$tpl->msg('review_sidebar_title')
?>
		</h5>
		<div class="pBody">
			<form method='post' id="review_sidebar">
<?php
	if ( $did_update_review )
		print wfMsgForContent ( 'review_has_been_stored' ) . "<br />" ;
	print wfMsgForContent ( 'review_your_review' ) . "<br />" ;
	foreach( $wgReviewExtensionTopics as $topic ) {
?>
			<a id="review_sidebar_link" href="
<?php
	$topic_title = Title::makeTitleSafe( NS_MEDIAWIKI, wfMsgForContent('review_topic_page').'#'.$topic['name'] );
	print $topic_title->escapeLocalURL();
?>
				">
<?php
	echo $topic['name'] ;
?>
				</a>
<?php
	if ( $topic['range'] > 2 )
		print "<small> (" . $topic['left'] . "&rarr;" . $topic['right'] . ")</small><br />" ;
	echo "<div id='review_sidebar_range'>" . wfReviewExtensionGetTopicForm ( $topic ) . "</div>" ;
?>
<?php
	}
	print "<input type='hidden' name='review_oldid' value='{$revision}'/>\n" ;
	if ( count ( $ratings ) > 1 ) {
		# "Merge" CHECKBOX
		print "<div id='review_sidebar_range'><input type='checkbox' checked name='do_merge' value='1'/>" . wfMsgForContent ( 'review_do_merge' ) . "</div>\n";
	} else {
		# Hidden field "don't merge"
		print "<input type='hidden' name='do_merge' value='0'/>\n" ;
	}
	print "<input style='width:100%' type='submit' name='save_review' value='" . wfMsgForContent('review_save') . "'/>" ;
	print "<div id='review_sidebar_note'>" ;
	print wfMsgForContent ( 'review_sidebar_explanation' ) ;
	if ( count ( $ratings ) > 1 ) {
		print " " . wfMsgForContent ( 'review_sidebar_you_have_other_reviews_for_this_article' ) ;
	}
	print "<br />" ;
	$stat_title = Title::makeTitleSafe( NS_SPECIAL, "Review" );
	$link = $skin->makeLinkObj( $stat_title, wfMsgHTML( 'review_page_link' ), "mode=view_page_statistics&page_id=".$wgTitle->getArticleID() );
	$out = str_replace ( "$1" , $link , wfMsg ( 'review_sidebar_final' ) ) ;
	print $out ;
?>
	</div></form>
	<ul>
<?php
	return true ;
}


# ____________________________________________________________________
# Class / Special Page

/**
* @todo document
*/
function wfReviewExtensionFunction () {
	global $IP, $wgMessageCache;
	wfReviewExtensionInitMessages();

	// FIXME : i18n
	$wgMessageCache->addMessage( 'review', 'Review' );

	require_once( "$IP/includes/SpecialPage.php" );

	/**
	* Constructor
	*/
	class SpecialReview extends SpecialPage {
	
		function SpecialReview() {
			SpecialPage::SpecialPage( 'Review' );
			$this->includable( true );
			wfReviewExtensionInitMessages();
		}

		/**
		* Returns the reviewed revision numbers for the page
		* @param $title The page title
		* @return Array[] => val_revision
		*/
		function get_reviewed_revisions ( $title ) {
			$fname = 'get_reviewed_revisions';
			
			$dbr =& wfGetDB( DB_SLAVE );
			$res = $dbr->select(
					/* FROM   */ 'validate',
					/* SELECT */ 'DISTINCT val_revision',
					/* WHERE  */ array ( 'val_page' => $title->getArticleID() ),
					$fname
			);
			$ret = array () ;
			while ( $line = $dbr->fetchObject( $res ) ) {
				$ret[] = $line->val_revision ;
			}
			return $ret ;
		}

		/**
		* Returns all review data for a single revision of a page
		* @param $title The page
		* @param $revision The revision ID
		* @return array of objects with one review each
		*/
		function get_reviews_for_revision ( $title , $revision ) {
			$conds = array (
				'val_page' => $title->getArticleID() ,
				'val_revision' => $revision ,
			) ;
		
			# Query
			$dbr =& wfGetDB( DB_SLAVE );
			$res = $dbr->select(
					/* FROM   */ 'validate',
					/* SELECT */ '*',
					/* WHERE  */ $conds,
					__METHOD__
			);

			$ret = array() ;
			while ( $line = $dbr->fetchObject( $res ) ) {
				$ret[] = $line ;
			}
			return $ret ;
		}

		/**
		* Sum up the review data for a single revision and add it to $statistics
		* @param $title The page
		* @param $revision The revision ID
		* @param $reviews The array of reviews
		* @param $statistics The array of overall statistics
		* @return Data for this revision, as an array of objects (same nomenclature as for $statistics)
		*/
		function analyze_review_data ( $title , $revision , &$reviews , &$statistics ) {
			global $wgReviewExtensionTopics ;

			# Read data
			$data = array () ;
			foreach ( $reviews AS $review ) {
				$type = $review->val_type ;
				if ( !isset ( $data[$type] ) ) {
					# Set dummy values
					$data[$type] = "" ;
					$data[$type]->total_count = 0 ;
					$data[$type]->anon_count = 0 ;
					$data[$type]->sum = 0 ;
					$data[$type]->max = $wgReviewExtensionTopics[$type]['range'] ;
				}
				$data[$type]->total_count++ ;
				if ( $review->val_user == 0 )
					$data[$type]->anon_count++ ;
				$data[$type]->sum += $review->val_value ;
				$data[$type]->comment = $review->val_comment ;
			}

			# Add data to overall statistics
			foreach ( $data AS $type => $v ) {
				if ( !isset ( $statistics[$type] ) ) {
					$statistics[$type] = $v ;
					continue ;
				}
				$statistics[$type]->total_count += $v->total_count ;
				$statistics[$type]->anon_count += $v->anon_count ;
				$statistics[$type]->sum += $v->sum ;
			}
			return $data ;
		}

		/**
		* Returns a HTML table row for the statistics of a revision. Output heavy!
		* @param $title The page
		* @param $revision The revision ID (or -1 for table header, 0 for total statistics)
		* @param $data The data for this revision
		* @param $revision_mode Set "true" when viewing an individual revision
		* @return HTML table row
		*/
		function get_revision_statistics_row ( $title , $revision , &$data , $revision_mode = false ) {
			global $wgReviewExtensionTopics , $wgUser , $wgTitle , $wgRequest , $wgReviewFeatureSingleUserMode ;
			$skin =& $wgUser->getSkin() ;

			# Row header
			$ret = "<tr><th id='review_statistics_table_header' align='left' nowrap>" ;
			if ( $revision < 0 ) {
				# Table headersconcerns
				if ( $revision == -1 ) {
					$ret .= wfMsgForContent ( 'review_statistics_left_corner' ) ;
				} else {
					$rev_id = $wgRequest->getInt ( 'rev_id' , 0 ) ;
					$page_id = $title->getArticleID() ;
					$version_link = $skin->makeLinkObj ( $title , wfMsgForContent('review_version_link',$rev_id) , "oldid={$rev_id}" ) ;
					$ret .= $version_link ;
					}
			} else if ( $revision == 0 ) {
				# Total statistics
				$ret .= wfMsgForContent ( 'review_total_statistics' ) ;
			} else if ( $revision_mode ) {
				# User
				$ak = array_keys ( $data ) ;
				$k = array_shift ( $ak ) ;
				if ( $data[$k]->val_user == 0 ) {
					$user = new User ;
					$user->setName ( $data[$k]->val_ip ) ;
					$user_reviews = "user_ip=" . $data[$k]->val_ip ;
				} else {
					$user = new User ;
					$user->setID ( $data[$k]->val_user ) ;
					$user->loadFromDatabase() ;
					$user_reviews = "user_id=" . $data[$k]->val_user ;
				}
				$ret .= $skin->makeLinkObj ( $user->getUserPage() , $user->getName() ) ;
				$ret .= "<br />" ;
				$ret .= $skin->makeLinkObj ( $wgTitle ,
							wfMsgForContent('review_user_reviews') ,
							"mode=view_user_reviews&{$user_reviews}" ) ;
			} else {
				# Individual revision
				$page_id = $title->getArticleID() ;
				$version_link = $skin->makeLinkObj ( $title , wfMsgForContent('review_version_link',$revision) , "oldid={$revision}" ) ;
				$version_review_link = $skin->makeLinkObj ( $wgTitle , wfMsgForContent('review_version_reviews_link') ,
							"mode=view_version_statistics&page_id={$page_id}&rev_id={$revision}" ) ;
				$ret .= $version_link . "<br />" . $version_review_link ;
			}
			$ret .= "</th>" ;

			foreach ( $wgReviewExtensionTopics AS $type => $topic ) {
				if ( $revision < 0 ) {
					# Table header row
					$ret .= "<th id='review_statistics_table_header'>{$topic['name']}</th>" ;
				} else if ( $revision_mode ) {
					$ret .= "<td id='review_statistics_table_cell'>" ;
					if ( isset ( $data[$type] ) ) {
						$ret .= "<div id='" ;
						$ret .= "review_radio_" . $data[$type]->val_value . "_of_" . $topic['range'] ;
						$ret .= "'>" ;
						$ret .= wfMsgForContent ( 'review_version_statistic_cell' , $data[$type]->val_value , $topic['range'] ) ;
						$ret .= "</div>" ;
					} else {
						$ret .= "&mdash;" ;
					}
					$ret .= "</td>" ;
				} else {
					$ret .= "<td id='review_statistics_table_cell'>" ;
					if ( isset( $data[$type] ) && $data[$type]->total_count > 0 ) {
						$average = $data[$type]->sum / $data[$type]->total_count ;
						$ret .= "<div id='" ;
						$ret .= "review_radio_" . (int) $average . "_of_" . $data[$type]->max ;
						$ret .= "'>" ;
						if ( $wgReviewFeatureSingleUserMode && $revision > 0 ) {
							$ret .= wfMsgForContent ( 'review_version_statistic_cell' ,
											sprintf ( "%1.1f" , $average ) ,
											$data[$type]->max
							) ;
							$ret .= "<br />" . htmlentities ( $data[$type]->comment ) ;
						} else {
							$ret .= wfMsgForContent ( 'review_statistic_cell' ,
											sprintf ( "%1.1f" , $average ) ,
											$data[$type]->max ,
											$data[$type]->total_count ,
											$data[$type]->total_count - $data[$type]->anon_count ,
											$data[$type]->anon_count
							) ;
						}
						$ret .= "</div>" ;
					} else {
						$ret .= "&mdash;" ;
					}
					$ret .= "</td>" ;
				}
			}
			$ret .= "</tr>\n" ;
			return $ret ;
		}

		/**
		* Groups data *for a single revision* by user
		* @param $reviews The review data *for a single revision*
		* @return array[user arbitary key] => ( array[types] => revision data )
		*/
		function group_data_by_user ( &$reviews ) {
			$data = array () ;
			foreach ( $reviews AS $review ) {
				$type = $review->val_type ;
				$user = $review->val_user == 0 ? $review->val_ip : $review->val_user ;
				if ( !isset ( $data[$user] ) ) {
					$data[$user] = array () ;
				}
				$data[$user][$type] = $review ;
			}
			return $data ;
		}

		/**
		 * @param $user
		 * @todo document
		 */
		function get_list_of_pages_reviewed_by_user ( $user ) {
			$conds = array () ;
			wfReviewExtensionSetUserCondition ( $user , $conds ) ;
			$dbr =& wfGetDB( DB_SLAVE );
			$res = $dbr->select(
					/* FROM   */ 'validate',
					/* SELECT */ 'DISTINCT val_page',
					/* WHERE  */ $conds,
					$fname
			);

			$ret = array() ;
			while ( $line = $dbr->fetchObject( $res ) ) {
				$ret[] = $line->val_page ;
			}
			return $ret ;
		}
		
		/**
		 * @param $page
		 * @param $revision
		 * @todo document
		 */
		function review_page  ( $page , $revision ) {
			global $wgTitle, $wgUser , $wgReviewExtensionTopics, $wgArticle, $action, $wgRequest;
			$title = Title::newFromID ( $page ) ;
			
			# Do we care?
			if( !wfReviewExtensionDoesNamespaceApply ( $title->getNamespace() ) )
				return wfMsgForContent ( 'review_wrong_namespace' ) ;
			if ( $wgUser->isBlocked() )
				return wfMsgForContent ( 'review_blocked' ) ;
			
			# Initialize
			$out = "" ;
			$do_merge = $wgRequest->getBool ( 'do_merge' , false ) ;
			$skin =& $wgUser->getSkin() ;
			wfReviewExtensionInitMessages () ;
			$ratings = wfReviewExtensionGetUserRatingsForPage ( $title , $wgUser ) ;
			$did_update_review = wfReviewExtensionReadLastForm ( $ratings , $title , $do_merge ) ;
			if ( !isset ( $ratings[$revision] ) ) # Construct blank dummy, if necessary
				$ratings[$revision] = array () ;
			wfReviewExtensionPresetForm ( $wgReviewExtensionTopics , $ratings[$revision] ) ;
			
			$link = $skin->makeLinkObj( $title , wfMsgForContent('review_version_link',$revision) , "old_id={$revision}" );
			$out .= "<p>" . $link . "</p>" ;;
			$out .= "<form method='post' id='review_page_version'>" ;
			
			if ( $did_update_review )
				$out .= wfMsgForContent ( 'review_has_been_stored' ) . "<br />" ;
			
			$out .= wfMsgForContent ( 'review_your_review' ) . "<br />" ;
			$out .= "<table border='1' width='100%'>" ;
			$out .= "<tr><th align='left'>" . wfMsgForContent('review_topic') . "</th><th>" . wfMsgForContent('review_no_opinion') ;
			$out .= "</th><th colspan='3'>" . wfMsg('review_rating') . "</th><th>" ;
			$out .= wfMsg('review_comment') . "</th></tr>" ;
			foreach( $wgReviewExtensionTopics as $topic ) {
				$topic_title = Title::makeTitleSafe( NS_MEDIAWIKI, wfMsgForContent('review_topic_page').'#'.$topic['name'] );
				$link = $skin->makeLinkObj( $topic_title,$topic['name'] );
				$out .= "<tr><th align='left' nowrap>{$link}</th>" ;
				$out .= wfReviewExtensionGetTopicForm ( $topic , true ) . "</tr>" ;
				
			}
			$out .= "</table><p>" ;
			
			$out .= "<input type='hidden' name='review_oldid' value='{$revision}'/>\n" ;
			if ( count ( $ratings ) > 1 ) {
				# "Merge" CHECKBOX
				print "<input type='checkbox' checked name='do_merge' value='1'/>" . wfMsgForContent ( 'review_do_merge' ) . " \n";
			} else {
				# Hidden field "don't merge"
				print "<input type='hidden' name='do_merge' value='0'/>\n" ;
			}
			$out .= "<input type='submit' name='save_review' value='" . wfMsgForContent('review_save') . "'/>" ;

			$out .= "</p></form>" ;
			return $out ;
		}

		/**
		* Special page main function
		*/
		function execute( $par ) {
			global $wgRequest , $wgOut , $wgUser , $wgTitle ;
			wfReviewExtensionInitMessages () ;

			$out = "" ;
			$skin =& $wgUser->getSkin () ;
			$mode = $wgRequest->getText ( 'mode' , 'view_page_statistics' ) ;
			$page_id = $wgRequest->getInt ( 'page_id' , 0 ) ;
			$rev_id = $wgRequest->getInt ( 'rev_id' , 0 ) ;
			$user_id = $wgRequest->getInt ( 'user_id' , 0 ) ;
			$user_ip = $wgRequest->getText ( 'user_ip' , "" ) ;
			$error = false ;

			if ( $user_id != 0 OR $user_ip != "" ) {
				$theuser = new User ;
				if ( $user_id == 0 ) {
					$theuser->setName ( $user_ip ) ;
				} else {
					$theuser->setID ( $user_id ) ;
					$theuser->loadFromDatabase() ;
				}
			}
			
			if ( $page_id == 0 ) {
				if( $par != ''){
					$title = Title::newFromUrl($par);
					$page_id = $title->getArticleID();
				}
				else{
					$title = NULL ;
				}
			} else {
				$title = Title::newFromID ( $page_id ) ;
			}

			# Info ahead
			$o = array () ;
			if ( $page_id != 0 ) {
				$link = $skin->makeLinkObj( $title ) ;
				$o[] = wfMsgForContent ( 'review_concerns_page' , $link ) ;
			}
			if ( isset ( $theuser ) ) {
				$link = $skin->makeLinkObj ( $theuser->getUserPage() , $theuser->getName() ) ;
				$o[] = wfMsgForContent ( 'review_concerns_user' , $link ) ;
			}
			if ( $page_id > 0 AND $rev_id > 0 ) {
				$link = $skin->makeLinkObj( $wgTitle , wfMsgForContent('revision_review_this_page_version_link') , "&mode=review&page_id={$page_id}&rev_id={$rev_id}" ) ;
				$o[] = $link ;
			}
			if ( count ( $o ) > 0 ) {
				$out .= "<ul><li>" . implode ( "</li>\n<li>" , $o ) . "</li></ul>" ;
			}

			// FIXME: use private methods!
			# Modes
			if ( $mode == 'view_page_statistics' && $title != null ) {
				# View statistics for one page
				$revisions = $this->get_reviewed_revisions ( $title ) ;
				arsort ( $revisions ) ; # Newest first
				if ( count ( $revisions ) == 0 ) {
					$out .= wfMsgForContent ( 'review_no_reviews_for_page' , $skin->makeLinkObj( $title ) ) ;
				} else {
					# Load review data for each version separately to avoid memory apocalypse
					$statistics = array() ;
					$out .= "<table id='review_statistics_table'>\n" ;
					$out .= $this->get_revision_statistics_row ( $title , -1 , $statistics ) ;
					$out2 = "" ;
					foreach ( $revisions AS $revision ) {
						$reviews = $this->get_reviews_for_revision ( $title , $revision ) ;
						$data = $this->analyze_review_data ( $title , $revision , $reviews , $statistics ) ;
						$out2 .= $this->get_revision_statistics_row ( $title , $revision , $data ) ;
					}
					$out .= $this->get_revision_statistics_row ( $title , 0 , $statistics ) ;
					$out .= $out2 ;
					$out .= "</table>\n" ;
				}
				$page_title = wfMsgForContent ( 'review_for_page' , $title->getPrefixedText() ) ;
			} else if ( $mode == 'view_version_statistics' && $title != null ) {
				# View statistics for a specific version of a page
				$data = array () ;
				$out .= "<table id='review_statistics_table'>\n" ;
				$out .= $this->get_revision_statistics_row ( $title , -2 , $data ) ;
				$reviews = $this->get_reviews_for_revision ( $title , $rev_id ) ;
				$this->analyze_review_data ( $title , $rev_id , $reviews , $data ) ;
				$out .= $this->get_revision_statistics_row ( $title , 0 , $data ) ; # Statistics for the revision
				$data = $this->group_data_by_user ( $reviews ) ;
				foreach ( $data AS $entry ) {
					$out .= $this->get_revision_statistics_row ( $title , 1 , $entry , true ) ;
				}
				$out .= "</table>\n" ;
				$page_title = wfMsgForContent ( 'review_for_page' , $title->getPrefixedText() ) ;
			} else if ( $mode == 'view_user_reviews' AND isset ( $theuser ) ) {
				if ( $page_id != 0 ) {
					# View the reviews of a user for a specific page
					global $wgReviewFeatureSingleUserMode ;
					$wgReviewFeatureSingleUserMode = true ;
					$revisions = wfReviewExtensionGetUserRatingsForPage ( $title , $theuser ) ;
					
					$statistics = array() ;
					$out .= "<table id='review_statistics_table'>\n" ;
					$out .= $this->get_revision_statistics_row ( $title , -1 , $statistics ) ;
					$out2 = "" ;
					foreach ( $revisions AS $revision => $reviews ) {
						$data = $this->analyze_review_data ( $title , $revision , $reviews , $statistics ) ;
						$out2 .= $this->get_revision_statistics_row ( $title , $revision , $data ) ;
					}
					$out .= $this->get_revision_statistics_row ( $title , 0 , $statistics ) ;
					$out .= $out2 ;
					$out .= "</table>\n" ;
					$wgReviewFeatureSingleUserMode = false ;

				} else {
					# View the pages reviewed by a user
					$data = $this->get_list_of_pages_reviewed_by_user ( $theuser ) ;
					$out .= "<h2>" . wfMsgForContent ( 'review_user_page_list' ) . "</h2>\n" ;
					$data2 = array () ;
					if ( $user_id == 0 )
						$user_link = "user_ip=".$user_ip ;
					else
						$user_link = "user_id=".$user_id ;
					foreach ( $data AS $pid ) {
						$t = Title::newFromID ( $pid ) ;
						$link1 = $skin->makeLinkObj ( $t ) ;
						$link2 = $skin->makeLinkObj ( $wgTitle ,
							wfMsgForContent('review_user_details_link') ,
							"mode=view_user_reviews&" . $user_link . "&page_id={$pid}"
						) ;
						$data2[] = $link1 . " " . $link2 ;
					}
					asort ( $data2 ) ;
					if ( count ( $data2 ) > 0 )
						$out .= "<ol><li>" . implode ( "</li>\n<li>" , $data2 ) . "</li></ul>" ;
				}
				$page_title = wfMsgForContent ( 'review_for_user' , $theuser->getName() ) ;
			} else if ( $mode == 'review' ) {
				$out = $this->review_page ( $page_id , $rev_id ) ;
				$page_title = wfMsgForContent ( 'review_page_review' , $title->getPrefixedText() ) ;
			} else {
				$error = true ;
			}
		
			$this->setHeaders();
			if ( $error ) {
				$wgOut->addHtml( wfMsgForContent ( 'review_error' ) );
			} else {
				$wgOut->setPageTitle ( $page_title ) ;
				$wgOut->addHtml( $out );
			}
		}
	} # end of class SpecialReview

	SpecialPage::addPage(new SpecialReview);
}
