<table>
<? foreach( $list as $item ): ?>
	<tr>
		<td><?= ++$offset ?></td>
		<td><a href="<?= $item['link'] ?>"><?= $item['title'] ?></a></td>
		<td><?= wfMessage( 'insights-last-edit' )->rawParams(
				Xml::element('a', [
						'href' => $item['revision']['userpage']
					],
					$item['revision']['username']
				),
				date('F j, Y', $item['revision']['timestamp'])
			)->escaped() ?></td>
		<td># of views</td>
	</tr>
<? endforeach ?>
</table>
<?php

?>
