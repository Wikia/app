define( 'ext.wikia.AffiliateService.templates', [], function() { 
    'use strict'; 

    function unit(options) {
        return '<div class="affiliate-unit__wrapper">'
            + '<a class="affiliate-unit__link" href="' + options.link + '" target="_blank">'
            + '<div class="affiliate-unit__image-wrapper" style="background-image: url(' + options.image + ')"></div>'
            + '<div class="affiliate-unit__info">'
            + '<p class="affiliate-unit__header">' + options.heading + '</p>'
            + '<button class="wds-button wds-is-secondary affiliate-unit__cta">' + options.buttonText + '</button>'
            + '<img class="affiliate-unit__logo light" src="' + options.logoLight + '">'
            + '<img class="affiliate-unit__logo dark" src="' + options.logoDark + '">'
            + '</div>'
            + '</a>'
            + '</div>';
    }
    
    return {
        unit: unit,
    }; 
});
