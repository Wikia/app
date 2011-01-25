<!-- s:<?= __FILE__ ?> -->
	<div class="tabs-container">
		<ul class="tabs" style="list-style: none">

			<? foreach( $tabs as $tabName => $tabItems ){ ?>
			<li pane="tab-pane-<?=$tabName; ?>" <? if($tab == $tabName) echo 'class="selected"'; ?> >
				<a href="<?=$path.'/'.$tabName;?>"><?= wfMsg("sponsorship-dashboard-tab-".$tabName) ?></a>
			</li>
			<? } ?>
			
		</ul>
	</div>

	<?

if( isset($tabs[ $tab ]) ){
	?><ul class="subcats"><?
		foreach( $tabs[ $tab ] as $subcat ){
			echo '<li><a href="'.$path.'/'.$subcat.'">'.wfMsg('sponsorship-dashboard-report-'.$subcat).'</a></li>';
		}
	?></ul><?
}
	
	?>
<!-- e:<?= __FILE__ ?> -->
