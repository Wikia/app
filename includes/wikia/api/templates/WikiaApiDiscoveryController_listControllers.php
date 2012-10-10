<h2>Wikia API browser</h2>
<dl>
<? foreach ( $controllers as $c ) : ?>
	<dt><a href="<?= $c['referenceUrl'] ;?>"><?= $c['name'] ;?></a></dt>
	<? if ( !is_null( $c['description'] ) ) :?><dd><?= $c['description'] ;?></dd><? endif ;?>
<? endforeach ;?>
</dl>