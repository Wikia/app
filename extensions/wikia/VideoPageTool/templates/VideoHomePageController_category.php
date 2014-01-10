<? /* @var $assets array */ ?>

<div class="latest-videos-wrapper"></div>

<script type="text/javascript">

	var Wikia = Wikia || {};
	Wikia.videoHomePage = Wikia.videoHomePage || {};

	// set data for Backbone collection
	Wikia.videoHomePage.categoryData = <?= json_encode( $assets ) ?>;

</script>
