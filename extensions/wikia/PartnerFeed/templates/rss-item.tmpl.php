
		<item>
			<title><![CDATA[ <?=$item->getTitle(); ?>]]></title>
			<link><![CDATA[ <?=$item->getUrl(); ?>]]></link>
			<description><![CDATA[ <?=$item->getDescription(); ?>]]></description>
<? if( $item->getDate() ) { ?>			<pubDate><![CDATA[ <?= $item->getDate() ?>]]></pubDate>
<?}?>
<? if( $item->getAuthor() ) {?>			<dc:creator><![CDATA[ <?=$item->getAuthor(); ?>]]></dc:creator>
<?}?>
<? if( $item->getComments() ) {?>			<comments><![CDATA[ <?=$item->getComments(); ?>]]></comments>
<?}?>
<? foreach( $item->OtherTags as $key => $val ) { if ($key == 'media:thumbnail'){
?>			<<?=$key; ?> url="<?=$item->getOtherTag($key); ?>" />
<?
}else{
?>			<<?=$key; ?>><?=$item->getOtherTag($key); ?></<?=$key; ?>>
<?}}?>
		</item>
