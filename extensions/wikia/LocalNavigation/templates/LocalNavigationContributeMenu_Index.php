<div class="contribute-container">
	<div class="contribute-button"><?= wfMessage('oasis-button-contribute-tooltip')->text() ?></div>
	<ul class="dropdown">
<?php
	foreach( $dropdownItems as $key => $item ):
		$href = empty( $item[ 'href' ] ) ? '#' : htmlspecialchars( $item[ 'href' ] );

		$attributes = '';
		foreach ( $item as $attr => $value ) {
			if ( $attr === 'href' || $attr === 'text' ) {
				continue;
			}
			$attributes .= empty( $value ) ? '' : ' ' . $attr . '="' . $value . '"';
		}
//	$accesskey = empty( $item[ 'accesskey' ] ) ? '' : ' accesskey="' . $item[ 'accesskey' ] . '"';
//	$title = empty( $item[ 'title' ] ) ? '' : ' title="' . $item[ 'title' ] . '"';
//	$id = empty( $item[ 'id' ] ) ? '' : ' id="' . $item[ 'id' ] . '"';
//	$class = empty( $item[ 'class' ] ) ? '' : ' class="' . $item[ 'class' ] . '"';
//	$attr = empty( $item[ 'attr' ] ) ? '' : ' ' . $item[ 'attr' ];
?>
		<li>
			<? /* <a href="<?= $href ?>" data-id="<?= $key ?>"<?= $accesskey . $title . $id . $class . $attr ?>><?= htmlspecialchars( $item[ 'text' ] ) ?></a> */?>
			<a href="<?= $href ?>" data-id="<?= $key ?>"<?= $attributes ?>>
				<span><?= htmlspecialchars( $item[ 'text' ] ) ?></span>
			</a>
		</li>
<?php endforeach; ?>
	</ul>
</div>
