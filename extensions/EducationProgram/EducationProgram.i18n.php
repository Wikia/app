<?php

/**
 * Internationalization file for the Education Program extension.
 *
 * @since 0.1
 *
 * @file EducationProgram.i18n.php
 * @ingroup EducationProgram
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

$messages = array();

/** English
 * @author Jeroen De Dauw
 */
$messages['en'] = array(
	'educationprogram-desc' => 'Allows for running education courses in which students can enroll.',

	// Misc
	'ep-item-summary' => 'Summary',
	'ep-toplink' => 'My courses',

	// Tabs
	'ep-tab-view' => 'Read',
	'ep-tab-edit' => 'Edit',
	'ep-tab-create' => 'Create',
	'ep-tab-history' => 'View history',
	'ep-tab-enroll' => 'Enroll',

	// Tooltips
	'tooltip-ep-form-save' => 'Save',
	'tooltip-ep-edit-institution' => 'Edit this institution',
	'tooltip-ep-edit-course' => 'Edit this course',

	// Access keys
	'accesskey-ep-form-save' => 's', # do not translate or duplicate this message to other languages
	'accesskey-ep-edit-institution' => 'e', # do not translate or duplicate this message to other languages
	'accesskey-ep-edit-course' => 'e', # do not translate or duplicate this message to other languages

	// Navigation links
	'ep-nav-orgs' => 'Institution list',
	'ep-nav-courses' => 'Courses list',
	'ep-nav-mycourses' => 'My courses',
	'ep-nav-students' => 'Student list',
	'ep-nav-mentors' => 'Ambassador list',
	'ep-nav-cas' => 'Campus Ambassadors',
	'ep-nav-oas' => 'Online Ambassadors',
	'ep-nav-oaprofile' => 'Online Ambassador profile',
	'ep-nav-caprofile' => 'Campus Ambassador profile',

	// Logging
	'log-name-institution' => 'Education Program institution log',
	'log-name-course' => 'Education Program course log',
	'log-name-student' => 'Education Program student log',
	'log-name-online' => 'Education Program Online Ambassador log',
	'log-name-campus' => 'Education Program Campus Ambassador log',
	'log-name-instructor' => 'Education Program instructor log',

	'log-header-institution' => 'These events track the changes that are made to Education Program institutions.',
	'log-header-course' => 'These events track the changes that are made to Education Program courses.',
	'log-header-instructor' => 'These events track the changes that are made to Education Program instructors.',
	'log-header-campus' => 'These events track the changes that are made to Education Program Campus Ambassadors.',
	'log-header-online' => 'These events track the changes that are made to Education Program Online Ambassadors.',
	'log-header-student' => 'These events track the changes that are made to Education Program students.',

	'log-description-institution' => 'Log of all changes to [[Special:Institutions|institutions]].',
	'log-description-course' => 'Log of all changes to [[Special:Courses|courses]].',
	'log-description-instructor' => 'Log of all changes to instructors.',
	'log-description-online' => 'Log of all changes to Education Program [[Special:OnlineAmbassadors|Online Ambassadors]]',
	'log-description-campus' => 'Log of all changes to Education Program [[Special:CampusAmbassadors|Campus Ambassadors]]',
	'log-description-student' => 'Log of all changes to [[Special:Students|students]].',

	'logentry-institution-add' => '$1 created institution $3',
	'logentry-institution-remove' => '$1 removed institution $3',
	'logentry-institution-update' => '$1 updated institution $3',

	'logentry-course-add' => '$1 created course $3',
	'logentry-course-remove' => '$1 removed course $3',
	'logentry-course-update' => '$1 updated course $3',

	'logentry-instructor-add' => '$1 {{GENDER:$2|added}} {{PLURAL:$4|instructor|instructors}} $5 to course $3',
	'logentry-instructor-remove' => '$1 {{GENDER:$2|removed}} {{PLURAL:$4|instructor|instructors}} $5 from course $3',
	'logentry-instructor-selfadd' => '$1 added {{GENDER:$2|added himself|herself}} as {{GENDER:$2|instructor}} to course $3',
	'logentry-instructor-selfremove' => '$1 removed {{GENDER:$2|removed himself|herself}} as {{GENDER:$2|instructor}} from course $3',

	'logentry-online-add' => '$1 added {{PLURAL:$4|Online Ambassador|Online Ambassadors}} $5 to course $3',
	'logentry-online-remove' => '$1 removed {{PLURAL:$4|Online Ambassador|Online Ambassadors}} $5 from course $3',
	'logentry-online-selfadd' => '$1 added {{GENDER:$2|himself|herself}} as {{GENDER:$2|Online Ambassador}} to course $3',
	'logentry-online-selfremove' => '$1 removed {{GENDER:$2|himself|herself}} as {{GENDER:$2|Online Ambassador}} from course $3',

	'logentry-campus-add' => '$1 added {{PLURAL:$4|Campus Ambassador|Campus Ambassadors}} $5 to course $3',
	'logentry-campus-remove' => '$1 removed {{PLURAL:$4|Campus Ambassador|Campus Ambassadors}} $5 from course $3',
	'logentry-campus-selfadd' => '$1 added {{GENDER:$2|himself|herself}} as {{GENDER:$2|Campus Ambassador}} to course $3',
	'logentry-campus-selfremove' => '$1 removed {{GENDER:$2|himself|herself}} as {{GENDER:$2|Campus Ambassador}} from course $3',

	'logentry-student-enroll' => '$1 enrolled in course $3',
	'logentry-student-remove' => '$1 removed $4 as student from course $3',
	'logentry-student-selfremove' => '$1 removed {{GENDER:$2|his|her}} enrollment from course $3',

	// Preferences
	'prefs-education' => 'Education',
	'ep-prefs-showtoplink' => 'Show a link to [[Special:MyCourses|your courses]] at the top of every page.',

	// Rights
	'right-ep-org' => 'Manage Education Program institutions',
	'right-ep-course' => 'Manage Education Program courses',
	'right-ep-token' => 'See Education Program enrollment tokens',
	'right-ep-remstudent' => 'Remove students from courses',
	'right-ep-enroll' => 'Enroll in Education Program courses',
	'right-ep-online' => 'Add or remove online ambassadors to courses',
	'right-ep-campus' => 'Add or remove campus ambassadors to courses',
	'right-ep-instructor' => 'Add or remove instructors to courses',

	// Actions
	'action-ep-org' => 'manage institutions',
	'action-ep-course' => 'manage courses',
	'action-ep-token' => 'see enrollment tokens',
	'action-ep-remstudent' => 'remove students from courses',
	'action-ep-enroll' => 'enroll in courses',
	'action-ep-online' => 'add or remove online ambassadors to courses',
	'action-ep-campus' => 'add or remove campus ambassadors to courses',
	'action-ep-instructor' => 'add or remove instructors to courses',

	// Groups
	'group-epadmin' => 'Education program admins',
	'group-epadmin-member' => '{{GENDER:$1|Education Program admin}}',
	'grouppage-epadmin' => '{{ns:project}}:Education_program_administrators',

	'group-epstaff' => 'Education program staff',
	'group-epstaff-member' => '{{GENDER:$1|Education Program staff}}',
	'grouppage-epstaff' => '{{ns:project}}:Education_program_staff',

	'group-eponlineamb' => 'Education program online ambassador',
	'group-eponlineamb-member' => '{{GENDER:$1|Education Program online ambassador}}',
	'grouppage-eponlineamb' => '{{ns:project}}:Education_program_online_ambassadors',

	'group-epcampamb' => 'Education program campus ambassador',
	'group-epcampamb-member' => '{{GENDER:$1|Education Program campus ambassador}}',
	'grouppage-epcampamb' => '{{ns:project}}:Education_program_campus_ambassadors',

	'group-epinstructor' => 'Education program instructor',
	'group-epinstructor-member' => '{{GENDER:$1|Education Program instructor}}',
	'grouppage-epinstructor' => '{{ns:project}}:Education_program_instructors',

	// Special pages
	'specialpages-group-education' => 'Education',
	'special-mycourses' => 'My courses',
	'special-institutions' => 'Institutions',
	'special-student' => 'Student',
	'special-students' => 'Students',
	'special-courses' => 'Courses',
	'special-educationprogram' => 'Education Program',
	'special-enroll' => 'Enroll',
	'special-onlineambassadors' => 'Online ambassadors',
	'special-campusambassadors' => 'Campus ambassadors',
	'special-onlineambassador' => 'Online ambassador',
	'special-campusambassador' => 'Campus ambassador',

	// Course statuses
	'ep-course-status-passed' => 'Passed',
	'ep-course-status-current' => 'Current',
	'ep-course-status-planned' => 'Planned',

	// Special:Institutions
	'ep-institutions-nosuchinstitution' => 'There is no institution with name "$1". Existing institutions are listed below.',
	'ep-institutions-noresults' => 'There are no institutions to list.',
	'ep-institutions-addnew' => 'Add a new institution',
	'ep-institutions-namedoc' => 'Enter the name for the new institution (which should be unique) and hit the button.',
	'ep-institutions-newname' => 'Institution name:',
	'ep-institutions-add' => 'Add institution',

	// Special:Courses
	'ep-courses-nosuchcourse' => 'There is no course with name "$1". Existing courses are listed below.',
	'ep-courses-noresults' => 'There are no courses to list.',
	'ep-courses-addnew' => 'Add a new course',
	'ep-courses-namedoc' => 'Enter the institution the course belongs to and the year in which it is active.',
	'ep-courses-newterm' => 'Term:',
	'ep-courses-newname' => 'Name:',
	'ep-courses-neworg' => 'Institution:',
	'ep-courses-add' => 'Add course',
	'ep-courses-noorgs' => 'There are no institutions yet. You need to [[Special:Institutions|add an institution]] before you can create any courses.',
	'ep-courses-addorgfirst' => 'There are no institutions yet. You need to [[Special:Institutions|add an institution]] before you can create any courses.',

	// Special:Students
	'ep-students-noresults' => 'There are no students to list.',

    // Special:Ambassadors
    'ep-mentors-noresults' => 'There are no ambassadors to list.',

	// Pager
	'ep-pager-showonly' => 'Show only items with',
	'ep-pager-clear' => 'Clear filters',
	'ep-pager-go' => 'Go',
	'ep-pager-withselected' => 'With selected',
	'ep-pager-delete-selected' => 'Delete',

	// Org pager
	'eporgpager-header-name' => 'Name',
	'eporgpager-header-city' => 'City',
	'eporgpager-header-country' => 'Country',
	'eporgpager-filter-country' => 'Country',
	'eporgpager-header-courses' => 'Courses',
	'eporgpager-header-students' => 'Students',
	'eporgpager-header-active' => 'Active',
	'eporgpager-filter-active' => 'Active courses',
	'eporgpager-yes' => 'Yes',
	'eporgpager-no' => 'No',
	'ep-pager-cancel-button-org' => 'Cancel',
	'ep-pager-delete-button-org' => 'Remove {{PLURAL:$1|institution|institutions}}',
	'ep-pager-confirm-delete-org' => '{{PLURAL:$1|Confirm institution removal|Confirm removal of multiple institutions}}',
	'ep-pager-retry-button-org' => 'Retry',
	'ep-pager-summary-message-org' => 'Summary:',
	// Yeah we need two of these - having a jQuery node in PLURAL breaks, at least at r110788.
	'ep-pager-confirm-message-org' => 'You are about to remove institution $1. This will remove all associated courses and their student data!',
	'ep-pager-confirm-message-org-many' => 'You are about to remove these institutions: $1. This will remove all associated courses and their student data!',

	// Course pager
	'epcoursepager-header-name' => 'Name',
	'epcoursepager-header-term' => 'Term',
	'epcoursepager-header-start' => 'Start',
	'epcoursepager-header-org-id' => 'Institution',
	'epcoursepager-header-end' => 'End',
	'epcoursepager-header-status' => 'Status',
	'epcoursepager-header-students' => 'Students',
	'epcoursepager-header-lang' => 'Language',
	'epcoursepager-filter-term' => 'Term',
	'epcoursepager-filter-lang' => 'Language',
	'epcoursepager-filter-org-id' => 'Institution',
	'epcoursepager-filter-status' => 'Status',
	'epcoursepager-invalid-lang' => 'Invalid',
	'ep-pager-cancel-button-course' => 'Cancel',
	'ep-pager-delete-button-course' => 'Remove {{PLURAL:$1|course|courses}}',
	'ep-pager-confirm-delete-course' => '{{PLURAL:$1|Confirm course removal|Confirm removal of multiple courses}}',
	'ep-pager-retry-button-course' => 'Retry',
	'ep-pager-summary-message-course' => 'Summary:',
	// Yeah we need two of these - having a jQuery node in PLURAL breaks, at least at r110788.
	'ep-pager-confirm-message-course' => 'You are about to remove course $1. This will remove all associated student data!',
	'ep-pager-confirm-message-course-many' => 'You are about to remove these courses: $1. This will remove all associated student data!',

	// Student pager
	'epstudentpager-header-user-id' => 'User',
	'epstudentpager-header-id' => 'Id',
	'epstudentpager-header-current-courses' => 'Current courses',
	'epstudentpager-header-passed-courses' => 'Passed courses',
	'epstudentpager-header-first-enroll' => 'First enrollment',
	'epstudentpager-header-last-active' => 'Last active',
	'epstudentpager-header-active-enroll' => 'Currently enrolled',
	'epstudentpager-yes' => 'Yes',
	'epstudentpager-no' => 'No',

	// Article pager
	'ep-articles-noresults' => 'There are no articles to list.',
	'ep-articles-noresults' => 'There are no articles to list.',

	// Campus ambassador pager
	'epcapager-header-photo' => 'Photo',
	'epcapager-header-user-id' => 'User',
	'epcapager-header-bio' => 'Profile',
	'epcapager-header-courses' => 'Current courses',
	'ep-ca-noresults' => 'There are no Campus Ambassadors to list.',

	// Online ambassador pager
	'epoapager-header-photo' => 'Photo',
	'epoapager-header-user-id' => 'User',
	'epoapager-header-bio' => 'Profile',
	'epoapager-header-courses' => 'Current courses',
	'ep-oa-noresults' => 'There are no Online Ambassadors to list.',

	// Institution editing
	'editinstitution-text' => 'Enter the institution details below and click submit to save your changes.',
	'educationprogram-org-edit-name' => 'Institution name',
	'editorg-add-legend' => 'Add institution',
	'editorg-edit-legend' => 'Edit institution',
	'educationprogram-org-edit-city' => 'City',
	'educationprogram-org-edit-country' => 'Country',
	'educationprogram-org-submit' => 'Submit',
	'ep-addorg' => 'There is no institution with this name yet, but you can add it.',
	'ep-editorg' => 'You are editing an existing institution.',
	'ep-editorg-exists-already' => 'This institution already exists. You are editing it.',
	'ep-editorg-edit' => 'Editing institution: $1',
	'ep-editorg-add' => 'Adding institution: $1',


	// Course editing
	'editcourse-add-legend' => 'Add course',
	'editcourse-edit-legend' => 'Edit course',
	'ep-course-edit-term' => 'Term',
	'ep-course-edit-org' => 'Institution',
	'ep-course-edit-start' => 'Start date',
	'ep-course-edit-end' => 'End date',
	'ep-course-edit-token' => 'Enrollment token',
	'ep-course-edit-description' => 'Description',
	'ep-course-edit-name-format' => '$1 ($2)',
	'ep-course-edit-name' => 'Page title',
	'ep-course-edit-field' => 'Field of study',
	'ep-course-edit-level' => 'Course level',
	'ep-course-edit-term' => 'Academic term',
	'ep-course-edit-mc' => 'Course name',
	'ep-course-edit-lang' => 'Course language',
	'ep-addcourse' => 'There is no course with this name yet, but you can add it.',
	'ep-editcourse' => 'You are editing an existing course.',
	'ep-editcourse-exists-already' => 'This course already exists. You are editing it.',
	'ep-editcourse-edit' => 'Editing course: $1',
	'ep-editcourse-add' => 'Adding course: $1',

	'ep-course-invalid-org' => 'This institution does not exist.',
	'ep-course-invalid-token' => 'The token needs to be at least contain $1 {{PLURAL:$1|character|characters}}.',
	'ep-course-invalid-description' => 'The description needs to be at least contain $1 {{PLURAL:$1|character|characters}}.',
	'ep-course-invalid-lang' => 'This language is not valid.',

	// ep.pager
	'ep-pager-confirm-delete' => 'Are you sure you want to delete this item?',
	'ep-pager-delete-fail' => 'Could not delete this item.',
	'ep-pager-confirm-delete-selected' => 'Are you sure you want to delete the selected {{PLURAL:$1|item|items}}?',
	'ep-pager-delete-selected-fail' => 'Could not delete the selected {{PLURAL:$1|item|items}}.',

	// Institution viewing
	'vieworgaction-none' => 'There is no institution with name "$1". See [[Special:Institutions|here]] for a list of institutions.',
	'ep-institution-create' => 'There is no institution with name "$1" yet, but you can create it.',
	'ep-institution-title' => 'Institution: $1',
	'vieworgaction-summary-name' => 'Name',
	'vieworgaction-summary-city' => 'City',
	'vieworgaction-summary-country' => 'Country',
	'vieworgaction-summary-status' => 'Status',
	'vieworgaction-summary-courses' => 'Course count',
	'vieworgaction-summary-students' => 'Student count',
	'ep-institution-add-course' => 'Add a course',
	'ep-institution-inactive' => 'Inactive',
	'ep-institution-active' => 'Active',
	'ep-institution-courses' => 'Courses',

	// Course viewing
	'ep-course-title' => 'Course: $1',
	'ep-course-students' => 'Students',
	'ep-course-articles' => 'Articles',
	'viewcourseaction-none' => 'There is no course with name "$1". See [[Special:Courses|here]] for a list of courses.',
	'ep-course-create' => 'There is no course with name "$1", but you can create a new one.',
	'ep-course-description' => 'Description',
	'ep-course-no-online' => '',
	'viewcourseaction-summary-org' => 'Institution',
	'viewcourseaction-summary-term' => 'Term',
	'viewcourseaction-summary-start' => 'Start',
	'viewcourseaction-summary-end' => 'End',
	'viewcourseaction-summary-students' => 'Student count',
	'viewcourseaction-summary-status' => 'Status',
	'viewcourseaction-summary-token' => 'Enrollment token',
	'viewcourseaction-summary-instructors' => 'Instructors',
	'viewcourseaction-summary-online' => 'Online Ambassaords',
	'viewcourseaction-summary-campus' => 'Campus Ambassaords',
	'ep-course-no-instructor' => 'There are no instructors for this course yet.',
	'ep-course-become-instructor' => 'Become an instructor',
	'ep-course-add-instructor' => 'Add an instructor',
	'ep-course-no-online' => 'There are no Online Ambassadors for this course yet.',
	'ep-course-become-online' => 'Become an Online Ambassador',
	'ep-course-add-online' => 'Add an Online Ambassador',
	'ep-course-no-campus' => 'There are no Campus Ambassadors for this course yet.',
	'ep-course-become-campus' => 'Become an Campus Ambassador',
	'ep-course-add-campus' => 'Add an Campus Ambassador',
	'ep-instructor-summary' => 'Summary:',
	'ep-online-summary' => 'Summary:',
	'ep-campus-summary' => 'Summary:',

	// Institution history
	'ep-org-history' => 'View logs for this institution',
	'ep-orghistory-title' => 'Revision history of institution "$1"',
	'ep-orghistory-norevs' => 'There is no edit history for this institution.',
	'ep-orghistory-deleted' => 'This institution has been deleted.',

	// Course history
	'ep-course-history' => 'View logs for this course',
	'ep-coursehistory-title' => 'Revision history of course "$1"',
	'ep-coursehistory-norevs' => 'There is no edit history for this course.',
	'ep-coursehistory-deleted' => 'This course has been deleted.',

	// Special:Ambassador
	'ep-ambassador-does-not-exist' => 'There is no ambassador with name "$1". See [[Special:Ambassadors|here]] for a list of ambassadors.',
	'ep-ambassador-title' => 'Ambassador: $1',

	// Special:Student
	'ep-student-none' => 'There is no student with id "$1". See [[Special:Students|here]] for a list of students.',
	'ep-student-title' => 'Student: $1',
	'ep-student-actively-enrolled' => 'Currently enrolled',
	'ep-student-no-active-enroll' => 'Not currently enrolled',
	'specialstudent-summary-active-enroll' => 'Enrollment status',
	'specialstudent-summary-last-active' => 'Last activity',
	'specialstudent-summary-first-enroll' => 'First enrollment',
	'specialstudent-summary-user' => 'User',
	'ep-student-courses' => 'Courses this student has enrolled in',

	// Special:Enroll
	'ep-enroll-title' => 'Enroll for $1 at $2',
	'ep-enroll-login-first' => 'Before you can enroll in this course, you need to login.',
	'ep-enroll-login-and-enroll' => 'Login with an existing account & enroll',
	'ep-enroll-signup-and-enroll' => 'Create a new account & enroll',
	'ep-enroll-not-allowed' => 'Your account is not allowed to enroll',
	'ep-enroll-invalid-id' => 'The course you tried to enroll for does not exist. A list of existing courses can be found [[Special:Courses|here]].',
	'ep-enroll-no-id' => 'You need to specify a course to enroll for. A list of existing courses can be found [[Special:Courses|here]].',
	'ep-enroll-invalid-token' => 'The token you provided is invalid.',
	'ep-enroll-legend' => 'Enroll',
	'ep-enroll-header' => 'In order to enroll for this course, all you need to do is fill out this form and click the submission button. After that you will be enrolled.',
	'ep-enroll-gender' => 'Gender (optional)',
	'ep-enroll-realname' => 'Real name (required)',
	'ep-enroll-invalid-name' => 'The name needs to be at least contain $1 {{PLURAL:$1|character|characters}}.',
	'ep-enroll-invalid-gender' => 'Please select one of these genders',
	'ep-enroll-add-token' => 'Enter your enrollment token',
	'ep-enroll-add-token-doc' => 'In order to enroll for this course, you need a token provided by your instructor or one of the ambassadors for your course.',
	'ep-enroll-token' => 'Enrollment token',
	'ep-enroll-submit-token' => 'Enroll with this token',
	'ep-enroll-course-passed' => 'This course has ended, so you can no longer enroll for it. A list of existing courses can be found [[Special:Courses|here]].',
	'ep-enroll-course-planned' => 'This course has not yet started, please be patient. A list of existing courses can be found [[Special:Courses|here]].',

	// Special:MyCourses
	'ep-mycourses-enrolled' => 'You have successfully enrolled for $1 at $2.',
	'ep-mycourses-not-enrolled' => 'You are not enrolled in any course. A list of courses can be found [[Special:Courses|here]].',
	'ep-mycourses-current' => 'Active courses',
	'ep-mycourses-passed' => 'Passed courses',
	'ep-mycourses-header-name' => 'Name',
	'ep-mycourses-header-institution' => 'Institution',
	'ep-mycourses-show-all' => 'This page shows one of the courses you are enrolled in. You can also view all [[Special:MyCourses|your courses]].',
	'ep-mycourses-no-such-course' => 'You are not enrolled in any course with name "$1". The courses you are enrolled in are listed below.',
	'ep-mycourses-course-title' => 'My courses: $1 at $2',
	'specialmycourses-summary-name' => 'Course name',
	'specialmycourses-summary-org' => 'Institution name',
    'ep-mycourses-not-a-student' => 'You are not enrolled in any [[Special:Courses|courses]].',
	'ep-mycourses-enrollment' => 'Courses I am enrolled in',
	'ep-mycourses-course-enrollment' => 'Course I am enrolled in',
	'ep-mycourses-login-first' => 'You need to login before you can view your courses.',
	'ep-mycourses-ambcourses-epoa' => 'Courses I am Online Ambassador for',
	'ep-mycourses-ambcourses-epca' => 'Courses I am Campus Ambassador for',
	'ep-mycourses-noambcourses-epca' => 'There are no courses you are Campus Ambassador for yet.',
	'ep-mycourses-noambcourses-epoa' => 'There are no courses you are Online Ambassador for yet.',

	// ep.enlist instructor
	'ep-instructor-remove-title' => 'Remove instructor from course',
	'ep-instructor-remove-button' => 'Remove instructor',
	'ep-instructor-removing' => 'Removing...',
	'ep-instructor-removal-success' => 'This instructor has been successfully removed from this course.',
	'ep-instructor-close-button' => 'Close',
	'ep-instructor-remove-retry' => 'Retry',
	'ep-instructor-remove-failed' => 'Something went wrong - could not remove the instructor from the course.',
	'ep-instructor-cancel-button' => 'Cancel',
	'ep-instructor-remove-text' => 'You are about to remove $2 (Username: $1) as {{GENDER:$1|instructor}} from course $3. Please enter a brief summary with the reason for this removal.',
	'ep-instructor-adding' => 'Adding...',
	'ep-instructor-addittion-success' => '$1 has been successfully added as {{GENDER:$1|instructor}} for course $2!',
	'ep-instructor-addittion-self-success' => 'You have been successfully added as {{GENDER:$1|instructor}} for course $2!',
	'ep-instructor-add-close-button' => 'Close',
	'ep-instructor-add-retry' => 'Retry',
	'ep-instructor-addittion-failed' => 'Something went wrong - could not add the instructor to the course.',
	'ep-instructor-add-title' => 'Add an instructor to the course',
	'ep-instructor-add-self-title' => 'Become an {{GENDER:$1|instructor}} for this course',
	'ep-instructor-add-button' => 'Add instructor',
	'ep-instructor-add-self-button' => 'Become {{GENDER:$1|instructor}}',
	'ep-instructor-add-text' => 'You are adding an instructor for course $1. Enter the username of the instructor and a brief description why this person is being added.',
	'ep-instructor-add-self-text' => 'You are adding yourself as {{GENDER:$1|instructor}} for course $1. Please add a brief description why you are doing so.',
	'ep-instructor-add-cancel-button' => 'Cancel',
	'ep-instructor-summary-input' => 'Summary:',
	'ep-instructor-name-input' => 'User name:',

	// ep.enlist online
	'ep-online-remove-title' => 'Remove Online Ambassador from course',
	'ep-online-remove-button' => 'Remove Online Ambassador',
	'ep-online-removing' => 'Removing...',
	'ep-online-removal-success' => 'This Online Ambassador has been successfully removed from this course.',
	'ep-online-close-button' => 'Close',
	'ep-online-remove-retry' => 'Retry',
	'ep-online-remove-failed' => 'Something went wrong - could not remove the Online Ambassador from the course.',
	'ep-online-cancel-button' => 'Cancel',
	'ep-online-remove-text' => 'You are about to remove $2 (Username: $1) as {{GENDER:$1|Online Ambassador}} from course $3. Please enter a brief summary with the reason for this removal.',
	'ep-online-adding' => 'Adding...',
	'ep-online-addittion-success' => '$1 has been successfully added as {{GENDER:$1|Online Ambassador}} for course $2!',
	'ep-online-addittion-self-success' => 'You have been successfully added as {{GENDER:$1|Online Ambassador}} for course $2!',
	'ep-online-add-close-button' => 'Close',
	'ep-online-add-retry' => 'Retry',
	'ep-online-addittion-failed' => 'Something went wrong - could not add the Online Ambassador to the course.',
	'ep-online-add-title' => 'Add an Online Ambassador to the course',
	'ep-online-add-self-title' => 'Become an {{GENDER:$1|Online Ambassador}} for this course',
	'ep-online-add-button' => 'Add Online Ambassador',
	'ep-online-add-self-button' => 'Become {{GENDER:$1|Online Ambassador}}',
	'ep-online-add-text' => 'You are adding an Online Ambassador for course $1. Enter the username of the Online Ambassador and a brief description why this person is being added.',
	'ep-online-add-self-text' => 'You are adding yourself as {{GENDER:$1|Online Ambassador}} for course $1. Please add a brief description why you are doing so.',
	'ep-online-add-cancel-button' => 'Cancel',
	'ep-online-summary-input' => 'Summary:',
	'ep-online-name-input' => 'User name:',

	// ep.enlist campus
	'ep-campus-remove-title' => 'Remove Campus Ambassador from course',
	'ep-campus-remove-button' => 'Remove Campus Ambassador',
	'ep-campus-removing' => 'Removing...',
	'ep-campus-removal-success' => 'This Campus Ambassador has been successfully removed from this course.',
	'ep-campus-close-button' => 'Close',
	'ep-campus-remove-retry' => 'Retry',
	'ep-campus-remove-failed' => 'Something went wrong - could not remove the Campus Ambassador from the course.',
	'ep-campus-cancel-button' => 'Cancel',
	'ep-campus-remove-text' => 'You are about to remove $2 (Username: $1) as {{GENDER:$1|Campus Ambassador}} from course $3. Please enter a brief summary with the reason for this removal.',
	'ep-campus-adding' => 'Adding...',
	'ep-campus-addittion-success' => '$1 has been successfully added as {{GENDER:$1|Campus Ambassador}} for course $2!',
	'ep-campus-addittion-self-success' => 'You have been successfully added as {{GENDER:$1|Campus Ambassador}} for course $2!',
	'ep-campus-add-close-button' => 'Close',
	'ep-campus-add-retry' => 'Retry',
	'ep-campus-addittion-failed' => 'Something went wrong - could not add the Campus Ambassador to the course.',
	'ep-campus-add-title' => 'Add an Campus Ambassador to the course',
	'ep-campus-add-self-title' => 'Become an {{GENDER:$1|Campus Ambassador}} for this course',
	'ep-campus-add-button' => 'Add Campus Ambassador',
	'ep-campus-add-self-button' => 'Become {{GENDER:$1|Campus Ambassador}}',
	'ep-campus-add-text' => 'You are adding an Campus Ambassador for course $1. Enter the username of the Campus Ambassador and a brief description why this person is being added.',
	'ep-campus-add-self-text' => 'You are adding yourself as {{GENDER:$1|Campus Ambassador}} for course $1. Please add a brief description why you are doing so.',
	'ep-campus-add-cancel-button' => 'Cancel',
	'ep-campus-summary-input' => 'Summary:',
	'ep-campus-name-input' => 'User name:',

	// EPInstrucor
	'ep-instructor-remove' => 'remove as instructor',

	// EPCA
	'ep-campus-remove' => 'remove as Campus Ambassador',

	// EPOA
	'ep-online-remove' => 'remove as Online Ambassador',

	// API enlist
	'ep-enlist-invalid-user-args' => 'You need to either provide the username or the userid parameter',
	'ep-enlist-invalid-user' => 'The provided user id or name is not valid and can therefore not be associated as instrucor or ambassador with the specified course',
	'ep-enlist-invalid-course' => 'There is no course with the provided ID',

	// Special:OnlineAmbassadorProfile
	'onlineambassadorprofile' => 'Online Ambassador profile',
	'onlineambassadorprofile-legend' => 'My Online Ambassador profile',
	'onlineambassadorprofile-text' => 'Your Online Ambassador profile is what students get to see when they browse available ambassadors.',
	'epoa-profile-invalid-photo' => 'The photo must be located on {{PLURAL:$2|this website: $1|one of these websites: $1}}',
	'epoa-profile-bio' => 'Short bio',
	'epoa-profile-photo' => 'Profile photo',
	'epoa-profile-saved' => 'Your profile has been saved',

	// Special:CampusAmbassadorProfile
	'campusambassadorprofile' => 'Campus Ambassador profile',
	'campusambassadorprofile-legend' => 'My Campus Ambassador profile',
	'campusambassadorprofile-text' => 'Your Campus Ambassador profile is what students get to see when they browse available ambassadors.',
	'epca-profile-invalid-photo' => 'The photo must be located on {{PLURAL:$2|this website: $1|one of these websites: $1}}',
	'epca-profile-bio' => 'Short bio',
	'epca-profile-photo' => 'Profile photo',
	'epca-profile-saved' => 'Your profile has been saved',
);

/** Message documentation (Message documentation)
 * @author Jeroen De Dauw
 */
$messages['qqq'] = array(
	'right-' => '{{doc-right|}}',

	'action-' => '{{doc-action|}}',

	'specialpages-group-education' => 'Special pages group, h2',
	'special-mycourses' => '{{doc-special|mycourses}}',
	'special-institution' => '{{doc-special|institution}}',
	'special-institutions' => '{{doc-special|institutions}}',
	'special-student' => '{{doc-special|student}}',
	'special-students' => '{{doc-special|students}}',
	'special-course' => '{{doc-special|course}}',
	'special-courses' => '{{doc-special|courses}}',
	'special-educationprogram' => '{{doc-special|educationprogram}}',

	'ep-institutions-nosuchinstitution' => 'Error message stating there is no institution with name $1',
);
