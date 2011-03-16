<?php foreach($data as $value): ?>
	<div>
		<strong>S<?php echo $value['season'] ?> E<?php echo $value['episode'] ?> - <?php echo $value['title'] ?> </strong>
		<div style="width:510px;height:425px">
			<?php echo $value['video-widget'] ?> 
		</div>
		<br>
		<strong><?php echo wfMsg('avs-code-for-widget'); ?></strong>
		<div style="margin-left:30px;margin-bottom: 35px;" >
			<?php echo wfMsg('avs-code-for-video-widget'); ?><span style="color:red;"><?php echo $value['video-widget-code'] ?> </span> <br>
			<?php echo wfMsg('avs-code-for-image-widget'); ?><span style="color:red;"><?php echo $value['image-widget-code'] ?> </span>
		</div>
	</div>
<?php endforeach; ?>