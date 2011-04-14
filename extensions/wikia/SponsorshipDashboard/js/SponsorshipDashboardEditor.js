var SponsorshipDashboardEditor = {

	sourceCounter: 0,
	currentIndex: 0,
	sourceData: {},
	chartCount: 0,
	
	init: function() {

		$( '.sd-addNewGapi' ).click( function(){SponsorshipDashboardEditor.addSource( 'axGetGapiForm' )} );
		$( '.sd-addNewGapiCu' ).click( function(){SponsorshipDashboardEditor.addSource( 'axGetGapiCuForm' )} );
		$( '.sd-addWikiStats' ).click( function(){SponsorshipDashboardEditor.addSource( 'axGetStatsForm' )} );
		$( '.sd-addOneDot' ).click( function(){SponsorshipDashboardEditor.addSource( 'axGetOneDotForm' )} );
		$( '.sd-addMobile' ).click( function(){SponsorshipDashboardEditor.addSource( 'axGetMobileForm' )} );
		$( '.sd-save' ).click( function(){ SponsorshipDashboardEditor.gatherDataFromAllSources( true ) } );
		$( '.sd-preview' ).click( function(){ SponsorshipDashboardEditor.gatherDataFromAllSources( false ) } );


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

	gatherDataFromAllSources: function ( save ){
		SponsorshipDashboardEditor.sourceData = [],
		$( 'form.sd-form' ).each( function( index ){
			SponsorshipDashboardEditor.sourceData.push( $( this ).serialize() );
		});

		$().log( SponsorshipDashboardEditor.sourceData, 'test' );

		SponsorshipDashboardEditor.chartCount = SponsorshipDashboardEditor.chartCount + 1;

		$( '#debug' ).removeClass( 'small' );
		
		if( save == true ){
			$( '#debug' ).addClass( 'throbber' );
			$( '#debug' ).addClass( 'small' );
			var axMethod = 'axSaveReport';
		} else {
			$( '#debug' ).addClass( 'throbber' );
			var axMethod = 'axPreviewReport';
		}

		$( '#debug' ).show();
		$( '#debug' ).empty();
		$( '#debug' ).get(0).scrollIntoView();

		var data = {
			action: 'ajax',
			articleId: wgArticleId,
			method: axMethod,
			rs: 'SponsorshipDashboardAjax',
			chartCount : SponsorshipDashboardEditor.chartCount,
			formData: SponsorshipDashboardEditor.sourceData
		};
		$().log( data, 'test' );
		$.post( wgScript, data,
		function( axData ){
			if( save == true ){
				window.location.href = axData;
			} else {
				$( '#debug' ).html( axData );
			}
		});
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