/**
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 *
 * Interaction handlers for the creation/editing UI of TopLists extension
 */
$(function() {
	TopListsEditor._init();
});

var TopListsEditor = {
	length: 0,
	_mListContainer: null,
	_mAutocompleteField: null,
	_mSelectedPictureField: null,
	_mPictureFrame: null,
	_mAutocompleteFieldChanged: false,
	
	_init: function(){
		TopListsEditor._mListContainer = $('#toplist-editor .ItemsList');
		TopListsEditor.length = TopListsEditor._mListContainer.find('li:not(.ItemTemplate)').length;
		TopListsEditor._mAutocompleteField = $('#toplist-editor input[name="related_article_name"]');
		TopListsEditor._mSelectedPictureField = $('#toplist-editor input[name="selected_picture_name"]');
		TopListsEditor._mPictureFrame =  $('#toplist-editor .ImageBrowser .frame');

		$.loadJQueryAutocomplete(function(){
			TopListsEditor._mAutocompleteField.autocomplete({
				serviceUrl: wgServer + wgScript + '?action=ajax&rs=getLinkSuggest&format=json',
				appendTo: '#toplist-editor div.InputSet:last',
				deferRequestBy: 1000,
				maxHeight: 1000,
				selectedClass: 'selected',
				width: '270px',
				onSelect: function(v, d){
					TopListsEditor.track('autocomplete-suggestion-selected');
					TopListsEditor._mAutocompleteFieldChanged = true;
					TopListsEditor.autoSelectImage(v);
				}
			})
		});

		$.loadJQueryUI(function(){
			TopListsEditor._mListContainer.sortable({
				containment: '#toplist-editor .ItemsList',
				items: '.NewItem',
				handle: '.ItemDrag',
				placeholder: 'DragPlaceholder',
				axis: 'y',
				cursorAt: 'right',
				cursor: 'move',
				opacity: 0.5,
				revert: 200,
				scroll: true,
				update: TopListsEditor._fixLabels
			});
		});

		//events handlers
		TopListsEditor._mAutocompleteField.bind('blur', function(){ TopListsEditor.autoSelectImage($(this).val()); });
		TopListsEditor._mAutocompleteField.bind('change', function(){ TopListsEditor._mAutocompleteFieldChanged = true; });
		$('#toplist-editor .ImageBrowser a.wikia-chiclet-button').click(TopListsEditor.showImageBrowser);
		TopListsEditor._mListContainer.find('li .ItemRemove a').click(TopListsEditor.removeItem);
		$('#toplist-add-item').click(TopListsEditor.addItem);
	},

	track: function(token){
		$.tracker.byStr('TopLists/editor/' + token);
	},

	_fixLabels: function(){
		TopListsEditor.track('item-drag-order');
		TopListsEditor._mListContainer.find('li:not(.ItemTemplate) .ItemNumber').each(function(index, elm){
			$(elm).html('#' + (index + 1));
		});
	},

	autoSelectImage: function(imageText){
		if(typeof imageText != 'undefined' && imageText != '' && TopListsEditor._mAutocompleteFieldChanged){
			TopListsEditor.track('autoselecting-image-requested');
			TopListsEditor._mAutocompleteFieldChanged = false;
			TopListsImageBrowser.getImageData(imageText);
		}
	},

	addItem: function(){
		TopListsEditor.track('item-add');
		TopListsEditor.length++;
		
		var item = TopListsEditor._mListContainer
			.find('li:first')
			.clone(true)
			.removeClass('ItemTemplate')
			.appendTo(TopListsEditor._mListContainer)
			.show();

			item
				.find('.ItemNumber')
				.text('#' + TopListsEditor.length);

			item
				.find('input[type=text]:disabled')
				.removeAttr('disabled');
	},

	removeItem: function(){
		TopListsEditor.track('item-remove');
		var item = $(this).closest('li');

		if(!item.hasClass('NewItem')){
			$('<input/>', {
				'type': 'hidden',
				'name': 'removed_items[]'
			}).
				val(parseInt(item.find('input[type="hidden"]').val())).
				appendTo($('#toplist-editor'));
		}
		
		item.remove();
		
		TopListsEditor.length--;
		TopListsEditor._fixLabels();
	},

	setPicture: function(picture){
		TopListsEditor._mPictureFrame.find('img').remove();
		
		if(picture == null || typeof picture === 'undefined'){
			TopListsEditor.track('picture-cleared-out');
			TopListsEditor._mPictureFrame.find('.NoPicture').show();
			TopListsEditor._mSelectedPictureField.val('');
		} else {
			TopListsEditor.track('picture-selected');
			$('<img/>', {
				'src': picture.url,
				'alt': picture.name,
				'title': picture.name
			}).appendTo(TopListsEditor._mPictureFrame);

			TopListsEditor._mPictureFrame.find('.NoPicture').hide();
			TopListsEditor._mSelectedPictureField.val(picture.name);
		}

	},

	showImageBrowser: function(){
		TopListsImageBrowser.show(
			TopListsEditor._mAutocompleteField.val(),
			TopListsEditor._mSelectedPictureField.val(),
			TopListsEditor.setPicture
		);
	}
};

