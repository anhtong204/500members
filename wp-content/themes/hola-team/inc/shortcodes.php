<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

add_shortcode('year', 'year_shortcode');
function year_shortcode()
{
    return date('Y');
}

function site_social()
{
    ob_start();
    ?>
    <?php if (have_rows('social_media', 'option')): ?>
        <ul class="social-media-list list-inline">
            <?php while (have_rows('social_media', 'option')):
                the_row(); ?>
                <?php
                $channel = get_sub_field('social_media_channel');
                $icon = get_sub_field('social_media_fa_icon');
                $url = get_sub_field('social_media_url');
                ?>
                <li class="social-media-item list-inline-item">
                    <a target="_blank" href="<?php echo $url; ?>" class="channel-<?php echo $channel; ?>">
                        <?php if ($icon != ''): ?>
                            <span class='<?php echo $icon; ?>'></span>
                        <?php else: ?>
                            <i class='fa fa-<?php echo $channel; ?>'></i>
                        <?php endif; ?>
                    </a>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php endif; ?>

    <?php
    return ob_get_clean();
}
add_shortcode('site_social', 'site_social');

function hola_team_survey_shortcode()
{
    $recaptcha_site_key = get_field('recaptcha_site_key', 'option');
    ob_start();
    ?>
    <script>
        var holaTeamAjax = {
            url: '<?php echo admin_url("admin-ajax.php"); ?>',
            recaptchaSiteKey: '<?php echo esc_js($recaptcha_site_key); ?>'
        };
    </script>
    <?php if ($recaptcha_site_key): ?>
        <script src="https://www.google.com/recaptcha/api.js?render=<?php echo esc_attr($recaptcha_site_key); ?>"></script>
    <?php endif; ?>
    <?php
    include(locate_template("components/survey/default.php"));
    return ob_get_clean();
}
add_shortcode('survey', 'hola_team_survey_shortcode');

add_action('wp_ajax_submit_survey', 'hola_team_submit_survey');
add_action('wp_ajax_nopriv_submit_survey', 'hola_team_submit_survey');

function hola_team_submit_survey()
{
    $recipient_email = get_field('survey_recipient_email', 'option');
    if (empty($recipient_email)) {
        $recipient_email = get_option('admin_email');
    }

    // reCAPTCHA v3 verification
    $recaptcha_secret = get_field('recaptcha_secret_key', 'option');
    if ($recaptcha_secret) {
        $recaptcha_token = isset($_POST['recaptcha_token']) ? sanitize_text_field($_POST['recaptcha_token']) : '';

        if (empty($recaptcha_token)) {
            error_log('[Survey reCAPTCHA] Token is empty. POST keys: ' . implode(', ', array_keys($_POST)));
            wp_send_json_error('reCAPTCHA token was not sent. Please refresh the page and try again.');
            wp_die();
        }

        $verify_response = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', array(
            'body' => array(
                'secret' => $recaptcha_secret,
                'response' => $recaptcha_token
            ),
        ));

        if (is_wp_error($verify_response)) {
            error_log('[Survey reCAPTCHA] API request error: ' . $verify_response->get_error_message());
            wp_send_json_error('Could not connect to reCAPTCHA server. Error: ' . $verify_response->get_error_message());
            wp_die();
        }

        $verify_body = json_decode(wp_remote_retrieve_body($verify_response), true);
        error_log('[Survey reCAPTCHA] Google response: ' . wp_remote_retrieve_body($verify_response));

        if (empty($verify_body['success'])) {
            $error_codes = isset($verify_body['error-codes']) ? implode(', ', $verify_body['error-codes']) : 'none';
            wp_send_json_error('reCAPTCHA validation failed. Error codes: ' . $error_codes);
            wp_die();
        }

        if (isset($verify_body['score']) && $verify_body['score'] < 0.5) {
            wp_send_json_error('reCAPTCHA score too low (' . $verify_body['score'] . '). You may be a bot.');
            wp_die();
        }
    }

    $subject = 'New Survey Submission';

    $legal_name = isset($_POST['legal_name']) ? sanitize_text_field($_POST['legal_name']) : '';
    $dob = isset($_POST['dob']) ? sanitize_text_field($_POST['dob']) : '';
    $npn = isset($_POST['npn']) ? sanitize_text_field($_POST['npn']) : '';
    $state = isset($_POST['state_licensed']) ? sanitize_text_field($_POST['state_licensed']) : '';

    $ssn = isset($_POST['ssn']) ? sanitize_text_field($_POST['ssn']) : '';
    $phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';

    $carriers = isset($_POST['carriers']) ? sanitize_textarea_field($_POST['carriers']) : '';

    // Process Interests (Array)
    $interests = isset($_POST['interests']) && is_array($_POST['interests']) ? array_map('sanitize_text_field', $_POST['interests']) : array();
    $interests_str = !empty($interests) ? implode(', ', $interests) : 'None selected';

    // Address fields
    $address = isset($_POST['address']) ? sanitize_text_field($_POST['address']) : '';
    $address_2 = isset($_POST['address_2']) ? sanitize_text_field($_POST['address_2']) : '';
    $city = isset($_POST['city']) ? sanitize_text_field($_POST['city']) : '';
    $address_state = isset($_POST['address_state']) ? sanitize_text_field($_POST['address_state']) : '';
    $zipcode = isset($_POST['zipcode']) ? sanitize_text_field($_POST['zipcode']) : '';

    // Validate required fields
    $required = array(
        'Legal Name' => $legal_name,
        'Date of birth' => $dob,
        'NPN' => $npn,
        'State licensed' => $state,
        'Social Security number' => $ssn,
        'Phone number' => $phone,
        'Email' => $email,
        'Address' => $address,
        'City' => $city,
        'State' => $address_state,
        'Zip code' => $zipcode,
    );

    $missing = array();
    foreach ($required as $label => $value) {
        if (empty($value)) {
            $missing[] = $label;
        }
    }

    if (!empty($missing)) {
        wp_send_json_error('Missing required fields: ' . implode(', ', $missing));
        wp_die();
    }

    $message = "You have received a new survey submission:\n\n";
    $message .= "Legal Name: $legal_name\n";
    $message .= "Date of birth: $dob\n";
    $message .= "NPN: $npn\n";
    $message .= "State licensed: $state\n";
    $message .= "Social Security number: $ssn\n";
    $message .= "Phone number: $phone\n";
    $message .= "Email: $email\n";
    $message .= "Insurance carriers: $carriers\n";
    $message .= "Interests: $interests_str\n\n";
    $message .= "--- Address ---\n";
    $message .= "Address: $address\n";
    if (!empty($address_2)) {
        $message .= "Address 2: $address_2\n";
    }
    $message .= "City: $city\n";
    $message .= "State: $address_state\n";
    $message .= "Zip Code: $zipcode\n";

    $headers = array('Content-Type: text/plain; charset=UTF-8');
    if ($email) {
        $headers[] = 'Reply-To: ' . $email;
    }

    $sent = wp_mail($recipient_email, $subject, $message, $headers);

    if ($sent) {
        wp_send_json_success('Survey submitted successfully.');
    } else {
        wp_send_json_error('Failed to send survey.');
    }
    wp_die();
}

