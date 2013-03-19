<?php if( empty( $inGroup ) ): ?>
<li class=result>
<?php endif; ?>
	<p>
		<?php
		$title = ( empty( $inGroup ) && $isInterWiki && empty( $result['isWikiMatch'] ) ) ? str_replace('$1', $result->getTitle(), $result->getVar('wikititle')) : $result->getTitle();
		?>
		<a class=title href="<?= $result->getUrl(); ?>"><?= $title; ?></a>
	</p>
	<span class=desc><?= $result->getText(); ?></span>
<?php if( empty( $inGroup ) ): ?>
</li>
<?php endif; ?>