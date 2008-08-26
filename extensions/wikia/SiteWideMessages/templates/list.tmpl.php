<!-- s:<?= __FILE__ ?> -->
<style type="text/css">
.TablePager td, .TablePager th {padding: 5px; border: 1px solid silver}
.noactive {background-color: #FFEAEA ! important}
</style>

<div id="PaneNav">
	<a href="<?= $title->getLocalUrl() ?>"><?= wfMsg('swm-page-title-editor') ?></a>
</div>

<div id="PaneList">
	<fieldset>
		<legend><?= wfMsg('swm-label-list') ?></legend>
		<?= $formData['body'] ?>
		<?= $formData['nav'] ?>
		</table>
	</fieldset>
</div>
<!-- e:<?= __FILE__ ?> -->