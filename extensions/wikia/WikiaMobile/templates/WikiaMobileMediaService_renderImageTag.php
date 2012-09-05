<?
/**
 * @var $anchorAttributes array
 * @var $attributes array
 * @var $noscript String
 * @var $content String
 */
?>
<? if ( !empty( $anchorAttributes ) ) :?><a<? foreach ( $anchorAttributes as $name => $value ) :?><?= ( !empty( $value ) ) ? " {$name}=\"{$value}\"" : " {$name}" ;?><? endforeach ;?>><? endif ;?>
<img<? foreach ( $attributes as $name => $value ) :?><?= ( !empty( $value ) ) ? " {$name}=\"{$value}\"" : " {$name}" ;?><? endforeach ;?>>
<? if ( !empty( $noscript ) ) :?><noscript><?= $noscript ;?></noscript><? endif ;?>
<? if ( !empty( $anchorAttributes ) ) :?></a><? endif ;?>
<? if ( !empty( $content) ) :?><?= $content ;?><? endif ;?>