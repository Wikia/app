<?php

/**
 * Internationalisation for DMCARequest extension
 *
 * @file
 * @ingroup Extensions
 */

$messages = [];

/** English
 * @author Daniel Grunwell (grunny)
 */
$messages['en'] = [
	'dmcarequest' => 'DMCA Request',
	'dmcarequest-desc' => 'Allows the submission and management of DMCA takedown requests.',
	'right-dmcarequestmanagement' => 'Manage DMCA requests',
	'action-dmcarequestmanagement' => 'manage DMCA requests',
	'dmcarequest-request-intro' => 'As a host for user-­generated content, Wikia follows the notice and takedown	provisions of the Digital Millennium Copyright Act (DMCA). If you believe that your copyrighted content is being used on Wikia in a manner that violates your rights, you may send a DMCA takedown notice. This page is a guided form that will allow you to fill out the required elements of a DMCA takedown notice. Once you click send, it will generate an email to [mailto:copyright@wikia.com copyright@wikia.com] as a full DMCA takedown notice.

Please ensure the accuracy of your notice before sending it, and please note that Wikia is not in a position to provide legal advice. If you have questions, we recommend that you speak to an attorney.',
	'dmcarequest-request-type-label' => 'I am:',
	'dmcarequest-request-type-copyrightholder' => 'The copyright holder',
	'dmcarequest-request-type-representative' => 'The legal representative of the copyright holder',
	'dmcarequest-request-type-none' => 'None of the above',
	'dmcarequest-request-name-label' => 'Your full legal name:',
	'dmcarequest-request-address-label' => 'Your full mailing address:',
	'dmcarequest-request-telephone-label' => 'Your primary telephone number:',
	'dmcarequest-request-email-label' => 'Your primary email address:',
	'dmcarequest-request-links-original-label' => 'Link(s) to the original material allegedly being infringed (one per line):',
	'dmcarequest-request-upload-label' => 'Need to attach a file of the material? If so, please upload here:',
	'dmcarequest-request-links-wikia-label' => 'Link(s) to the allegedly infringing material on Fandom (one per line):',
	'dmcarequest-request-comments-label' => 'Additional comments:',
	'dmcarequest-request-good-faith-label' => 'I have a good faith belief that the copyright holder, its agent, or the law do not authorize the use of the material in the manner I have complained of.',
	'dmcarequest-request-perjury-label' => 'I swear, under penalty of perjury, that the information in this notice is accurate and that I am the copyright holder or an authorized representative of the copyright holder.',
	'dmcarequest-request-wikiarights-label' => 'I acknowledge that Wikia, Inc reserves the right to release, in accordance with the Digital Millennium Copyright Act and the company’s discretion, this takedown notice, with appropriate redactions to private information, to: the individual(s) that the notice alleges infringed upon my intellectual property; the administrators of relevant Fandom communities; transparency websites, such as Chilling Effects; and the public at large.',
	'dmcarequest-request-signature-label' => 'Electronic signature:',
	'dmcarequest-request-send-label' => 'Send to Fandom',
	'dmcarequest-request-send-copy-label' => 'Send me a copy of this message',
	'dmcarequest-request-outro' => 'By clicking "Send to Fandom" below, you are sending a completed DMCA takedown notice. If you already have a DMCA takedown notice and do not require the guided form, you may send your notice directly to [mailto:copyright@wikia.com copyright@wikia.com].',
	'dmcarequest-request-success' => 'Thank you for contacting Wikia, Inc with your DMCA request. We will review your request and do our best to get back to you in the next 2-3 business days.',
	'dmcarequest-request-error-incomplete' => 'You must fill out all required fields.',
	'dmcarequest-request-error-invalid' => 'An invalid value was provided.',
	'dmcarequest-request-error-invalid-email' => 'Please provide a valid email address.',
	'dmcarequest-request-error-agreements' => 'You must agree to all the statements below by clicking the checkboxes to proceed.',
	'dmcarequest-request-error-submission' => 'Unfortunately an error occurred while processing your request. Please try again, and if the problem persists send the notice directly to [mailto:copyright@wikia.com copyright@wikia.com].',

	'dmcarequest-email-subject' => 'Claim of copyright infringement',
	'dmcarequest-email-text' => 'TO:
ATTN: Copyright Agent
Wikia, Inc.
360 Third Street
Suite 750
San Francisco, CA 94107

FROM:
$1
$2
$3
$4

I am $5 of the following materials:

$6

My copyright is being infringed at:

$7

$8

$9

$10

$11

Sincerely,
$12

----
$13',

	'dmcarequestmanagement' => 'DMCA Request Management',
	'dmcarequestmanagement-list-id' => 'ID',
	'dmcarequestmanagement-list-date' => 'Date',
	'dmcarequestmanagement-list-fullname' => 'Name',
	'dmcarequestmanagement-list-email' => 'Email',
	'dmcarequestmanagement-list-ce-id' => 'Chilling Effects ID',
	'dmcarequestmanagement-notice-email-text' => 'Notice email text',
	'dmcarequestmanagement-error-no-notice' => "There isn't a notice with the ID #$1",
	'dmcarequestmanagement-chillingeffects-header' => 'Submit to Chilling Effects',
	'dmcarequestmanagement-title-default' => 'DMCA Complaint to Wikia, Inc',
	'dmcarequestmanagement-title-label' => 'Title:',
	'dmcarequestmanagement-subject-label' => 'Subject:',
	'dmcarequestmanagement-source-default' => 'Online form',
	'dmcarequestmanagement-source-label' => 'Source (Online form, Email, etc.):',
	'dmcarequestmanagement-action-label' => 'Action taken:',
	'dmcarequestmanagement-action-yes' => 'Yes',
	'dmcarequestmanagement-action-no' => 'No',
	'dmcarequestmanagement-action-partial' => 'Partial',
	'dmcarequestmanagement-name-label' => 'Sender\'s full name',
	'dmcarequestmanagement-sendertype-label' => 'Sender type:',
	'dmcarequestmanagement-language-label' => 'Language:',
	'dmcarequestmanagement-sender-type-organization' => 'Organization',
	'dmcarequestmanagement-sender-type-individual' => 'Individual',
	'dmcarequestmanagement-links-description-label' => 'Description of work allegedly being infringed:',
	'dmcarequestmanagement-kind-label' => 'Type of content (i.e. book, movie, video, etc.):',
	'dmcarequestmanagement-error-submission' => 'Unfortunately an error occurred while processing your request. Please try again.',
	'dmcarequestmanagement-chillingeffects-success' => 'Successfully submitted DMCA notice to Chilling Effects with ID $1.',
	'dmcarequestmanagement-chillingeffects-submitted' => 'This DMCA notice has been submitted to Chilling Effects with ID $1.',
	'dmcarequestmanagement-send-label' => 'Send to Chilling Effects',
];

