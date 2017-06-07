<? if ( !$subtitle->suppressPageSubtitle ): ?>
	<? if ( !empty( $subtitle->pageSubtitle ) ): ?>
		<div class="page-header__page-subtitle"><?= $subtitle->pageSubtitle ?></div>
	<? endif;
	if ( !empty( $subtitle->subtitle ) ): ?>
		<div class="page-header__subtitle"><?= $subtitle->subtitle ?></div>
	<? endif; ?>
<? endif; ?>
