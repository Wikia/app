<?php foreach($list as $val): ?>
	<li>
		<img src="<?php echo $val['avatar'];  ?>"/>
		<a href="<?php echo $val['profilepage'];  ?>">
			<?php echo $val['name']; ?>
		</a>
	</li>
<?php endforeach; ?>


<?php if($hasmore): ?> 
	<li>
		<?php echo wfMsg('wall-votes-modal-showmore'); ?>
	</li>
<?php endif; ?>