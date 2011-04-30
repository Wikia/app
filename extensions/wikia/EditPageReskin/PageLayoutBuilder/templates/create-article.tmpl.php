<?php if($isdelete): ?>
	<div class="WikiaConfirmation">
		<p class="plainlinks"><?php echo wfMsg('plb-special-form-layout-delete'); ?></p>
	</div>
<?php endif;?>

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


<div class="plb-article-form-space" ></div>
<?php echo $layout; ?>
<div class="plb-article-form-end" ><?php echo wfMsg('plb-special-form-required'); ?></div>