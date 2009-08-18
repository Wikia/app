<h3>Bolek</h3>

<p>Collection:</p>

<ul>
	<?php foreach ($collection as $page): ?>
		<li>
			<?=Title::newFromID($page)->getText()?>
			[<a href="/wiki/Special:Bolek?action=remove&page_id=<?=$page?>">x</a>]
		</li>
	<?php endforeach; ?>
	<?php if (!sizeof($collection)): ?>
		<li>(empty)</li>
	<?php endif; ?>
</ul>

<p><a href="/wiki/Special:Bolek?action=clear">Clear collection</a></p>

<h3>Lolek</h3>

<p><a href="/wiki/Special:Bolek?action=print">Preview pdf source</a></p>

<script type="text/javascript">
/*<![CDATA[*/
function getPdf() {
	$("#getpdf_result").text("...request sent, please wait...");
	$.get(wgServer, {
		action:    "ajax",
		rs:        "Lolek::getPdf",
		url:       "<?=$url?>",
		user_id:    <?=$user_id?>,
		timestamp:  <?=$timestamp?>
	}, function(data, textStatus) {
		if (data.match(/\.pdf$/)) {
			$("#getpdf_result").html("...pdf is ready, please <a href=\"" + data + "\">download it</a>.");
		} else {
			$("#getpdf_result").text("..." + data);
		}
	});
}
/*]]>*/
</script>

<p>
<a href="#" onclick="getPdf();return false;">Get pdf</a>
<span id="getpdf_result"></span>
</p>

<hr />

<p>Debug: (<?=$action?>) <?=$result?></p>

