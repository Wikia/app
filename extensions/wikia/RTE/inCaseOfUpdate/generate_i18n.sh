#!/bin/bash

# Copy required scripts into target directories.
cp scripts/generate_i18n_from_core.php ../ckeditor/lang/.;
cp scripts/scriptCore.js ../ckeditor/lang/.;
cp scripts/generate_i18n_from_plugins.php ../ckeditor/plugins/.;
cp scripts/scriptPlugins.js ../ckeditor/plugins/.;
cp scripts/merge-into-one.php ../i18n/.;

# CORE
cd ../ckeditor/lang/.;
printf "Currently at: ";
printf `pwd`;
printf "\n";

printf "Processing CORE\n";
php generate_i18n_from_core.php > CK.core.i18n.phpCORE;

mv CK.core.i18n.phpCORE ../../i18n/.;

rm generate_i18n_from_core.php;
rm scriptCore.js;

#PLUGINS
cd ../plugins/.;
printf "Currently at: ";
printf `pwd`;
printf "\n";

printf "Processing PLUGINS\n";

php generate_i18n_from_plugins.php > CK.core.i18n.phpPLUGINS;

mv CK.core.i18n.phpPLUGINS ../../i18n/.;

rm generate_i18n_from_plugins.php;
rm scriptPlugins.js;

cd ../../i18n/.;

# MERGING
printf "Currently at: ";
printf `pwd`;
printf "\n";

printf "Merging\n";

php merge-into-one.php > CK.core.i18n.php;

rm merge-into-one.php;
rm CK.core.i18n.phpCORE;
rm CK.core.i18n.phpPLUGINS;

printf "Generated file is in RTE/i18n/.\n";
printf "Done!\n";
