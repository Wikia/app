<div class='skinKiller'>

	<em><?= wfMsg('devbox-intro') ?></em>

	<div class="tabs-container">
		<ul class="tabs" style="list-style: none">
			<li pane="tab-pane-1" class="selected">
				<a href="#"><?= wfMsg("devbox-heading-svn-tool") ?></a>
			</li>
			<li pane="tab-pane-2">
				<a href="#"><?= wfMsg("devbox-heading-change-wiki") ?></a>
			</li>
			<li pane="tab-pane-3">
				<a href="#"><?= wfMsg("devbox-heading-vital") ?></a>
			</li>
		</ul>
	</div>

	<div class="tab-pane" id="tab-pane-1">
		<h2><?= wfMsg("devbox-heading-svn-tool") ?></h2>
		<?= $svnToolHtml ?>
	</div>

	<div class="tab-pane" id="tab-pane-2" style="display: none">
		<h2><?= wfMsg("devbox-heading-change-wiki") ?></h2>
		<?php if (getForcedWikiValue() == ""): ?>
			<?= wfMsg("devbox-change-wiki-intro", $_SERVER['SERVER_NAME']) ?>
		<?php else: ?>
			<?= wfMsg("devbox-change-wiki-success", $_SERVER['SERVER_NAME']) ?>
		<?php endif; ?>
		<?= $dbComparisonHtml ?>
	</div>

	<div class="tab-pane" id="tab-pane-3" style="display: none">
		<h2><?= wfMsg("devbox-heading-vital") ?></h2>
		<?= $infoHtml ?>
	</div>

	<br />
	<hr />
	<small><?= $footer ?></small>

</div>