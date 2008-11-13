<!-- s:<?php echo __FILE__ ?> -->
<script type="text/javascript">
/*<![CDATA[*/
//

function cloudAdd(category, num) {

	category_text = YD.get ('wpCategoryTextarea') ;

        if (category_text.value == '') {
                category_text.value += unescape (category) ;
        } else {
                category_text.value += '|' + unescape (category) ;
        }
        this_button = document.getElementById('cloud' + num);
        this_button.onclick = function() {
                eval("cloudRemove('" + category + "'," + num + ")");
                return false;
        }
        this_button.style["color"] = "#419636";
        return false;
};

function cloudInputAdd () {
	category_input = YD.get ('wpCategoryInput') ;
	category_text = YD.get ('wpCategoryTextarea') ;
	var category = 	category_input.value ;
	if ('' != category_input.value) {
		if (category_text.value == '') {
			category_text.value += unescape (category) ;
		} else {
			category_text.value += '|' + unescape (category) ;
		}
		category_input.value = '' ;
		var c_found = false ;
		var core_cat = category.replace (/\|.*/,'') ;
		for (j in YWC.foundCategories) {
			if (YWC.foundCategories[j] == core_cat) {
				this_button = YD.get ('cloud'+ j) ;
				var actual_cloud = YWC.foundCategories[j] ;
				var cl_num = j ;

				this_button.onclick = YWC.onclickCategoryFn (core_cat,j) ;
				this_button.style.color = "#419636" ;
				c_found = true ;
				break ;
			}
		}
		if (!c_found) {
			var n_cat = document.createElement ('a') ;
			var s_cat = document.createElement ('span') ;
			n_cat_count = YWC.foundCategories.length ;

			var cat_full_section = YD.get ('createpage_cloud_section') ;
			var cat_num = n_cat_count ;
			n_cat.setAttribute ('id','cloud' + cat_num) ;
			n_cat.setAttribute ('href','#') ;
			n_cat.onclick = YWC.onclickCategoryFn (core_cat, cat_num) ;
			n_cat.style.color = '#419636' ;
			n_cat.style.fontSize = '10pt' ;
			s_cat.setAttribute ('id','tag' + cat_num) ;
			t_cat = document.createTextNode (core_cat) ;
			space = document.createTextNode (' ') ;
			n_cat.appendChild (t_cat) ;
			s_cat.appendChild (n_cat) ;
			s_cat.appendChild (space) ;
			cat_full_section.appendChild (s_cat) ;
			YWC.foundCategories [n_cat_count] = core_cat  ;
		}
	}
}

function cloudRemove(category, num) {
	category_text = YD.get ('wpCategoryTextarea') ;
        this_pos = category_text.value.indexOf (unescape (category)) ;
        if (this_pos != -1) {
                category_text.value = category_text.value.substr(0, this_pos-1) + category_text.value.substr(this_pos + unescape (category).length);
        }
        this_button = document.getElementById('cloud' + num);
        this_button.onclick = function() {
                eval("cloudAdd('" + category + "'," + num + ")");
                return false
        };
        this_button.style["color"] = "";
        return false;
};

function cloudBuild(o) {
        var categories = o.value;
        new_text = '';
        categories = categories.split("|");
        for (i=0; i < categories.length; i++) {
                if (categories[i]!='') {
                        new_text += '[[Category:' + categories[i] + ']]';
                }
        }
        return new_text;
};

/*]]>*/
</script>

<style type="text/css">
/*<![CDATA[*/

/*]]>*/
</style>

<div id="createpage_cloud_div" style="display: none;">
<div style="font-weight: bold;"><?= wfMsg ('createpage_categories') ?></div>
<div id="createpage_cloud_section">
<?
$xnum = 0;
foreach ( $cloud->tags as $xname => $xtag ) {
?>
	<span id="tag<?=$xnum?>" style="font-size:<?=$xtag['size']?>pt">
	<a href="#" id="cloud<?=$xnum?>" onclick="cloudAdd(escape ('<?=$xname?>'), <?=$xnum?>); return false;"><?=$xname?></a>
	</span>
<?
$xnum++;
}
?>
</div>
<textarea accesskey="," name="wpCategoryTextarea" id="wpCategoryTextarea" rows='3' cols='<?=$cols?>'<?$ew?>><?=$text_category?></textarea>
<input type="button" name="wpCategoryButton" id="wpCategoryButton" class="button color1" value="Add Category" onclick="cloudInputAdd(); return false ;" />
<input type="text" name="wpCategoryInput" id="wpCategoryInput" value="" />
</div>
<script type="text/javascript">
/*<![CDATA[*/
var div = document.getElementById('createpage_cloud_div');
document.getElementById('createpage_cloud_div').style.display = 'block';
/*]]>*/
</script>
<noscript>
<div id="createpage_cloud_section_njs">
<?
$xnum = 0;

foreach ( $cloud->tags as $xname => $xtag ) {
	$checked = (array_key_exists($xname, $array_category) && ($array_category[$xname])) ? "checked" : "";
	$array_category[$xname] = 0;
	#--$xtag['size']
?>
	<span id="tag_njs_<?=$xnum?>" style="font-size:9pt">
		<input <?=$checked?> type="checkbox" name="category_<?=$xnum?>" id="category_<?=$xnum?>" value="<?=$xname?>">&nbsp;<?=$xname?>
	</span>
<?
$xnum++;
}
$display_category = array();
foreach ($array_category as $xname => $visible) {
	if ($visible == 1) {
		$display_category[] = $xname;
	}
}
$text_category = implode(",", $display_category);
?>
</div>
<textarea tabindex='<?=$num?>' accesskey="," name="wpCategoryTextarea" id="wpCategoryTextarea" rows='3' cols='<?=$cols?>'<?$ew?>><?=$text_category?></textarea>
</noscript>

<!-- e:<?= __FILE__ ?> -->
