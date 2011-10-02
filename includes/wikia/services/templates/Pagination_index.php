<ul class="Pagination">
	<? if ($prev) { ?>
		<li data-page="<?= $currentPage - 1; ?>"  class="prev">
			<a href="#"><?php echo wfMsg('wikia-pagination-prev'); ?></a>
		</li>
	<? } ?>
	
	<? for ($i=0; $i<count($pages); $i++) { ?>
		<? $class = ($i == 0) ? ' first ' : ''; ?>
		<? $class .= ($pages[$i] == $currentPage) ? ' selected ' : ''; ?>
		
		<? if (gettype($pages[$i]) == 'string') { ?>
			<li class="ellipsis"><?= $pages[$i] ?></li>
		<? } else { ?>
			<li data-page="<?= $pages[$i]; ?>" class="<?= $class ?>">
				<a  href="#"><?= $pages[$i] ?></a>
			</li>
		<? } ?>
	<? } ?>
	
	<? if ($next) { ?>
		<li data-page="<?= $currentPage + 1; ?>" class="next">
			<a  href="#"><?php echo wfMsg('wikia-pagination-next'); ?></a>
		</li>
	<? } ?>
</ul>