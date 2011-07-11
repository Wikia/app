<?php if( is_array($users) && !empty($users) ): ?>
<p><?php echo wfMsg('myextension-note'); ?></p>

<table border="1" cellpadding="1" cellspacing="1">
	<tr>
		<td><?php echo wfMsg('myextension-table-user'); ?></td>
		<td><?php echo wfMsg('myextension-table-user-edits'); ?></td>
		<td><?php echo wfMsg('myextension-table-comments');?></td>
	</tr>
	<?php foreach($users as $user): ?>
	<tr>
	 	<td><?php echo $user->name; ?></td>
	  	<td><?php echo $user->views; ?></td>
	  	<td>
	  		<?php foreach($user->getComments($wikicity) as $comment): ?>
	  			<div class="comment"><?php echo $comment; ?></div>
	  		<?php endforeach; ?>
	  		<h3><?php  echo wfMsg('myextension-leave-comment'); ?></h3>
	  		<form method="post" action="<?php echo $url; ?>" >
	  			<textarea name="styled-textarea" id="styled" class="textarea#styled"></textarea>
	  			<input type="submit" name="add" value="<?php /*echo $user->GetID();*/echo wfMsg('myextension-button-add-comments'); ?>"/>
	  			<input type="hidden" name="id" value="<?php echo $user->GetID(); ?>"/>
	  		</form>
	  	</td>
	</tr>
	<?php endforeach; ?>
</table>

<?php else: ?>
	 <p><?php echo wfMsg('top-ten-viewers-no-data'); ?></p>
<?php endif; ?>
