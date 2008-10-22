<?php
	global $wgServer, $wgLang, $wgContLang, $wgOut, $wgExtensionsPath, $wgCityId;
?>

<?= $problems_selector ?>

<div style="padding-top: 10px; clear: both"><?= $pager  ?></div>

<?php if (!empty($mailer_result)): ?><div class="usermessage problemreportsmailer">
<?php 
	echo htmlspecialchars($mailer_result);

	if (!empty($mailer_message)) {
		echo '<br />'. htmlspecialchars(urldecode($mailer_message));
	}
?></div><?php endif ?>

<!-- User ("<?= implode('", "', $userGroups); ?>") permissions: actions: <?= $can_do_actions ? 'yes' : 'no' ?> (here: <?= $can_do_actions_here ? 'yes' : 'no' ?>; cross: <?= $can_do_actions_cross ? 'yes' : 'no' ?>); remove: <?= $can_remove ? 'yes' : 'no' ?>; staff: <?= $isStaff ? 'yes' : 'no' ?> -->

<?php if ( $showall &&  $can_do_actions_here && !$can_do_actions_cross ) { // #2181
 $wgOut->addHTML('<p>'.wfMsg('pr_sysops_notice', Title::newFromText('ProblemReports', NS_SPECIAL)->escapeLocalURL() ).'</p>');
} ?>

<div class="problemReportsListWrapper"><table class="problemReportsList" width="100%">
<thead>
	<tr>
<?php foreach($th as $header): ?>
		<th><?= htmlspecialchars(wfMsg($header)) ?></th>
<?php endforeach ?>
	</tr>		
</thead>

<tbody>
<?php if (count($reports) == 0): ?>
	<tr><td colspan="9" style="text-align: center; font-weight: bold"><?= wfMsg('pr_no_reports') ?></td></tr>

<?php endif; ?>
<?php if (count($reports) > 0): ?>

<?php $count = 0; foreach($reports as $problem):?>

<?php

	// change hostname to the one set in pr_server
	$url = Title::makeTitle(NS_MAIN,$problem['title'])->getFullURL();
	$url = str_replace($wgServer, $problem['server'], $url);
    
	// comments page - red links only for not existing local project_talk pages (use parser for this)
	if ($wgServer == $problem['server']) {
		// link to local page -> use $wgOut->parse
		$comments_url = $wgOut->parse('[[Project_talk:ProblemReports/'.$problem['id'].'|'.wfMsg('pr_table_comments').']]');
	}
	else {
		$comments_url = $problem['server'] . Title::makeTitle(NS_MAIN, 'Project_talk:ProblemReports/'.$problem['id'])->escapeLocalURL();
		$comments_url = '<a href="'.htmlspecialchars($comments_url).'">'. htmlspecialchars(wfMsg('pr_table_comments')) .'</a>';
	}
			
	// make link to: user page (for logged-in users) / contributions list of certain IP + entered username (for anons)
	if ($problem['anon'] == 1) {
		// Special:Contributions/72.134.123.98
		$user_url = Title::makeTitle(NS_SPECIAL, 'Contributions/'.$problem['ip'])->escapeLocalURL();
		$user_name = $problem['ip'] . (empty($problem['reporter']) ? '' :  ' ("'.$problem['reporter'].'")');								
	}
	else {
		// User:foo
		$user_url = Title::makeTitle(NS_USER, $problem['reporter'])->escapeLocalURL();
		$user_name = $problem['reporter'];
	}
			
	// change link to point to wikia where problem was reported (#3566)
	if ($wgCityId != $problem['city']) {
		$user_url = $problem['server'] . $user_url;
	}
		
	// format date (calculate time for UTC per #2214)
	$date = $wgLang->sprintfDate('j\-M\-y\<\b\r \/\>H:i', $problem['date']) . ' UTC';
			
	// more link
	$more_url = Title::makeTitle(NS_SPECIAL,'ProblemReports')->escapeLocalURL('city='.$problem['city']);
?>

<!-- Problem #<?= $problem['id'] ?> -->

<tr id="problemReportsList-problem-<?= $problem['id'] ?>"<?= (++$count) % 2 ? '' : ' class="odd"' ?>>

<td style="border-<?= $wgContLang->isRTL() ? 'right' : 'left' ?>: solid 4px #<?= $colors[$problem['type']] ?>" width="80">
<?php if( !empty($problem['summary']) ): ?>    <a onclick="reportProblemToogleSummary(<?= $problem['id'] ?>)" class="problemReportsInfo" title="<?= wfMsg('pr_table_description')?>">&nbsp;</a><?php endif; ?>
	<a href="<?= Title::newFromText('ProblemReports/'.$problem['id'], NS_SPECIAL)->escapeLocalURL() ?>" title="<?= htmlspecialchars(wfMsg('moredotdotdot')) ?>">#<?= number_format($problem['id'], 0, '.', '.') ?></a>&nbsp;<?php if (!empty($problem['summary'])):?>
