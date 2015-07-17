var PortableInfoboxModal = {
    init: function () {
        $('.wikia-button[data-id=edit]').on('click', function (event) {
            event.preventDefault();
            alert('You want to use a new portable infobox tool!');
        });
    }
};

$(function () {
    PortableInfoboxModal.init();
});
