define( 'ext.wikia.AffiliateService.templates', [], function() { 
    'use strict'; 

    function unit(options) {
        return '<div class="affiliate-unit__wrapper">'
            + '<div class="affiliate-unit__image-wrapper" style="background-image: url(' + options.image + ')"></div>'
            + '<div class="affiliate-unit__info">'
            + '<p class="affiliate-unit__header">' + options.heading + '</p>'
            + '<a href="' + options.link + '" class="wds-button wds-is-secondary affiliate-unit__cta" target="_blank">' + options.buttonText + '</a>'
            + '<img class="affiliate-unit__logo light" src="' + options.logoLight + '">'
            + '<img class="affiliate-unit__logo dark" src="' + options.logoDark + '">'
            + '</div>'
            + '</div>';
    }
    
    return {
        unit: unit,
    }; 
});
