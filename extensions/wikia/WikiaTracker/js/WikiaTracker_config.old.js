/*
 * AB tests config
 * 
 * Format: 'test_name': [ 'group1', 'group2' ]
 * 
 * Test_name should be "GoogleAnalytics friendly"
 * (Please try to stick to ASCII letters, numbers, and underscore)
 * 
 * Groups are A-B-C-D-E-F-G-H-I-J (defined in WikiaTracker.js file)
 * There are 10 of them; they are distinct; each represents 1% of Wikia users
 * 
 * Please remember to remove or comment out finished tests
 * Please consider adding a comment, eg. "Nef's test, ending Oct/31"
 * 
 * Please ask Nef if you have questions
 */

var WikiaTracker_ABtests = {
	//'test1':['C', 'D'], // ending 2011-10-31, nef
	//'test2':['A'] // ending 2011-10-31, nef
};

// PLEASE MAKE SURE LAST TEST LINE DOES NOT END WITH A COMMA!!!
