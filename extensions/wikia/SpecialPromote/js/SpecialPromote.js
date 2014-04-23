var SpecialPromote = function () {
	'use strict';

	this.headlineNode = null;
	this.descriptionNode = null;

	this.inputParams = {
		title: {
			minChars: 0,
			maxChars: 0
		},
		description: {
			minChars: 0,
			maxChars: 0
		}
	};

	this.original = {
		headline: null,
		description: null,
		mainImageName: null,
		additionalImagesNames: []
	};

	this.current = {
		headline: null,
		description: null,
		mainImageName: null,
		additionalImagesNames: []
	};

	this.uploadType = null;
	this.imageIndex = null;
	this.status = {
		title: false,
		description: false
	};

	this.ADDITIONAL_IMAGES_LIMIT = 9;
	this.UPLOAD_TYPE_MAIN = 'main';
	this.UPLOAD_TYPE_ADDITIONAL = 'additional';

	this.ERROR_REMOVE_TEMP_IMAGE = 'temp image removal failed';
	this.ERROR_UNKNOWN_UPLOAD_TYPE = 'unknown upload form';
	this.ERROR_GET_UPLOAD_FORM_ERROR = 'get upload form error';
	this.ERROR_FILE_UPLOADS_DISABLED = 'file uploads disabled';
	this.ERROR_UNKNOWN_ERROR = 'unknown error';
};

