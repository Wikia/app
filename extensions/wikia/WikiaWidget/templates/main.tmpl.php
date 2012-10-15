<? 
global $wgLogo, $wgSitename, $wgServer;

//List of parameters and default values
$flashvardefault = array(
	'backgroundColor' => '336699', 
	'backgroundImage' => '', 
	'borderColor' => '333333', 
	'dropShadow' => '1', 
	'headerColor' => '000000', 
	'headerAlpha' => '.2', 
	'headerBorderColor' => 'FFFFFF', 
	'headline1' => $wgSitename .' presents', 
	'headline1Color' => 'CCCCCC', 
	'headline2' => 'A cool slideshow!', 
	'headline2Color' => 'FFFFFF', 
	'clickURL' => $wgServer, 
	'wikiURLColor' => 'FFFFFF', 
	'wikiaLogoColor' => 'FFFFFF',
	'logo' => $wgLogo,
	'type' => 'slideshow',
	'slideshowImages' => 'http://images.wikia.com/common/skins/common/flash_widgets/slideshow_placeholder.png,http://images.wikia.com/common/skins/common/flash_widgets/slideshow_placeholder2.png'
);


//Determine if any of the above values have been submitted as GET vars
foreach ($flashvardefault as $key => $value) {
	if (!empty($_POST[$key])) {
		$use_default_style = false;
		break;
	} else {
		$use_default_style = true;
	}
}

//Set $flashvars variable with either default values or user values
$flashvars = 'FlashVars="';
if ($use_default_style) {
	foreach ($flashvardefault as $key => $value) {
		$flashvars .= $key .'='. urlencode($value) .'&';
		$_POST[$key] = $value;
	}
} else {
	foreach ($flashvardefault as $key => $value) {
		//change linebreaks to commas
		if ($key == 'slideshowImages') {
			$temp_img_array = preg_split("/\n/", trim($_POST[$key]));
			$_POST[$key] = implode(',', $temp_img_array);
			$flashvars .= $key .'='. urlencode($_POST[$key]) .'&';
			break;
		}
		if (isset($_POST[$key])) {
			$flashvars .= $key .'='. urlencode($_POST[$key]) .'&';
		}
	}
}
$flashvars .= 'logo='. $wgLogo .'"';
?>

<script type="text/javascript">
function backgroundImageInterface(e) {
	document.wikia_widget.loadBackground(e.target.value);
}
function myInterface(e) {
	if (e.target.value) {
		switch (e.target.name) {
			case 'backgroundColor':
				document.wikia_widget.setColor('background', e.target.value);
				break;
			case 'borderColor':
				document.wikia_widget.setColor('border', e.target.value);
				break;
			case 'headerColor':
				document.wikia_widget.setColor('header', e.target.value);
				document.wikia_widget.setColor('footer', e.target.value);
				break;
			case 'headerAlpha':
				document.wikia_widget.setColor('header', document.forms['config'].headerColor.value, e.target.value);
				document.wikia_widget.setColor('footer', document.forms['config'].headerColor.value, e.target.value);
			case 'headerBorderColor':
				document.wikia_widget.setColor('header_border', e.target.value);
				document.wikia_widget.setColor('footer_border', e.target.value);
				break;
			case 'headline1':
				document.wikia_widget.headline('headline1', e.target.value, document.forms['config'].headline1Color.value);
				break;
			case 'headline2':
				document.wikia_widget.headline('headline2', e.target.value, document.forms['config'].headline2Color.value);
				break;
			case 'headline1Color':
				document.wikia_widget.headline('headline1', document.forms['config'].headline1.value, e.target.value);
				break;
			case 'headline2Color':
				document.wikia_widget.headline('headline2', document.forms['config'].headline2.value, e.target.value);
				break;
			case 'wikiaLogoColor':
				document.wikia_widget.setColor('wikia_logo', e.target.value);
				break;
			case 'clickURL':
				document.wikia_widget.url(e.target.value, document.forms['config'].wikiURLColor.value);
				break;
			case 'wikiURLColor':
				document.wikia_widget.url(document.forms['config'].clickURL.value, e.target.value);
				break;
			case 'type':
				setType(e.target.value);
				break;
			case 'dropShadow':
				document.wikia_widget.shadow(e.target.checked);
				break;
			default:
				break;
		}
	}
}

function generateWidgetCode() {
	var flashcode = '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="300" height="250" align="middle" id="wikia_widget"> <param name="allowScriptAccess" value="always" /> <param name="movie" value="http://images.wikia.com/common/skins/common/flash_widgets/wikia_widget.swf" /> <param name="quality" value="high" /> <param name="wmode" value="transparent" /> <embed src="http://images.wikia.com/common/skins/common/flash_widgets/wikia_widget.swf" ';
	
	var params = 'FlashVars="';
	var elements = document.forms['config'].elements;
	for (i=0; i<elements.length; i++) {
		if (elements[i].name == 'slideshowImages') {
			var img_array = elements[i].value.split("\n");
			params += elements[i].name + '=' + img_array.join(",") + '&';
		} else {
			params += elements[i].name + '=' + elements[i].value + '&';
		}
	}
	params += '"';

	flashcode += params;
	
	flashcode += ' quality="high" wmode="transparent" width="300" height="250" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" name="wikia_widget" /> </object>';
	
	document.getElementById('codearea').innerHTML = flashcode;
}
</script>

