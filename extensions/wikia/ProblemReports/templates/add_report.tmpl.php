<b class="xtop"><b class="xb1"></b><b class="xb2"></b><b class="xb3"></b><b class="xb4"></b></b><div class="r_boxContent">

<form name="reportProblem" id="reportProblem" method="post" action="" onsubmit="return wikiaProblemReportsDialog.panelSubmit()">

<input type="hidden" name="pr_ns" value="<?= $pageNamespace ?>" />

<div class="boxHeader color1"><?= htmlspecialchars(wfMsg('reportproblem')) ?> | <span style="text-transform: none"><?= $pageTitle ?></span></div>

<div class="reportProblemText"><?= $introductoryText ?></div>

<label for="pr_reporter" class="floaty"><?= wfMsg('yourname') ?></label>
<input id="pr_reporter" name="pr_reporter" type="text" value="<?= ($user->isLoggedIn() ?   htmlspecialchars($user->getName()).'" disabled="disabled"' : '"') ?> class="floaty" />
<br class="floaty" />

<label for="pr_title" class="floaty"><?= wfMsg('pr_what_page') ?>:</label>
<input name="pr_title" id="pr_title" type="text" value="<?= $pageTitle ?>" disabled="disabled" class="floaty" />
<br class="floaty" />

<label for="pr_email" class="floaty" title="<?= htmlspecialchars(wfMsg('pr_email_visible_only_to_staff'))  ?>"><?= wfMsg('email') ?>:</label>
<input id="pr_email" name="pr_email" title="<?= htmlspecialchars(wfMsg('pr_email_visible_only_to_staff'))  ?>" type="text" value="<?= htmlspecialchars($user->getEmail()) ?>" class="floaty"<?= ($user->isLoggedIn() ? ' disabled="disabled"' : '') ?> />
<br class="floaty" />

<label for="pr_cat" class="floaty"><?= wfMsg('pr_what_problem') ?>:</label>
<select id="pr_cat" class="floaty" style="padding:1px 2px" name="pr_cat">
	<option value="-" selected="selected">-- <?= htmlspecialchars(wfMsg('pr_what_problem_select'))?> --</option>

<?php foreach($what_problem_options as $id => $option): ?>
	<option value="<?= $id ?>"><?= htmlspecialchars(wfMsg($option))?></option>
<?php endforeach ?>

</select>
<br class="floaty" />

<label for="pr_summary" class="floaty"><?= wfMsg('pr_describe_problem') ?>:</label>
<textarea name="pr_summary" id="pr_summary" rows="3" cols="15" onchange="wikiaProblemReportsDialog.checkTextareaLength(this)" onkeyup="wikiaProblemReportsDialog.checkTextareaLength(this)"></textarea>

<br class="floaty" />

<div id="pr_browser"></div>

<div style="text-align:center; clear: both; padding: 15px 0 5px 0">
    <input type="submit" value="<?= htmlspecialchars(wfMsg('reportproblem')) ?>" id="pr_submit" style="font-weight: bolder" />
    <input type="button" value="<?= htmlspecialchars(wfMsg('cancel')) ?>" id="pr_cancel" style="margin-left: 30px" />
</div>

</form><div style="clear: both"></div></div><b class="xbottom"><b class="xb4"></b><b class="xb3"></b><b class="xb2"></b><b class="xb1"></b></b>
