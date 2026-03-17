<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package holateam
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

add_filter( 'body_class', 'holateam_body_classes' );

if ( ! function_exists( 'holateam_body_classes' ) ) {
	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 *
	 * @return array
	 */
	function holateam_body_classes( $classes ) {
		// Adds a class of group-blog to blogs with more than 1 published author.
		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}
		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}

		return $classes;
	}
}

if ( function_exists( 'holateam_adjust_body_class' ) ) {
	/*
	 * holateam_adjust_body_class() deprecated in v0.9.4. We keep adding the
	 * filter for child themes which use their own holateam_adjust_body_class.
	 */
	add_filter( 'body_class', 'holateam_adjust_body_class' );
}

// Filter custom logo with correct classes.
add_filter( 'get_custom_logo', 'holateam_change_logo_class' );

if ( ! function_exists( 'holateam_change_logo_class' ) ) {
	/**
	 * Replaces logo CSS class.
	 *
	 * @param string $html Markup.
	 *
	 * @return string
	 */
	function holateam_change_logo_class( $html ) {

		$html = str_replace( 'class="custom-logo"', 'class="img-fluid"', $html );
		$html = str_replace( 'class="custom-logo-link"', 'class="navbar-brand custom-logo-link"', $html );
		$html = str_replace( 'alt=""', 'title="Home" alt="logo"', $html );

		return $html;
	}
}

if ( ! function_exists( 'holateam_pingback' ) ) {
	/**
	 * Add a pingback url auto-discovery header for single posts of any post type.
	 */
	function holateam_pingback() {
		if ( is_singular() && pings_open() ) {
			echo '<link rel="pingback" href="' . esc_url( get_bloginfo( 'pingback_url' ) ) . '">' . "\n";
		}
	}
}
add_action( 'wp_head', 'holateam_pingback' );

