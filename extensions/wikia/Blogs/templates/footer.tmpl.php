<!-- s:<?= __FILE__ ?> -->
<?php
$url = htmlspecialchars( $oTitle->getFullURL() );
$title = htmlspecialchars( $oTitle->getText() );
?>
<br />
<div id="articleFooter" class="reset" style="clear:both;">
	<table cellspacing="0">
		<tr>
			<td class="col1">
				<ul class="actions" id="articleFooterActions">
					<li><a rel="nofollow" id="fe_edit_icon" href="<?= htmlspecialchars(Title::newFromText("CreateBlogPage", NS_SPECIAL)->getLocalUrl()) ?>"><img src="<?= $wgStylePath ?>/monobook/blank.gif" id="fe_edit_icon" class="sprite" alt="<?= wfMsg("blog-create-label") ?>" /></a> <div><a id="fe_edit_link" rel="nofollow" href="<?= htmlspecialchars(Title::newFromText("CreateBlogPage", NS_SPECIAL)->getLocalUrl()) ?>"><?= wfMsg("blog-create-next-label") ?></a></div></li>
					<li id="fe_talk"><a rel="nofollow" id="fe_talk_icon" href="<?= $oTitle->getLocalURL("action=history") ?>"><img src="<?= $wgStylePath ?>/monobook/blank.gif" id="fe_talk_icon" class="sprite" alt="<?= wfMsg('history_short') ?>" /></a> <div><a id="fe_talk_link" rel="nofollow" href="<?= $oTitle->getLocalURL("action=history") ?>"><?= wfMsg('history_short') ?></a></div></li>
					<li id="fe_permalink"><a rel="nofollow" id="fe_permalink_icon" href="<?= $oTitle->getLocalURL("oldid={$oTitle->getLatestRevID()}") ?>"><img src="<?= $wgStylePath ?>/monobook/blank.gif" id="fe_permalink_icon" class="sprite" alt="<?= wfMsg('permalink') ?>" /></a> <div><a id="fe_permalink_link" rel="nofollow" href="<?= $oTitle->getLocalURL("oldid={$oTitle->getLatestRevID()}") ?>"><?= wfMsg('permalink') ?></a></div></li>
					<li><?php (isset($oUserTitle) && $oUserTitle->exists()) ? '<a id="fe_user_icon" rel="nofollow" href="'.$oUserTitle->getLocalUrl().'">' : '' ?><img src="<?= $wgStylePath ?>/monobook/blank.gif" id="fe_user_icon" class="sprite" alt="<?= wfMsg('userpage') ?>" /><?= (isset($oUserTitle) && $oUserTitle->exists()) ? '</a>' : '' ?> <div><?= wfMsg('footer_5', '<a id="fe_user_link" rel="nofollow" '.((isset($oUserTitle) && $oUserTitle->exists()) ? '' : ' class="new" ').'href="'.$oUserTitle->getLocalUrl().'">'.$username.'</a>', $lastUpdate) ?></div></li>
				</ul>
<?php if ( $voting_enabled ): ?>
				<strong><?= wfMsgHtml('rate_it') ?></strong>
				<div id="star-rating-wrapper">
					<ul id="star-rating" class="star-rating">
						<li style="width: <?php echo $ratingPx ?>px;" id="current-rating" class="current-rating"><span><?= $rating ?>/5</span></li>
						<li><a class="one-star" id="star1" title="1/5"<?=$hidden_star?>><span>1</span></a></li>
						<li><a class="two-stars" id="star2" title="2/5"<?=$hidden_star?>><span>2</span></a></li>
						<li><a class="three-stars" id="star3" title="3/5"<?=$hidden_star?>><span>3</span></a></li>
						<li><a class="four-stars" id="star4" title="4/5"<?=$hidden_star?>><span>4</span></a></li>
						<li><a class="five-stars" id="star5" title="5/5"<?=$hidden_star?>><span>5</span></a></li>
					</ul>
					<span style="<?= ($voted ? '' : 'display: none;') ?>" id="unrateLink"><a id="unrate" href="#"><?php echo wfMsg( 'unrate_it' ) ?></a></span>
				</div>
<?php endif ?>
			</td>
			<td class="col2">
				<ul class="actions" id="articleFooterActions2">
					<li><a rel="nofollow" id="fe_random_icon" href="<?= Skin::makeSpecialUrl( 'Randompage' ) ?>"><img src="<?= $wgStylePath ?>/monobook/blank.gif" id="fe_random_icon" class="sprite" alt="<?= wfMsg('randompage') ?>" /></a> <div><a rel="nofollow" id="fe_random_link" href="<?= Skin::makeSpecialUrl( 'Randompage' ) ?>"><?= wfMsg('footer_6') ?></a></div></li>
<?php if ( !empty($wgProblemReportsEnable) ): ?>
					<li><img src="<?= $wgStylePath ?>/monobook/blank.gif" id="fe_report_icon" class="sprite" alt="<?= wfMsg('blogs-reportproblem') ?>" /> <div><a style="cursor:pointer" id="fe_report_link"><?= wfMsg('blogs-reportproblem') ?></a></div></li>
<?php endif ?>
<?php if ( !empty($wgNotificationEnableSend) ): ?>
					<li><img src="<?= $wgStylePath ?>/monobook/blank.gif" id="fe_email_icon" class="sprite" alt="email" /> <div><a href="#" id="shareEmail_a"><?= wfMsg('footer_7') ?></a></div></li>
<?php endif ?>
					<strong><?= wfMsg('footer_8') ?>:</strong>
					<div id="share">
					<dl id="shareDelicious" class="share">
						<dt>del.icio.us</dt>
						<dd><a rel="nofollow" href="http://del.icio.us/post?v=4&amp;noui&amp;jump=close&amp;url=<?=$url?>&amp;title=<?=$title?>" id="shareDelicious_a"></a></dd>
					</dl>
					<dl id="shareStumble" class="share">
						<dt>StumbleUpon</dt>
						<dd><a rel="nofollow" href="http://www.stumbleupon.com/submit?url=<?=$url?>&amp;title=<?=$title?>" id="shareStumble_a"></a></dd>
					</dl>
					<dl id="shareDigg" class="share">
						<dt>Digg</dt>
						<dd><a rel="nofollow" href="http://digg.com/submit?phase=2&amp;url=<?=$url?>&amp;title=<?=$title?>" id="shareDigg_a"></a></dd>
					</dl>
					<dl id="shareFacebook" class="share">
						<dt>Facebook</dt>
						<dd><a rel="nofollow" href="http://www.facebook.com/share.php?u=<?=$url?>" id="shareFacebook_a"></a></dd>
					</dl>
					</div>
				</ul>
			</td>	
		</tr>
	</table>
</div>
<!-- e:<?= __FILE__ ?> -->
