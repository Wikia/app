<div  class="wikia-paginator">
co jest
	<div>
		<ul>
		<?	$i = 1;
			foreach($pages as $page ){
			?>
				<? if ( ( $i === 1) && ( $page < $currentPage ) ){
					?><li><a href="<?=str_replace( '%s', ( $currentPage - 1 ), $url); ?>" data-back="true" data-page="<?=$currentPage - 1; ?>" class="paginator-page special paginator-prev"><?=wfMsg('paginator-back'); ?></a></li><?;
				} ?>
				<? if ( $page === '' ){
					echo '<li><a class="paginator-spacer">...</a></li>';
				} else {
					?><li><a href="<?=str_replace( '%s', $page, $url); ?>" <? if( $currentPage > $page ) echo 'data-back="true"'; ?>  data-page="<?=$page; ?>" class="paginator-page<? if ( $page == $currentPage ) echo ' active'; ?>" ><?=$page; ?></a></li><?
				} ?>
				<? if ( ( $i === count($pages)) && ( $page > $currentPage ) ){
					?><li><a href="<?=str_replace( '%s', ( $currentPage + 1 ), $url); ?>" data-page="<?=$currentPage + 1; ?>" class="paginator-page special no-border paginator-next"><?=wfMsg('paginator-next'); ?></a></li><?;
				} ?>
			<?
			$i++;
			} ?>
		</ul>
	</div>
</div>