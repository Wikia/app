<!-- s:<?php echo __FILE__ ?> -->

<span id="blogPostCategoriesTitle"><?php echo $categoryCloudTitle; ?></span>
<div id="categoryCloudDiv" style="display: block;">
	<div id="categoryCloudSection<?=$cloudNo;?>" class="categoryCloudSection">
		<?php $xnum = 0; foreach( $cloud->tags as $xname => $xtag): ?>
			<span id="tag<?=$cloudNo;?>_<?=$xnum?>" style="font-size:<?=$xtag['size']?>pt">
			<a href="#" id="cloud<?=$cloudNo;?>_<?=$xnum?>" onclick="cloudAdd(<?=$cloudNo;?>, 'wpCategoryTextarea<?=$cloudNo;?>', escape ('<?=$xname?>'), <?=$xnum?>); return false;"><?=$xname?></a>
			</span>
		<?php $xnum++; endforeach; ?>
	</div>
	<textarea accesskey="," name="wpCategoryTextarea<?=$cloudNo;?>" id="wpCategoryTextarea<?=$cloudNo;?>" class="wpCategoryTextarea" rows='3' cols='<?=$cols?>'><?=$textCategories?></textarea>
	<input type="button" name="wpCategoryButton" id="wpCategoryButton" class="button color1" value="Add Category" onclick="cloudInputAdd(<?=$cloudNo;?>, 'wpCategoryTextarea<?=$cloudNo;?>', 'categoryCloudSection<?=$cloudNo;?>', 'wpCategoryInput<?=$cloudNo;?>'); return false ;" />
	<input type="text" name="wpCategoryInput<?=$cloudNo;?>" class="wpCategoryInput" id="wpCategoryInput<?=$cloudNo;?>" value="" />
</div>

<script type="text/javascript">
/*<![CDATA[*/
	YWC.CheckCategoryCloud(<?=$cloudNo;?>, 'wpCategoryTextarea<?=$cloudNo;?>', 'categoryCloudSection<?=$cloudNo;?>');
/*]]>*/
</script>
<!-- e:<?= __FILE__ ?> -->
