<?php if (!empty( $relatedLanguages ) ) { ?>
	<section class="internal-linking-languages">
		<h3>Related Languages</h3>
		<ul>
			<?php foreach( $relatedLanguages as $code => $url ) { ?>
				<li><a href="<?= $url ?>"><?= Language::getLanguageName( $code ) ?></li>
			<?php } ?>
		</ul>
	</section>
<?php } ?>
