import 'slick-carousel/slick/slick.min';

const initializeTestimonials = function( block ) {
  const settings = block.data('settings') || {};
  const defaults = {
    dots: false,
    arrows: false,
    infinite: true,
    speed: 600,
    slidesToShow: 3,
    slidesToScroll: 3,
    responsive: [
      {
        breakpoint: 992,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
        },
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
        },
      },
    ],
  };

  block.slick(jQuery.extend(true, {}, defaults, settings));
};

jQuery(document).ready(function($) {
  $('.holateam-testimonials').each(function() {
    initializeTestimonials($(this));
  });
});
