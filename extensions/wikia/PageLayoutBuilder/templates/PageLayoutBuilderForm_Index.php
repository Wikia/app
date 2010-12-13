<?php if( $display ): ?>
	<section class="FormCornerModule module">
		<p><?php echo wfMsg('plb-special-form-box-caption', array($layoutName)); ?></p>
		<?php echo $layoutDesc; ?>
		<ul>
			<li class="first" >
				<?php echo wfMsg('plb-special-form-box-create'); ?>
			</li>
			<li>
				<?php echo $profileAvatar; ?>
			</li>
			<li class="username" >
				<?php echo $profileName; ?> <br>
				<?php echo $titleTime; ?>
			</li>
		</ul>
	</section>
<?php endif; ?>