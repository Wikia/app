<?php  if ( !empty( $devel ) ): ?>
	<h1>Error</h1>
	<p>
	<?php echo $response->getException()->getFile().':'.$response->getException()->getLine(); ?>
	<?php echo $response->getException()->getMessage(); ?>
	</p>
	<p>
	<?php echo str_replace("\n", '<br />' ,$response->getException()->getTraceAsString()); ?>
	</p>
<?php endif; ?>