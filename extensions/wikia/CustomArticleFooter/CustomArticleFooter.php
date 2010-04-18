<?php
$wgHooks['CustomArticleFooter'][] = 'wfCustomArticleFooter';

function wfCustomArticleFooter(  $skin , &$tpl, &$custom_article_footer ) {

	global $IP, $wgUser, $wgTitle, $wgOut, $wgUploadPath, $wgMemc, $wgSitename, $wgProblemReportsEnable;
	//because of changes in hook call, move condition here
	if (!($wgTitle->exists() && $wgTitle->isContentPage() && !$wgTitle->isTalkPage() && $wgOut->isArticle())) {
		return true;
	}

	$page_title_id = $wgTitle->getArticleID();

	$key = wfMemcKey( 'recenteditors', 'list', $page_title_id );
	$data = $wgMemc->get( $key );
	$editors = array();
	if(!$data ) {
		wfDebug( "loading recent editors for page {$page_title_id} from db\n" );

		$dbr =& wfGetDB( DB_SLAVE );
		$sql = "SELECT DISTINCT rev_user, rev_user_text FROM revision WHERE rev_page = {$page_title_id} and rev_user <> 0 and rev_user_text<>'Mediawiki Default' ORDER BY rev_id DESC LIMIT 0,8";
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchObject( $res ) ) {
			$editors[] = array( "user_id" => $row->rev_user, "user_name" => $row->rev_user_text);
		}

		$wgMemc->set( $key, $editors, 60 * 30 );
	} else {
		wfDebug( "loading recent editors for page {$page_title_id} from cache\n" );
		$editors = $data;
	}

	global $wgBlankImgUrl;
	$custom_article_footer .= "<div id=\"articleFooter\" class=\"reset\">
		<table cellspacing=\"0\">
			<tr>
				<td class=\"col1\">
					<div class=\"footer-recent-contributors-title\">
						Contribute
					</div>
					<div class=\"recent-contributors-message\">
						Did you know you can edit this page?
					</div>
					<ul class=\"actions\">
						<li>
							<a id=\"fe_edit_icon\" href=\"".$wgTitle->getEditURL()."\"><img src=\"$wgBlankImgUrl\" id=\"fe_edit_icon\" class=\"sprite edit\" /></a>
							<div>Improve Wikia by <a href=\"".$wgTitle->getEditURL()."\">".wfMsg('footer_1.5')."</a></div>
						</li>
						<li>
							<a id=\"fe_history_icon\" href=\"".$skin->data['content_actions']['history']['href']."\"><img src=\"$wgBlankImgUrl\" id=\"fe_history_icon\" class=\"sprite history\" /></a>
							<div><a href=\"".$skin->data['content_actions']['history']['href']."\">".$skin->data['content_actions']['history']['text']."</a></div>
						</li>
						<li>
							<a id=\"fe_random_icon\" href=\"" . Title::makeTitle(NS_SPECIAL,"Random")->escapeFullURL() . "\"><img src=\"$wgBlankImgUrl\" id=\"fe_random_icon\" class=\"sprite random\" /></a>
							<div><a id=\"fe_random_link\" href=\"" . Title::makeTitle(NS_SPECIAL,"Random")->escapeFullURL() . "\">".wfMsg('footer_6')."</a></div>
						</li>";

				if (!empty($wgProblemReportsEnable)) {
					$custom_article_footer .= "
						<li id=\"fe_report_link\">
							<a id=\"fe_create_icon\" href=\"#wikia_header\"><img src=\"$wgBlankImgUrl\" id=\"fe_report_icon\" class=\"sprite error\" /></a>
							<div><a href=\"#wikia_header\">".wfMsg('reportproblem')."</a></div>
						</li>";
				}

				$custom_article_footer .= "
					</ul>
				</td>";

				if (count($editors)>0) {

				$custom_article_footer .= "<td class=\"col2\">
				<div class=\"footer-recent-contributors\">
					<div class=\"footer-recent-contributors-title\">
						Recent Contributors
					</div>
					<div class=\"recent-contributors-message\">
						The following people recently contributed to this article
					</div>";

					$x=1;
					$per_row=4;

						foreach($editors as $editor) {
							$avatar = new wAvatar($editor["user_id"],"m");
							$user_title = Title::makeTitle(NS_USER,$editor["user_name"]);

							$custom_article_footer .= "<a href=\"{$user_title->escapeFullURL()}\" rel=\"nofollow\"><img src=\"{$wgUploadPath}/avatars/{$avatar->getAvatarImage()}\" alt=\"\" border=\"0\"/></a>";

							if($x==count($editors) || $x!=1 && $x%$per_row ==0) {
								$custom_article_footer .= "<br/>";
							}

							$x++;

						}

				$custom_article_footer .= "</div></td>";

			}

			$custom_article_footer .= "</tr>
		</table>
	</div>";
	return true;
}

?>
