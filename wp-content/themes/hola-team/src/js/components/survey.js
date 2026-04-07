/* eslint-disable */
(function($) {
  $(document).ready(function() {
    if (!$('.survey-component-wrapper').length) return;

    // Open modal and show target step
    $('.survey-btn-choice').on('click', function(e) {
      e.preventDefault();
      const target = $(this).data('target');
            
      // Hide all steps in modal
      $('.survey-step-content').hide();
            
      // Show the target step
      $('#' + target).fadeIn(300);
            
      // Show Modal
      $('#survey-modal').addClass('show');
    });

    function updateHasInputClass($field) {
      var $group = $field.closest('.survey-form-group');
      if (!$group.length) return;

      var value = $field.val();
      var hasInput = $field.is('select') ? value !== '' && value !== null : $.trim(value).length > 0;

      $group.toggleClass('has-input', hasInput);
    }

    function attachHasInputListeners() {
      $('#survey-modal').find('input, select, textarea').each(function() {
        var $field = $(this);
        var eventType = $field.is('select') ? 'change' : 'input';

        $field.on(eventType, function() {
          updateHasInputClass($field);
        });

        updateHasInputClass($field);
      });
    }

    attachHasInputListeners();

    // Next button logic
    $('.survey-btn-next').on('click', function(e) {
      const nextTarget = $(this).data('next');
      const currentStep = $(this).closest('.survey-step-content');
      
      // HTML5 Validation for the current step
      let isValid = true;
      currentStep.find('input, select, textarea').each(function() {
        if (this.hasAttribute('required') && !this.checkValidity()) {
          this.reportValidity();
          isValid = false;
          return false; // Break the each loop
        }
      });
      
      if (!isValid) return;
            
      if (nextTarget === 'submit') {
        // Handled by the form's submit event
        return;
      } else if (nextTarget) {
        e.preventDefault();
        $('.survey-step-content').hide();
        $('#' + nextTarget).fadeIn(300);
      }
    });

    // Form submission logic
    $('#survey-form').on('submit', function(e) {
      e.preventDefault();
      
      var $form = $(this);
      var $submitBtn = $form.find('.survey-btn-submit');
      var originalText = $submitBtn.text();
      
      $submitBtn.text('Sending...').prop('disabled', true);

      var siteKey = (typeof holaTeamAjax !== 'undefined') ? holaTeamAjax.recaptchaSiteKey : '';

      function sendForm(token) {
        var formData = $form.serialize();
        if (token) {
          formData += '&recaptcha_token=' + encodeURIComponent(token);
        }

        $.ajax({
          type: 'POST',
          url: typeof holaTeamAjax !== 'undefined' ? holaTeamAjax.url : '/wp-admin/admin-ajax.php',
          data: formData,
          success: function(response) {
            if (response.success) {
              $form.find('.survey-step-content').hide();
              $form[0].reset();
              attachHasInputListeners();
              $submitBtn.text(originalText).prop('disabled', false);
              $('#survey-step-success').fadeIn(300);
            } else {
              alert('Error: ' + (response.data || 'Something went wrong.'));
              $submitBtn.text(originalText).prop('disabled', false);
            }
          },
          error: function() {
            alert('Error connecting to the server. Please try again.');
            $submitBtn.text(originalText).prop('disabled', false);
          }
        });
      }

      if (siteKey) {
        // Wait for grecaptcha to load (it loads async via the API script)
        function waitForRecaptcha(attempts) {
          if (typeof grecaptcha !== 'undefined' && grecaptcha.ready) {
            grecaptcha.ready(function() {
              grecaptcha.execute(siteKey, { action: 'submit_survey' }).then(function(token) {
                sendForm(token);
              }).catch(function(err) {
                console.error('reCAPTCHA execute error:', err);
                alert('reCAPTCHA failed. Please try again.');
                $submitBtn.text(originalText).prop('disabled', false);
              });
            });
          } else if (attempts > 0) {
            setTimeout(function() { waitForRecaptcha(attempts - 1); }, 300);
          } else {
            console.error('reCAPTCHA API failed to load');
            alert('reCAPTCHA could not load. Please refresh and try again.');
            $submitBtn.text(originalText).prop('disabled', false);
          }
        }
        waitForRecaptcha(10);
      } else {
        sendForm(null);
      }
    });

    // Close modal when clicking outside of dialog
    $('#survey-modal').on('click', function(e) {
      if ($(e.target).is('#survey-modal')) {
        $(this).removeClass('show');
      }
    });
        
    // Optional: Close modal on Esc key
    $(document).on('keydown', function(e) {
      if (e.key === 'Escape' && $('#survey-modal').hasClass('show')) {
        $('#survey-modal').removeClass('show');
      }
    });
  });
})(jQuery);
