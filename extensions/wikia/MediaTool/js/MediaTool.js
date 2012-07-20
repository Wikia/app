var MediaTool = MediaTool || (function () {

	/** @private **/
	var cart = null;
	var itemsCollection = null;
	var renderer = null;
	var videoPreview = null;
	var resourceLoaderCache = null;
	var dialogWrapper = null;
	var isVideoPlayerDisplayed = false;
	var currentView = "find"; // [ find, edit ]
	var mt = null;

	/* templates */
	var templateDialog = null;
	var templateCart = null;
	var templateItemsList = null;
	var templateItem = null;
	var itemPreviewTpl = null;
	var itemPreviewBorderTpl = null;
	var itemPreviewInputsTpl = null;
	var sliderMinMediaSize = 60;
	var sliderMaxMediaSize = 660;
	var minMediaSize = 1;
	var maxMediaSize = 9999;
	var smallMediaSize = 250
	var largeMediaSize = 300;
	var defaultMediaSettings = { align:'left', alt:"", caption:"", thumbnail:true, width:300 };
	var watchCreations = false;

	function loadResources() {
		return resourceLoaderCache = resourceLoaderCache ||
			$.Deferred(function (dfd) {
				$.when(
					Wikia.getAMgroups('mediatool'),
					$.loadMustache(),
					$.loadJQueryUI(),
					callBackend('getTemplates', function (resp) {
						//@todo: pass cb call in parameters (for caching)
						templateDialog = resp['dialog'];
						templateCart = resp['cart'];
						itemPreviewTpl = resp['itemPreviewTpl'];
						itemPreviewBorderTpl = resp['itemPreviewBorderTpl'];
						itemPreviewInputsTpl = resp['itemPreviewInputsTpl'];
						templateItemsList = $("<div>").html(resp['itemsList']).find('#mediaToolBasketTemplate').html();
						templateItem = $("<div>").html(resp['itemsList']).find('#mediaToolBasketItemTemplate').html();
					}),
					callBackend('getData', function(resp) {
							//@todo: recentMedia should be fetched in this call
							watchCreations = resp['watchCreations'];
						}
					)

				).done(dfd.resolve);
			}).promise();
	}

	var initModalComplete = false;

	function initModal() {
		if (!initModalComplete) {

		    	// loading resources, constructing dialog
			renderer = new MediaTool.MainRenderer();
			videoPreview = new MediaTool.VideoPreview();

			itemsCollection = new MediaTool.ItemsCollection('mediatool-thumbnail-browser', 'mediaToolItemList', 'mediaToolBasket');
			itemsCollection.template = templateItemsList;
							itemsCollection.itemTemplate = templateItem;
			cart = new MediaTool.Cart('mediaToolBasket', 'mediaToolItemList');
			cart.template = templateCart;
			this.bind('Cart::itemsChanged', onCartContentChange);
			this.bind('Cart::thumbnailStyleChanged', onThumbnailStyleChange);
			this.bind('Cart::mediaSizeChanged', onMediaSizeChange);
			this.bind('Cart::mediaLocationChanged', onMediaLocationChange);

			this.bind('showModal', function() {trackMUT(WikiaTracker.ACTIONS.CLICK, 'open', wgCityId);});
			this.bind('editDone', function() {trackMUT(WikiaTracker.ACTIONS.CLICK, 'complete', wgCityId);});
			this.bind('changeTab', onChangeTab);
			this.bind('error', onError);

			mt = this;
			initModalComplete = true;
		}
	}

	function trackMUT(action, label, value) {

		/*
		 tracking using new werehouse
		 */
		WikiaTracker.trackEvent(null, {
		    ga_category: 'mut',
		    ga_action: action,
		    ga_label: label || '',
		    ga_value: value || 0
		}, 'internal');
	}

	function getInitialMediaSetting(initialMediaSettings, key) {
		if ((typeof initialMediaSettings === "object") && (typeof initialMediaSettings[key] !== "undefined") && (initialMediaSettings[key] !== "")) {
			return initialMediaSettings[key];
		}
		return defaultMediaSettings[key];
	}

	function showModal(wikiTextCallback, initialMediaSettings, initialBasketContent) {
		var self = this;
		loadResources().done(function () {

			self.initModal();
			var processedhtml = $.mustache(templateDialog, {
					'cart':templateCart,
					'itemslist':$.mustache(templateItemsList, {
						'title':'Media recently added to wiki',
						'items':itemsCollection.items
					}),
					largeMediaLabel: $.msg('mediatool-large-thumbnail', largeMediaSize),
					smallMediaLabel: $.msg('mediatool-small-thumbnail', smallMediaSize)
				}
			);
			dialogWrapper = $.showModal('MUT', processedhtml, { width:970, className:"MediaToolModal" });

			appendUIActions.call(self);

			self.fire('showModal');

			cart.setThumbnailStyle(getInitialMediaSetting.call(self, initialMediaSettings, 'thumbnail'));
			cart.setMediaLocation(getInitialMediaSetting.call(self, initialMediaSettings, 'align'));
			cart.setMediaSize(Math.min(getInitialMediaSetting.call(self, initialMediaSettings, 'width'), maxMediaSize));
			renderer.setWikiTextCallback(wikiTextCallback);

			if ( typeof initialBasketContent  != "undefined" && initialBasketContent.length ) {
				useInitialBasketContent( initialBasketContent );
				renderPreview();

			} else {
				changeCurrentView( "find" );
			}
		});
	}

	function useInitialBasketContent( basketContent ) {

		var self = this;

		$( basketContent).each( function(i, item) {
			cart.createItem(item, templateItem);
		});
		//TODO: switch to "Edit media tab"
		changeCurrentView( "edit" );
	}

	function onError(info) {
		// @todo will be implemented someday..
		alert(info.msg);
	}

	function onCartContentChange() {
		if(cart.isEmpty()) {
			$('.tabs li[data-tab=edit-media]').addClass('disabled');
			$('.MediaToolButtons button[name=continue]').attr('disabled','disabled');
		} else {
			$('.tabs li[data-tab=edit-media]').removeClass('disabled');
			$('.MediaToolButtons button[name=continue]').removeAttr('disabled');
		}
	}

	function onMediaLocationChange() {
		$('.media-tool-media-location img').removeClass('selected');
		$('.media-tool-media-location img[data-media-location="' + cart.getMediaLocation() + '"]').addClass('selected');
	}

	function onThumbnailStyleChange() {
		$('.media-tool-thumbnail-style img').removeClass('selected');
		if(cart.getThumbnailStyle()) {
			$('.media-tool-thumbnail-style img[data-thumb-style="border"]').addClass('selected');
			$('.media-tool-thumbnail-style .thumb-style-desc').html($.msg('mediatool-thumbnail-style-border'));
		} else {
			$('.media-tool-thumbnail-style img[data-thumb-style="no-border"]').addClass('selected');
			$('.media-tool-thumbnail-style .thumb-style-desc').html($.msg('mediatool-thumbnail-style-no-border'));
		}
		renderPreview();
	}

	function onMediaSizeChange() {
		if ($("input[name='mediasize']:checked", dialogWrapper).length==0) {
			// on first display select the proper radio
			if (cart.getMediaSize() == largeMediaSize) {
				$('#mediaToolLargeMedia').attr('checked',true);
			} else if (cart.getMediaSize() == smallMediaSize) {
				$('#mediaToolSmallMedia').attr('checked',true);
			} else {
				$('#mediaToolCustomMedia').attr('checked',true);
			}
		}
		if ($('#mediaToolCustomMedia').attr("checked")) {
			$('#mediaToolMediaSizeInput').prop('disabled', false);
			$('#mediaToolMediaSizeSlider').slider("enable");
		} else {
			$('#mediaToolMediaSizeInput').prop('disabled', true);
			$('#mediaToolMediaSizeSlider').slider("disable");
		}
		$('#mediaToolMediaSizeInput').val(cart.getMediaSize());	//?
		$('#mediaToolMediaSizeSlider').slider("value", cart.getMediaSize());

		if ( isVideoPlayerDisplayed == true ) {
			renderPreview();
		}
		renderer.updatePreview( {width:cart.getMediaSize()} );
	}

	function initMediaSizeActions() {
		$('#mediaToolMediaSizeSlider').slider({
			min: sliderMinMediaSize,
			max: sliderMaxMediaSize,
			//value: 500,
			step: 3,
			slide: function(event, ui) {
				cart.setMediaSize(ui.value);
			}
		});
		$('#mediaToolMediaSizeInput').on('blur', function() {
			var numberVal = $('#mediaToolMediaSizeInput').val().replace(/[^0-9]/g, '');
			var val = parseInt(numberVal, 10);
			if (isNaN(val)) {
				numberVal = val = cart.getMediaSize();
			}
			if (numberVal != $('#mediaToolMediaSizeInput').val()) $('#mediaToolMediaSizeInput').val(numberVal);
			if ((val >= minMediaSize) && (val <= maxMediaSize)) {
				cart.setMediaSize(val);
			} else {
				if (val < minMediaSize) cart.setMediaSize(minMediaSize);
				else cart.setMediaSize(maxMediaSize);
			}
		}).on('keyup', function() {
			var val = parseInt($('#mediaToolMediaSizeInput').val(), 10);
			if (!isNaN(val)) {
				if ((val >= minMediaSize) && (val <= maxMediaSize)) {
					cart.setMediaSize(val);
				}
			}
		});
		$('#mediaToolLargeMedia').on('click', function() {
			cart.setMediaSize(largeMediaSize);
		});
		$('#mediaToolSmallMedia').on('click', function() {
			cart.setMediaSize(smallMediaSize);
		});
		$('#mediaToolCustomMedia').on('click', function() {
			cart.setMediaSize(cart.getMediaSize());
		});

	}

	function onChangeTab() {

		if ( currentView == "edit" ) {
			renderPreview();
		}
	}

	function closeModal() {
		//TODO: check state and add confirm
		$(dialogWrapper).closeModal();
	}

	function canEnterEditTab() {
		return cart.isEmpty() ? false : true;
	}

	function finalizeDialog() {
		this.fire('editDone', cart);
		this.closeModal();
	}

	function renderPreview() {

		var container = $('.media-tool-preview', dialogWrapper);
		container.html('');
		$.each( cart.items, function(i, item){
			var it = $( item.renderPreview({
				itemTpl: itemPreviewTpl,
				borderTpl: itemPreviewBorderTpl,
				inputsTpl: itemPreviewInputsTpl,
				width: cart.getMediaSize(),
				useBorder: cart.getThumbnailStyle()
			}) );
			var elem = null;
			if ( it.find("a.image").length == 0 ) {
				elem = it;
			} else {
				elem = it.find("a.image");
			}
			container.append( it );
			elem.attr("data-item-nr", i);
			if ( item.remoteUrl != null ) {
				elem.attr("data-remote-url", item.remoteUrl);
			}
			cart.items[i].htmlObj = it;
		} );

		renderer.updatePreview( { width:cart.getMediaSize() });
		isVideoPlayerDisplayed = false;
	}

	function changeCurrentView(newView, fromTab) {

		var previousView = currentView;

		if (newView == "edit") {

			if (canEnterEditTab()) {

				currentView = "edit";
				if (!fromTab) {
					$("ul.tabs li[data-tab='edit-media'] a", dialogWrapper).trigger("click");
				}
				$("button[name='done']", dialogWrapper).show();
				$("button[name='continue']", dialogWrapper).hide();
			}
		}

		if (newView == "find") {

			currentView = "find";
			$("button[name='done']", dialogWrapper).hide();
			$("button[name='continue']", dialogWrapper).show();
		}

		if ( previousView != currentView ) {
		    mt.fire('changeTab');
		}
	}

	function onAddViaUrlClick() {
		var videoUrl = $('#mediatool-online-url').val();

		callBackend('getVideoMetadata', { videoUrl: videoUrl }, function(response) {
			if(response.status == 'ok') {
				cart.createItem(response, templateItem);
				$('#mediatool-online-url').val('');
			}
			else {
				mt.fire('error', response);
			}
		});
	}

	function appendUIActions() {
		var self = this;
		$("button[name='cancel']", dialogWrapper).on("click", function (e) {
			closeModal();
		});
		$("button[name='continue']", dialogWrapper).on("click", function (e) {
			changeCurrentView("edit");
		});
		$("button[name='done']", dialogWrapper).on("click", function (e) {
			self.finalizeDialog();
		});
		$("button[name='addviaurl']", dialogWrapper).on("click", function (e) {
			onAddViaUrlClick();
		});

		$("ul.tabs li[data-tab='edit-media'] a", dialogWrapper).on("click", function (e) {
			changeCurrentView("edit", true);
		});
		$("ul.tabs li[data-tab='find-media'] a", dialogWrapper).on("click", function (e) {
			changeCurrentView("find", true);
		});
		$(".media-tool-thumbnail-style img", dialogWrapper).on("click", function (e) {
			cart.setThumbnailStyle($(e.target).attr("data-thumb-style") == "border");
		});
		$(".media-tool-media-location img", dialogWrapper).on("click", function (e) {
			cart.setMediaLocation($(e.target).attr("data-media-location"));
		});

		$(".media-tool-preview", dialogWrapper).on("click", "a.video", function (e) {
			videoPreview.thumbnailClickAction($(e.target));
			isVideoPlayerDisplayed = true;
		});

		$(".media-tool-content").on("blur", "input.media-tool-item-caption", function (e) {
			var fieldName = $(e.target).attr("name");
			var cartItemId = fieldName.substr(0, fieldName.lastIndexOf("-"));
			var item = cart.getItem(cartItemId);
			if (item) item.caption = $(e.target).val();
		});

		initMediaSizeActions.call(self);
	}

	function callBackend(method, params, callback) {
		return $.nirvana.getJson(
			'MediaTool',
			method,
			params,
			callback
		);
	}

	/** @public **/
	var MediaToolClass = $.createClass(Observable, {

		constructor:function () {
			MediaToolClass.superclass.constructor.call(this);
			//this.debugEvents();
		},
		initModal: initModal,
		showModal: showModal,
		closeModal: closeModal,

		finalizeDialog: finalizeDialog,
		callBackend: callBackend,
		dialogWrapper: dialogWrapper,
		getCart: function () {
			return cart;
		},
		getItemsCollection: function () {
			return itemsCollection;
		},
		getRenderer: function() {
			return renderer;
		},
		getUserFollowSetting: function() {
			return watchCreations;
		}
	});

	return new MediaToolClass;
})();