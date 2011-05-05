<?php if($iserror): ?>
	<div class="plb-form-errorbox" >
		<strong><?php echo wfMsg('plb-special-form-error-info'); ?></strong>
		<ul>
			<?php foreach ($errors as $value): ?>
				<li><?php echo $value; ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php endif; ?>