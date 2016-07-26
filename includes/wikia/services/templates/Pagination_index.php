<ul class="Pagination"  <? foreach($data as $key => $val ): ?> data-<?= htmlspecialchars( $key ) ?>="<?= Sanitizer::encodeAttribute($val); ?>" <? endforeach; ?> >
	<? if( $prev ): ?>
		<li data-page="<?= $currentPage - 1; ?>"  class="prev">
			<a href="<?= Sanitizer::encodeAttribute( $url !== '#' ? $url.($currentPage - 1) : $url) ?>"><?= htmlspecialchars( $prevMsg ) ?></a>
		</li>
	<? endif; ?>
	
	<? for( $i=0; $i<count($pages); $i++ ): ?>
		<? $class = ($i == 0) ? ' first ' : ''; ?>
		<? $class .= ($pages[$i] == $currentPage) ? ' selected ' : ''; ?>
		
		<? if( is_string($pages[$i]) ): ?>
			<li class="ellipsis"><?= htmlspecialchars( $pages[$i] ) ?></li>
		<? else: ?>
			<li data-page="<?= $pages[$i]; ?>" class="<?= $class ?>">
				<a href="<?= Sanitizer::encodeAttribute( $url !== '#' ? $url.$pages[$i] : $url ) ?>"><?= $pages[$i] ?></a>
			</li>
		<? endif; ?>
	<? endfor; ?>
	
	<? if( $next ): ?>
		<li data-page="<?= $currentPage + 1; ?>" class="next">
			<a href="<?= Sanitizer::encodeAttribute( $url !== '#' ? $url.($currentPage + 1) : $url ) ?>"><?= htmlspecialchars( $nextMsg ) ?></a>
		</li>
	<? endif; ?>
</ul>