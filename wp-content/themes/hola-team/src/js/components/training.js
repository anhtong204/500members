(function($) {
  const initializeTraining = function( block ) {
    const $section = block.hasClass('component-training') ? block : block.find('.component-training');
    const $buttons = $section.find('.training-filter');
    const $items = $section.find('.training-item');
    const $searchInput = $section.find('.training-search-input');

    let activeCategory = 'all';
    let searchQuery = '';

    const applyFilters = function() {
      $items.each(function() {
        const $item = $(this);
        const itemCategories = $item.data('category') ? String($item.data('category')).split(' ') : [];
        const matchesCategory = activeCategory === 'all' || itemCategories.indexOf(activeCategory) !== -1;

        const itemTitle = $item.find('.training-card-title').text().toLowerCase();
        const matchesSearch = searchQuery === '' || itemTitle.indexOf(searchQuery) !== -1;

        $item.toggle(matchesCategory && matchesSearch);
      });
    };

    $buttons.on('click', function() {
      const $button = $(this);
      $buttons.removeClass('active');
      $button.addClass('active');
      activeCategory = $button.data('category');
      applyFilters();
    });

    $searchInput.on('input', function() {
      searchQuery = $(this).val().toLowerCase().trim();
      applyFilters();
    });
  };

  $(document).ready(function() {
    $('.component-training').each(function() {
      initializeTraining($(this));
    });
  });
})(jQuery);
