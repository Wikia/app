<?php

class TopAwards extends UnlistedSpecialPage {

	/**
	 * Constructor
	 */
	public function __construct(){
		parent::__construct('TopAwards');
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ){
		global $wgRequest, $wgOut, $wgUser, $wgUploadPath, $wgDBprefix, $wgScriptPath;

		// Variables 
		$output = '';
		$gift_name_check = '';
		$x = 0;
		$category_number = $wgRequest->getVal( 'category' );

		// System gift class array		
		$categories = array(
			array('category_name' => 'Edit', 'category_threshold' => '500', 'category_id' => 1),
			array('category_name' => 'Vote', 'category_threshold' => '2000', 'category_id' => 2),
			array('category_name' => 'Comment', 'category_threshold' => '1000', 'category_id' => 3),
			array('category_name' => 'Recruit', 'category_threshold' => '0', 'category_id' => 7),
			array('category_name' => 'Friend', 'category_threshold' => '25', 'category_id' => 8)
		);

		// Set title
		if( !($category_number) or $category_number > 4 ) {
			$category_number = 0;
			$page_category = $categories[$category_number][category_name];
		} else {
			$page_category = $categories[$category_number][category_name];
		}

		// Database calls
		$dbr = wfGetDB( DB_MASTER );
		$sql = "SELECT sg_user_name, sg_user_id, gift_category, MAX(gift_threshold) AS top_gift FROM ".$wgDBprefix."user_system_gift INNER JOIN ".$wgDBprefix."system_gift ON gift_id=sg_gift_id WHERE gift_category = {$categories[$category_number][category_id]} AND gift_threshold > {$categories[$category_number][category_threshold]} GROUP BY sg_user_name ORDER BY top_gift DESC";
		$res = $dbr->query($sql);

		// Page title 
		$wgOut->setPageTitle("Top Awards - {$page_category} Milestones");

		// Style
		$output .= "<style>

			.top-awards {
				float:left;
				width:60%;
				padding-top:15px
			}

			.top-awards-navigation {
				float:right;
				margin:15px 0px 0px 0px;
				width:20%;
			}

			.top-awards-navigation p {
				margin:0px 0px 3px 0px;
			}

			.top-awards-navigation a {
				font-weight:bold;
				text-decoration:none;
			}

			.top-awards-navigation h1 {
				color:#333333;
				font-size:16px;
				font-weight:bold;
				padding:0px 0px 3px 0px;
				margin:0px 0px 10px 0px !important;
				border-bottom:1px solid #dcdcdc;
			}

			.top-award-title {
				font-size:16px;
				font-weight:bold;
				margin:0px 0px 18px 0px;
				color:#797979;
			}

			.top-award {
				margin:0px 0px 18px 0px;
				font-size:13px;
				color:#797979;
			}

			.top-award-number {
				font-size:16px;
				color:#dcdcdc;
				font-weight:bold;
				margin:0px 10px 0px 0px;
			}

			.top-award img {
				vertical-align:middle;
				margin:0px 3px 0px 0px;
			}

			.top-award a {
				font-size:16px;
				font-weight:bold;
				text-decoration:none;
			}
		</style>";

		$output .= '<div class="top-awards-navigation">
			<h1>Award Categories</h1>';

			$nav_x = 0;

			foreach( $categories as $award_type ) {

				if( $nav_x == $category_number ) {
					$output .= "<p><b>{$award_type[category_name]}s</b></p>";
				} else {
					$output .= "<p><a href=\"".$wgScriptPath."/index.php?title=Special:TopAwards&category={$nav_x}\">{$award_type[category_name]}s</a></p>";
				}
				$nav_x++;
			}

		$output .= '</div>';

		$output .= '<div class="top-awards">';

		while( $row = $dbr->fetchObject( $res ) ) {

			$user_name = $row->sg_user_name;
			$user_id = $row->sg_user_id;
			$avatar = new wAvatar($user_id, 'm');
			$top_gift = $row->top_gift;
			$gift_name = number_format($top_gift) . " {$categories[$category_number][category_name]}".( ( $top_gift > 1 ) ? 's' : '' )." Milestone";

				if( $gift_name !== $gift_name_check ) {
					$x = 1;
					$output .= "<div class=\"top-award-title\">
						{$gift_name}
					</div>";
				}  else {
					$x++;
				}

				$output .= "<div class=\"top-award\">
					<span class=\"top-award-number\">{$x}.</span>
					{$avatar->getAvatarURL()}
					<a href=\"".$wgScriptPath."/index.php?title=User:{$row->sg_user_name}\">{$user_name}</a>
				</div>";

				$gift_name_check = $gift_name;

		}

		$output .= '</div>
		<div class=\"cleared\"></div>';

		$wgOut->addHTML($output);
	}
}