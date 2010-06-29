<!-- user mailer -->
<fieldset id="mailer">
    <legend><?= wfMsg('emailpage') ?></legend>

<?php
	global $wgCityId;

	// wiki is in read-only mode
	if ( $is_readonly ) {
?>
   <h4><?= wfMsg('readonly') ?></h4>
<?php
	}
	// no email provided
	else if (empty($problem['email'])) {
?>
    <p><?= wfMsg('noemailtitle') ?></p>
<?php
	}
	// force sending emails from wiki problem was reported from (RT #14522)
	else if ($wgCityId != $problem['city'] ) {
		// generate URL to problem report
		$url = $problem['server'] . '/index.php?title=Special:ProblemReports/' . $problem['id'];
?>
	<?= wfMsgExt('pr_mailer_go_to_wiki', 'parse', $url) ?>
<?php
	}
	// now we can show mailer form
	else {
?>
    
    <form action="<?= Title::newFromText('ProblemReports/mailer', NS_SPECIAL)->escapeLocalURL() ?>" method="post">
    
    <input type="hidden" name="mailer-id" id="mailer-id" value="<?= $problem['id'] ?>" />
    
    <div id="mailer-notice"><?= wfMsg('pr_mailer_notice') ?></div>
    
    <div class="headers">
		<label for="mailer-from"><?= wfMsg('emailfrom') ?></label><input type="text" name="mailer-from" id="mailer-from" value="<?= htmlspecialchars($mailer_from) ?>" disabled="disabled" /><br />
		<label for="mailer-to"><?= wfMsg('emailto') ?></label><input type="text" name="mailer-to" id="mailer-to" value="<?= htmlspecialchars($problem['reporter']) ?> <?= ($isStaff ? '&lt;'.htmlspecialchars($problem['email']).'&gt;' : wfMsg('pr_mailer_to_default')) ?>" disabled="disabled" /><br />
		<label for="mailer-subject"><?= wfMsg('emailsubject') ?></label><input type="text" name="mailer-subject" id="mailer-subject" value="[<?= SpecialProblemReports::makeEmailTitle($problem['city']).'] '.wfMsg('pr_mailer_subject') ?> &quot;<?= htmlspecialchars($problem['title']) ?>&quot;" /><br />
    </div>
    
    <label for="mailer-message"><?= wfMsg('emailmessage') ?></label>
    
    <div id="mailer-templates">
		<?= str_replace('<ul', '<ul id="mailer-templates-list"', $wgOut->parse(wfMsg('ProblemReportsResponses'))) ?>
		<div style="margin: 20px 0 0 50px; text-align: right; font-size: 0.9em"><?= $wgOut->parse(wfMsg('pr_mailer_tmp_info')) ?></div>
	</div>
    
    <textarea name="mailer-message" id="mailer-message" rows="15">


----
<?= $problem['server'] . Title::newFromText('ProblemReports/'.$problem['id'], NS_SPECIAL)->escapeLocalURL(); ?></textarea><br style="clear: both" />
    <input type="checkbox" name="mailer-ccme" id="mailer-ccme" /><label for="mailer-ccme"><?= wfMsg('emailccme') ?></label><br />
    
    <div class="actionBar">
		<input id="mailer-send" class="wikia-button" type="submit" value="<?= wfMsg('emailsend') ?>" />
    </div>
    
    <script type="text/javascript">/*<![CDATA[*/
		reportProblemMailerResponsesTemplatesSetup(YAHOO.util.Dom.get('mailer-templates-list'), YAHOO.util.Dom.get('mailer-message'), "<?= $problem['server'] . Title::newFromText('ProblemReports/'.$problem['id'], NS_SPECIAL)->escapeLocalURL(); ?>");
    /*]]>*/</script>
    
    </form><?php } ?>
</fieldset>
<!-- /user mailer -->
