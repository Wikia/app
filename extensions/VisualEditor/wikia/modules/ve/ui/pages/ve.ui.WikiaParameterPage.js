/*!
 * VisualEditor user interface WikiaParameterPage class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */
( function ( ve ) {

	/**
	 * Restores infobox dialog info when going back from media dialog
	 *
	 * @param {ve.ui.WindowManager} win
	 * @param {ve.dm.WikiaTransclusionModel} model - original tranclusion model of infobox dialog
	 * @param {string} imageName - image name from media dialog
	 * @param {string} paramName - Name of a field (e.g. image1)
	 */
	function restoreInfoboxDialog( win, model, imageName, paramName ) {
		win.transclusionModel = model;

		if ( imageName ) {
			win.transclusionModel.parts[0].params[paramName].setValue( imageName );
		}

		win.bookletLayout.$element.html( '' );
		win.initializeTemplateParameters();
	}

	/**
	 * shorthand function to open dialogs
	 *
	 * @param {string} name - Name of a dialog to open
	 */

	function openDialog( name ) {
		ve.ui.actionFactory
			.create( 'window', ve.init.target.getSurface() )
			.open( name );
	}
	/**
	 *
	 * @param {ve.ui} currentWindow
	 * @param {ve.dm.WikiaCart} cartItems
	 * @returns {string|null}
	 */
	function getImageName( currentWindow, cartItems ) {
		if (
			currentWindow.currentAction &&
			currentWindow.currentAction.getAction() === 'insertImageToPortableInfobox' &&
			cartItems.length > 0
		) {
			return cartItems[0].title;
		}

		return null;
	}
	/**
	 * In order to intercept default behaviour of wikiaMediaInsert
	 * additional action was added to the dialog
	 * goback - it does nothing, but allows us to get images chosen in the dialog
	 *
	 * @param {string} action action name (e.g. goback, apply)
	 */
	function setDefaultMediaInsertDialogAction( action ) {
		ve.ui.WikiaMediaInsertDialog.static.actions[0].action = action;
	}

	/**
	 * Event handler on image button
	 * Opens wikiaMediaInsert dialog and allows user to choose an image
	 * from wiki images
	 *
	 * @param {string} paramName Name of a field (e.g. image1)
	 */
	function handleClickOnImageButton( paramName ) {
		var windowManager = ve.init.target.getSurface().getDialogs(),
			transclusionModel = windowManager.currentWindow.transclusionModel,
			windowName = windowManager.currentWindow.constructor.static.name;

		windowManager.closeWindow( windowName ).done( function () {
			openDialog( 'wikiaMediaInsert' );
			setDefaultMediaInsertDialogAction( 'insertImageToPortableInfobox' );

			windowManager.once( 'closing', function ( currentWindow ) {
				var imageName;

				if ( currentWindow instanceof ve.ui.WikiaMediaInsertDialog ) {
					imageName = getImageName( currentWindow, currentWindow.cartModel.getItems() );

					windowManager.closing.done( function () {
						/**
						 * first 'opening' is an event fired when a dialog is opening
						 * in the callback to this event I get a windowManager in a state where
						 * windowManager.opening is actually a promise
						 * before that windowManager is null
						 */
						windowManager.once( 'opening', function ( win ) {
							windowManager.opening.done(
								restoreInfoboxDialog.bind( this, win, transclusionModel, imageName, paramName )
							);
						});

						setDefaultMediaInsertDialogAction( 'apply' );
						openDialog( windowName );
					});
				}
			});
		});
	}

	/**
	 * Wikia transclusion dialog template page.
	 *
	 * @class
	 * @extends ve.ui.MWParameterPage
	 *
	 * @constructor
	 * @param {ve.dm.MWParameterModel} parameter Template parameter
	 * @param {string} name Unique symbolic name of page
	 * @param {Object} [config] Configuration options
	 */
	ve.ui.WikiaParameterPage = function VeUiWikiaParameterPage( parameter, name, config ) {
		var paramName = parameter.getName(),
			paramType;

		// Parent constructor
		ve.ui.WikiaParameterPage.super.call( this, parameter, name, config );

		paramType = this.spec.params && this.spec.params[paramName] && this.spec.params[paramName].type;

		if ( paramType === 'image' ) {
			this.uploadImageButton = new OO.ui.ButtonWidget( {
				$: this.$,
				icon: 'add-image',
				flags: ['primary'],
				title: ve.msg( 'wikia-visualeditor-dialog-transclusion-add-image' )
			} );

			this.uploadImageButton.on( 'click', handleClickOnImageButton.bind( this, paramName ) );

			this.$field
				.addClass( 've-ui-imageField' )
				.append( this.uploadImageButton.$element );
		}

		// Properties
		this.templateGetInfoWidget = new ve.ui.WikiaTemplateGetInfoWidget( {
			template: parameter.getTemplate()
		} );

		// Initialization
		this.addButton.$element
			.addClass( 've-ui-mwParameterPage-addButton' )
			.after( this.templateGetInfoWidget.$element );
	};

	/* Inheritance */

	OO.inheritClass( ve.ui.WikiaParameterPage, ve.ui.MWParameterPage );
} )( ve );
