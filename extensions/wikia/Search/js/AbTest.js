jQuery(function($)  {
	var searchFormsSelector = 'form.WikiaSearch'
		,searchPaginationLinksSelector = '.Search .wikia-paginator a.paginator-page'
		,parameterName = 'ab';

	function findSearchRelatedExperiments() {
		var experiments = Wikia.AbTest.getExperiments();
		var searchExperiments = [];
		for( var i = 0; i < experiments.length; i++ ) {
			if( experiments[i].name.toUpperCase().indexOf('SEARCH') === 0 ) {
				// all experiments with name starting with search are considered search related
				searchExperiments.push(experiments[i]);
			}
		}
		return experiments;
	}

	function getSearchRelatedGroupIds() {
		var searchRelatedExperiments = findSearchRelatedExperiments();
		var groupIds = [];
		for( var i = 0; i < experiments.length; i++ ) {
			if ( searchRelatedExperiments[i].group ) {
				groupIds.push( searchRelatedExperiments[i].group.id );
			}
		}
		return groupIds;
	}

	function addParameterToForms( groupIds ) {
		$(searchFormsSelector).append('<input type="hidden" name="' + parameterName + '" value="' + groupIds.join(',') + '">');
	}

	function addParamterToLinks(groupIds) {
		$(searchPaginationLinksSelector).each(function() {
			$(this).attr('href', $(this).attr('href') + '&' + parameterName + '=' + groupIds.join(','));
		});
	}

	var groups = getSearchRelatedGroupIds();
	addParameterToForms( groups );
	addParamterToLinks( groups );
});

