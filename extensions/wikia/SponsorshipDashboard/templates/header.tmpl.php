<!-- s:<?= __FILE__ ?> -->
	<div class="tabs-container">
		<ul class="tabs" style="list-style: none">

			<? foreach( $groups as $oGroup ){ ?>
			<li<? if( $oGroup->id == $groupId ) echo ' class="selected"'; ?> >
				<a href="<?=$path.'/'.$oGroup->id;?>"><?=$oGroup->name ?></a>
			</li>
			<? } ?>
			
		</ul>
	</div>

	<?

	?><ul class="subcats"><?
		$first = true;
		foreach( $reports as $oReport ){
			echo '<li ';
			if ( $first ){ 
				$first = false;
				echo ' class="first"';
			}
			echo '><a href="'.$path.'/'.$groupId.'/'.$oReport->id.'">'.$oReport->name.'</a></li>';
		}
	?></ul><?
	
	?>
<!-- e:<?= __FILE__ ?> -->