<div style="float: right; margin-left: 10px;">
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="300" height="250" align="middle" id="wikia_widget">
	<param name="allowScriptAccess" value="always" />
	<param name="movie" value="/skins/common/flash_widgets/wikia_widget.swf" />
	<param name="quality" value="high" />
	<param name="wmode" value="transparent" />
	<embed src="/skins/common/flash_widgets/wikia_widget.swf" <?=$flashvars?> quality="high" wmode="transparent" width="300" height="250" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" name="wikia_widget" />
</object>
</div>

<form name="config" method="POST" action="<?=$_SERVER['PHP_SELF']?>">
<h2>Background colors and images</h2>

<h3>Main background</h3>
<ul>
	<li>
		<label>Background style</label>
		<ul>
			<li>
				<label>Background color:</label>
				#<input type="text" name="backgroundColor" onblur="myInterface(event)" style="width: 6em;" maxlength="6" value="<?=htmlspecialchars($_POST['backgroundColor'])?>" /><br />
				<b>or</b>
			</li>
			<li>
				<label>Background image:</label>
				<input type="text" name="backgroundImage" onblur="backgroundImageInterface(event)" value="<?=htmlspecialchars($_POST['backgroundImage'])?>" /> 
			</li>
		</ul>
	</li>
	<li>
		<label>Border color:</label>
		#<input type="text" name="borderColor" onblur="myInterface(event)" style="width: 6em;" maxlength="6" value="<?=htmlspecialchars($_POST['borderColor'])?>" />
	</li>
	<li>
		<label>Drop shadow:</label>
		<input type="checkbox" name="dropShadow" checked="checked" onchange="myInterface(event);" />
</ul>


<h3>Header &amp; Footer</h3>
<ul>
	<li>
		<label>Header &amp; footer background color:</label>
		#<input type="text" name="headerColor" onblur="myInterface(event)" style="width: 6em;" maxlength="6" value="<?=htmlspecialchars($_POST['headerColor'])?>" />
		<ul>
			<li>
				<label>Opacity:</label>
				<input type="text" name="headerAlpha" onblur="myInterface(event)" style="width: 2em;" value="<?=htmlspecialchars($_POST['headerAlpha'])?>" /> (decimal between 0.0 and 1.0)
			</li>
		</ul>
	</li>
	<li>
		<label>Header &amp; footer border color:</label>
		#<input type="text" name="headerBorderColor" onblur="myInterface(event)" style="width: 6em;" maxlength="6" value="<?=htmlspecialchars($_POST['headerBorderColor'])?>" />
	</li>
</ul>

<h2>Headline text</h2>
<ul>
	<li>
		<label>First Headline</label>
		<input type="text" name="headline1" onblur="myInterface(event);" value="<?=htmlspecialchars($_POST['headline1'])?>" />
		<label>Color:</label>
		#<input type="text" name="headline1Color" onblur="myInterface(event);" style="width: 6em;" maxlength="6" value="<?=htmlspecialchars($_POST['headline1Color'])?>" />
	</li>
	<li>
		<label>Second Headline</label>
		<input type="text" name="headline2" onblur="myInterface(event);" value="<?=htmlspecialchars($_POST['headline2'])?>" />
		<label>Color:</label>
		#<input type="text" name="headline2Color" onblur="myInterface(event);" style="width: 6em;" maxlength="6" value="<?=htmlspecialchars($_POST['headline2Color'])?>" />
	</li>
</ul>

<h2>Attribution</h2>
<ul>
	<li>
		<label>Click URL:</label>
		<input type="text" name="clickURL" onblur="myInterface(event);" value="<?=htmlspecialchars($_POST['clickURL'])?>" />
		<label>Link color:</label>
		#<input type="text" name="wikiURLColor" onblur="myInterface(event);" style="width: 6em;" maxlength="6" value="<?=htmlspecialchars($_POST['wikiURLColor'])?>" />
	</li>
	<li>
		<label>Wikia logo color:</label>
		#<input type="text" name="wikiaLogoColor" onblur="myInterface(event);" style="width: 6em;" maxlength="6" value="<?=htmlspecialchars($_POST['wikiaLogoColor'])?>" />
	</li>
</ul>

<h2>Images</h2>
<input type="hidden" name="type" value="slideshow" />
<textarea name="slideshowImages" style="height: 100px;"><?=htmlspecialchars(str_replace(",", PHP_EOL, $_POST['slideshowImages']))?></textarea><br />
(One full image url per line) <input type="submit" value="Preview images in the widget"/>
</form>

<h2>Get the code</h2>
<input type="button" value="Generate Code" onclick="generateWidgetCode();" /><br />
<textarea id="codearea" style="width: 600px; height: 150px;"></textarea>
