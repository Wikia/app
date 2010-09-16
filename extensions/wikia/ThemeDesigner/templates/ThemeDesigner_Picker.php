<aside class="ThemeDesignerPicker" id="ThemeDesignerPicker">
	<div class="color">
		<h1>Pick a Color</h1>
		<ul class="swatches">
			<li style="background-color: #a10000"></li>
			<li style="background-color: #919500"></li>
			<li style="background-color: #009603"></li>
			<li style="background-color: #009494"></li>
			<li style="background-color: #190095"></li>
			<li style="background-color: #a30093"></li>
			<li style="background-color: #919191"></li>
			<li style="background-color: #929292"></li>

			<li style="background-color: #9d5000"></li>
			<li style="background-color: #2b9600"></li>
			<li style="background-color: #009651"></li>
			<li style="background-color: #004e94"></li>
			<li style="background-color: #5e0094"></li>
			<li style="background-color: #a1004e"></li>
			<li style="background-color: #797979"></li>
			<li style="background-color: #a9a9a9"></li>

			<li style="background-color: #ff0000"></li>
			<li style="background-color: #fbff00"></li>
			<li style="background-color: #00ff0a"></li>
			<li style="background-color: #00ffff"></li>
			<li style="background-color: #3400ff"></li>
			<li style="background-color: #ff00ff"></li>
			<li style="background-color: #5e5e5f"></li>
			<li style="background-color: #c0c0c0"></li>

			<li style="background-color: #ff9100"></li>
			<li style="background-color: #56ff00"></li>
			<li style="background-color: #00ff94"></li>
			<li style="background-color: #008eff"></li>
			<li style="background-color: #a800ff"></li>
			<li style="background-color: #ff008f"></li>
			<li style="background-color: #424242"></li>
			<li style="background-color: #d6d6d6"></li>

			<li style="background-color: #ff7474"></li>
			<li style="background-color: #fbff72"></li>
			<li style="background-color: #00ff78"></li>
			<li style="background-color: #15ffff"></li>
			<li style="background-color: #816fff"></li>
			<li style="background-color: #ff69ff"></li>
			<li style="background-color: #212121"></li>
			<li style="background-color: #ebebeb"></li>

			<li style="background-color: #ffd773"></li>
			<li style="background-color: #c6ff74"></li>
			<li style="background-color: #00ffd7"></li>
			<li style="background-color: #57d6ff"></li>
			<li style="background-color: #e96dff"></li>
			<li style="background-color: #ff77d7"></li>
			<li style="background-color: #000000"></li>
			<li style="background-color: #ffffff"></li>
		</ul>
		<h1>Enter Your Own</h1>
		<form id="ColorNameForm" class="ColorNameForm">
			<input type="text" placeholder="Color name or Hex code" id="color-name" class="color-name">
			<input type="submit" value="Ok">
		</form>
	</div>
	<div class="image">
		<h1>Pick an Image</h1>
		<ul class="swatches">
			<li></li>
			<li></li>
			<li></li>
			<li></li>

			<li></li>
			<li></li>
			<li></li>
			<li></li>

			<li></li>
			<li></li>
			<li></li>
			<li></li>

			<li></li>
		</ul>
		<h1>Upload Your Own</h1>

		<form id="BackgroundImageForm" class="BackgroundImageForm" onsubmit="return AIM.submit(this, ThemeDesigner.backgroundImageUploadCallback)" action="<?= $wgScriptPath ?>/index.php?action=ajax&rs=moduleProxy&moduleName=ThemeDesigner&actionName=BackgroundImageUpload&outputType=html" method="POST" enctype="multipart/form-data">
			<input id="backgroundImageUploadFile" name="wpUploadFile" type="file">
			<input type="submit" value="Upload" onclick="return ThemeDesigner.backgroundImageUpload(event);">
		</form>

	</div>
</aside>