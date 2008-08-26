SignDocument MediaWiki Extension
By: Daniel Cannon (AmiDaniel)
------------------------------------------------------------------------------

** WARNING: THIS EXTENSION IS HIGHLY EXPERIMENTAL! INSTALL AT YOUR OWN RISK **

SignDocument is an extension for MediaWiki 1.10+ that enables the electronic
signing of documents, such as petitions or opinion polls. It allows for
per-document customization of signing and an advanced moderation interface to
aid in identifying and discrediting non-unique and otherwise inelligible
signatures.

The extension is completely brand new (whipped up in about two days) and
should, at present time, only be installed by developers. It is by no means
fit for actual use.

[0] Table of contents
	[1] Installation
	[2] Using Special:CreateSignDocument
	[3] Using Special:SignDocument
	[4] File manifest

[1] Installation
	[1.1] SignDocument has the following installation prerequisites: 
		[1.1.1] MediaWiki 1.10+ and its requirements (such as PHP5 and MySQL)
		[1.1.2] It should run on all operating systems that MW supports;
		however, it has only been tested on SuSE Linux 10.1 and Red Hat Fedora
		Core 4.
		[1.1.3] ExtensionFunctions.php must be installed in your extensions
		directory. This can be downloaded from subversion.
	
	[1.2] Verify that you have all the needed files (see |4| below) in the
	directoy "<wikiroot>/extensions/SignDocument". If you need the extension
	to be stored elsewhere, then amend these instructions accordingly.
	
	[1.3] First, you must set up the database to support the extension. To do
	this, execute "mysql -u root -p |yourwikidb| < signdocument.sql", or
	otherwise execute the signdocument.sql script (using phpMyAdmin or similar
	applications).

	[1.4] Then, add to your LocalSettings.php: 
	'require_once( "$IP/extensions/SignDocument/SignDocument.php" )'.

	[1.5] You can then add a user on your wiki to the group "sigadmin" via
	Special:Userrights.

	[1.6] Verify that the installation was successful by visiting
	Special:SignDocument and Special:CreateSignDocument on your wiki.

[2] Using Special:CreateSignDocument
	[2.1] Special:CreateSignDocument is a special page that allows users in
	the group "sigadmin" to enable the signing of a document and specify
	settings for how users can sign the document, such as which fields are
	visible to users and which are required.

	[2.2] To use it, you must first have a page in your wiki on which you wish
	to enable signing. Once you have enabled the signing of the document the
	presently current version will be the only version displayed to users when
	signing it, so be sure that the page is in a stable state before
	proceeding.

	[2.3] Visit the page Special:CreateSignDocument to enable the signing of
	this page. Provide the name of the page to the field "Page," specify which
	group should be allowed to sign it, specify which fields you wish to make
	hidden and optional, indicate a minimum age to require signers to obtain
	(or omit if you wish to enforce no minimum age), and type a brief
	introductory text providing instructions to users that are specific to the
	signing of this page.

	[2.4] Then, hit "Create" to enable the signing. Note that there is
	presently no way to modify SignDocuments after they are created except
	through database queries, so be careful! To delete a SignDocument you
	created accidentally, execute "DELETE FROM sdoc_form WHERE form_id = X;"
	where "X" is the ID number of the document you created.

[3] Using Special:SignDocument
	[3.1] The heart of the extension is Special:SignDocument, which provides
	both the interface allowing users to sign documents and the moderation
	interface, accessible to users in the group "sigadmin". 

	[3.2] Accessing the special page directly will give you a list of pages
	that you can sign or for which you can view signatures; however, in most
	cases, the actual signing forms should simply be linked directly, by
	linking to 'Special:SignDocument?doc=id'.

	[3.3] Once at a signing page, you will see the full text of the document
	followed by a form prompting you for the information needed to sign the
	petition, as specified by the sigadmin who enabled the signing of the
	document. You can fill out the information and click "Sign document" to
	sign the page.

	[3.4] You will also see a link in the upper-right hand corner allowing you
	to view all signatures submitted for the page.

	[3.5] At the "view signatures" page, you can view a list of all signatures
	submitted, which can be sorted by any of the available fields. Sigadmins
	will also be able to use this form to disable or enable the signing of a
	page, and they will be able to view the IP addresses and user agents of
	all the signers.

	[3.6] Additionally, sigadmins will see an link next to each signature
	title "Options". Clicking it will take you to a detail view of the
	signature that will provide you with many tools to examine the signature,
	and the ability to review and "strike" the signature.

[4] File manifest
	[4.1] README.txt
		-> This file.
	[4.2] signdocument.sql
		-> MySQL script to set up the needed tables.
	[4.3] SignDocument.php
		-> The initialization file for the extension.
	[4.4] SignDocument.i18n.php
		-> General localization.
	[4.5] SpecialSignDocument.php
		-> Implements Special:SignDocument as described above.
	[4.6] SpecialSignDocument.i18n.php
		-> Localization for Special:SignDocument.
	[4.7] SpecialCreateSignDocument.php
		-> Implements Special:CreateSignDocument.
	[4.8] SpecialCreateSignDocument.i18n.php
		-> Localization for Special:CreateSignDocument.
	[4.9] SignDocumentHelpers.php
		-> Helper classes for the extension.
	
	
	