var TopListsImageBrowser = {
	_mDialog: null,
	_mContext:null,
	_mOnSelectCallback: null,
	_uploadForm: null,
	_uploadInProgress: false,

	_init: function(){
		TopListsImageBrowser._mDialog = $('.modalWrapper');
		TopListsImageBrowser._mContext = $('#image-browser-dialog');
		TopListsImageBrowser._uploadForm = TopListsImageBrowser._mContext.find('form');
		
		$.loadJQueryAIM(function(){

			TopListsImageBrowser._uploadForm.find('input[type="file"]').change(TopListsImageBrowser._onImageFileSelected);
			TopListsImageBrowser._uploadForm.submit(TopListsImageBrowser._onImageUpload);
		});

		//handle events
		TopListsImageBrowser._mContext.find('.SuggestedPictures a').click(TopListsImageBrowser._onSelect);
		TopListsImageBrowser._mContext.find('.SuggestedPictures .NoPicture').click(TopListsImageBrowser._onSelect);
	},

	_destroy: function(){
		if( !TopListsImageBrowser._uploadInProgress )
			TopListsImageBrowser._mDialog.closeModal();

		return !TopListsImageBrowser._uploadInProgress;
	},

	_onSelect: function(){
		if( !TopListsImageBrowser._uploadInProgress ){
			TopListsEditor.track('image-browser-picture-selected');
			elm = $(this);
			selectedPicture = null;

			if(!elm.hasClass('NoPicture')){
				selectedPicture = {
					name: elm.attr('title'),
					url: elm.children().first().attr('src')
				}
			}

			if(typeof TopListsImageBrowser._mOnSelectCallback === 'function') TopListsImageBrowser._mOnSelectCallback(selectedPicture);
			TopListsImageBrowser._destroy();
		}
	},

	_onImageFileSelected: function(){
		if( !TopListsImageBrowser._uploadInProgress ){
			TopListsEditor.track('image-browser-upload-file-selected');
			TopListsImageBrowser._uploadForm.submit();
		}
	},

	_onImageUpload: function(){
		TopListsImageBrowser._uploadInProgress = true;
		TopListsImageBrowser.blockInput();
		
		$.AIM.submit(
			this,
			{
				onComplete: TopListsImageBrowser._onImageUploadComplete
			}
		);
	},

	_onImageUploadComplete: function(response){
		TopListsImageBrowser._uploadInProgress = false;
		TopListsImageBrowser.unblockInput();

		if(response.success === true){
			TopListsEditor.track('image-browser-upload-completed');
			if(typeof TopListsImageBrowser._mOnSelectCallback === 'function') TopListsImageBrowser._mOnSelectCallback(response);
			TopListsImageBrowser._destroy();
		} else if (response.error === true || response.conflict === true){
			TopListsEditor.track('image-browser-upload-file-failed');
			TopListsImageBrowser._uploadForm.find('p.error').html(response.message);
		}
	},

	unblockInput: function(){
		$('#toplists-loading-screen').remove();
	},

	blockInput: function(){
		TopListsImageBrowser.unblockInput();
		TopListsImageBrowser._mContext.prepend('<div id="toplists-loading-screen"></div>');
	},
	
	show: function(relatedArticle, selectedPicture, onSelectCallback){
		TopListsEditor.track('image-browser-opened');

		$().getModal(
			wgScript + '?action=ajax&rs=TopListHelper::renderImageBrowser&title=' + encodeURI(relatedArticle) + '&selected=' + encodeURI(selectedPicture),
			'#image-browser-dialog',
			{
				width: 290,
				callback: TopListsImageBrowser._init,
				onClose: TopListsImageBrowser._destroy
			}
		);
		
		TopListsImageBrowser._mOnSelectCallback = onSelectCallback;
	},

	getImageData: function(title){
		$.getJSON(wgScript,
			{
				'action': 'ajax',
				'rs': 'TopListHelper::getImageData',
				'title': title
			},
			function(response) {
				if(response.result === true){
					TopListsEditor.track('autoselecting-image-success');
					TopListsEditor.setPicture(response);
				}
				else{
					TopListsEditor.track('autoselecting-image-fail');
				}
				
				return false;
			}
		);
	}
}