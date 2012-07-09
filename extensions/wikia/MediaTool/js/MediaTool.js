var MediaTool = MediaTool || (function () {

	/** @private **/
	var cart = null;
	var itemsCollection = null;
	var renderer = null;
	var resourceLoaderCache = null;
	var dialogWrapper = null;
	var currentView = "find"; // [ find, edit ]

	/* templates */
	var templateDialog = null;
	var templateCart = null;
	var templateItemsList = null;
	var templateItem = null;

	function loadResources() {
		return resourceLoaderCache = resourceLoaderCache ||
			$.Deferred(function (dfd) {
				$.when(
					$.getResources([
						wgExtensionsPath + '/wikia/MediaTool/js/Cart.js',
						wgExtensionsPath + '/wikia/MediaTool/js/Item.js',
						wgExtensionsPath + '/wikia/MediaTool/js/Renderer.js',
						wgExtensionsPath + '/wikia/MediaTool/js/ItemsCollection.js'
					]),
					$.loadMustache(),
					$.loadJQueryUI(),
					callBackend('getTemplates', function (resp) {
						templateDialog = resp['dialog'];
						templateCart = resp['cart'];
						//templateItemsList = resp['itemsList'];
						templateItemsList = $("<div>").html(resp['itemsList']).find('#mediaToolBasketTemplate').text();
						templateItem = $("<div>").html(resp['itemsList']).find('#mediaToolBasketItemTemplate').text();
					})

				).done(dfd.resolve);
			}).promise();
	}
    var initModalComplete = false;

    function initModal() {
        if (!initModalComplete) {
            // loading resources, constructing dialog
            renderer = new MediaTool.Renderer();
            itemsCollection = new MediaTool.ItemsCollection('mediatool-thumbnail-browser', 'mediaToolItemList', 'mediaToolBasket');
            itemsCollection.template = templateItemsList;
						itemsCollection.itemTemplate = templateItem;
            cart = new MediaTool.Cart('mediaToolBasket', 'mediaToolItemList');
            cart.template = templateCart;
            this.bind('Cart::itemsChanged', onCartContentChange);
			this.bind('Cart::thumbnailStyleChanged', onThumbnailStyleChange);
			this.bind('Cart::thumbnailStyleChanged', onThumbnailSizeChange);

            this.bind('showModal', function() {trackMUT(WikiaTracker.ACTIONS.CLICK, 'open', wgCityId);});
            this.bind('editDone', function() {trackMUT(WikiaTracker.ACTIONS.CLICK, 'complete', wgCityId);});
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

	function showModal(event) {
		var self = this;
		loadResources().done(function () {
		self.initModal();
			var processedhtml = $.mustache(templateDialog, {
					'cart':templateCart,
					'itemslist':$.mustache(templateItemsList, {
						'title':'Media recently added to wiki',
						'items':itemsCollection.items
					})
				}
			);
			dialogWrapper = $.showModal('MUT', processedhtml, { width:970, className:"MediaToolModal" });

			appendUIActions.call(self);

			self.fire('showModal');

			changeCurrentView( "find" );
			//$('.WikiaSlider').slider();
			//$('.WikiaSlider').slider('value', 120);
			/*

			ustawic styl slidera:
			 #VideoEmbedSlider {
			 float: left;
			 margin-right: 20px;
			 width: 208px;
			 }

			 */
		});
	}

	function onCartContentChange() {
		if(cart.isEmpty()) {
			$('.tabs li[data-tab=edit-media]').addClass('disabled');
			$('.MediaTool-buttons button[name=continue]').attr('disabled','disabled');
		} else {
			$('.tabs li[data-tab=edit-media]').removeClass('disabled');
			$('.MediaTool-buttons button[name=continue]').removeAttr('disabled');
		}
	}

	function onThumbnailStyleChange() {
		$('.media-tool-thumbnail-style img').removeClass('selected');
		$('.media-tool-thumbnail-style img[data-thumb-style="' + cart.getThumbnailStyle() + '"]').addClass('selected');
		switch(cart.getThumbnailStyle())
		{
			case 'border':
				$('.media-tool-thumbnail-style .thumb-style-desc').html($.msg('mediatool-thumbnail-style-border'));
				break;
			case 'no-border':
				$('.media-tool-thumbnail-style .thumb-style-desc').html($.msg('mediatool-thumbnail-style-no-border'));
				break;
		}
	}

	function onThumbnailSizeChange() {
		// update the whole UI
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

	function changeCurrentView(newView, fromTab) {

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
	}

	function onAddViaUrlClick() {
		var videoUrl = $('#mediatool-online-url').val();

		callBackend('getVideoMetadata', { videoUrl: videoUrl }, function(response) {
			response.id = 'viaurl';
			cart.createItem(response, templateItem);
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
			cart.setThumbnailStyle($(e.target).attr("data-thumb-style"));
		});

		//@todo: init the slider, append all events to inputs...
		$('.WikiaSlider').slider({
			min: 60,
			max: 660,
			value: 500,
			step: 3,
			slide: function(event, ui) {
				console.log('WikiaSlider.slide ' + ui.value);
				//$('#VideoEmbedManualWidth').val(ui.value);
			},
			create: function(event, ui) {
				console.log('WikiaSlider.create');
				$('#VideoEmbedManualWidth').val(500);
			}
		});
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
		getCart: function () {
			return cart;
		},
		getItemsCollection: function () {
			return itemsCollection;
		},
		getRenderer: function() {
			return renderer;
		}
	});

	return new MediaToolClass;
})();