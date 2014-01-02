<!-- s:<?= __FILE__ ?> -->
<style type="text/css">
.TablePager td, .TablePager th {padding: 5px; border: 1px solid silver}
.noactive {background-color: #FFEAEA ! important}
</style>

<div id="PaneNav">
	<a href="<?= $title->getLocalUrl() ?>"><?= wfMessage( 'swm-page-title-editor' )->escaped() ?></a>
</div>

<div id="PaneList">
	<?= $formData['body'] ?>
	<?= $formData['nav'] ?>
</div>
<!-- e:<?= __FILE__ ?> -->
