const initializeFaq = function( block ) {
  // `block` is expected to be the root .component-faq element.
  // If it's a wrapper, locate the inner component.
  const $faq = block.hasClass('component-faq') ? block : block.find('.component-faq');

  $faq.find('.faq-question').on('click', function() {
    const $button = jQuery(this);
    const $item = $button.closest('.faq-item');
    const isOpen = $item.hasClass('open');

    // Close all other items
    $item.siblings('.faq-item').removeClass('open').find('.faq-question').attr('aria-expanded', 'false');
    $item.siblings('.faq-item').find('.faq-answer').attr('aria-hidden', 'true');

    // Toggle current
    if ( isOpen ) {
      $item.removeClass('open');
      $button.attr('aria-expanded', 'false');
      $item.find('.faq-answer').attr('aria-hidden', 'true');
    } else {
      $item.addClass('open');
      $button.attr('aria-expanded', 'true');
      $item.find('.faq-answer').attr('aria-hidden', 'false');
    }
  });
};

jQuery(document).ready(function($) {
  $('.component-faq').each(function() {
    initializeFaq($(this));
  });
});
