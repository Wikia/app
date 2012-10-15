/**
 * Utility functions for managing a tag cloud of categories for the CreateBlogListing SpecialPage
 */

var CreateBlogPost = {};

CreateBlogPost.foundCategories = [] ;

CreateBlogPost.onclickCategoryFn = function (cat, id, categoryTextarea, cloudId) {
	return function () {
		cloudToggle (cloudId, categoryTextarea, escape(cat), id) ;
		return false ;
	}
}

CreateBlogPost.CheckCategoryCloud = function (cloudId, categoryTextarea, categoryCloudSection) {
	var cat_textarea = $(categoryTextarea);
	if (!cat_textarea) {
		return ;
	}

	var cat_full_section = $(categoryCloudSection) ;

	var cloud_num = cat_full_section.children().length ;
	var n_cat_count = cloud_num ;
	var text_categories = new Array () ;
	for (i=0;i<cloud_num;i++) {
		var cloud_id = '#cloud' + cloudId + '_' + i ;
		var found_category = $(cloud_id).text() ;
		if (found_category) {
			CreateBlogPost.foundCategories[i] = found_category ;
		}
	}
	var categories = cat_textarea.val() ;
	if ('' == categories) {
		return ;
	}

	categories = categories.split ("|") ;
	for (i=0;i<categories.length;i++) {
		text_categories [i] =  categories[i] ;
	}

	for (i=0; i<text_categories.length;i++) {
		var c_found = false ;
		for (j in CreateBlogPost.foundCategories) {
			var core_cat = text_categories[i].replace (/\|.*/,'') ;
			if (CreateBlogPost.foundCategories[j] == core_cat) {
				this_button = $('#cloud' + cloudId + '_' + j) ;
				this_button.css('color', "#419636") ;
				c_found = true ;
				break ;
			}
		}
		if (!c_found && core_cat != '') {
			var n_cat = document.createElement ('a') ;
			var s_cat = document.createElement ('span') ;
			n_cat_count++ ;
			var cat_num = n_cat_count - 1 ;
			n_cat.setAttribute ('id','cloud' + cloudId + '_' + cat_num) ;
			n_cat.setAttribute ('href','#') ;
			n_cat.onclick = CreateBlogPost.onclickCategoryFn(text_categories[i], cat_num, categoryTextarea, cloudId) ;
			n_cat.style.color = '#419636' ;
			n_cat.style.fontSize = '10pt' ;
			s_cat.setAttribute ('id','tag' + cloudId + '_' + n_cat_count) ;
			t_cat = document.createTextNode (core_cat) ;
			space = document.createTextNode (' ') ;
			n_cat.appendChild (t_cat) ;
			s_cat.appendChild (n_cat) ;
			s_cat.appendChild (space) ;
			cat_full_section.append (s_cat) ;
		}
	}
}


function cloudInputAdd (cloudId, categoryTextarea, categoryCloudSection, categoryInput) {
	var category_text = $(categoryTextarea).val() ;
	var category = 	$(categoryInput).val() ;

	if ('' != category) {
		if ($(categoryTextarea).val() == '') {
			$(categoryTextarea).val( category_text += unescape (category) );
		} else {
			$(categoryTextarea).val( category_text += '|' + unescape (category)) ;
		}
		$(categoryInput).val('') ;
		var c_found = false ;
		var core_cat = category.replace (/\|.*/,'') ;
		for (j in CreateBlogPost.foundCategories) {

			if (CreateBlogPost.foundCategories[j] == core_cat) {
				this_button = $('#cloud' + cloudId + '_' + j) ;
				this_button.css ('color' , "#419636");
				c_found = true ;
				break ;
			}
		}
		if (!c_found) {
			var n_cat = document.createElement ('a') ;
			var s_cat = document.createElement ('span') ;
			n_cat_count = CreateBlogPost.foundCategories.length ;

			var cat_num = n_cat_count ;
			n_cat.setAttribute ('id','cloud' + cloudId + '_' + cat_num) ;
			n_cat.setAttribute ('href','#') ;
			n_cat.onclick = CreateBlogPost.onclickCategoryFn(core_cat, cat_num, categoryTextarea, cloudId) ;
			n_cat.style.color = '#419636' ;
			n_cat.style.fontSize = '10pt' ;
			s_cat.setAttribute ('id','tag' + cloudId + '_' + cat_num) ;
			t_cat = document.createTextNode (core_cat) ;
			space = document.createTextNode (' ') ;
			n_cat.appendChild (t_cat) ;
			s_cat.appendChild (n_cat) ;
			s_cat.appendChild (space) ;
			$(categoryCloudSection).append (s_cat) ;
			CreateBlogPost.foundCategories [n_cat_count] = core_cat ;
		}
	}
}

function cloudToggle(cloudId, categoryTextarea, category, num) {
	var category_text = $(categoryTextarea).val() ;
	this_button = $('#cloud' + cloudId + '_' + num);

	// if cloud is already selected, unselect it
	this_pos = category_text.indexOf (unescape (category)) ;
	if (this_pos != -1) {
		$(categoryTextarea).val( category_text.substr(0, this_pos-1) +category_text.substr(this_pos + unescape (category).length) );
		this_button.css ("color", "");
	} else {
		// select the cloud tag
		if (category_text == '') {
			$(categoryTextarea).val( category_text += unescape (category)) ;
		} else {
			$(categoryTextarea).val( category_text += '|' + unescape (category)) ;
		}
		this_button.css ("color", "#419636");
	}
	return false;
};

function cloudBuild(o) {
	var categories = o.val();
	new_text = '';
	categories = categories.split("|");
	for (i=0; i < categories.length; i++) {
		if (categories[i]!='') {
			new_text += '[[Category:' + categories[i] + ']]';
		}
	}
	return new_text;
};
