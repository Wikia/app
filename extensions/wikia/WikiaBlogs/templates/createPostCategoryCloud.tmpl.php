<!-- s:<?php echo __FILE__ ?> -->

<span id="blogPostCategoriesTitle"><?php echo $categoryCloudTitle; ?></span>
<div id="categoryCloudDiv" style="display: block;">
	<div id="categoryCloudSection<?=$cloudNo;?>" class="categoryCloudSection">
	<?php if (!empty($cloud->tags)) : ?>
		<?php $xnum = 0; foreach( $cloud->tags as $xname => $xtag): ?>
			<span id="tag<?=$cloudNo;?>_<?=$xnum?>" style="font-size:<?=$xtag['size']?>pt">
			<a href="#" id="cloud<?=$cloudNo;?>_<?=$xnum?>" onclick="cloudAdd(<?=$cloudNo;?>, 'wpCategoryTextarea<?=$cloudNo;?>', escape ('<?=$xname?>'), <?=$xnum?>); return false;"><?=$xname?></a>
			</span>
		<?php $xnum++; endforeach; ?>
	<?php endif ?>	
	</div>
	<textarea accesskey="," name="wpCategoryTextarea<?=$cloudNo;?>" id="wpCategoryTextarea<?=$cloudNo;?>" class="wpCategoryTextarea" rows='3' cols='<?=$cols?>'><?=$textCategories?></textarea>
	<?=wfMsg('create-blog-categories-textinput')?>&nbsp;<input type="text" name="wpCategoryInput<?=$cloudNo;?>" class="wpCategoryInput" id="wpCategoryInput<?=$cloudNo;?>" value="" />
	<input type="button" name="wpCategoryButton" id="wpCategoryButton" class="button color1" value="<?=wfMsg('create-blog-categories-submit')?>" onclick="cloudInputAdd(<?=$cloudNo;?>, 'wpCategoryTextarea<?=$cloudNo;?>', 'categoryCloudSection<?=$cloudNo;?>', 'wpCategoryInput<?=$cloudNo;?>'); return false ;" />
</div>

<script type="text/javascript">
/*<![CDATA[*/
	YWC.CheckCategoryCloud(<?=$cloudNo;?>, 'wpCategoryTextarea<?=$cloudNo;?>', 'categoryCloudSection<?=$cloudNo;?>');
/*]]>*/
</script>
<!-- e:<?= __FILE__ ?> -->
