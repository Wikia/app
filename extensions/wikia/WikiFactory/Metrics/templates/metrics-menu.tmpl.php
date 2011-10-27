<ul class="tabs">
	<? foreach ( $tabs as $value ) : ?>
	<li class="<?=( $active == $value ) ? 'selected' : '' ?>" >
		<a href="<?=$path;?>/<?=$value; ?>"><?=$value; ?></a>
	</li>
	<? endforeach ?>
	<? foreach ( $other as $value ) : ?>
	<li class="<?=( $active == $value ) ? 'selected' : '' ?>" >
		<a href="<?=$path;?>/<?=$value; ?>"><?=wfMsg('newwikisgraph-param-'.$value); ?></a>
	</li>
	<? endforeach ?>
</ul>