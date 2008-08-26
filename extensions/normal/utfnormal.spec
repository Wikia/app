Summary: PHP extension to use ICU library to do stuff
Name: utfnormal
Version: 0.0.1
Release: 2
Copyright: MIT
Group: Applications/Internet
Source: utfnormal-0.0.1.tar.gz
BuildRoot: /var/tmp/%{name}-buildroot
Requires: icu
BuildRequires: swig

%description
PHP extension to use ICU library for UTF-8 normalization.
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

/usr/local/lib/php/extensions/no-debug-non-zts-20020429/php_utfnormal.so

%changelog
* Fri Sep 16 2005 Brion Vibber <brion@pobox.com>
- Including SWIG-generated files in source for easier building on FC2 (rev 2).
* Mon Sep 12 2005 Brion Vibber <brion@pobox.com>
- Initial packaging.

