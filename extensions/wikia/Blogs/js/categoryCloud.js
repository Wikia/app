YAHOO.namespace("Wikia.CreateBlogPost");

var YD = YAHOO.util.Dom;
var YWC = YAHOO.Wikia.CreateBlogPost;

YWC.foundCategories = [] ;

YWC.onclickCategoryFn = function (cat, id, categoryTextarea, cloudId) {
	return function () {
		cloudRemove (cloudId, categoryTextarea, escape(cat), id) ;
		return false ;
	}
}

YWC.CheckCategoryCloud = function (cloudId, categoryTextarea, categoryCloudSection) {
	var cat_textarea = YD.get (categoryTextarea) ;
	if (!cat_textarea) {
		return ;
	}

	var cat_full_section = YD.get (categoryCloudSection) ;

	var cloud_num = (cat_full_section.childNodes.length - 1) / 2 ;
	var n_cat_count = cloud_num ;
	var text_categories = new Array () ;
	for (i=0;i<cloud_num;i++) {
		var cloud_id = 'cloud' + cloudId + '_' + i ;
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
				this_button = YD.get ('cloud' + cloudId + '_' + j) ;
				var actual_cloud = YWC.foundCategories[j] ;
				var cl_num = j ;

				this_button.onclick = YWC.onclickCategoryFn (text_categories[i],j,categoryTextarea,cloudId) ;
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
			n_cat.setAttribute ('id','cloud' + cloudId + '_' + cat_num) ;
			n_cat.setAttribute ('href','#') ;
			n_cat.onclick = YWC.onclickCategoryFn (text_categories[i], cat_num, categoryTextarea, cloudId) ;
			n_cat.style.color = '#419636' ;
			n_cat.style.fontSize = '10pt' ;
			s_cat.setAttribute ('id','tag' + cloudId + '_' + n_cat_count) ;
			t_cat = document.createTextNode (core_cat) ;
			space = document.createTextNode (' ') ;
			n_cat.appendChild (t_cat) ;
			s_cat.appendChild (n_cat) ;
			s_cat.appendChild (space) ;
			cat_full_section.appendChild (s_cat) ;
		}
	}
}

function cloudAdd(cloudId, categoryTextarea, category, num) {
	category_text = YD.get (categoryTextarea) ;
	if (category_text.value == '') {
		category_text.value += unescape (category) ;
	} else {
		category_text.value += '|' + unescape (category) ;
	}
	this_button = document.getElementById('cloud' + cloudId + '_' + num);
	this_button.onclick = function() {
		eval("cloudRemove('" + cloudId + "', '" + categoryTextarea + "', '" + category + "'," + num + ")");
		return false;
	}
	this_button.style["color"] = "#419636";
	return false;
};

function cloudInputAdd (cloudId, categoryTextarea, categoryCloudSection, categoryInput) {
	category_input = YD.get (categoryInput) ;
	category_text = YD.get (categoryTextarea) ;
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
				this_button = YD.get ('cloud' + cloudId + '_' + j) ;
				var actual_cloud = YWC.foundCategories[j] ;
				var cl_num = j ;
				this_button.onclick = YWC.onclickCategoryFn (core_cat,j,categoryTextarea,cloudId) ;
				this_button.style.color = "#419636" ;
				c_found = true ;
				break ;
			}
		}
		if (!c_found) {
			var n_cat = document.createElement ('a') ;
			var s_cat = document.createElement ('span') ;
			n_cat_count = YWC.foundCategories.length ;

			var cat_full_section = YD.get (categoryCloudSection) ;
			var cat_num = n_cat_count ;
			n_cat.setAttribute ('id','cloud' + cloudId + '_' + cat_num) ;
			n_cat.setAttribute ('href','#') ;
			n_cat.onclick = YWC.onclickCategoryFn (core_cat, cat_num, categoryTextarea, cloudId) ;
			n_cat.style.color = '#419636' ;
			n_cat.style.fontSize = '10pt' ;
			s_cat.setAttribute ('id','tag' + cloudId + '_' + cat_num) ;
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

function cloudRemove(cloudId, categoryTextarea, category, num) {
	category_text = YD.get (categoryTextarea) ;
	this_pos = category_text.value.indexOf (unescape (category)) ;
	if (this_pos != -1) {
		category_text.value = category_text.value.substr(0, this_pos-1) + category_text.value.substr(this_pos + unescape (category).length);
	}
	this_button = document.getElementById('cloud' + cloudId + '_' + num);
	this_button.onclick = function() {
		eval("cloudAdd('" + cloudId + "', '" + categoryTextarea + "', '" + category + "'," + num + ")");
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
