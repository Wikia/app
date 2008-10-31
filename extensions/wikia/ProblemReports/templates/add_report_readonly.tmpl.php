<b class="xtop"><b class="xb1"></b><b class="xb2"></b><b class="xb3"></b><b class="xb4"></b></b><div class="r_boxContent">

<form name="reportProblem" id="reportProblem">

<div class="boxHeader color1"><?= htmlspecialchars(wfMsg('reportproblem')) ?> | <?= wfMsg( 'readonly' ) ?></div>

<div class="reportProblemText">
<h4><?= wfMsg('pr_read_only') ?></h4>
<?= wfMsgWikiHTML( 'readonlytext', $reason ) ?>
<span style="display:none" id="pr_browser"></span>
</div>

</form>

<div style="clear: both"></div></div><b class="xbottom"><b class="xb4"></b><b class="xb3"></b><b class="xb2"></b><b class="xb1"></b></b>
