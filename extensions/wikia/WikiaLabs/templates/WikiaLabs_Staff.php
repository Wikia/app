<?php if($show): ?>
	<section class="FormCornerModule module WikiaLabsStaff">
		<h1 class='title'>
			<?php echo wfMsg('wikialabs-staff-title'); ?>
			<button id="addProject"/>
				<img width="0" height="0" class="sprite new" src="<?= wfBlankImgUrl() ;?>">
				<?php echo wfMsg('wikialabs-staff-add'); ?>
			</button>
		</h1>
		<span class="redinfo"><?php echo wfMsg('wikialabs-staff-info'); ?></span>
		
		<span class="editinfo" ><?php echo wfMsg('wikialabs-staff-items'); ?></span>
		<select class="prjselect" >
			<option value="0"><?php echo wfMsg('wikialabs-staff-empty-project'); ?></option>
			<?php foreach($projects as $value): ?>
				<option value="<?php echo $value->getId(); ?>"><?php echo $value->getName(); ?></option>
			<?php endforeach; ?>
		</select>	
	</section>
<?php endif; ?>