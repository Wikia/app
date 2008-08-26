Summary: PHP extension to do fast diffs for MediaWiki
Name: wikidiff
Version: 0.0.1
Release: 2
Copyright: Uknown
Group: Applications/Internet
Source: wikidiff-0.0.1.tar.gz
BuildRoot: /var/tmp/%{name}-buildroot

%description
PHP extension to do fast diffs for MediaWiki.
(Packaged for Wikimedia local use!)

%prep
%setup -q

%build
make

%install
rm -rf $RPM_BUILD_ROOT
INSTALL_TARGET="$RPM_BUILD_ROOT/usr/local/lib/php/extensions/no-debug-non-zts-20020429" make install

%clean
rm -rf $RPM_BUILD_ROOT

%files
%defattr(-,root,root)
%dir /usr/local/lib/php/extensions/no-debug-non-zts-20020429

/usr/local/lib/php/extensions/no-debug-non-zts-20020429/php_wikidiff.so

%changelog
* Fri Sep 16 2005 Brion Vibber <brion@pobox.com>
- Including SWIG-generated files in source for easier building on FC2 (rev 2).
* Mon Sep 12 2005 Brion Vibber <brion@pobox.com>
- Initial packaging.

