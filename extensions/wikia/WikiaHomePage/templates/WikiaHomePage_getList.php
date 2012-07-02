<script>
	var wgWikiaHomePageVisualizationStatus = <?= $status; ?>;
	<?php if(!empty($data)): ?>
		<!-- dynamic Visualization Data -->
		var wgWikiaHomePageVisualizationData = <?= json_encode($data); ?>;
	<?php endif; ?>
	<?php if(!empty($failoverData)): ?>
		<!-- failover Visualization Data -->
		var wgWikiaHomePageVisualizationData = <?= json_encode($failoverData); ?>;
	<?php endif; ?>
</script>