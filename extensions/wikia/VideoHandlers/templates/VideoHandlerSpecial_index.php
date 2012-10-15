<h4><?= !empty($uploadStatus) ? 'Success!' : 'Error!' ?></h4>
<? if (!empty($uploadStatus)) { ?>	
<?= $isNewFile ? 'New file created' : 'File updated'?>: <a href="<?= $url?>"><?= $title?></a>
<? } else { ?>
Remember to pass these parameters:
<ul>
	<li>videoid</li>
	<li>provider</li>
</ul>
<? } ?>