<table id="plbLayoutList" cellspacing="0" cellpadding="0"  >
	<thead>
		<tr>
			<td class="first" >
				<?php echo wfMsg('plb-list-name'); ?>
			</td>
			<td class="desc">
				<?php echo wfMsg('plb-list-desc'); ?>
			</td>
			<td class="count" >
				<?php echo wfMsg('plb-list-count'); ?>
			</td>
			<td class="last" >
				<?php echo wfMsg('plb-list-last-edit'); ?>
			</td>
		</tr>
	</thead>
	<tbody>
		<?php foreach($data as $value): ?>
			<tr>
				<td class="name" >
					<p class="layout-name" ><?php echo $value['page_title'] ?></p>
					<p>
						<?php foreach ($value['page_actions'] as $action): ?>
							<a href="<?php echo $action['link'] ?>" class="PLBActionLink <?php echo $action['class'] ?>" ><? echo $action['name']; ?></a>
							<?php if($action['separator']): ?>
								|
							<?php endif; ?> 
						<?php endforeach; ?>
					</p>
					<input type="hidden" class="page_id" value="<?php echo $value['page_id'] ?>" />
				</td>
				<td class="desc" >
					<?php echo $value['desc'] ?>
				</td>
				<td class="count" >
					<?php echo $value['page_count'] ?>
				</td>
				<td class="username" >
					<ul>
						<li>
							<a href="<?php echo $value['profile_link']; ?>"><?php echo $value['profile_avatar'] ?></a>
						</li>
						<li class="username">
							<a href="<?php echo $value['profile_link']; ?>"><?php echo $value['profile_name'] ?></a><br>
							<?php echo $value['edit_date'] ?>
						</li>
					</ul>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php /* posting action form */ ?>
<form style="display: none" method="post" id="PLBActionForm" >
	<input  type="hidden" name="plbId" id="plbId" value="" />
	<input  type="hidden" name="subaction" id="subaction" value="" />
</form>

<a id="plbNewButton" class="wikia-button" href="<?php echo $newlink; ?>" ><?php echo wfMsg('plb-special-form-new'); ?> <a/>
