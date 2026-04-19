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

  // Sidebar accordion + client-side category filtering
  function initListingSidebar($layout) {
    var $wrapper = $layout.find('.training-listing-wrapper');
    if (!$wrapper.length) return;

    var $items = $layout.find('.training-item');
    var isArchivePage = $layout.closest('.component-training').length === 0;

    // Filter cards by category slug
    function filterByCategory(slug) {
      if (!slug || slug === 'all') {
        $items.show();
      } else {
        $items.each(function() {
          var $item = $(this);
          var cats = $item.data('category') ? String($item.data('category')).split(' ') : [];
          $item.toggle(cats.indexOf(slug) !== -1);
        });
      }
    }

    // Set active state on sidebar categories (both desktop & mobile)
    function setActiveCategory(slug) {
      $layout.find('.training-sidebar-category').removeClass('active');
      $layout.find('.training-sidebar-category-btn').removeClass('active');

      if (slug) {
        $layout.find('.training-sidebar-category[data-term="' + slug + '"]').addClass('active');
        $layout.find('.training-sidebar-category[data-term="' + slug + '"] > .training-sidebar-category-btn').addClass('active');
      }
    }

    // Accordion: init visibility
    function initAccordion($container) {
      $container.find('.training-sidebar-lessons').hide();

      // Open active category or first
      var $activeCat = $container.find('.training-sidebar-category.active').first();
      if (!$activeCat.length) {
        $activeCat = $container.find('.training-sidebar-category').first();
      }
      if ($activeCat.length) {
        $activeCat.addClass('active');
        $activeCat.find('.training-sidebar-lessons').show();
      }
    }

    // Handle category link click: filter + pushState + accordion
    function bindCategoryClicks($container) {
      $container.find('.training-sidebar-category-btn').on('click', function(e) {
        e.preventDefault();

        var $link = $(this);
        var $category = $link.closest('.training-sidebar-category');
        var slug = $category.data('term');
        var url = $link.attr('href');
        var isActive = $category.hasClass('active');

        // Accordion: close all, toggle clicked
        $container.find('.training-sidebar-category').removeClass('active');
        $container.find('.training-sidebar-lessons').slideUp(200);

        if (!isActive) {
          $category.addClass('active');
          $category.find('.training-sidebar-lessons').slideDown(200);
        }

        // On listing component page: filter cards + pushState
        if (!isArchivePage) {
          setActiveCategory(slug);
          filterByCategory(slug);

          // Update URL without reload
          if (url && window.history.pushState) {
            window.history.pushState({ category: slug }, '', url);
          }
        } else {
          // On archive page: navigate to the category page
          window.location.href = url;
        }
      });
    }

    // Desktop sidebar
    var $sidebar = $wrapper.find('.training-sidebar');
    if ($sidebar.length) {
      initAccordion($sidebar);
      bindCategoryClicks($sidebar);
    }

    // Mobile modal
    var $mobileModal = $wrapper.find('.training-mobile-modal');
    if ($mobileModal.length) {
      initAccordion($mobileModal);
      bindCategoryClicks($mobileModal);

      // Open modal
      $wrapper.find('.training-mobile-trigger').on('click', function() {
        $mobileModal.addClass('show');
        $('body').css('overflow', 'hidden');
      });

      // Close modal: close button
      $mobileModal.find('.training-mobile-modal-close').on('click', function() {
        $mobileModal.removeClass('show');
        $('body').css('overflow', '');
      });

      // Close modal: click on backdrop
      $mobileModal.on('click', function(e) {
        if ($(e.target).is('.training-mobile-modal')) {
          $mobileModal.removeClass('show');
          $('body').css('overflow', '');
        }
      });
    }

    // Handle browser back/forward
    if (!isArchivePage) {
      $(window).on('popstate', function(e) {
        var state = e.originalEvent.state;
        if (state && state.category) {
          setActiveCategory(state.category);
          filterByCategory(state.category);
        } else {
          // Reset to show all
          setActiveCategory('all');
          filterByCategory('all');
        }
      });
    }
  }

  // Detail page sidebar (accordion + mobile modal, links navigate)
  function initDetailSidebar($layout) {
    var $wrapper = $layout.find('.training-detail-wrapper');
    if (!$wrapper.length) return;

    function initDetailAccordion($container) {
      $container.find('.training-sidebar-lessons').hide();

      // Auto-open active category
      var $activeCat = $container.find('.training-sidebar-category.active').first();
      if ($activeCat.length) {
        $activeCat.find('.training-sidebar-lessons').show();
      }

      // Toggle accordion on category click, then navigate to category page
      $container.find('.training-sidebar-category-btn').on('click', function(e) {
        e.preventDefault();
        var $link = $(this);
        var $category = $link.closest('.training-sidebar-category');
        var $lessons = $category.find('.training-sidebar-lessons');
        var url = $link.attr('href');
        var isActive = $category.hasClass('active');

        // Toggle accordion
        $container.find('.training-sidebar-category').removeClass('active');
        $container.find('.training-sidebar-lessons').slideUp(200);

        if (!isActive) {
          $category.addClass('active');
          if ($lessons.length) {
            $lessons.slideDown(200);
          }
        }

        // "All lessons" → full navigation; categories → pushState only
        if (url) {
          if ($category.data('term') === 'all') {
            window.location.href = url;
          } else if (window.history.pushState) {
            window.history.pushState({ category: $category.data('term') }, '', url);
          }
        }
      });
    }

    // Desktop sidebar
    var $sidebar = $wrapper.find('.training-sidebar');
    if ($sidebar.length) {
      initDetailAccordion($sidebar);
    }

    // Mobile modal
    var $mobileModal = $wrapper.find('.training-mobile-modal');
    if ($mobileModal.length) {
      initDetailAccordion($mobileModal);

      $wrapper.find('.training-mobile-trigger').on('click', function() {
        $mobileModal.addClass('show');
        $('body').css('overflow', 'hidden');
      });

      $mobileModal.find('.training-mobile-modal-close').on('click', function() {
        $mobileModal.removeClass('show');
        $('body').css('overflow', '');
      });

      $mobileModal.on('click', function(e) {
        if ($(e.target).is('.training-mobile-modal')) {
          $mobileModal.removeClass('show');
          $('body').css('overflow', '');
        }
      });
    }

    // Mark done lessons in sidebar from cookie
    markDoneInSidebar($layout);

    // Done button
    $layout.find('.training-done-btn').on('click', function() {
      var $btn = $(this);
      var postId = String($btn.data('post-id'));
      var completed = getCompletedTrainings();

      if (completed.indexOf(postId) === -1) {
        completed.push(postId);
        saveCompletedTrainings(completed);
        $btn.addClass('is-done');
        $btn.find('.training-done-text').text('Done');
      }

      markDoneInSidebar($layout);
    });

    // Check if current post is already done on load
    var $doneBtn = $layout.find('.training-done-btn');
    if ($doneBtn.length) {
      var currentId = String($doneBtn.data('post-id'));
      var done = getCompletedTrainings();
      if (done.indexOf(currentId) !== -1) {
        $doneBtn.addClass('is-done');
        $doneBtn.find('.training-done-text').text('Done');
      }
    }
  }

  // Cookie helpers
  function getCompletedTrainings() {
    var match = document.cookie.match(/(?:^|;\s*)training_done=([^;]*)/);
    if (match) {
      try {
        return JSON.parse(decodeURIComponent(match[1]));
      } catch (e) {
        return [];
      }
    }
    return [];
  }

  function saveCompletedTrainings(arr) {
    var expires = new Date();
    expires.setFullYear(expires.getFullYear() + 1);
    document.cookie = 'training_done=' + encodeURIComponent(JSON.stringify(arr)) +
      ';expires=' + expires.toUTCString() +
      ';path=/;SameSite=Lax';
  }

  function markDoneInSidebar($context) {
    var completed = getCompletedTrainings();
    $context.find('.training-sidebar-lesson[data-post-id]').each(function() {
      var $lesson = $(this);
      var pid = String($lesson.data('post-id'));
      if (completed.indexOf(pid) !== -1) {
        $lesson.addClass('is-done');
      }
    });
  }

  $(document).ready(function() {
    // Default layout (component)
    $('.component-training').each(function() {
      initializeTraining($(this));
    });

    // Listing layout (component & archive page)
    $('.training-listing-layout').each(function() {
      initListingSidebar($(this));
      markDoneInSidebar($(this));
    });

    // Detail layout (single training page)
    $('.training-detail-layout').each(function() {
      initDetailSidebar($(this));
    });
  });
})(jQuery);
