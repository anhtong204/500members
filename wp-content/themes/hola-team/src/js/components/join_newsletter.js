/* global holaTeamJoinAjax, grecaptcha */
jQuery(document).ready(function ($) {
  if ($('#join-newsletter-form').length === 0) {
    return;
  }

  $('#join-newsletter-form').on('submit', function (e) {
    e.preventDefault();
        
    var $form = $(this);
    var $submitBtn = $('#join-submit-btn');
    var $btnText = $submitBtn.find('.btn-text');
    var $spinner = $submitBtn.find('.spinner-border');
    var $message = $('#join-newsletter-message');
    var email = $('#join-email').val();

    if (!email) {
      return;
    }

    // loading state
    $submitBtn.prop('disabled', true);
    $btnText.addClass('d-none');
    $spinner.removeClass('d-none');
    $message.hide().removeClass('text-success text-danger').text('');

    if (typeof grecaptcha !== 'undefined' && holaTeamJoinAjax.recaptchaSiteKey) {
      grecaptcha.ready(function () {
        grecaptcha.execute(holaTeamJoinAjax.recaptchaSiteKey, { action: 'submit' }).then(function (token) {
          $('#join_recaptcha_token').val(token);
          submitJoinForm($form, $submitBtn, $btnText, $spinner, $message);
        });
      });
    } else {
      submitJoinForm($form, $submitBtn, $btnText, $spinner, $message);
    }
  });

  function submitJoinForm($form, $submitBtn, $btnText, $spinner, $message) {
    var formData = $form.serializeArray();
    formData.push({ name: 'action', value: 'submit_join' });

    $.ajax({
      url: holaTeamJoinAjax.url,
      type: 'POST',
      data: $.param(formData),
      success: function (response) {
        $submitBtn.prop('disabled', false);
        $spinner.addClass('d-none');
        $btnText.removeClass('d-none');

        if (response.success) {
          $form[0].reset();
          $message.addClass('text-success').text(response.data).fadeIn();
          setTimeout(function() {
            $message.fadeOut();
          }, 5000);
        } else {
          $message.addClass('text-danger').text(response.data).fadeIn();
        }
      },
      error: function () {
        $submitBtn.prop('disabled', false);
        $spinner.addClass('d-none');
        $btnText.removeClass('d-none');
        $message.addClass('text-danger').text('An error occurred. Please try again.').fadeIn();
      }
    });
  }
});