if ( ! function_exists( 'holateam_mobile_web_app_meta' ) ) {
	/**
	 * Add mobile-web-app meta.
	 */
	function holateam_mobile_web_app_meta() {
		echo '<meta name="mobile-web-app-capable" content="yes">' . "\n";
		echo '<meta name="apple-mobile-web-app-capable" content="yes">' . "\n";
		echo '<meta name="apple-mobile-web-app-title" content="' . esc_attr( get_bloginfo( 'name' ) ) . ' - ' . esc_attr( get_bloginfo( 'description' ) ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'holateam_mobile_web_app_meta' );

if ( ! function_exists( 'holateam_default_body_attributes' ) ) {
	/**
	 * Adds schema markup to the body element.
	 *
	 * @param array $atts An associative array of attributes.
	 * @return array
	 */
	function holateam_default_body_attributes( $atts ) {
		$atts['itemscope'] = '';
		$atts['itemtype']  = 'http://schema.org/WebSite';
		return $atts;
	}
}
add_filter( 'holateam_body_attributes', 'holateam_default_body_attributes' );

// Escapes all occurances of 'the_archive_description'.
add_filter( 'get_the_archive_description', 'holateam_escape_the_archive_description' );

if ( ! function_exists( 'holateam_escape_the_archive_description' ) ) {
	/**
	 * Escapes the description for an author or post type archive.
	 *
	 * @param string $description Archive description.
	 * @return string Maybe escaped $description.
	 */
	function holateam_escape_the_archive_description( $description ) {
		if ( is_author() || is_post_type_archive() ) {
			return wp_kses_post( $description );
		}

		/*
		 * All other descriptions are retrieved via term_description() which returns
		 * a sanitized description.
		 */
		return $description;
	}
} // End of if function_exists( 'holateam_escape_the_archive_description' ).

// Escapes all occurances of 'the_title()' and 'get_the_title()'.
add_filter( 'the_title', 'holateam_kses_title' );

// Escapes all occurances of 'the_archive_title' and 'get_the_archive_title()'.
add_filter( 'get_the_archive_title', 'holateam_kses_title' );

if ( ! function_exists( 'holateam_kses_title' ) ) {
	/**
	 * Sanitizes data for allowed HTML tags for post title.
	 *
	 * @param string $data Post title to filter.
	 * @return string Filtered post title with allowed HTML tags and attributes intact.
	 */
	function holateam_kses_title( $data ) {
		// Tags not supported in HTML5 are not allowed.
		$allowed_tags = array(
			'abbr'             => array(),
			'aria-describedby' => true,
			'aria-details'     => true,
			'aria-label'       => true,
			'aria-labelledby'  => true,
			'aria-hidden'      => true,
			'b'                => array(),
			'bdo'              => array(
				'dir' => true,
			),
			'blockquote'       => array(
				'cite'     => true,
				'lang'     => true,
				'xml:lang' => true,
			),
			'cite'             => array(
				'dir'  => true,
				'lang' => true,
			),
			'dfn'              => array(),
			'em'               => array(),
			'i'                => array(
				'aria-describedby' => true,
				'aria-details'     => true,
				'aria-label'       => true,
				'aria-labelledby'  => true,
				'aria-hidden'      => true,
				'class'            => true,
			),
			'code'             => array(),
			'del'              => array(
				'datetime' => true,
			),
			'img'              => array(
				'src'    => true,
				'alt'    => true,
				'width'  => true,
				'height' => true,
				'class'  => true,
				'style'  => true,
			),
			'ins'              => array(
				'datetime' => true,
				'cite'     => true,
			),
			'kbd'              => array(),
			'mark'             => array(),
			'pre'              => array(
				'width' => true,
			),
			'q'                => array(
				'cite' => true,
			),
			's'                => array(),
			'samp'             => array(),
			'span'             => array(
				'dir'      => true,
				'align'    => true,
				'lang'     => true,
				'xml:lang' => true,
			),
			'small'            => array(),
			'strong'           => array(),
			'sub'              => array(),
			'sup'              => array(),
			'u'                => array(),
			'var'              => array(),
		);
		$allowed_tags = apply_filters( 'holateam_kses_title', $allowed_tags );

		return wp_kses( $data, $allowed_tags );
	}
} // End of if function_exists( 'holateam_kses_title' ).

if ( ! function_exists( 'holateam_hide_posted_by' ) ) {
	/**
	 * Hides the posted by markup in `holateam_posted_on()`.
	 *
	 * @param string $byline Posted by HTML markup.
	 * @return string Maybe filtered posted by HTML markup.
	 */
	function holateam_hide_posted_by( $byline ) {
		if ( is_author() ) {
			return '';
		}
		return $byline;
	}
}
add_filter( 'holateam_posted_by', 'holateam_hide_posted_by' );


add_filter( 'excerpt_more', 'holateam_custom_excerpt_more' );

if ( ! function_exists( 'holateam_custom_excerpt_more' ) ) {
	/**
	 * Removes the ... from the excerpt read more link
	 *
	 * @param string $more The excerpt.
	 *
	 * @return string
	 */
	function holateam_custom_excerpt_more( $more ) {
		if ( ! is_admin() ) {
			$more = '';
		}
		return $more;
	}
}

add_filter( 'wp_trim_excerpt', 'holateam_all_excerpts_get_more_link' );

if ( ! function_exists( 'holateam_all_excerpts_get_more_link' ) ) {
	/**
	 * Adds a custom read more link to all excerpts, manually or automatically generated
	 *
	 * @param string $post_excerpt Posts's excerpt.
	 *
	 * @return string
	 */
	function holateam_all_excerpts_get_more_link( $post_excerpt ) {
		if ( ! is_admin() ) {
			$post_excerpt = $post_excerpt . ' [...]<p><a class="btn btn-secondary understrap-read-more-link" href="' . esc_url( get_permalink( get_the_ID() ) ) . '">' . __(
				'Read More...',
				'holateam'
			) . '<span class="screen-reader-text"> from ' . get_the_title( get_the_ID() ) . '</span></a></p>';
		}
		return $post_excerpt;
	}
}

// Disable XML RPC
add_filter( 'xmlrpc_enabled', '__return_false' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );

//  Disable XMLRPC call
add_action('xmlrpc_call', function ($action) {
    if ($action === 'pingback.ping') {
        wp_die('Pingbacks are not supported', 'Not Allowed!', ['response' => 403]);
    }
});

//  Remove pingback header
add_filter('wp_headers', function ($headers) {
    if (isset($headers['X-Pingback'])) {
        unset($headers['X-Pingback']);
    }
    return $headers;
}, 10, 1);

//  Kill bloginfo('pingback_url')
add_filter('bloginfo_url', function ($output, $show) {
    if ($show === 'pingback_url') {
        $output = '';
    }
    return $output;
}, 10, 2);


//  [_1_] Set the permalink structure  //

add_action('after_switch_theme', function () {
    if (get_option('permalink_structure') == '') {
        global $wp_rewrite;
        $wp_rewrite->set_permalink_structure('/%postname%');
        $wp_rewrite->flush_rules();
    }
});

//  ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** *****  //


//  [_2_] Remove Admin Bar  //

add_filter('show_admin_bar', '__return_false');

//  ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** *****  //


//  [_3_] Disable Upgrades & Updates  //

//  This removes upgrades and updates for non-administrative users
function prop_remove_core_updates()
{
    global $wp_version;
    return (object) array(
        'last_checked' => time(),
        'version_checked' => $wp_version,
    );
}

add_filter('pre_site_transient_update_core', 'prop_remove_core_updates');
add_filter('pre_site_transient_update_plugins', 'prop_remove_core_updates');
add_filter('pre_site_transient_update_themes', 'prop_remove_core_updates');
add_filter('pre_option_update_core', '__return_null');
add_action('init', function () {
    remove_action('init', 'wp_version_check');
}, 2);

//  ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** *****  //


//  [_4_] Hide Visual & Text Tabs  //
//  Default to visual tab as user will not be able to switch

add_filter('wp_default_editor', fn () => 'tinymce');

//  ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** *****  //


//  [_5_] Remove Dashboard Widgets  //

add_action('admin_init', function () {
    remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
    remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
    remove_meta_box('dashboard_primary', 'dashboard', 'normal');
    remove_meta_box('dashboard_secondary', 'dashboard', 'normal');
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
    remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
});

//  ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** *****  //


//  [_6_] Remove Admin Pages & Submenus  //

add_action('admin_menu', function () {
    // remove_menu_page( 'index.php' );                          // Dashboard
    // remove_menu_page( 'edit.php' );                           // Posts
    // remove_menu_page( 'upload.php' );                         // Media
    // remove_menu_page( 'edit.php?post_type=page' );            // Pages
    // remove_menu_page( 'themes.php' );                         // Appearance
    // remove_menu_page( 'plugins.php' );                        // Plugins
    // remove_menu_page( 'users.php' );                          // Users
    // remove_menu_page( 'tools.php' );                          // Tools
    // remove_menu_page( 'options-general.php' );                // Settings
    remove_menu_page('edit-comments.php');
});

add_action('admin_head', function () {
    remove_submenu_page('themes.php', 'widgets.php'); // Widgets Submenu
});

//  ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** *****  //


//  [_7_] Remove Comments  //

add_action('admin_init', function () {
    remove_post_type_support('post', 'comments');
    remove_post_type_support('page', 'comments');
}, 100);

add_action('wp_before_admin_bar_render', function () {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
});

//  ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** *****  //


//  [_8_] Disable Emoji's in tinyMCE  //

add_action('init', function ($plugins) {
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    } else {
        return array();
    }
});

//  ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** *****  //


//  [_9_] Disable XML  //

//  Disable XML RPC
add_filter('xmlrpc_enabled', '__return_false');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');

//  Disable XMLRPC call
add_action('xmlrpc_call', function ($action) {
    if ($action === 'pingback.ping') {
        wp_die('Pingbacks are not supported', 'Not Allowed!', ['response' => 403]);
    }
});

//  ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** *****  //


//  [_10_] Pingback  //

//  Remove pingback header
add_filter('wp_headers', function ($headers) {
    if (isset($headers['X-Pingback'])) {
        unset($headers['X-Pingback']);
    }
    return $headers;
}, 10, 1);

//  Kill bloginfo('pingback_url')
add_filter('bloginfo_url', function ($output, $show) {
    if ($show === 'pingback_url') {
        $output = '';
    }
    return $output;
}, 10, 2);

//  ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** *****  //


//  [_11_] Kill Trackback Rewrite Rule  //

add_filter('rewrite_rules_array', function ($rules) {
    foreach ($rules as $rule => $rewrite) {
        if (preg_match('/trackback\/\?\$$/i', $rule)) {
            unset($rules[$rule]);
        }
    }
    return $rules;
});

//  ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** *****  //


//  [_12_] Prevent SSL Capability Testing  //

remove_filter('atom_service_url', 'atom_service_url_filter');

//  ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** *****  //


//  [_13_] User Access  //
//  Allow editors access to menus

$role_object = get_role('editor');
$role_object->add_cap('edit_theme_options');

//  ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** *****  //


//  [_14_] Remove Custom CSS  //

add_action('customize_register', function ($wp_customize) {
    $wp_customize->remove_section('custom_css');
}, 15);

//  ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** *****  //


//  [_15_] Make Site Public  //

add_action('wp_login', function () {
    if (get_option('blog_public') == 0) {
        update_option('blog_public', '1');
    }
}, 10, 2);

//  ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** *****  //


//  [_16_] Remove content editor  //

add_action('admin_head', function () {
    remove_post_type_support('page', 'editor');
});

//  ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** *****  //


//  [_17_] Enable future posts in archives and posts  //

add_action('pre_get_posts', function ($wp_query) {
    global $wp_post_statuses;

    if (
        !empty($wp_post_statuses['future']) &&
        !is_admin() &&
        $wp_query->is_main_query() && ($wp_query->is_date() ||
            $wp_query->is_single())
    ) {
        $wp_post_statuses['future']->public = true;
    }
});

//  ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** *****  //


//  [_18_] Permalinks for future post  //

add_filter('post_type_link', function ($permalink, $post, $leavename) {
    /* for filter recursion (infinite loop) */
    static $recursing = false;

    if (empty($post->ID)) {
        return $permalink;
    }

    if (!$recursing) {
        if (isset($post->post_status) && ('future' === $post->post_status)) {
            // set the post status to publish to get the 'publish' permalink
            $post->post_status = 'publish';
            $recursing = true;
            return get_permalink($post, $leavename);
        }
    }

    $recursing = false;
    return $permalink;
}, 10, 4);

//  ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** *****  //


//  [_19_] Remove Search Querying  //
// This function removes the natural WordPress Search functionality, /search/anything will 404, unless it is an actual page

add_action('parse_query', function ($query, $error = true) {
    if (!is_admin() && is_search()) {
        $query->is_search = false;
        $query->query_vars['s'] = false;
        $query->query['s'] = false;
        if ($error == true)
            $query->is_404 = true;
    }
});

//  ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** *****  //


//  [_20_] Add Theme Support For Title  //

add_theme_support('title-tag');

//  ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** *****  //


//  [_21_] Add Last-Modified Header  //
// This function add Last-Modified header so we are able to invalidate cache in Service Worker

add_action('template_redirect', function () {
    if (is_admin()) return;
    // Get current queried object.
    $post = get_queried_object();
    // Valid post types: post, page, public custom post types
    $supported_post_types = array_merge(
        array('post', 'page'),
        get_post_types(array('public' => true, '_builtin' => false))
    );
    if (
        !is_object($post)
        || !isset($post->post_type)
        || !in_array(get_post_type($post), $supported_post_types)
    ) {
        return;
    }

    // Check for password protected post
    if (post_password_required()) return;

    // Retrieve stored time of post object
    $post_mtime = $post->post_modified_gmt;
    $post_mtime_unix = strtotime($post_mtime);

    // Check if headers have already been sent
    if (headers_sent()) {
        return;
    }

    // Send the headers
    header(sprintf('%s: %s', 'Last-Modified', gmdate($post_mtime_unix) . " GMT"));
});

//  ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** *****  //


//  [_22_] Fix skip link on IE 11 //

/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @link https://git.io/vWdr2
 */
add_action(
    'wp_print_footer_scripts',
    function () {
?>
    <script>
        /(trident|msie)/i.test(navigator.userAgent) && document.getElementById && window.addEventListener && window.addEventListener("hashchange", function() {
            var t, e = location.hash.substring(1);
            /^[A-z0-9_-]+$/.test(e) && (t = document.getElementById(e)) && (/^(?:a|select|input|button|textarea)$/i.test(t.tagName) || (t.tabIndex = -1), t.focus())
        }, !1);
    </script>
<?php
    }
);

