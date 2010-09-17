		<entry>
			<id><![CDATA[<?=$item->getUrl(); ?>]]></id>
			<title><![CDATA[ <?=$item->getTitle(); ?>]]></title>
			<link><![CDATA[ <?=$item->getUrl(); ?>]]></link>
			<summary><![CDATA[ <?=$item->getDescription(); ?>]]></summary>
<? if( $item->getDate() ) { ?>			<updated><![CDATA[ <?=gmdate( 'D, d M Y H:i:s \G\M\T', wfTimestamp( TS_UNIX, $item->getDate() ) ); ?>]]></updated>
<?}?>
<? if( $item->getAuthor() ) {?>			<author><![CDATA[ <?=$item->getAuthor(); ?>]]></author>
<?}?>
<? if( $item->getComments() ) {?>			<comments><![CDATA[ <?=$item->getComments(); ?>]]></comments>
<?}?>
<? foreach( $item->OtherTags as $key => $val ) {?>			<<?=$key; ?>><?=$item->getOtherTag($key); ?>}</<?=$key; ?>>
<?}?>
		</entry>