function hola_team_join_newsletter_shortcode()
{
    $recaptcha_site_key = get_field('recaptcha_site_key', 'option');
    ob_start();
    ?>
    <script>
        var holaTeamJoinAjax = {
            url: '<?php echo admin_url("admin-ajax.php"); ?>',
            recaptchaSiteKey: '<?php echo esc_js($recaptcha_site_key); ?>'
        };
    </script>
    <?php if ($recaptcha_site_key): ?>
        <script src="https://www.google.com/recaptcha/api.js?render=<?php echo esc_attr($recaptcha_site_key); ?>"></script>
    <?php endif; ?>
    <?php
    include(locate_template("components/join_newsletter/default.php"));
    return ob_get_clean();
}
add_shortcode('join_newsletter', 'hola_team_join_newsletter_shortcode');

add_action('wp_ajax_submit_join', 'hola_team_submit_join');
add_action('wp_ajax_nopriv_submit_join', 'hola_team_submit_join');

function hola_team_submit_join()
{
    $recipient_email = get_field('survey_recipient_email', 'option');
    if (empty($recipient_email)) {
        $recipient_email = get_option('admin_email');
    }

    // reCAPTCHA v3 verification
    $recaptcha_secret = get_field('recaptcha_secret_key', 'option');
    if ($recaptcha_secret) {
        $recaptcha_token = isset($_POST['recaptcha_token']) ? sanitize_text_field($_POST['recaptcha_token']) : '';

        if (empty($recaptcha_token)) {
            wp_send_json_error('reCAPTCHA token was not sent. Please refresh the page and try again.');
            wp_die();
        }

        $verify_response = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', array(
            'body' => array(
                'secret' => $recaptcha_secret,
                'response' => $recaptcha_token
            ),
        ));

        if (is_wp_error($verify_response)) {
            wp_send_json_error('Could not connect to reCAPTCHA server. Error: ' . $verify_response->get_error_message());
            wp_die();
        }

        $verify_body = json_decode(wp_remote_retrieve_body($verify_response), true);

        if (empty($verify_body['success'])) {
            $error_codes = isset($verify_body['error-codes']) ? implode(', ', $verify_body['error-codes']) : 'none';
            wp_send_json_error('reCAPTCHA validation failed. Error codes: ' . $error_codes);
            wp_die();
        }

        if (isset($verify_body['score']) && $verify_body['score'] < 0.5) {
            wp_send_json_error('reCAPTCHA score too low. You may be a bot.');
            wp_die();
        }
    }

    $subject = 'New Slack Join Request';
    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';

    if (empty($email)) {
        wp_send_json_error('Email is required.');
        wp_die();
    }

    $message = "You have received a new newsletter join request:\n\n";
    $message .= "Email: $email\n";

    $headers = array('Content-Type: text/plain; charset=UTF-8');
    $headers[] = 'Reply-To: ' . $email;

    $sent = wp_mail($recipient_email, $subject, $message, $headers);

    if ($sent) {
        wp_send_json_success('Successfully joined.');
    } else {
        wp_send_json_error('Failed to send request.');
    }
    wp_die();
}
