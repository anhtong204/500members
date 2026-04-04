(function($) {
  const initializeTraining = function( block ) {
    const $section = block.hasClass('component-training') ? block : block.find('.component-training');
    const $buttons = $section.find('.training-filter');
    const $items = $section.find('.training-item');

    const filterItems = function( category ) {
      $items.each(function() {
        const $item = $(this);
        const itemCategories = $item.data('category') ? String($item.data('category')).split(' ') : [];
        const show = category === 'all' || itemCategories.indexOf(category) !== -1;
        $item.toggle(show);
      });
    };

    $buttons.on('click', function() {
      const $button = $(this);
      $buttons.removeClass('active');
      $button.addClass('active');
      filterItems($button.data('category'));
    });
  };

  $(document).ready(function() {
    $('.component-training').each(function() {
      initializeTraining($(this));
    });
  });
})(jQuery);
