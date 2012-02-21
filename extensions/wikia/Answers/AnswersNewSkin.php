<?php
/**
 * Answers for answer.wikia.com
 *
 * Translated from gwicke's previous TAL template version to remove
 * dependency on PHPTAL.
 *
 * @ingroup Skins
 * @author Nick Sullivan
 */

if( !defined( 'MEDIAWIKI' ) )
	die( -1 );

/**
 * Inherit main code from Monaco, set the CSS and template filter.
 * @ingroup Skins
 */

#uncomment when moving back require dirname(__FILE__) . '/Monaco.php';

class SkinAnswers extends SkinMonaco {

	var $skinname = 'answers';

	public function initPage(&$out) {
		parent::initPage( $out );
		$this->skinname  = 'answers';
		$this->stylename = 'answers';
		$this->template  = 'AnswersTemplate';
	}

	function setupSkinUserCss( OutputPage $out ) {
		global $wgHandheldStyle;

		parent::setupSkinUserCss( $out );

	}
}

/**
 * @ingroup Skins
 */
class AnswersTemplate extends MonacoTemplate {
	var $skin;

	/**
	 * Do any last-minute initialization before calling MonacoTemplate's execute() function which outputs the HTML for the page.
	 */
	function execute() {
		if(!isset($this->extraBodyClasses) || !is_array($this->extraBodyClasses)){
			$this->extraBodyClasses = array();
		}
		// Allow CSS to target just just this new Answers skin.  In most cases, the rules will just
		// be put in monaco_answers and therefore not need to target, but there are exceptions.  For
		// example, when the code to center the page is in monaco_answers and then combined CoreCSS
		// does not load, then the page fails ungracefully.  Now this one rule will be moved into CoreCSS
		// but target only this skin.
		array_unshift($this->extraBodyClasses, "custom_answers");

		parent::execute();
	}

