<div  class="wikia-paginator">
	<div>
		<ul>
		<?	$i = 1;
			foreach($pages as $page ){
			?>
				<? if ( ( $i === 1) && ( $page < $currentPage ) ){
					?><li><a href="<? printf($url, $currentPage - 1); ?>" data-back="true" data-page="<?=$currentPage - 1; ?>" class="paginator-page special"><?=wfMsg('paginator-back'); ?></a></li><?;
				} ?>
				<? if ( $page === '' ){
					echo '<li><a class="paginator-spacer">...</a></li>';
				} else {
					?><li><a href="<? printf($url, $page); ?>" <? if( $currentPage > $page ) echo 'data-back="true"'; ?>  data-page="<?=$page; ?>" class="paginator-page<? if ( $page == $currentPage ) echo ' active'; ?>" ><?=$page; ?></a></li><?
				} ?>
				<? if ( ( $i === count($pages)) && ( $page > $currentPage ) ){
					?><li><a href="<? printf($url, $currentPage + 1); ?>" data-page="<?=$currentPage + 1; ?>" class="paginator-page special no-border"><?=wfMsg('paginator-next'); ?></a></li><?;
				} ?>
			<?
			$i++;
			} ?>
		</ul>
	</div>
</div>