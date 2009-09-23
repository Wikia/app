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

<form method="POST">

<p>Front cover:</p>

<ul>
	<?php foreach ($cover as $c_name => $c_value): ?>
		<li>
			<label for="c_<?=$c_name?>"><?=str_replace("_", " ", $c_name)?></label>
			<input id="c_<?=$c_name?>" name="cover[<?=$c_name?>]" value="<?=htmlspecialchars($c_value)?>"/>
		</li>
	<?php endforeach; ?>
</ul>

<input type="submit" name="action" value="customize"/>

</form>

<h3>Lolek</h3>

<p>Preview <a href="/wiki/Special:Bolek?action=cover">front cover</a> and pdf <a href="/wiki/Special:Bolek?action=print">content</a>.</p>

<script type="text/javascript">
/*<![CDATA[*/
function getPdf() {
	$("#getpdf_result").text("...request sent, please wait...");
	$.get(wgServer, {
		action:    "ajax",
		rs:        "Lolek::getPdf",
		url:       "<?=$url?>",
		bolek_id:  "<?=$bolek_id?>",
		timestamp:  <?=$timestamp?>
	}, function(data, textStatus) {
		if (data.match(/\.pdf$/)) {
			$("#getpdf_result").html("...pdf is ready, please <a href=\"" + data + "\">download it</a>.");
			showPage($("#page1"), 7);
			showPage($("#page2"), 8);
		} else {
			$("#getpdf_result").text("..." + data);
		}
	});
}

function showPage(o, i) {
	$.get(wgServer, {
		action:    "ajax",
		rs:        "Lolek::getPage",
		bolek_id:  "<?=$bolek_id?>",
		timestamp:  <?=$timestamp?>,
		page_id:    i
	}, function(data, textStatus) {
		if (data.match(/\.jpg$/)) {
			o.attr({src: data});
		}
	});
}
/*]]>*/
</script>

<p>
<a href="#" onclick="getPdf();return false;">Get pdf</a>
<span id="getpdf_result"></span>
</p>

<img id="page1" src="http://images.wikia.com/common/releases_trunk/skins/monobook/blank.gif" width="150" height="200" style="border: black 1px solid" />
<img id="page2" src="http://images.wikia.com/common/releases_trunk/skins/monobook/blank.gif" width="150" height="200" style="border: black 1px solid" />

<iframe id="magcloud" src="https://magcloud.com/apps/authorizeask/f0515620-ce8d-41f1-9354-d6907d4bf201?ud=approval" width="1" height="1"></iframe>

<script type="text/javascript">
/*<![CDATA[*/
function publish() {
	$("#publish_result").text("...logging in, please wait...");
	try {
		var token = $("#magcloud").contents().find("#token").text();
	} catch(err) {
		$("#publish_result").html("...please <a href=\"https://magcloud.com/apps/authorizeask/f0515620-ce8d-41f1-9354-d6907d4bf201\">login to MagCloud</a> and try again.");
		return;
	}

	$("#publish_result").text("...publishing your magazine, please wait...");
	$.get(wgServer, {
		action:    "ajax",
		rs:        "Tola::publish",
		bolek_id:  "<?=$bolek_id?>",
		timestamp:  <?=$timestamp?>,
		token:      token
	}, function(data, textStatus) {
		if (data.match(/^[0-9]+$/)) {
			$("#publish_result").html("...all done, you can visit <a href=\"http://magcloud.com/browse/Issue/" + data + "\">your new magazine</a> now.");
		} else {
			$("#publish_result").text("..." + data);
		}
	});
}
/*]]>*/
</script>

<p>
<a href="#" onclick="publish();return false;">Publish pdf</a>
<span id="publish_result"></span>
</p>

<hr />

<p>Debug: (<?=$action?>) <?=$result?> [<?=$bolek_id?>]</p>

