<table>
	<tr>
		<td><?php echo wfMsg('avs-season') ?> </td>
		<td><?php echo wfMsg('avs-episode') ?> </td>
		<td><?php echo wfMsg('avs-video-widget') ?> </td>
		<td><?php echo wfMsg('avs-image-link-widget') ?> </td
	</tr>
	<tr>
		<?php foreach($data as $value): ?>
			<td><?php echo $value['season'] ?></td>
			<td><?php echo $value['episode'] ?></td>
			<td><?php echo $value['video-widget'] ?></td>
			<td><?php echo $value['image-link-widget'] ?></td>
		<?php endif; ?>
	</tr>
</table>