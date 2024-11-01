<?php
/*
Plugin Name: Social Menu Icons
Plugin URI: https://mediaron.com/portfolio/social-menu-icons/
Description: Social menu options for WordPress.
Author: Ronald Huereca
Version: 1.0.0
Requires at least: 4.7
Author URI: https://mediaron.com
Contributors: ronalfy
Text Domain: social-menu-icons
Domain Path: /languages
Credit: Forked from https://github.com/bigwing/bigwing-social
*/

class Social_Menu_Icons {
	public function __construct() {
		require( 'customizer.php' );
		load_plugin_textdomain( 'social-menu-icons', false, basename( dirname( __FILE__ ) ) . '/languages' );
		add_action( 'wp_footer', array( $this, 'include_svg' ), 9999 );
		add_filter( 'nav_menu_item_args', array( $this, 'nav_menu_item_args' ), 20, 3 );
		add_filter( 'wp_nav_menu_args', array( $this, 'nav_menu_args' ), 20, 1 );
		add_action( 'after_setup_theme', array( $this, 'register_nav_menu' ), 10, 1 );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ), 10, 1 );
	}

	/**
	 * Get list of SVG icons available.
	 *
	 * Get list of SVG icons available.
	 *
	 * @since 1.0.0
	 * 
	 * Forked from twentyseventeen `twentyseventeen_social_links_icons` 
	 */
	public function get_icons() {
		// Supported social links icons.
		$social_links_icons = array(
			'amazon.com'      => 'amazon',
			'behance.net'     => 'behance',
			'blogger.com'     => 'blogger',
			'codepen.io'      => 'codepen',
			'dribbble.com'    => 'dribble',
			'dropbox.com'     => 'dropbox',
			'eventbrite.com'  => 'eventbrite',
			'facebook.com'    => 'facebook',
			'flickr.com'      => 'flickr',
			'feed'            => 'feed',
			'foursquare.com'  => 'foursquare',
			'ghost.org'       => 'ghost',
			'github.com'      => 'github',
			'github.io'       => 'github',
			'plus.google.com' => 'google-plus',
			'google.com'      => 'google',
			'instagram.com'   => 'instagram',
			'linkedin.com'    => 'linkedin',
			'mailto'          => 'mail',
			'medium.com'      => 'medium',
			'path.com'        => 'path',
			'pinterest.com'   => 'pinterest-alt',
			'getpocket.com'   => 'pocket',
			'polldaddy.com'   => 'polldaddy',
			'reddit.com'      => 'reddit',
			'skype.com'       => 'skype',
			'spotify.com'     => 'spotify',
			'squarespace.com' => 'squarespace',
			'stumbleupon.com' => 'stumbleupon',
			'telegram.org'    => 'telegram',
			'tumblr.com'      => 'tumblr-alt',
			'twitch.tv'       => 'twitch',
			'twitter.com'     => 'twitter-alt',
			'vimeo.com'       => 'vimeo',
			'xanga.com'       => 'xanga',
			'wordpress.org'   => 'wordpress',
			'wordpress.com'   => 'wordpress',
			'youtu.be'        => 'youtube',
			'youtube.com'     => 'youtube'
		);

		/**
		 * Filter Social Icons.
		 *
		 * @since 1.0.0
		 *
		 * @param array $social_links_icons
		 */
		return apply_filters( 'social_menu_icons', $social_links_icons );
	}

	/**
	 * Get a list of defaults.
	 *
	 * @since 1.0.0
	 * 
	 * @return array Array of defaults 
	 */
	public function get_options_defaults() {
		$defaults = array(
			'icon_size'         => '24',
			'fill_color'        => 'gray',
			'fill_color_custom' => '#767676',
			'text_color'        => '#FFFFFF',
			'layout'            => 'list-item'
		);
		return $defaults;
	}

	/**
	 * Return SVG markup.
	 *
	 * Forked from twentyseventeen `twentyseventeen_get_svg`
	 *
	 * @param array $args {
	 *     Parameters needed to display an SVG.
	 *
	 *     @type string $icon  Required SVG icon filename.
	 *     @type string $title Optional SVG title.
	 *     @type string $desc  Optional SVG description.
	 * }
	 * @return string SVG markup.
	 */
	public function get_svg( $args = array() ) {
		// Make sure $args are an array.
		if ( empty( $args ) ) {
			return __( 'Please define default parameters in the form of an array.', 'social-menu-icons' );
		}

		// Define an icon.
		if ( false === array_key_exists( 'icon', $args ) ) {
			return __( 'Please define an SVG icon filename.', 'social-menu-icons' );
		}

		// Set defaults.
		$defaults = array(
			'icon'        => '',
			'title'       => '',
			'desc'        => '',
			'fallback'    => false,
		);

		// Parse args.
		$args = wp_parse_args( $args, $defaults );

		// Set aria hidden.
		$aria_hidden = ' aria-hidden="true"';

		// Set ARIA.
		$aria_labelledby = '';

		if ( $args['title'] ) {
			$aria_hidden     = '';
			$unique_id       = uniqid();
			$aria_labelledby = ' aria-labelledby="title-' . $unique_id . '"';

			if ( $args['desc'] ) {
				$aria_labelledby = ' aria-labelledby="title-' . $unique_id . ' desc-' . $unique_id . '"';
			}
		}
		
		/* Get Fill/Text Color */
		$options = get_option( 'social_menu_icons' );
		$options = wp_parse_args( $options, $this->get_options_defaults() );
		$css = array();
		if ( isset( $options[ 'fill_color' ] ) && 'custom' === $options[ 'fill_color' ] ) {
			$fill_color = $options[ 'fill_color_custom' ];
			$css[] = sprintf( 'fill: %s', $fill_color );
		}
		$css = implode( ';', $css );

		// Begin SVG markup.
		$svg = '<svg class="icon icon-' . esc_attr( $args['icon'] ) . '"' . $aria_hidden . $aria_labelledby . ' role="img" style="' . esc_attr( $css ) . '">';

		// Display the title.
		if ( $args['title'] ) {
			$svg .= '<title id="title-' . $unique_id . '">' . esc_html( $args['title'] ) . '</title>';

			// Display the desc only if the title is already set.
			if ( $args['desc'] ) {
				$svg .= '<desc id="desc-' . $unique_id . '">' . esc_html( $args['desc'] ) . '</desc>';
			}
		}

		/*
		* Display the icon.
		*
		* The whitespace around `<use>` is intentional - it is a work around to a keyboard navigation bug in Safari 10.
		*
		* See https://core.trac.wordpress.org/ticket/38387.
		*/
		$svg .= ' <use href="#' . esc_html( $args['icon'] ) . '" xlink:href="#' . esc_html( $args['icon'] ) . '"></use> ';

		// Add some markup to use as a fallback for browsers that do not support SVGs.
		if ( $args['fallback'] ) {
			$svg .= '<span class="svg-fallback icon-' . esc_attr( $args['icon'] ) . '"></span>';
		}

		$svg .= '</svg>';

		return $svg;
	}

	/**
	 * Include SVG file in the footer.
	 *
	 * Include SVG file in the footer.
	 *
	 * @since 1.0.0
	 * 
	 * Forked from twentyseventeen `twentyseventeen_include_svg_icons` 
	 */
	public function include_svg() {

		// Define SVG sprite file.
		$path = '/images/social-logos.svg';
		$svg_icons = rtrim( plugin_dir_path(__FILE__), '/' );
		if ( ! empty( $path ) && is_string( $path) ) {
			$svg_icons .= '/' . ltrim( $path, '/' );
		}
	
		/**
		 * Filter Social Icons Sprite.
		 *
		 * @since 1.0.0
		 *
		 * @param string Absolute directory path to SVG sprite
		 */
		$svg_icons = apply_filters( 'social_menu_icons_sprite', $svg_icons );
	
		// If it exists, include it.
		if ( file_exists( $svg_icons ) ) {
			echo '<div style="position: absolute; height: 0; width: 0; overflow: hidden;">';
			require_once( $svg_icons );
			echo '</div>';
		}
	}

	/**
	 * Whether a menu is a social menu or not.
	 *
	 * Whether a menu is a social menu or not.
	 *
	 * @since 1.0.0
	 * 
	 *
	 * @param array $args Array of wp_nav_menu() arguments. 
	 */
	public function maybe_has_menu( $args ) {
		
		// Check theme location
		$location = isset( $args[ 'theme_location' ] ) ? $args[ 'theme_location' ] : false;
		if ( $location && 'smi-social' === $location ) {
			return true;
		}
		
		// Check Menu
		$menu = isset( $args[ 'menu' ] ) ? $args[ 'menu' ] : false;
		if ( ! $menu ) {
			return false;
		}
		
		// Get menu object
		$menu_object = wp_get_nav_menu_object( $menu );
		if ( $menu_object && is_a( $menu_object, 'WP_Term' ) ) {
			$menu_locations = get_nav_menu_locations();
			foreach( $menu_locations as $menu_location => $menu_term_id ) {
				if ( 'smi-social' === $menu_location && $menu_term_id === $menu_object->term_id ) {
					return true;
				}
			}
		}
		
		return false;
	}

	/**
	 * Add screen reader span around link text in menu item.
	 *
	 * Add screen reader span around link text in menu item.
	 *
	 * @since 1.0.0
	 * 
	 * @param stdClass $args  An object of wp_nav_menu() arguments.
	 * @param WP_Post  $item  Menu item data object.
	 * @param int      $depth Depth of menu item. Used for padding.
	 */
	public function nav_menu_item_args( $args, $item, $depth ) {
		if ( ! $this->maybe_has_menu( (array)$args ) ) {
			return $args;
		}
		
		// Wrap text in span so it can be hidden via CSS
		$args->link_before = '<span class="smi-screen-reader-text">';
		$args->link_after = '</span>';
		
		// Add SVG Icons
		$maybe_icons = $this->get_icons();
		foreach ( $maybe_icons as $attr => $value ) {
			if ( false !== strpos( $item->url, $attr ) ) {
				$args->link_after .= $this->get_svg( array( 'icon' => esc_attr( $value ) ) );
			}
		}
		
		return $args;
	}

	/**
	 * Add menu-level classes.
	 *
	 * Add menu-level classes.
	 *
	 * @since 1.0.0
	 * 
	 * @see wp_nav_menu()
	 *
	 * @param array $args Array of wp_nav_menu() arguments. 
	 */
	public function nav_menu_args( $args ) {
		
		if ( !$this->maybe_has_menu( $args ) ) {
			return $args;
		}
		
		$options = get_option( 'social_menu_icons' );
		$options = wp_parse_args( $options, $this->get_options_defaults() );
		
		$classes = array(
			'smi-social-menu',
			'smi-social-icon-' . absint( $options[ 'icon_size' ] ),
			'smi-social-fill-' . esc_attr( $options[ 'fill_color' ] ),
			'smi-layout-' . esc_attr( $options[ 'layout' ] )
		);
		$args[ 'container_class' ] .= ' ' . implode( ' ', $classes );
		$args[ 'container_class' ] = ltrim( $args[ 'container_class' ], ' ' );
		return $args;
	}

	/**
	 * Register navigation menus for usage.
	 *
	 * Register navigation menus for usage.
	 *
	 * @since 1.0.0
	 */
	public function register_nav_menu() {
		register_nav_menu( 'smi-social', __( 'Social Menu Icons', 'social-menu-icons' ) );
	}

	/**
	 * Register styles for the menu.
	 *
	 * Register styles for the menu.
	 *
	 * @since 1.0.0
	 */
	function register_scripts() {
		wp_enqueue_style( 'social-menu-icons', plugins_url( '/css/main.min.css', __FILE__ ), array(), '20180919', 'all' );
	}
}

add_action( 'plugins_loaded', function() {
	new Social_Menu_Icons();
} );



