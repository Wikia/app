<? /* @var $assets array */ ?>

<div class="latest-videos-wrapper" id="latest-videos-wrapper"></div>

<script type="text/javascript">
	Wikia.modules = Wikia.modules || {};
	Wikia.modules.videoHomePage = Wikia.modules.videoHomePage || {};

	// set data for Backbone collection
	Wikia.modules.videoHomePage.categoryData = <?= json_encode( $assets ) ?>;
</script>
