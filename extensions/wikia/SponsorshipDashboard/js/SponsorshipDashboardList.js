var SponsorshipDashboardList = {
	
	init: function() {

		$( 'a.delete' ).click( SponsorshipDashboardList.deleteElement );
	},

	deleteElement: function (){

		if( confirm( 'Are you sure you want to delete this element?' ) ) {
			var elementId	= $( this ).attr('data-id');
			var elementType = $( this ).attr('data-type');
			$( this ).parents( 'tr' ).remove();

			var data = {
				action: 'ajax',
				articleId: wgArticleId,
				method: 'axDelete',
				rs: 'SponsorshipDashboardAjax',
				elementId : elementId,
				elementType : elementType
			};

			$.get( wgScript, data );
		}
	}
};

//on content ready
wgAfterContentAndJS.push( SponsorshipDashboardList.init );