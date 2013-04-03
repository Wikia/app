		<entry>
			<id><![CDATA[<?=$item->getUrl(); ?>]]></id>
			<title><![CDATA[ <?=$item->getTitle(); ?>]]></title>
			<link><![CDATA[ <?=$item->getUrl(); ?>]]></link>
			<summary><![CDATA[ <?=$item->getDescription(); ?>]]></summary>
<? if( $item->getDate() ) { ?>			<updated><![CDATA[ <?= $item->getDate() ?>]]></updated>
<?}?>
<? if( $item->getAuthor() ) {?>			<author><![CDATA[ <?=$item->getAuthor(); ?>]]></author>
<?}?>
<? if( $item->getComments() ) {?>			<comments><![CDATA[ <?=$item->getComments(); ?>]]></comments>
<?}?>
<? foreach( $item->OtherTags as $key => $val ) { if ($key == 'media:thumbnail'){
?>			<<?=$key; ?> url="<?=$item->getOtherTag($key); ?>" />
<?
}else{
?>			<<?=$key; ?>><?=$item->getOtherTag($key); ?></<?=$key; ?>>
<?}}?>
		</entry>
