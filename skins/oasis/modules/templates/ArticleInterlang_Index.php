<?php if ( $language_list ): ?>
	<nav class="WikiaArticleInterlang">
		<h3><?= wfMessage( 'oasis-interlang-languages' )->escaped(); ?> </h3>
		<ul>
			<?php foreach ( $language_list as $key => $val ) : ?>
				<li><a data-tracking="<?= $key ?>"
					   href="<?= Sanitizer::encodeAttribute( $val['href'] ); ?>"><?= htmlspecialchars( $val['name'] ); ?></a>
				</li>
			<?php endforeach ?>
		</ul>
	</nav>
<?php endif ?>
