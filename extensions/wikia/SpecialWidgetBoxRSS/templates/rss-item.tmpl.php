		<item>
			<title><![CDATA[ <?=$item->getTitle(); ?>]]></title>
			<link><![CDATA[ <?=$item->getUrl(); ?>]]></link>
			<description><![CDATA[ <?=$item->getDescription(); ?>]]></description>
<? if( $item->getDate() ) { ?>			<pubDate><![CDATA[ <?=gmdate( 'D, d M Y H:i:s \G\M\T', wfTimestamp( TS_UNIX, $item->getDate() ) ); ?>]]></pubDate>
<?}?>
<? if( $item->getAuthor() ) {?>			<dc:creator><![CDATA[ <?=$item->getAuthor(); ?>]]></dc:creator>
<?}?>
<? if( $item->getComments() ) {?>			<comments><![CDATA[ <?=$item->getComments(); ?>]]></comments>
<?}?>
<? foreach( $item->OtherTags as $key => $val ) {?>			<<?=$key; ?>><?=$item->getOtherTag($key); ?></<?=$key; ?>>
<?}?>
		</item>