SpecialPromote.prototype = {
	init: function () {
		'use strict';

		this.disablePublish();
		this.headlineNode = $( 'input[name=title]' );
		this.descriptionNode = $( 'textarea[name=description]' );
		this.characterCounter = $( '.character-counter' );
		this.characterCounterHeadline = $( '.headline-character-counter' );

		this.current.headline = this.original.headline = this.headlineNode.val();
		this.current.description = this.original.description = this.descriptionNode.val();
		this.current.mainImageName = this.original.mainImageName = $( '.large-photo img#curMainImageName' )
			.data( 'filename' );

		$( '.small-photos img.additionalImage' ).each( $.proxy( function ( i, img ) {
			var fileName = $( img ).data( 'filename' );
			this.current.additionalImagesNames.push( fileName );
			this.original.additionalImagesNames.push( fileName );
		}, this ) );

		this.headlineNode.keyup( $.proxy( this.onKeyUp, this ) );
		this.descriptionNode.keyup( $.proxy( this.onKeyUp, this ) );
		$( '.upload-button' ).click( $.proxy( this.onAddPhotoBtnClick, this ) );
		$( '.UploadTool' )
			.submit( $.proxy( this.onUploadFormSubmit, this ) )
			.on(
				'hover',
				'.large-photo, .small-photos-wrapper',
				$.proxy( this.modifyRemoveHandler, this )
			)
			.on( 'click', '.modify-remove .modify', $.proxy( this.onChangePhotoClick, this ) )
			.on( 'click', '.modify-remove .remove', $.proxy( this.onDeletePhotoClick, this ) );
		$( '.WikiaArticle' ).addClass( 'SpecialPromoteArticle' );

		this.initInput( this.headlineNode );
		this.initInput( this.descriptionNode );
		this.checkPublishButton();
		$().log( 'SpecialPromote.init finished' );
	},
	initInput: function ( targetObject ) {
		'use strict';

		var fieldName = targetObject.attr( 'name' );
		this.initInputParams( targetObject, fieldName );
		this.initValidate( targetObject, fieldName );
	},
	initValidate: function ( targetObject, fieldName ) {
		'use strict';

		var characterCount = targetObject.val().length;

		if (
			typeof this.inputParams[fieldName].minChars !== 'undefined' &&
				typeof this.inputParams[fieldName].maxChars !== 'undefined'
			) {
			this.inputParams[fieldName].minChars = parseInt( this.inputParams[fieldName].minChars, 10 );
			this.inputParams[fieldName].maxChars = parseInt( this.inputParams[fieldName].maxChars, 10 );

			if ( this.inputParams[fieldName].minChars > characterCount ) {
				if ( characterCount ) {
					this.addTooLittleCharsError( targetObject, characterCount, this.inputParams[fieldName].minChars );
				}
				this.status[fieldName] = false;
			}
			else if ( this.inputParams[fieldName].maxChars < characterCount ) {
				if ( characterCount ) {
					this.addTooManyCharsError( targetObject, characterCount, this.inputParams[fieldName].maxChars );
				}
				this.status[fieldName] = false;
			} else {
				this.status[fieldName] = true;
			}
		}
	},
	initInputParams: function ( targetObject, fieldName ) {
		'use strict';

		this.inputParams[fieldName].minChars = targetObject.data( 'min' );
		this.inputParams[fieldName].maxChars = targetObject.data( 'max' );
	},
	onKeyUp: function ( event ) {
		'use strict';

		var targetObject = $( event.target ),
			fieldName = targetObject.attr( 'name' ),
			characterCount = targetObject.val().length;

		if ( this.inputParams[fieldName].minChars > characterCount ) {
			this.addTooLittleCharsError( targetObject, characterCount, this.inputParams[fieldName].minChars );
			this.status[fieldName] = false;
		} else if ( this.inputParams[fieldName].maxChars < characterCount ) {
			this.addTooManyCharsError( targetObject, characterCount, this.inputParams[fieldName].maxChars );
			this.status[fieldName] = false;
		} else {
			targetObject.closest( 'div' ).parent().removeClass( 'error' );
			targetObject.closest( 'div' ).parent().find( '.error' ).text( '' );
			this.status[fieldName] = true;
		}

		if ( fieldName === 'description' ) {
			this.characterCounter.text( characterCount );
		}
		else if ( fieldName === 'title' ) {
			this.characterCounterHeadline.text( characterCount );
		}

		this.current.headline = this.headlineNode.val();
		this.current.description = this.descriptionNode.val();

		this.checkPublishButton();
	},
	addTooLittleCharsError: function ( targetObject, characterCount, minChars ) {
		'use strict';

		targetObject.closest( 'div' ).parent().addClass( 'error' );
		targetObject.closest( 'div' ).parent().find( '.error' ).text(
			$.msg( 'promote-error-less-characters-than-minimum', characterCount, minChars )
		);
	},
	addTooManyCharsError: function ( targetObject, characterCount, maxChars ) {
		'use strict';

		targetObject.closest( 'div' ).parent().addClass( 'error' );
		targetObject.closest( 'div' ).parent().find( '.error' ).text(
			$.msg( 'promote-error-more-characters-than-maximum', characterCount, maxChars )
		);
	},
	checkPublishButton: function () {
		'use strict';

		if ( this.validateData() ) {
			this.enablePublish();
		} else {
			this.disablePublish();
		}
	},
	getUploadForm: function ( data ) {
		'use strict';

		if ( !data.uploadType ) {
			throw this.ERROR_GET_UPLOAD_FORM_ERROR;
		}
		$.nirvana.sendRequest( {
			type: 'get',
			format: 'json',
			controller: 'SpecialPromote',
			method: 'getUploadForm',
			data: data,
			callback: $.proxy( this.showImageModal, this )
		} );
		return true;
	},
	showErrorModal: function ( errorMessage, onCloseCallback ) {
		'use strict';

		var modalConfig = {
			type: 'default',
			vars: {
				id: 'specialPromoteErrorModal',
				size: 'small',
				content: errorMessage,
				closeButton: true,
				buttons: [
					{
						vars: {
							value: $.msg( 'ok' ),
							data: [
								{
									key: 'event',
									value: 'close'
								}
							]
						}
					}
				]
			}
		};

		require( [ 'wikia.ui.factory' ], function ( uiFactory ) {
			uiFactory.init( 'modal' ).then( function ( uiModal ) {
				uiModal.createComponent( modalConfig, function ( errorModal ) {
					if ( typeof onCloseCallback === 'function' ) {
						errorModal.bind( 'beforeClose', onCloseCallback );
					}
					errorModal.show();
				} );
			} );
		} );

	},
	showImageModal: function ( response ) {
		'use strict';

		if ( ( typeof response.errorMessage !== 'undefined' ) && response.errorMessage.length ) {
			this.showErrorModal( response.errorMessage );
		} else {

			var modalConfig = {
					type: 'default',
					vars: {
						id: 'specialPromoteModal',
						size: 'medium',
						content: response.html,
						title: response.title,
						closeButton: true,
						buttons: [
							{
								vars: {
									value: response.labelSubmit,
									classes: [ 'normal', 'primary' ],
									data: [
										{
											key: 'event',
											value: 'submit'
										}
									]
								}
							},
							{
								vars: {
									value: response.labelCancel,
									data: [
										{
											key: 'event',
											value: 'close'
										}
									]
								}
							}
						]
					}
				},
				that = this;

			require( [ 'wikia.ui.factory' ], function ( uiFactory ) {
				uiFactory.init( 'modal' ).then( function ( uiModal ) {
					uiModal.createComponent( modalConfig, function ( loginModal ) {
						SpecialPromote.$modal = loginModal;

						loginModal.bind( 'submit', $.proxy( that.saveAvatarAIM, that ) );
						loginModal.show();
					} );
				} );
			} );
		}
	},
	onAddPhotoBtnClick: function ( e ) {
		'use strict';

		e.preventDefault();
		var addPhotoBtn = $( e.currentTarget ),
			uploadType = addPhotoBtn.data( 'image-type' ),
			errorContainer = addPhotoBtn.parent().find( '.error' );

		if (
			uploadType === this.UPLOAD_TYPE_ADDITIONAL &&
				this.current.additionalImagesNames.length >= this.ADDITIONAL_IMAGES_LIMIT
			) {
			addPhotoBtn.parent().addClass( 'error' );
			errorContainer.text( $.msg( 'promote-error-too-many-images' ) );
			return;
		}
		errorContainer.html( '' );
		addPhotoBtn.parent().removeClass( 'error' );

		try {
			this.getUploadForm( {
				uploadType: uploadType,
				lang: window.wgUserLanguage
			} );
		} catch ( error ) {
			this.errorHandler();
		}
	},
	onChangePhotoClick: function ( e ) {
		'use strict';

		e.preventDefault();
		var parentNode = $( e.target ).parent().parent(),
			target = parentNode.find( 'img#curMainImageName' );

		if ( $.isEmptyObject( target[0] ) ) {
			target = parentNode.find( 'img.additionalImage' );
		}

		try {
			this.getUploadForm( {
				uploadType: target.data( 'image-type' ),
				imageIndex: target.data( 'image-index' ),
				lang: window.wgUserLanguage
			} );
		} catch ( error ) {
			this.errorHandler( error );
			return false;
		}
		return true;
	},
	onDeletePhotoClick: function ( e ) {
		'use strict';

		e.preventDefault();

		var target = $( e.target ).parent().parent().find( 'img.additionalImage' );
		try {
			this.removeImage( {
				uploadType: target.data( 'image-type' ),
				imageIndex: target.data( 'image-index' )
			} );
		} catch ( error ) {
			this.errorHandler( error );
		}
	},
	removeImage: function ( params ) {
		'use strict';

		if ( params.uploadType === 'additional' ) {
			var selectedByName = '',
				removalPromise;

			$.each( $( '.small-photos img.additionalImage' ), function ( i, element ) {
				var elementObject = $( element );
				if ( elementObject.data( 'image-index' ) === params.imageIndex ) {
					selectedByName = elementObject.data( 'filename' );
				}
			} );

			removalPromise = this.removeTempImage( selectedByName );

			removalPromise.done( $.proxy( function ( success ) {
				if ( success ) {
					var imagesNamesIndex = this.current.additionalImagesNames.indexOf( selectedByName );
					this.current.additionalImagesNames.splice( imagesNamesIndex, 1 );

					$.each( $( '.small-photos img.additionalImage' ), function ( i, domElement ) {
						var domElementObject = $( domElement );
						if ( domElementObject.data( 'image-index' ) === params.imageIndex ) {
							domElementObject.parent().remove();
						}
					} );
				} else {
					this.errorHandler( this.ERROR_FILE_UPLOADS_DISABLED );
				}
			}, this ) );

			removalPromise.fail( $.proxy( function () {
				this.errorHandler( this.ERROR_FILE_UPLOADS_DISABLED );
			}, this ) );

		} else {
			throw this.ERROR_UNKNOWN_UPLOAD_TYPE;
		}
		this.checkPublishButton();
		return true;
	},
	saveAvatarAIM: function () {
		'use strict';

		var form = $( '#ImageUploadForm' ),
			submitBtn = SpecialPromote.$modal.$element.find( '[data-event=submit]' ),
			that = this;

		$.AIM.submit( form, {
			onStart: $.proxy( function () {
				submitBtn.attr( 'disabled', 'disabled' );
			}, this ),
			onComplete: $.proxy( function ( response ) {
				var errorContainer = $( '#specialPromoteModal .error' ),
					unknownErrorMsg = $.msg( 'promote-error-upload-unknown-error' );

				try {
					response = JSON.parse( response );

					if ( typeof response.fileName !== 'undefined' && typeof response.fileUrl !== 'undefined' ) {
						that.setTempFile( response );
						SpecialPromote.$modal.trigger( 'close' );
					} else {
						if ( typeof response.errorMessages[0] === 'undefined' ) {
							errorContainer.text( unknownErrorMsg );
						} else {
							errorContainer.text( response.errorMessages.join( '\n' ) );
						}
					}
				} catch ( e ) {
					errorContainer.text( unknownErrorMsg );
					$().log( e );
				}
				$( submitBtn ).removeAttr( 'disabled' );
			}, this )
		} );

		form.submit();
	},
	setTempFile: function ( file ) {
		'use strict';

		switch ( file.uploadType ) {
			case this.UPLOAD_TYPE_MAIN:
				this.setMainImage( file );
				break;
			case this.UPLOAD_TYPE_ADDITIONAL:
				this.addAdditionalImage( file );
				break;
			default:
				$().log( 'ERROR: no correct upload type found' );
				break;
		}
	},
	setMainImage: function ( file ) {
		'use strict';

		this.current.mainImageName = file.fileName;

		var mainImgDiv = $( '.large-photo' ),
			imageNode = mainImgDiv.find( 'img#curMainImageName' ).get( 0 ),
			image;

		if ( typeof imageNode !== 'undefined' ) {
			$( imageNode )
				.attr( 'src', file.fileUrl )
				.data( 'filename', file.fileName )
				.data( 'image-type', 'main' );
		} else {
			image = new Image();
			mainImgDiv.append(
				$( image )
					.attr( 'src', file.fileUrl )
					.attr( 'id', 'curMainImageName' )
					.data( 'filename', file.fileName )
					.data( 'image-type', 'main' )
			);
		}
		$( '.large-photo .status div' ).addClass( 'hidden' );
		this.checkPublishButton();
	},
	addAdditionalImage: function ( file ) {
		'use strict';

		var image,
			imagesContainer,
			smallPhotosWrapper,
			modifyRemoveNode;

		if ( file.imageIndex ) {
			this.current.additionalImagesNames[file.imageIndex] = file.fileName;
			$( '.small-photos img' ).each( function ( key, value ) {
				var valueObject = $( value );

				if ( parseInt( file.imageIndex, 10 ) === parseInt( valueObject.data( 'image-index' ), 10 ) ) {
					image = valueObject;
				}
			} );
			if ( image ) {
				image.attr( 'src', file.fileUrl );
				image.data( 'filename', file.fileName );
				image.parent().find( '.status' ).remove();
			} else {
				throw this.ERROR_UNKNOWN_ERROR;
			}
		} else {
			this.current.additionalImagesNames.push( file.fileName );

			imagesContainer = $( '.small-photos' );
			image = new Image();
			smallPhotosWrapper = $( '<div class="small-photos-wrapper"></div>' );
			modifyRemoveNode = $( '<div class="modify-remove"><a class="modify" href="#">' +
				$.msg( 'promote-modify-photo' ) +
				'</a> <a class="remove" href="#">' +
				$.msg( 'promote-remove-photo' ) + '</a></div>' );

			smallPhotosWrapper
				.append( modifyRemoveNode )
				.append(
					$( image )
						.attr( 'src', file.fileUrl )
						.attr( 'class', 'additionalImage' )
						.data( 'filename', file.fileName )
						.data( 'image-type', this.UPLOAD_TYPE_ADDITIONAL )
						.data( 'image-index', this.current.additionalImagesNames.length )
				);
			imagesContainer.append( smallPhotosWrapper );
		}

		this.checkPublishButton();
	},
	validateData: function () {
		'use strict';

		var result = {valid: true};

		$.each( this.status, $.proxy( function ( key, value ) {
			if ( value === false ) {
				this.valid = false;
			}
		}, result ) );

		return result.valid;
	},
	disablePublish: function () {
		'use strict';

		$( '.button' ).attr( 'disabled', 'disabled' );
	},
	enablePublish: function () {
		'use strict';

		$( '.button' ).removeAttr( 'disabled' );
	},
	onUploadFormSubmit: function ( e ) {
		'use strict';

		var uploadTool = $( '.UploadTool' ),
			doSave = false;

		e.preventDefault();
		uploadTool.startThrobbing();
		if ( !this.validateData() ) {
			uploadTool.stopThrobbing();
			return false;
		}

		$.each( this.current, $.proxy( function ( key ) {
			if ( this.current[key] !== this.original[key] ) {
				doSave = true;
			}
		}, this ) );

		if ( doSave ) {
			this.saveWikiPromoData( this.current );
		}
	},
	saveWikiPromoData: function ( data ) {
		'use strict';

		$.nirvana.sendRequest( {
			type: 'post',
			format: 'json',
			controller: 'SpecialPromote',
			method: 'saveData',
			data: data,
			callback: $.proxy( function ( response ) {
				if ( response.success ) {
					Wikia.Querystring()
						.addCb()
						.goTo();
				} else {
					this.errorHandler( this.ERROR_FILE_UPLOADS_DISABLED );
				}
			}, this ),
			onErrorCallback: $.proxy( function () {
				this.errorHandler();
			}, this )
		} );
	},
	removeTempImage: function ( imagename ) {
		'use strict';

		var result = {
				removed: true
			},
			handlerFunction = $.proxy( function () {
				return result.removed;
			}, result );


		if ( !imagename ) {
			throw this.ERROR_REMOVE_TEMP_IMAGE;
		}


		return $.nirvana.sendRequest( {
			type: 'post',
			format: 'json',
			controller: 'SpecialPromote',
			method: 'removeTempImage',
			data: {
				fileName: imagename
			},
			onErrorCallback: $.proxy( function () {
				this.removed = false;
			}, result )
		} ).then( handlerFunction, handlerFunction );
	},
	modifyRemoveHandler: function ( e ) {
		'use strict';

		var targetObject = $( e.currentTarget );
		if ( targetObject.find( 'img' ).length > 0 ) {
			targetObject.find( '.modify-remove' ).toggleClass( 'show' );
		}
	},
	errorHandler: function ( error ) {
		'use strict';

		var msg;

		switch ( error ) {
			case this.ERROR_REMOVE_TEMP_IMAGE:
				msg = 'promote-error-upload-unknown-error';
				break;
			case this.ERROR_UNKNOWN_UPLOAD_TYPE:
				msg = 'promote-error-upload-type';
				break;
			case this.ERROR_GET_UPLOAD_FORM_ERROR:
				msg = 'promote-error-upload-form';
				break;
			case this.ERROR_FILE_UPLOADS_DISABLED:
				msg = 'promote-upload-image-uploads-disabled';
				break;
			default:
				msg = 'promote-error-upload-unknown-error';
		}

		$.getMessages( 'SpecialPromote', $.proxy( function () {
			this.showErrorModal( $.msg( msg ), function () {
				$( '.UploadTool' ).stopThrobbing();
			} );
		}, this ) );
	}
};

$( function () {
	'use strict';

	$.loadJQueryAIM().done( function () {
		var SpecialPromoteInstance = new SpecialPromote();
		SpecialPromoteInstance.init();
	} );
} );
