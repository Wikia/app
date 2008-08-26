Summary: PHP extension and standalone application to do fast word-level diffs
Name: wikidiff2
Version: VERSION
Release: 2
License: GPL
Group: Applications/Internet
Source: wikidiff2-VERSION.tar.gz
BuildRoot: /var/tmp/%{name}-buildroot

%description
PHP extension and standalone application to do fast word-level diffs.
(Packaged for Wikimedia local use!)

%prep
%setup -q

%build
make

%install
rm -rf $RPM_BUILD_ROOT
INSTALL_TARGET="$RPM_BUILD_ROOT" make install

%clean
rm -rf $RPM_BUILD_ROOT

%files
%defattr(-,root,root)
%dir /usr/local/lib/php/extensions/no-debug-non-zts-20060613

/usr/local/lib/php/extensions/no-debug-non-zts-20060613/php_wikidiff2.so

