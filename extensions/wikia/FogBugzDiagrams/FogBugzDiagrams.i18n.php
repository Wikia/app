<?php
/**
 * FogBugzDiagrams - International file.
 * @author Pawe³ Rych³y
 * @author Piotr Paw³owski ( Pepe )	 
 */
	
	$messages = array();
	
	$messages['en'] = array(
	        'fog-bugz-diagrams-special-page' => 'FogBugz diagrams',
			'bugs-age' => 'Bugs Age',
            'accumulated-by-priority' => 'Accumulated bugs by current priority',
         	'created-by-priority' => 'Created bugs by current priority',
            'created-p1-p2-p3' => 'Created bugs with current priority P1, P2 and P3 (weekly)',
            'resolved-minus-created' => 'Resolved minus Created (diff)',
            'brief' => 'Gray area in linear diagram shows level of value from current week. 
            	In bars diagrams it shows state from current week.',           	
			'description-bugs-age' => 'Average bug age measures how much time it takes to resolve defect, on average.
				Bug age is measured as time difference between when defect was resolved and opened,
				in case of not resolved defects time difference between current date and opened date. ', 
			'description-accumulated-by-current-priority' => 'This chart measures number of defects in our backlog, broken down by current priority.
				Most interesting information from the chart is generic trend (sum of all bugs). ',
			'description-created-by-current-priority' => 'The numbers of defects that we find, per week. 
				This informations are broken down by priority.',
			'description-created-p1-p2-p3-by-current-priority' => 'The number of bugs with priority 1, 2, 3 which we find, per week.
				This informations are broken down by priority.',
			'description-difference-resolved-created' => 'Difference between resolved defects and new ones. 
				Green bar means that we have resolved more defects than we have found in particular week (and how many more). Red bar means the opposite, that we have found more defects than we have resolved. '
	);