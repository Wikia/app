<!-- s:<?php echo __FILE__ ?> -->
<script type="text/javascript">
/*<![CDATA[*/
//
YAHOO.namespace("Wikia.CreateBlogPost");

var YD = YAHOO.util.Dom;
var YWC = YAHOO.Wikia.CreateBlogPost;

YWC.foundCategories = [] ;

YWC.onclickCategoryFn = function (cat, id) {
	return function () {
		cloudRemove (escape(cat), id) ;
		return false ;
	}
}

YWC.CheckCategoryCloud = function () {
	var cat_textarea = YD.get ('wpCategoryTextarea') ;
	if (!cat_textarea) {
		return ;
	}

	var cat_full_section = YD.get ('createpage_cloud_section') ;

	var cloud_num = (cat_full_section.childNodes.length - 1) / 2 ;
	var n_cat_count = cloud_num ;
	var text_categories = new Array () ;
	for (i=0;i<cloud_num;i++) {
		var cloud_id = 'cloud' + i ;
		var found_category = YD.get (cloud_id).innerHTML ;
		if (found_category) {
			YWC.foundCategories[i] = found_category ;
		}
	}

	var categories = cat_textarea.value ;
	if ('' == categories) {
		return ;
	}

	categories = categories.split ("|") ;
	for (i=0;i<categories.length;i++) {
		text_categories [i] =  categories[i] ;
	}

	for (i=0; i<text_categories.length;i++) {
		var c_found = false ;
		for (j in YWC.foundCategories) {
			var core_cat = text_categories[i].replace (/\|.*/,'') ;
			if (YWC.foundCategories[j] == core_cat) {
				this_button = YD.get ('cloud'+ j) ;
				var actual_cloud = YWC.foundCategories[j] ;
				var cl_num = j ;

				this_button.onclick = YWC.onclickCategoryFn (text_categories[i],j) ;
				this_button.style.color = "#419636" ;
				c_found = true ;
				break ;
			}
		}
		if (!c_found) {
			var n_cat = document.createElement ('a') ;
			var s_cat = document.createElement ('span') ;
			n_cat_count++ ;
			var cat_num = n_cat_count - 1 ;
			n_cat.setAttribute ('id','cloud' + cat_num) ;
			n_cat.setAttribute ('href','#') ;
			n_cat.onclick = YWC.onclickCategoryFn (text_categories[i], cat_num) ;
			n_cat.style.color = '#419636' ;
			n_cat.style.fontSize = '10pt' ;
			s_cat.setAttribute ('id','tag' + n_cat_count) ;
			t_cat = document.createTextNode (core_cat) ;
			space = document.createTextNode (' ') ;
			n_cat.appendChild (t_cat) ;
			s_cat.appendChild (n_cat) ;
			s_cat.appendChild (space) ;
			cat_full_section.appendChild (s_cat) ;
		}
	}
}

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
#createpage_cloud_section,
#createpage_cloud_section_njs {
	border: 1px solid lightgray;
	padding: 15px 15px 15px 15px;
}

#wpCategoryTextarea {
	display: none ;
}

#wpCategoryInput, #wpCategoryButton {
	margin: 4px 2px 0 2px ;
}

#wpCategoryInput {
	width: 450px ;
}

#blogPostCategoriesTitle {
	padding-right: 1em;
	text-align: right;
	font-size: 16px;
	color: orange;
}

/*]]>*/
</style>

<span id="blogPostCategoriesTitle"><?php echo $categoryCloudTitle; ?></span>
<div id="createpage_cloud_div" style="display: block;">
	<div id="createpage_cloud_section">
		<?php $xnum = 0; foreach( $cloud->tags as $xname => $xtag): ?>
			<span id="tag<?=$xnum?>" style="font-size:<?=$xtag['size']?>pt">
			<a href="#" id="cloud<?=$xnum?>" onclick="cloudAdd(escape ('<?=$xname?>'), <?=$xnum?>); return false;"><?=$xname?></a>
			</span>
		<?php $xnum++; endforeach; ?>
	</div>
	<textarea accesskey="," name="wpCategoryTextarea" id="wpCategoryTextarea" rows='3' cols='<?=$cols?>'><?=$postCategories?></textarea>
	<input type="button" name="wpCategoryButton" id="wpCategoryButton" class="button color1" value="Add Category" onclick="cloudInputAdd(); return false ;" />
	<input type="text" name="wpCategoryInput" id="wpCategoryInput" value="" />
</div>

<script type="text/javascript">
/*<![CDATA[*/
	YWC.CheckCategoryCloud();
/*]]>*/
</script>
<!-- e:<?= __FILE__ ?> -->

