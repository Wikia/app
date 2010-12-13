<!-- s:<?= __FILE__ ?> -->
	<div class="tabs-container">
		<ul class="tabs" style="list-style: none">
			<li pane="tab-pane-1" <? if($tab == 0) echo 'class="selected"'; ?> >
				<a href="<?=$path.'/report1';?>"><?= wfMsg("sponsorship-dashboard-report-1") ?></a>
			</li>
			<li pane="tab-pane-2" <? if($tab == 1) echo 'class="selected"'; ?>>
				<a href="<?=$path.'/report2';?>"><?= wfMsg("sponsorship-dashboard-report-2") ?></a>
			</li>
			<li pane="tab-pane-3" <? if($tab == 2) echo 'class="selected"'; ?>>
				<a href="<?=$path.'/report3';?>"><?= wfMsg("sponsorship-dashboard-report-3") ?></a>
			</li>
			<li pane="tab-pane-5" <? if($tab == 4) echo 'class="selected"'; ?>>
				<a href="<?=$path.'/report4';?>"><?= wfMsg("sponsorship-dashboard-report-4") ?></a>
			</li>
		</ul>
	</div>
<!-- e:<?= __FILE__ ?> -->