/**
 * @author Daniel Grunwell (grunny)
 */
$messages['qqq'] = [
	'dmcarequest' => 'Special page name.',
	'right-dmcarequestmanagement' => '{{doc-right|dmcarequestmanagement}}',
	'action-dmcarequestmanagement' => '{{doc-action|dmcarequestmanagement}}',
	'dmcarequest-desc' => '{{desc}}',
	'dmcarequest-request-intro' => 'Intro text on the request form.',
	'dmcarequest-request-type-label' => 'Label for selecting what relation the reporter has to the copyrighted material.',
	'dmcarequest-request-type-copyrightholder' => 'Option for the relation the reporter has to the copyrighted material.',
	'dmcarequest-request-type-representative' => 'Option for the relation the reporter has to the copyrighted material.',
	'dmcarequest-request-type-none' => 'Option for the relation the reporter has to the copyrighted material.',
	'dmcarequest-request-name-label' => 'Label next to the input box for the reporter\'s full name.',
	'dmcarequest-request-address-label' => 'Label next to the input box for the reporter\'s mailing address.',
	'dmcarequest-request-telephone-label' => 'Label next to the input box for the reporter\'s telephone number.',
	'dmcarequest-request-email-label' => 'Label next to the input box for the reporter\'s email address.',
	'dmcarequest-request-links-original-label' => 'Label for the text box for listing the URLs of the copyrighted material.',
	'dmcarequest-request-upload-label' => 'Label for uploading documents with the form.',
	'dmcarequest-request-links-wikia-label' => 'Label for the text box for listing the URLs of where the copyrighted material is used on Wikia.',
	'dmcarequest-request-comments-label' => 'Label for the text box for additional comments.',
	'dmcarequest-request-good-faith-label' => 'Label for the checkbox for agreeing the submission is in good faith.',
	'dmcarequest-request-perjury-label' => 'Label for the checkbox for confirming they are authorised to submit the request.',
	'dmcarequest-request-wikiarights-label' => 'Label for the checkbox for agreeing to Wikia\'s rights.',
	'dmcarequest-request-signature-label' => 'Label next to the input box for the reporter\'s slectronic signature.',
	'dmcarequest-request-send-label' => 'Label for the form\'s submission button.',
	'dmcarequest-request-send-copy-label' => 'Label for the checkbox to send the reporter a copy of their notice.',
	'dmcarequest-request-outro' => 'Text at the end of the form just before the submission button.',
	'dmcarequest-request-success' => 'Message shown on submitting the notice successfully.',
	'dmcarequest-request-error-incomplete' => 'Error message shown when the reporter hasn\'t fully completed the form.',
	'dmcarequest-request-error-invalid' => 'Error message shown when the reporter provided an invalid value.',
	'dmcarequest-request-error-invalid-email' => 'Error message shown when the reporter did not provide a valid email address.',
	'dmcarequest-request-error-agreements' => 'Error message shown when the reporter did not check all the agreement checkboxes.',
	'dmcarequest-request-error-submission' => 'Error message shown when an error occurred that cannot be resolved by the reporter.',

	'dmcarequest-email-subject' => 'Email subject line. Emails are only sent in English so do not translate.',
	'dmcarequest-email-text' => 'The template for the email. Emails are only sent in English so do not translate.',

	'dmcarequestmanagement' => 'Special page name.',
	'dmcarequestmanagement-list-id' => 'Table header in the list of notices for the ID of the notice.',
	'dmcarequestmanagement-list-date' => 'Table header in the list of notices for the date the notice was sent.',
	'dmcarequestmanagement-list-fullname' => 'Table header in the list of notices for the name of the sender of the notice.',
	'dmcarequestmanagement-list-email' => 'Table header in the list of notices for the email of the sender of the notice.',
	'dmcarequestmanagement-list-ce-id' => 'Table header in the list of notices for the ID of the notice in CE.',
	'dmcarequestmanagement-notice-email-text' => 'Heading for the preview of the email text when viewing a specific notice.',
	'dmcarequestmanagement-error-no-notice' => 'Error message when trying to view a notice that doesn\'t exist. $1 is the notice ID that was requested.',

	'dmcarequestmanagement-chillingeffects-header' => 'Header for form to submit notice to Chilling Effects.',
	'dmcarequestmanagement-title-default' => 'Default title of the notice to submit to Chilling Effects.',
	'dmcarequestmanagement-title-label' => 'Label for the title of the notice to submit to Chilling Effects.',
	'dmcarequestmanagement-subject-label' => 'Label for the subject of the notice to submit to Chilling Effects.',
	'dmcarequestmanagement-source-default' => 'Default value for the source of the notice to submit to Chilling Effects.',
	'dmcarequestmanagement-source-label' => 'Label for the source of the notice to submit to Chilling Effects.',
	'dmcarequestmanagement-action-label' => 'Label for the action taken on the notice to submit to Chilling Effects.',
	'dmcarequestmanagement-action-yes' => 'Text of the option for the Yes action on notices.',
	'dmcarequestmanagement-action-no' => 'Text of the option for the No action on notices.',
	'dmcarequestmanagement-action-partial' => 'Text of the option for the Partial action on notices.',
	'dmcarequestmanagement-name-label' => 'Label for the sender of the DMCA notice.',
	'dmcarequestmanagement-sendertype-label' => 'Label for the type of sender.',
	'dmcarequestmanagement-language-label' => 'Label for the language the notice was sent in.',
	'dmcarequestmanagement-sender-type-organization' => 'Text of the option for the organization type of sender.',
	'dmcarequestmanagement-sender-type-individual' => 'Text of the option for the individual type of sender.',
	'dmcarequestmanagement-links-description-label' => 'Label for the description of the notice to submit to Chilling Effects.',
	'dmcarequestmanagement-kind-label' => 'Label for the kind of data in the request to submit to Chilling Effects.',
	'dmcarequestmanagement-error-submission' => 'Error message displayed when an error occurred while sending the data to Chilling Effects.',
	'dmcarequestmanagement-chillingeffects-success' => 'Success message displayed upon submitting the notice to Chilling Effects. $1 is the ID of the notice on Chilling Effects.',
	'dmcarequestmanagement-chillingeffects-submitted' => 'Message displayed at the top of form page when a notice has already been sent to Chilling Effects. $1 is the ID of the notice on Chilling Effects.',
	'dmcarequestmanagement-send-label' => 'Label for the button to submit the notice data to Chilling Effects.',
];
