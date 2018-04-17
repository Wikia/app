PHP scripts that are used to generate proper messages for CKEDITOR.

Instructions:

	Execute ./generate_i18n.sh.

	It will use the files that are in ckeditor/lang/. as well as ckeditor/plugins/.
	
	If you want to change which plugins will be included in the file, modify the array in generate_i18n_from_plugins.php.
	
	OUTPUT: RTE/i18n/CK.core.i18n.php
	
	Use Wisely.


Author: Kacper Olek ( kolek@wikia-inc.com )
