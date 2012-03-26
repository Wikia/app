var SponsorshipDashboardEditor = {

	sourceCounter: 0,
	currentIndex: 0,
	sourceData: {},
	chartCount: 0,
	intId: null,
	lockDisplay: false,
	isError: false,
	
	init: function() {

		$( '.sd-addNewGapi' ).click( function(){SponsorshipDashboardEditor.addSource( 'axGetGapiForm' );} );
		$( '.sd-addNewGapiCu' ).click( function(){SponsorshipDashboardEditor.addSource( 'axGetGapiCuForm' );} );
		$( '.sd-addWikiStats' ).click( function(){SponsorshipDashboardEditor.addSource( 'axGetStatsForm' );} );
		$( '.sd-addOneDot' ).click( function(){SponsorshipDashboardEditor.addSource( 'axGetOneDotForm' );} );
		$( '.sd-addMobile' ).click( function(){SponsorshipDashboardEditor.addSource( 'axGetMobileForm' );} );
		$( '.sd-save' ).click( function(){ SponsorshipDashboardEditor.generateSave( false ); } );
		$( '.sd-save-as-new' ).click( function(){ SponsorshipDashboardEditor.generateSave( true ); } );
		$( '.sd-preview' ).click( function(){ SponsorshipDashboardEditor.generatePreview(); } );


		$( '#sd-source' ).click( function(e){
			if ( $( e.target ).hasClass( 'sd-source-remove' ) ){
				$( e.target ).parent( 'form.sd-sub-form' ).remove();
			}
			SponsorshipDashboardEditor.updatePlaceholder();
			SponsorshipDashboardEditor.redrawSourceNumbers();
		});

		$( '#sd-source' ).delegate( 'a[data-action="bringDefault"]', 'click', SponsorshipDashboardEditor.bringDefault );
		$( '#sd-source' ).delegate( 'input.validate-list', 'change', SponsorshipDashboardEditor.validatorList );
		$( '#sd-source' ).delegate( 'input.validate-number', 'change', SponsorshipDashboardEditor.validatorNumber );
		$( '#sd-form-main' ).delegate( 'input.validate-list', 'change', SponsorshipDashboardEditor.validatorList );
		$( '#sd-form-main' ).delegate( 'input.validate-number', 'change', SponsorshipDashboardEditor.validatorNumber );
		
		SponsorshipDashboardEditor.updatePlaceholder();
		SponsorshipDashboardEditor.redrawSourceNumbers();
	},

	updatePlaceholder: function(){

		if ( $('#sd-source').find('form.sd-sub-form').length > 0 ){
			$('#sd-placeholder').hide();
		} else {
			$('#sd-placeholder').show();
		}
	},

	addSource: function( axMethod ){

		var data = {
			action: 'ajax',
			articleId: wgArticleId,
			method: axMethod,
			rs: 'SponsorshipDashboardAjax'
		};
		$.get(wgScript, data,
		function(axData){
			$('#sd-source').append( axData );
			SponsorshipDashboardEditor.updatePlaceholder();
			SponsorshipDashboardEditor.redrawSourceNumbers();
		});
	},

	redrawSourceNumbers: function (){

		SponsorshipDashboardEditor.sourceCounter = 0;
		$( 'form.sd-sub-form' ).each( function(){
				SponsorshipDashboardEditor.redrawNumber( $(this).find( '.sd-source-title b' ) );
			}
		);
	},
	
	redrawNumber: function ( obj ){
		$( obj ).html( '#' + SponsorshipDashboardEditor.sourceCounter );
		SponsorshipDashboardEditor.sourceCounter = SponsorshipDashboardEditor.sourceCounter + 1;
	},

	generateSave: function ( asNew ){

		SponsorshipDashboardEditor.sourceData = [];
		$( 'form.sd-form' ).each( function( index ){
			SponsorshipDashboardEditor.sourceData.push( $( this ).serialize() );
		});

		SponsorshipDashboardEditor.chartCount = SponsorshipDashboardEditor.chartCount + 1;
		$( '#debug' ).addClass( 'throbber' );
		$( '#debug' ).addClass( 'small' );
		$( '#debug' ).show();
		$( '#debug' ).empty();
		$( '#debug' ).get(0).scrollIntoView();
		$( '#progress').hide();

		$.post(
			wgScript,
			{
				action: 'ajax',
				articleId: wgArticleId,
				method: 'axSaveReport',
				rs: 'SponsorshipDashboardAjax',
				chartCount : SponsorshipDashboardEditor.chartCount,
				formData: SponsorshipDashboardEditor.sourceData,
				asNew: asNew
			},
			function( axData ){
				window.location.href = axData;
			}
		);
	},

	generatePreview: function (){

		if ( SponsorshipDashboardEditor.intId != null ){
			clearInterval( SponsorshipDashboardEditor.intId );
		}
		SponsorshipDashboardEditor.sourceData = [];
		$( 'form.sd-form' ).each( function( index ){
			SponsorshipDashboardEditor.sourceData.push( $( this ).serialize() );
		});

		SponsorshipDashboardEditor.chartCount = SponsorshipDashboardEditor.chartCount + 1;

		$( '#debug' ).addClass( 'small' );
		$( '#debug' ).hide();
		$( '#debug' ).empty();
		$( '#progress').show();
		$( '#progress progress').attr( 'value', 0 );
		$( '#progressValue').html( 0 );
		$( '#progress' ).get(0).scrollIntoView();
		
		var objData = {
			action: 'ajax',
			articleId: wgArticleId,
			method: 'axPreviewReport',
			rs: 'SponsorshipDashboardAjax',
			chartCount : SponsorshipDashboardEditor.chartCount,
			formData: SponsorshipDashboardEditor.sourceData
		}

		SponsorshipDashboardEditor.isError = false;

		$.ajax({
			url: wgScript,
			data: objData,
			type: 'POST',
			success: function( axData ){
				SponsorshipDashboardEditor.displayChart( axData );
			},
			error: function(){
				SponsorshipDashboardEditor.isError = true;
			}
		});
		
		SponsorshipDashboardEditor.lockDisplay = false;
		SponsorshipDashboardEditor.intId = setInterval( progress, 5000 );

		function progress(){
			$.post(
				wgScript,
				{
					action: 'ajax',
					articleId: wgArticleId,
					method: 'axReportProgress',
					rs: 'SponsorshipDashboardAjax',
					chartCount : SponsorshipDashboardEditor.chartCount,
					formData: SponsorshipDashboardEditor.sourceData
				},
				function( axProgressData ){
					if ( SponsorshipDashboardEditor.lockDisplay == false ){
						$( '#progress progress').attr( 'value', axProgressData );
						$( '#progressValue').html( axProgressData );
						if ( axProgressData == 100 && SponsorshipDashboardEditor.isError == true ) {
							$.ajax({
								url: wgScript,
								data: objData,
								type: 'POST',
								success: function( axData ){
									SponsorshipDashboardEditor.displayChart( axData );
								},
								error: function(){
									SponsorshipDashboardEditor.displayErrorMsg();
								}
							});
						}
					}
				}
			);
		}
	},

	displayChart: function ( chartHtml ){
		$( '#progress progress').attr( 'value', 100 );
		$( '#progressValue').html( 100 );
		
		SponsorshipDashboardEditor.lockDisplay = true;
		if ( SponsorshipDashboardEditor.intId != null ){
			clearInterval( SponsorshipDashboardEditor.intId );
		}
		$( '#debug' ).show();
		$( '#debug' ).get(0).scrollIntoView();
		$( '#debug' ).removeClass( 'small' );
		$( '#debug' ).html( chartHtml );
		$( '#progress').hide();
	},

	displayErrorMsg: function (){
		alert( 'error' );
	},
	
	validatorNumber: function (){
		this.value = $.trim(this.value);
		var minimalValue = 0;
		if ( $( this ).hasClass( 'min1' ) ){
			minimalValue = 1;
		}

		if ( !Number( this.value ) || ( this.value < minimalValue ) ){
			if ( this.value.toLowerCase() == 'current' ) {
				this.value = 'current'
			} else {
				this.value = minimalValue;
			}
		} else {
			this.value = Math.floor( this.value );
		}
	},

	validatorList: function (){
		var listItems = $.trim( this.value ).split( ',' );
		var finalList = [];
		for( var i in listItems ){
			if ( !Number( listItems[i] ) || ( listItems[i] < 0 ) ){
				if ( listItems[i].toLowerCase() == 'current' ) {
					finalList.push( 'current' );
				}
			} else {
				finalList.push( Math.floor( listItems[i] ) );
			}
		}
		this.value = finalList.join(',')
	},

	bringDefault: function (){
		
		var tmp = $(this).attr('data-target');
		$( 'input[name="' + tmp + '"]' ).val( 
			$( 'input[name="' + tmp + '"]' ).attr('data-default')
		);
	}
};

//on content ready
wgAfterContentAndJS.push( SponsorshipDashboardEditor.init );