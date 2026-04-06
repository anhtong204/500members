(function($) {
  const initializeBenefitsEarnings = function( block ) {
    const $section = block.hasClass('component-benefits_earnings') ? block : block.find('.component-benefits_earnings');
    const $slider = $section.find('.benefits-range-input');
    const $stateSelect = $section.find('.earnings-card-select select');
    const $amount = $section.find('.earnings-value-amount');

    if ( ! $slider.length || ! $amount.length || ! $stateSelect.length ) {
      return;
    }

    const minValue = parseInt( $slider.attr('min') || 100, 10 );
    const maxValue = parseInt( $slider.attr('max') || 500, 10 );

    const formatCurrency = function( value ) {
      return '$' + value.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    };

    const getSelectedRate = function() {
      const rate = parseFloat( $stateSelect.find(':selected').data('rate') );
      return isNaN( rate ) ? 2891.66 : rate;
    };

    const updateValue = function( value ) {
      const rate = getSelectedRate();
      const amount = rate * ( value / 100 );
      $amount.text( formatCurrency( amount ) );
    };

    $slider.on('input change', function() {
      updateValue( parseInt( $(this).val(), 10 ) );
    });

    $stateSelect.on('change', function() {
      updateValue( parseInt( $slider.val(), 10 ) );
    });

    updateValue( parseInt( $slider.val(), 10 ) );
  };

  $(document).ready(function() {
    $('.component-benefits_earnings').each(function() {
      initializeBenefitsEarnings( $(this) );
    });
  });
})(jQuery);
