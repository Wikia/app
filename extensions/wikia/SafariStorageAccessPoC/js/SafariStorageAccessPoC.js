var SafariStorageAccessPoC = {
    setTestCookie: function(name, domain, expires) {
        document.cookie = name + "=1; expires=" + expires + "; path=/; domain="+domain+"; secure";
        alert('Cookie set!');
    }
};
