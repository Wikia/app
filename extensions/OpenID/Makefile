PHP_OPENID_VERSION=2.2.2
SUBDIR=openid-php-openid-782224d
SHELL = /bin/sh

# how to make that one predictable easily?

# http://www.mediawiki.org/wiki/Extension:OpenID
#
# This makefile automates the installation of a prerequisite for the MediaWiki OpenID extension.
#
# MediaWiki OpenID extensions depends on the 
# OpenIDEnabled.com PHP library for OpenID which in turn depends on the 
# OpenIDEnabled.com PHP library for YADIS.
#
# STEP 1: 
# Get the extension by method (a) or (b) or (c).
#
# (a) First download the MediaWiki OpenID extension which includes this makefile from
#    http://www.mediawiki.org/wiki/Special:ExtensionDistributor/OpenID
#
# or by checking out from SVN as explained in (b) or (c)
#
# (b) anonymous users checkout using this command:
#    cd $IP/extensions
#    svn checkout svn://svn.wikimedia.org/svnroot/mediawiki/trunk/extensions/OpenID OpenID
#
# (c) developers however checkout using this command:
#    cd $IP/extensions
#    svn checkout svn+ssh://USERNAME@svn.wikimedia.org/svnroot/mediawiki/trunk/extensions/OpenID OpenID
#
# STEP 2
# The makefile downloads the openid-php library from http://www.openidenabled.com/php-openid/
# and applies a patch to avoid PHP errors because Call-time pass-by-reference is deprecated
# since PHP 5.3.x see https://github.com/openid/php-openid/issues#issue/8  and
# the patch and fork of user kost https://github.com/openid/php-openid/pull/44/files
#
# Go to the extensions/OpenID subdirectors and start the installation 
# which also downloads and patches the pre-requisites:
#
#    cd $IP/extensions/OpenID
#    make
#
# If you want to clean-up (delete $IP/extensions/OpenID/Auth subdirectory and
# to delete a previously downloaded tgz file) to try a fresh "make", then use
#
#    cd $IP/extensions/OpenID
#    make clean
#    make
#
# initially written by Brion Vibber
# 20110203 T. Gries 
# 20111014 added a test whether "patch" (program) exists before starting it blindly

install: check-if-patch-exists Auth

# test if "patch" program is installed 
# some distributions don't have it installed by default
# 
# as suggested in 
# http://stackoverflow.com/questions/592620/check-if-a-program-exists-from-a-bash-script
# we use "hash" to test existence of "patch"

check-if-patch-exists:
	@if $(SHELL) -c 'hash patch' >/dev/null 2>&1; then \
		# echo "... The 'patch' program exists." ; \
		true; \
	else \
		echo "... The 'patch' program does not exist on your system. Please install it before running make."; \
		false; \
	fi

Auth:	php-openid-$(PHP_OPENID_VERSION).tar.gz check-php-openid-sha1
	@echo "... Extracting php-openid-$(PHP_OPENID_VERSION).tar.gz:"
	tar -xzf php-openid-$(PHP_OPENID_VERSION).tar.gz $(SUBDIR)/Auth
	rm -f php-openid-$(PHP_OPENID_VERSION).tar.gz
	mv $(SUBDIR)/Auth ./
	@echo "... Patching php-openid-$(PHP_OPENID_VERSION) files in the Auth subdirectory:"
	patch -p1 -d Auth < patches/php-openid-$(PHP_OPENID_VERSION).patch
	rmdir $(SUBDIR)
	@echo -e "\n\
... Now almost everything is ready for making your MediaWiki OpenID-aware.\n\
... Don't forget to add\n\
    require_once( \"\$$IP/extensions/OpenID/OpenID.php\" );\n\
... to your \$$IP/LocalSettings.php, if not yet done. Then start your wiki."

php-openid-$(PHP_OPENID_VERSION).tar.gz:
	@echo "... Downloading the PHP library for OpenID:"
	wget --no-check-certificate https://github.com/openid/php-openid/tarball/$(PHP_OPENID_VERSION) -O php-openid-$(PHP_OPENID_VERSION).tar.gz

check-php-openid-sha1:
	@if $(SHELL) -c "sha1sum -c php-openid-$(PHP_OPENID_VERSION).tar.gz.sha1" >/dev/null 2>&1; then \
		# echo "... The SHA1 hash does match."; \
		true; \
	else \
		echo "... Something is wrong: the SHA1 of the downloaded file does not match the expected value."; \
		false; \
	fi


# before starting a fresh installation or update,
# you could use "make clean" to clean up, then "make" again
clean:
	@echo "... Deleting the Auth subdirectory and the php-openid-$(PHP_OPENID_VERSION).tar.gz file:"
	rm -rf Auth php-openid-$(PHP_OPENID_VERSION).tar.gz
	@echo "... A new installation can be started now by typing 'make'."
