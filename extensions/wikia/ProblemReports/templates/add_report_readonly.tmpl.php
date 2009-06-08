<div id="reportProblemForm" title="<?= htmlspecialchars(wfMsg('reportproblem')) ?> | <?= wfMsg( 'readonly' ) ?>">

<form name="reportProblem" id="reportProblem">

<div class="reportProblemText">
<h4><?= wfMsg('pr_read_only') ?></h4>
<?= wfMsgWikiHTML( 'readonlytext', $reason ) ?>
<span style="display:none" id="pr_browser"></span>
</div>

</form>

<div style="clear: both"></div></div>
</div>
