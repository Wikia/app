<input type="hidden" value="<?= $name ?>" id="imgName"/>
<input type="hidden" value="<?= $width ?>" id="imgWidth"/>
<input type="hidden" value="<?= $height ?>" id="imgHeight"/>
<input type="hidden" value="<?php global $wgContLang; echo $wgContLang->getNsText(NS_IMAGE) ?>" id="imageLocalized"/>

<h2><?= wfMsg('mu_size_your_image') ?></h2>
<p><?= wfMsg('almosttheretext') ?></p>

<input name="mode" type="radio" value="original" id="insertFullSize" />
<label for="insertFullSize"><?= wfMsg('insertfullsize') ?></label>
<br />

<input name="mode" type="radio" value="thumbnail" id="insertThumbnail" checked=true/>
<label for="insertThumbnail"><?= wfMsg('insertthumbnail') ?></label>
<br />

<br />

<div id="userControls">
	<div id="thumbSizeLabel"><?= wfMsg('thumbnailsize') ?></div>
	<img src="http://images.wikia.com/common/skins/common/slider_groove.png" id="groove" />
	<img src="http://images.wikia.com/common/skins/common/slider_thumb_bg.png" id="slider" style="left:205px;" />

	<div id="thumbSizeValue"></div>
	<div id="alignControls">
		<img id="alignLeft" class="alignControl" title="<?= wfMsg('leftalign-tooltip') ?>" src="http://images.wikia.com/common/skins/common/align_left.png" />
        <img id="alignRight" class="alignControl" title="<?= wfMsg('rightalign-tooltip') ?>" src="http://images.wikia.com/common/skins/common/align_right.png" />
    </div>
</div>

<div id="wrapper" style="text-align:center; width:450px; height:200px;">
	<img id="imgThumbnail" style="width:50px; height:50px; background-color:#bbb; margin:5px; float: left; clear:none;" src="<?= $url ?>" />
</div>

<div id="captionDiv">
	<label for='captionText'><?= wfMsg('captionoptional') ?></label>
	<input type=text value="" name="captionText" id="captionText" style="'Lucida Grande', Verdana, Arial, sans-serif; padding: 5px; width: 310px; font-size: 13px; border: 1px solid #999; background-color: #fff">
</div>

<br/>

<p style="text-align:center;"><input id="insertimage" type="button" value="<?= wfMsg('insertimage') ?>" /></p>