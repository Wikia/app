<div  class="wikia-paginator">
	<div>
		<ul>
		<?	$i = 1;
			foreach($pages as $page ){
			?>
				<? if ( ( $i === 1) && ( $page < $currentPage ) ){
					?><li><a href="<?=str_replace( '%s', ( $currentPage - 1 ), $url); ?>" data-back="true" data-page="<?=$currentPage - 1; ?>" class="button secondary paginator-prev"></a></li><?;
				} ?>
				<? if ( $page === '' ){
					echo '<li><span class="paginator-spacer">...</span></li>';
				} else {
					?><li><a href="<?=str_replace( '%s', $page, $url); ?>" <? if( $currentPage > $page ) echo 'data-back="true"'; ?>  data-page="<?=$page; ?>" class="paginator-page<? if ( $page == $currentPage ) echo ' active'; ?>" ><?=$page; ?></a></li><?
				} ?>
				<? if ( ( $i === count($pages)) && ( $page > $currentPage ) ){
					?><li><a href="<?=str_replace( '%s', ( $currentPage + 1 ), $url); ?>" data-page="<?=$currentPage + 1; ?>" class="button secondary paginator-next"></a></li><?;
				} ?>
			<?
			$i++;
			} ?>
		</ul>
	</div>
</div>