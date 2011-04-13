<!-- s:<?= __FILE__ ?> -->
	<div class="tabs-container">
		<ul class="tabs" style="list-style: none">

			<? foreach( $tabs as $tabName ){ ?>
			<li pane="tab-pane-<?=$tabName; ?>" <? if($tab == $tabName) echo 'class="selected"'; ?> >
				<a href="<?=$path.'/'.SponsorshipDashboard::ADMIN.'/'.$tabName;?>"><?= wfMsg("sponsorship-dashboard-tab-".$tabName) ?></a>
			</li>
			<? } ?>
			
		</ul>
	</div>
<!-- e:<?= __FILE__ ?> -->