<?php endif ?></td>
	<td><a href="<?= $more_url ?>" title="<?= wfMsg('pr_raports_from_this_wikia') ?>"><?= str_replace(array('http://', '.wikia.com', '.wikia-inc.com'), '', $problem['server']) ?></a>&nbsp;<sup><a href="<?= Title::newFromText('ProblemReports', NS_SPECIAL)->escapeLocalURL('showall=1&lang='.$problem['lang']) ?>"><?= $problem['lang'] ?></a></sup></td>
	<td style="text-align: center; width: 40px"><?= htmlspecialchars($problemTypes[$problem['type']]) ?></td>
	<td><a href="<?= $url ?>"><?= wordwrap(htmlspecialchars($problem['title']), 30, ' <br />', true) ?></a></td>
	<td style="text-align: center"><?= $date ?></td>
	<td><a href="<?= htmlspecialchars($user_url) ?>"><?= htmlspecialchars(shortenText($user_name,30)) ?></a>
	<?php if (!empty($problem['email']) && $can_do_actions):?><a href="<?= Title::newFromText('ProblemReports/'.$problem['id'], NS_SPECIAL)->escapeLocalURL() ?>" title="<?= wfMsg('email')?>" style="text-decoration: none"><img src="<?= $wgExtensionsPath ?>/wikia/ProblemReports/images/mail_icon.gif" alt="@" width="16" height="16"/></a>
<?php endif ?><?php if ($isStaff && $problem['anon'] == 0) :?>(<?= $problem['ip'] ?>)
<?php endif ?>	</td>
	<td style="text-align: center; width: 65px" id="problemReportsList-problem-<?= $problem['id'] ?>-status"><em class="reportProblemStatus<?= $problem['status'] ?>"><?= wfMsg('pr_status_'.$problem['status']) ?></em></td>
<?php if ( $can_do_actions && !$is_readonly ) {

	echo "\t".'<td style="width: 120px" id="problemReportsActions-'.$problem['id'].'">';

	foreach($action_icons as $id => $name) {
	
		if ($id == 10 && !$can_remove)
			continue;	// you can't remove reports

		echo "\n\t\t".'<a id="problemReportsActions-'.$problem['id'].'-'.$id.'" class="problemReportsActions '.$name. ($problem['status'] == $id ? ' problemReportsActionGreyedOut' : '') .'" title="'.wfMsg('pr_status_'.$id).'" onclick="reportProblemAction(this, '.$problem['id'].', '.$id.', \''.wfMsg('pr_status_wait').'\', \''.wfMsg( ($id == 10) ? 'pr_remove_ask' : 'pr_status_ask').'\')">&nbsp;</a>';
	}
	
	echo "\n\t</td>";
} else if ($is_readonly) {
	echo "\t".'<td style="width: 120px" class="readOnlyInfo">'.wfMsg('readonly').'</td>';
}
?>

</tr>

<?php if (!empty($problem['summary'])): ?><tr id="problemReportsList-problem-<?= $problem['id'] ?>-summary" style="<?php if (!$single_report) { ?>display: none; <?php } ?>border-left: solid 4px #<?= $colors[$problem['type']] ?>"<?= ($count % 2 ? '' : ' class="odd"') ?>>
	<td colspan="<?= count($th) ?>" class="problemReportsDescription"><div><strong><?= wfMsg('pr_table_description') ?></strong>: <?= strip_tags($wgOut->parse($problem['summary']), '<p><a><b><i><u><pre><div><img>') ?></div>
	 <?php if (!empty( $problem['browser']  )): ?>

	<h5><?= htmlspecialchars($problem['browser']) ?></h5>
	<?php endif ?>

	<?= $comments_url ?>
</td></tr>
<?php endif ?>
<?php endforeach ?>
<?php endif ?>		

</tbody>
</table></div>

<div style="padding-top: 10px; clear: both"><?= $pager  ?></div>

<?php if ($can_do_actions && $single_report) :?>

<?php include 'change_type.tmpl.php'; ?>

<?php endif ?>

<?php if ($show_mailer) :?>

<?php include 'user_mailer.tmpl.php'; ?>

<!-- log -->
<h3>Log</h3>

<ul>
<?= $logs; ?>
</ul>

<!-- /log --><?php endif ?>
