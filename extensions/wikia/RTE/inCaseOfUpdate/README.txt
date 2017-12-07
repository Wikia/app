PHP scripts that are used to generate proper messages for CKEDITOR.

Instructions:
	1. Place generate_i18n_from_core.php and scriptCore.js in /ckeditor/lang/. folder.
	2. Execute 'php generate_i18n_from_core.php and save the output to CK.core.i18n.phpCORE.
	3. Place it in /RTE/i18n/. 
	
	4. Place generate_i18n_from_plugins.php and scriptPlugins.js in /ckeditor/plugins/. folder.
	5. Execute 'php generate_i18n_from_plugins.php and save the output CK.core.i18n.phpPLUGINS.
	6. Place it in /RTE/i18n/.
	
	7. Place merge_into_one.php in /RTE/i18n/.
	8. Execute 'php merge-into-one.php'.
	9. ???????
	10. PROFIT $$$
	11. The output is the final generated language file. Save it as CK.core.i18n.php.
