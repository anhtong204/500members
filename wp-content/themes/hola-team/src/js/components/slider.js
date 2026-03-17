import 'slick-carousel/slick/slick.min';

const initializeBlock = function( block ) {
    const settings = block.find('.holateam-slides').data('settings');
    const defaults = {
        dots: false,
        speed: 300,
        slidesToShow: 1,
        arrows: false,
        fade: true,
        cssEase: 'linear',
    }

    const slider = block.find('.holateam-slides').slick(Object.assign(defaults, settings));

    block.find('.prev').on('click', function() {
        slider.slick('slickPrev');
    } )

    block.find('.next').on('click', function() {
        slider.slick('slickNext');
    } ) 
}

// Initialize each block on page load (front end).
jQuery(document).ready(function($) {
    $('.component-slider').each(function() {
        initializeBlock($(this));
    });
})