	// Additional CSS, Javascript, etc. that appears in the HEAD tag
	function printAdditionalHead() {
		global $wgStyleVersion, $wgCdnStylePath;
		echo "<!-- Begin " . __METHOD__ . " -->\n";

		?>

<script type="text/javascript">/*<![CDATA[*/
// TODO - move this to .js file
function askQuestion(){
	var q = document.getElementById('answers_ask_field').value.replace(/\s/g,"_");
	if( !q ) { return false; }

	q = q.replace(/\?/g,""); //removes question mark
	q = q.replace(/_+/g,"_"); //we only want one space
	q = q.replace(/#/g,""); //we only want one space
	q = encodeURIComponent( q );

	var path = window.wgServer + window.wgArticlePath.replace("$1","");
	window.location = path + "Special:CreateQuestionPage?questiontitle=" + q.charAt(0).toUpperCase() + q.substring(1);
	return false;
}
/*]]>*/</script>
		<?php
	}

	// Override Monaco's default (remove the page bar, add the "Ask a question" box)
	function printPageBar(){
		global $wgUser;
		echo "<!-- page_bar removed via " . __METHOD__ . "-->\n";
		?>
		<?/* Off ro now echo AdEngine::getInstance()->getPlaceHolderIframe('TOP_LEADERBOARD'); */?>
		<br />
	<?php
	}

	private function answersPageBar(){
		global $wgUser, $wgTitle;
		if(!$wgUser->isAllowed('delete')) {
			// Only show it for admins
			return;
		}

		if (isset($this->data['articlelinks']['left'])) {
			$originalPageBar = $this->data['articlelinks']['left'];

			if (isset($this->data['articlelinks']['left']['share_feature'])) {
				$this->data['articlelinks']['left']['share_feature']['href']='#pagebar';
			}
		}

		echo '<a name="pagebar"></a>';

		// always print page bar to have accesskeys defined and hide it via CSS (RT #47700)
		$this->realPrintPageBar();

		if (isset($this->data['articlelinks']['left'])) {
			// Put them back
			$this->data['articlelinks']['left'] = $originalPageBar;
		}
	}

	function printFirstHeading(){
		global $wgTitle;
		$answer_page = Answer::newFromTitle( $wgTitle );
		if (! $answer_page->isQuestion()){
			// Default behaviour
			?><h1 class="firstHeading"><?php $this->data['displaytitle']!=""?$this->html('title'):$this->text('title') ?></h1><?php
			return;
		} else {
			// Don't display anything, this will be handled with $this->printContent();
		}
	}

	// Spotlights turned off for answers
	function printFooterSpotlights(){
		echo "<!-- spotlights removed via " . __METHOD__ . "-->\n";
	}


	// Answers as a leader board hard coded at the top, turn off Monaco's default.
	function getTopAdCode(){
		return "<!-- topAdCode removed via " . __METHOD__ . "-->\n";
	}


	// Override default content handling
	function printContent(){
		global $wgTitle, $wgUser, $wgCdnStylePath, $wgBlankImgUrl;
		$answer_page = Answer::newFromTitle( $wgTitle );

		if (ArticleAdLogic::isMainPage()){
			$this->printQuestionBox();
			echo parent::getTopAdCode();
			$this->html('bodytext');
			$this->answersPageBar();
			return true;
		} else if (!$answer_page->isQuestion()){
			// Default Monaco behavior
			$this->html('bodytext');
			$this->answersPageBar();
			return true;
		}

		// If it's a question view, display a special layout (below)
		?>

<!-- Begin layout from <?php echo __METHOD__ ?> -->
<div id="answers_article">
	<?php $this->printQuestionBox(); ?>
	<?php echo parent::getTopAdCode(); ?>


	<!-- LEFT COLUMN -->
	<div id="answers_left" class="answers-article-left">
		<div id="question_box">
<?php
	if (isset($this->data['content_actions']['move'])) {
?>
			<div id="question_edit_link">
				<?php global $wgBlankImgUrl; ?>
				<img src="<?php echo $wgBlankImgUrl; ?>" class="sprite edit" alt="<?php echo wfMsg('edit') ?>"/>
				<a href="<?php print $this->data['content_actions']['move']['href']?>" rel="nofollow" onclick="WET.byStr('articleAction/rephrase');"><?php echo wfMsg('editsection')?></a>
			</div>
<?php
	}
?>
			<div id="question_heading" class="dark_text_1"><?php echo wfMsg('q')?> <?php echo htmlspecialchars($this->html('title')) ?><?php echo wfMsg('?')?></div>

			<div id="question_attribution">
				<h3 class="question_title asked_title"><?php echo htmlspecialchars(wfMsg("asked_by"))?></h3>
				<?php
				// RT #48294
				if ($wgTitle->exists()) {
					$author = AttributionCache::getInstance()->getFirstContributor($wgTitle->getArticleId());
				}

				if (!empty($author)){ ?>
				<ul class="contributors reset clearfix">
				  <li><?php echo Answer::getUserBadge( $author ); ?></li>
				</ul>
				<?php } ?>
			</div><!-- question_attribution -->
		</div><!-- question_box -->

		<div id="category_level">
			<div id="answers_category_select">
				<?php
				global $wgRequest;
				if ( $wgRequest->getVal('action', 'view') == 'view' && $this->data['catlinks']) {
				  $this->html('catlinks');
				}?>
			</div><!-- answers_category_select -->
		</div><!-- category_level -->

		<?php
		global $wgRequest;
		global $wgBlankImgUrl;
		extract( $wgRequest->getValues( 'oldid', 'diff' ) );
		if ($answer_page->isArticleAnswered() || isset( $diff ) || isset( $oldid ) ) {
			?>
		<div id="answer_level">
			<div id="answer_box" class="accent" style="padding-bottom:12px"><!-- Clear the padding top set for unanswered questions -->
				<div id="answer_edit_link">
					<img src="<?php echo $wgBlankImgUrl; ?>" class="sprite edit" alt="<?php echo wfMsg('edit') ?>"/>
					<a href="<?php echo $this->data['content_actions']['edit']['href']?>"><?php echo wfMsg('editsection')?></a>
				</div>
				<div id="answer_heading" class="dark_text_1"><?php echo wfMsg('a')?></div>
				<div id="answer_content"><?php $this->html('bodytext'); ?></div>

				<!-- answer attribution -->
				<div id="answer_attribution" style="float:right">
				<?php
				if ($wgTitle->exists()) {
					echo $this->renderAttributionBox($answer_page, ( (!empty($author) && ($author['user_id'] == 0)) ? true : false ) );
				}
				?>
				</div>
				<?php $this->printStarRating(); ?>
			</div><!-- answer_box -->
		</div><!-- answer_level -->

	     <?php } else { // Unsanswersed question ?>
		<div id="answer_level">
		<div id="answer_box" class="accent">
			<div id="answer_follow_link">
				<img src="<?php echo $wgBlankImgUrl; ?>" class="sprite follow" alt="<?php echo wfMsg('watch') ?>" />
				<a href="<?=@$this->data['articlelinks']['left']['watch']['href']?>" rel="nofollow"><?php echo @$this->data['articlelinks']['left']['watch']['text']?></a>
			</div>
			<span id="answer_heading" class="dark_text_1"><?php echo wfMsg('answer_this_question')?></span>
				<?php $this->printUnansweredQuestionForm($wgTitle) ?>
			</div>
		</div><!-- answer_level -->
	     <?php } ?>


	</div><!-- /answers_left -->

	<!-- Right column -->
	<div id="answers_right" class="answers-article-right">
	<!-- the ads below the question -->
	<div id="questionTopAd" class="google-ad-unit"></div>
	<?php $this->printGoogleJsAd();
		$sk = $wgUser->getSkin();

	?>

	<!-- toolbox for answers -->
		<div id="qa_toolbox" class="qa_box accent">
			<div id="qa_toolbox_button_wrapper">
				<div id="qa_toolbox_button">
					<div id="qa_button">
						<?php
	// RT #47571
	$unansweredCategory = wfMsg('unanswered_category');

	echo $sk->makeKnownLinkObj( Title::makeTitle(NS_SPECIAL, "Randomincategory/{$unansweredCategory}"), wfMsg( 'qa-toolbox-button' ), '', '', '', 'onclick="WET.byStr(\'toolbox/random_unanswered\')"' );
?>
					</div>
				</div>
			</div>

			<div id="qa_toolbox_functions">
				<a name="qa_toolbox"></a>
				<span id="control_share_feature"><img class="sprite share" src="<?= $wgBlankImgUrl ?>" alt="Share"/><a href="#" onclick="ShareFeature.openDialog( '' ); WET.byStr('toolbox/share_feature')" id="qa_ca-share_feature" rel="nofollow"><?php echo wfMsg('qa-toolbox-share' ); ?></a></span>
				<span id="qa_toolbox_advancedtools_toggler">
					<a href="#qa_toolbox" onclick="$('#qa_toolbox_advancedtools_wrapper').toggle(); WET.byStr('toolbox/advanced_opentoggle'); "><?php echo wfMsg('qa-toolbox-tools' ); ?></a>
				</span>
			</div>
			<!-- Open by default if logged in -->
			<script>window.onload = function () {if (wgUserName !== null) { $('#qa_toolbox_advancedtools_wrapper').toggle();}};</script>

		<!-- this whole div hides / appears with respect to the toggle above -->
			<div id="qa_toolbox_advancedtools_wrapper">
				<div id="qa_toolbox_advancedtools_top">
					<ul>
						<li><?php echo $sk->makeKnownLinkObj( Title::makeTitle(NS_SPECIAL, 'recentchanges'), wfMsg( 'recentchanges' ), '', '', '', 'onclick="WET.byStr(\'toolbox/recent_changes\')"' );  ?></li>
						<li><?php echo $sk->makeKnownLinkObj( Title::makeTitle(NS_SPECIAL, 'specialpages'), wfMsg( 'specialpages' ), '', '', '', 'onclick="WET.byStr(\'toolbox/special_pages\')"' );  ?></li>
						<li><?php
	// RT #47569
	$pageName = !empty($wgTitle) ? $wgTitle->getText() : '';

	echo $sk->makeKnownLinkObj( Title::makeTitle(NS_SPECIAL, "whatlinkshere/{$pageName}"), wfMsg( 'whatlinkshere' ), '', '', '', 'onclick="WET.byStr(\'toolbox/what_links_here\')"' );  ?></li>
					</ul>
				</div>
				<div id="qa_toolbox_advancedtools_bottom" class="accent">
<?php
	$toolboxActions = array();

	if ($wgUser->isAllowed('protect')) {
		$toolboxActions[] = 'protect';
	}

	if ($wgTitle->exists() && $wgUser->isAllowed('delete')) {
		$toolboxActions[] = 'delete';
	}

	if ( $wgTitle->exists() ) {
		$toolboxActions[] = 'history';
	}

	foreach($toolboxActions as $action) {
?>
					<span id="qa_control_<?= $action ?>"><img class="sprite <?= $action ?>" src="<?= $wgBlankImgUrl ?>" alt="<?=wfMsg($action) ?>" />
						<?php echo $sk->makeKnownLinkObj( $wgTitle, wfMsg($action), "action={$action}", '', '', 'id="qa_ca-'.$action.'" onclick="WET.byStr(\'toolbox/'.$action.'\')" title="' . wfMsg( "qa-toolbox-{$action}" ) . '" rel="nofollow"', '')  ?>
					</span>
<?php
	}
?>
					<span id="qa_control_clear">&nbsp;</span>
				</div>
			</div>
		</div>
<?php
	$featuredSites = wfMsgExt( 'qa-featured-sites', array( 'parseinline' ) );
	if ( !wfEmptyMsg( 'qa-featured-sites', $featuredSites ) && !empty( $featuredSites ) && $featuredSites != '-' ) {
?>
		<div id="qa_featuredbox" class="qa_box">
			<?= $featuredSites; ?>
		</div>
<?php
	}
?>
	</div>

	<?php $this->answersPageBar(); ?>

</div><!-- id="answers_article"-->
	<?php
	}

	private function getGoogleHints(){
		static $hints = null;
		if (is_null($hints)){
			global $wgTitle, $wgSitename;
			$hints = array();
			$answer_page = Answer::newFromTitle( $wgTitle );
			if ( $answer_page->isQuestion(true) ) {
				$category_text = array();
				global $wgOut;
				$categories_array = $wgOut->getCategoryLinks();
				if( !empty( $categories_array["normal"] ) ){
					foreach($categories_array["normal"] as $ctg){
						$category_text[]=strip_tags($ctg);
					}
				}
				if ($category_text) {
					foreach($category_text as $ctg){
						if( strtoupper($ctg) != strtoupper(wfMsg("unanswered_category")) &&
						strtoupper($ctg) != strtoupper(wfMsg("answered_category")) ){
							$hints[] =  $ctg;
						}
					}
				}
			}
			$hints[] = $wgTitle->getText();
			$hints[] = trim(preg_replace('/(wiki|answers)/i', '', $wgSitename));
			$hints = implode(', ', $hints);
		}
		return $hints;
	}


	function printGoogleLinkUnit() {
		global $wgGoogleAdClient, $wgGoogleAdChannel;
		?>
		<div id="google_link_unit" style="margin-top:15px">
		<script type="text/javascript"><!--
		google_ad_client = "<?= $wgGoogleAdClient ?>";
		google_ad_channel = '<?= $wgGoogleAdChannel ?>';
		google_ad_region = 'region';
		google_ad_width = 468;
		google_ad_height = 15;
		google_color_border = "FFFFFF";
		google_color_bg     = "FFFFFF";
		google_color_link   = "002BB8";
		google_hints        = "<?php echo htmlspecialchars($this->getGoogleHints())?>";
		//-->
		</script>
		<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
		</div>
		<?php
	}

	function printGoogleJsAd($div = ''){
		global $wgGoogleAdClient, $wgGoogleAdChannel;
		?>
		<script type="text/javascript">
		function google_ad_request_done(google_ads) {
			var s = '';
			var i;

			/*
			* Verify that there are actually ads to display.
			*/
			if (google_ads.length == 0) {
				return;
			}

			var topAdContent = '';
			var middleAdsContent = '';

			topAdContent += '<small><a style="background:none" href=\"' + google_info.feedback_url + '\">Ads by Google</a></small>';
			middleAdsContent += '<small><a style="background:none" href=\"' + google_info.feedback_url + '\">Ads by Google</a></small>';

			for(i = 0; i < google_ads.length; ++i) {
				var href = '<a href="' +
					google_ads[i].url + '" onmouseout="window.status=\'\'" onmouseover="window.status=\'go to ' +
					google_ads[i].visible_url + '\';return true">';

				topAdContent += '<p>' + href + '<strong>' + google_ads[i].line1 + '</strong></a><br />' +
				google_ads[i].line2 + ' ' + google_ads[i].line3 + '<br />' +
				href + '<em>' + google_ads[i].visible_url + '</em></a></p>';
			}

			document.getElementById("questionTopAd").innerHTML = topAdContent;

			return;
		}

		google_ad_output = 'js';
		google_ad_channel = '<?= $wgGoogleAdChannel ?>';
		google_ad_region = 'region';
		google_max_num_ads = '2';
		google_ad_type = 'text';
		google_ad_client = "<?= $wgGoogleAdClient ?>";
		google_hints        = "<?php echo htmlspecialchars($this->getGoogleHints())?>";
		// ]]>
		</script>

		<script type="text/javascript" language="JavaScript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
	<?php
	}

	// Small wrapper that caches
	function getContributors() {
		global $wgTitle;
		static $contributors = null;
		if(is_null($contributors)) {
			$answerPage = Answer::newFromTitle( $wgTitle );
			$contributors = $answerPage->getContributors();
			# Reverse array for having "Unregistered" first
			$contributors = array_reverse( $contributors );
		}
		return $contributors;
	}

	function renderAttributionBox($answerPage, $isQuestionAskedByAnon = false) {
		global $wgUploadPath;

		$maxDisplayContributors = 3;

		$contributors = $this->getContributors();
		$helpersNum = 0;
		if(count($contributors) == 0) {
			return '';
		} else if( ($contributors[0]['user_name'] == 'helper') && (count($contributors) > $maxDisplayContributors) ) {
			// Skip the first one, which is the "Unregistered" users
			$helperContribs = array_shift($contributors);
			$helperEdits = $helperContribs['edits'] - 1;
			$maxDisplayContributors--;
		}

		// heading
		$ret = Xml::element('h3', array('class' => 'answer_title answered_title'), wfMsg("answered_by"));

		// use <ul> as a list wrapper
		$ret .= Xml::openElement('ul', array('class' => 'contributors reset clearfix'));

		$i = 1;
		foreach($contributors as $contributor) {
			if(($contributor['user_id'] == 0) && ($isQuestionAskedByAnon) && ($contributor['edits'] > 1)) {
				// substract the anon asker from "anon helpers"
				$contributor['edits']--;
			}
			$ret .= Xml::openElement('li');
			$ret .= Answer::getUserBadge($contributor);
			$ret .= Xml::closeElement('li');
			if( $i > $maxDisplayContributors ) {
				$ret .= Xml::openElement('li', array("class" =>"additional_helpers"));
				$ret .= wfMsgExt("plus_x_more_helpers", array('parseinline'), (count($contributors) - $maxDisplayContributors + $helperEdits));
				$ret .= Xml::closeElement('li');
				break;
			}
			$i++;
		}

		$ret .= Xml::closeElement('ul'); // END #contributors
		return $ret;
	}

	function printUnansweredQuestionForm($title){
		global $wgStylePath, $wgUser;

		// check whether current user is blocked (RT #48058)
		$isUserBlocked = $wgUser->isBlockedFrom($title, false);

		if ($isUserBlocked) {
			echo $this->getBlockedInfo();
			return;
		}
		?>
		<script src="<?=$wgStylePath?>/../extensions/wikia/JavascriptAPI/Mediawiki.js"></script>
		<form onsubmit="return handleEditForm(this)">
			<textarea name="article" class="answer-input" rows="7" id="article_textarea"></textarea><br />
			<script>document.getElementById("article_textarea").focus();</script>
			<span style="float:right"><input type="submit" value="save" id="article_save_button"/></span>
		</form>

		<script>
		function handleEditForm(f) {
			<?php
			global $wgReadOnly;
			if ($wgReadOnly){?>
				alert("<?php echo addslashes($wgReadOnly)?>");
				return false;
			<?php } ?>
			try {
				$("#article_save_button").val($("#article_save_button").val() + "...");
				$("#article_save_button").attr("disabled","disabled");
				Mediawiki.editArticle({
					"title": "<?php echo addslashes($title->getText())?>",
					"prependtext": $("#article_textarea").val()}, editArticleSuccess, apiFailed);
			} catch (e) {
				alert(Mediawiki.print_r(e));
			}
			return false; // Return false so that the form doesn't submit
		}

		function editArticleSuccess(){
			window.location.href = "<?php echo addslashes($title->getFullUrl())?>?cb=<?php echo mt_rand(1,10420)?>";
		}
		function apiFailed(e){
			alert(Mediawiki.print_r(e));
		}

		</script>
		<?php
	}


	/* Turn off the categories printed at the bottom in the Monaco skin */
	function printCategories(){
		global $wgRequest;
		if ( $wgRequest->getVal('action', 'view') == 'view') {
			echo "<!-- categories removed via " . __METHOD__ . "-->\n";
		} else {
			// Default behavior
			if($this->data['catlinks']) {
				$this->html('catlinks');
			}
		}
	}

	function printRequestWikiLink() {
		global $wgLang;
		//RT#53420
		$userlang = $wgLang->getCode();
		$userlang = $userlang == 'en' ? '' : "?uselang=$userlang";
		$link = "http://www.wikia.com/Special:CreateAnswers$userlang";

		echo '<!-- Begin ' . __METHOD__ . '-->';
		echo '<div id="requestWikiData">';
			echo '<a rel="nofollow" href="' . $link . '" id="request_wiki" class="wikia-button">'. wfMsg('createwikipagetitle') .'</a>';
		echo '</div>';

		// We also want one to appear in the footer
		$this->data['data']['wikiafooterlinks'][] = array(
			'text' => wfMsg('createwikipagetitle'),
			'href' => $link,
			'org' => $link,
			'desc' => '',
			'specialCanonicalName' => ''
		);

	}

	function printWikiaLogo() {
		echo '<!-- Begin ' . __METHOD__ . '-->';
		echo '<div id="wikia_logo"><a rel="nofollow" href="/">Wikia</a></div>';
	}


	private function printQuestionBox() { ?>
	<!-- The ask a question box -->
	<div class="yui-skin-sam" id="ask_wrapper">
		<div id="answers_ask">
			<div id="answers_ask_heading" class="dark_text_2"><?php echo wfMsg("ask_a_question")?></div>
			<form method="get" action="" onsubmit="return askQuestion();" name="ask_form" id="ask_form">
				<input type="text" id="answers_ask_field" value="" class="header_field alt" />
				<input type="submit" value="<?php echo htmlspecialchars(wfMsg("ask_button"))?>" id="ask_button"/>
			</form>
			<script>document.getElementById("answers_ask_field").focus();</script>
		</div> <!-- answers_ask -->
		<div id="answers_suggest"></div>
	</div><!-- ask_wrapper -->

	<div id="tagline" class="dark_text_2"><?php $this->msg('tagline') ?></div>
	<?php
	}

	/**
	 * Produce a "user is blocked" message.
	 */
	function getBlockedInfo() {
		global $wgUser, $wgContLang, $wgTitle, $wgLang;

		$name = User::whoIs( $wgUser->blockedBy() );
		$reason = $wgUser->blockedFor();
		if( $reason == '' ) {
			$reason = wfMsg( 'blockednoreason' );
		}
		$blockTimestamp = $wgLang->timeanddate( wfTimestamp( TS_MW, $wgUser->mBlock->mTimestamp ), true );
		$ip = wfGetIP();

		$link = '[[' . $wgContLang->getNsText( NS_USER ) . ":{$name}|{$name}]]";

		$blockid = $wgUser->mBlock->mId;

		$blockExpiry = $wgUser->mBlock->mExpiry;
		if ( $blockExpiry == 'infinity' ) {
			// Entry in database (table ipblocks) is 'infinity' but 'ipboptions' uses 'infinite' or 'indefinite'
			// Search for localization in 'ipboptions'
			$scBlockExpiryOptions = wfMsg( 'ipboptions' );
			foreach ( explode( ',', $scBlockExpiryOptions ) as $option ) {
				if ( strpos( $option, ":" ) === false )
					continue;
				list( $show, $value ) = explode( ":", $option );
				if ( $value == 'infinite' || $value == 'indefinite' ) {
					$blockExpiry = $show;
					break;
				}
			}
		} else {
			$blockExpiry = $wgLang->timeanddate( wfTimestamp( TS_MW, $blockExpiry ), true );
		}

		if ( $wgUser->mBlock->mAuto ) {
			$msg = 'autoblockedtext';
		} else {
			$msg = 'blockedtext';
		}

		/* $ip returns who *is* being blocked, $intended contains who was meant to be blocked.
		 * This could be a username, an ip range, or a single ip. */
		$intended = $wgUser->mBlock->mAddress;

		return wfMsgExt( $msg, array('parse'), $link, $reason, $ip, $name, $blockid, $blockExpiry, $intended, $blockTimestamp );
	}
} // end of class
