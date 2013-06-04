jQuery(function($)  {
	var searchFormsSelector = 'form.WikiaSearch'
		,searchPaginationLinksSelector = '.wikia-paginator a.paginator-page, .search-tabs a'
		,abGroupParameterName = 'ab';

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
		for( var i = 0; i < searchRelatedExperiments.length; i++ ) {
			if ( searchRelatedExperiments[i].group ) {
				groupIds.push( searchRelatedExperiments[i].group.id );
			}
		}
		return groupIds;
	}

	function addParameterToForms( params ) {
		for( var paramName in params ) {
			$(searchFormsSelector).append('<input type="hidden" name="' + paramName + '" value="' + params[paramName] + '">');
		}
	}

	function getQueryParameters() {
		var queryString = window.location.search;
		var parameters = {};

		queryString.replace(
			new RegExp( "([^?=&]+)(=([^&]*))?", "g" ),
			function( $0, $1, $2, $3 ){
				parameters[ $1 ] = $3;
			}
		);
		return parameters;
	};

	function getAbTestingParameters() {
		var parameters = {};
		var allParameters = getQueryParameters();
		for( var parameterName in allParameters ) {
			if( parameterName.indexOf('AbTest.') === 0 ) {
				parameters[parameterName] = allParameters[parameterName];
			}
		}
		return parameters;
	}

	function addParameterToLinks( params ) {
		$(searchPaginationLinksSelector).each(function() {
			var originalLink = $(this).attr('href'),
				modifiedLink = originalLink;
			for( var paramName in params ) {
				var modifiedLink = modifiedLink + '&' + paramName + '=' + params[paramName];
			}
			console.log('changing ' + originalLink  + ' to ' + modifiedLink);
			$(this).attr('href', modifiedLink);
		});
	}

	var groups = getSearchRelatedGroupIds();
	var parametersToEnforce = {};
	if( groups.length ) {
		parametersToEnforce[abGroupParameterName] = groups.join(',');
	}
	var abTestingParameters = getAbTestingParameters();
	for( var parameterName in abTestingParameters ) {
		parametersToEnforce[parameterName] = abTestingParameters[parameterName];
	}

	addParameterToForms( parametersToEnforce );
	addParameterToLinks( parametersToEnforce );
});

