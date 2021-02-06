<?php
/**
 * ONE PAGE NAV
 */

/**
 * Constants
 */
define( 'ONE_PAGE_NAV_DIR', get_stylesheet_directory() . '/one-page-nav' );
define( 'ONE_PAGE_NAV_URI', get_stylesheet_directory_uri() . '/one-page-nav' );

class One_Page_Nav {
  public static function init() {
    add_action( 'wp_enqueue_scripts', __CLASS__ . '::enqueue_scripts' );
    add_shortcode('one_page_nav', __CLASS__ . '::render_one_page_nav');
    add_filter( 'wp_nav_menu_items', __CLASS__ . '::add_close_button_to_single_page_nav', 10, 2 );
    add_action( 'wp_head', __CLASS__ . '::max_print_in_page_menu' );
    add_filter( 'body_class', __CLASS__ . '::one_page_nav_body_classes' );
  }

  public static function enqueue_scripts() {
    wp_enqueue_style( 'one-page-nav-style', ONE_PAGE_NAV_URI . '/css/style.css' );
    wp_enqueue_script( 'jquery-one-page-nav', ONE_PAGE_NAV_URI . '/js/jquery.nav.js', array( 'jquery' ) );
    wp_enqueue_script( 'one-page-nav-functions', ONE_PAGE_NAV_URI . '/js/functions.js', array( 'jquery', 'jquery-one-page-nav' ) );
  }

  /**
   * Add menu as shortcode
   */
  public static function render_one_page_nav($atts, $content = null) {
    extract(shortcode_atts(array( 'name' => null, 'class' => null ), $atts));
    return wp_nav_menu( array(
        'menu' => $name,
        'menu_class' => 'one-page-nav',
        'echo' => false,
        'container' => false,
        'one_page_nav' => true, // Add custom argument to determine if menu is a one page nav menu
      )
    );
  }

  /**
   * Add close button to menu as a menu item
   */
  public static function add_close_button_to_single_page_nav ( $items, $args ) {
    if ( get_field( 'has_in_page_nav' ) && is_single() && self::has_one_page_nav_arg( $args ) ) {
      $items .= '<span class="one-page-nav-trigger opn-close"><span class="opn-description">Close</span></span>';
    }
    return $items;
  }

  /**
   * Prints menu if ACF field on post or page is checked and has menu assigned
   */
  public static function max_print_in_page_menu() {
    if ( get_field( 'has_in_page_nav' ) && is_single() ) {
      $name = get_field( 'menu_name' );
      ob_start(); ?>

      <div>
        <?php echo do_shortcode( '[one_page_nav one_page_nav="true" name="' . $name . '"]' ); ?>
        <span class="one-page-nav-trigger opn-open"><span class="opn-description">Table of Contents</span></span>
      </div>

      <?php
      echo ob_get_clean();
    }
  }

  public static function one_page_nav_body_classes( $classes ) {
    if ( get_field( 'has_in_page_nav' ) && is_single() ) {
      $classes[] = 'one-page-nav-active';
    }
    return $classes;
  }

  /****************************************************************
   * Helper Classes
   ****************************************************************/

  /**
   * Detects one_page_nav argument in menu initialization
   */
  public static function has_one_page_nav_arg( $args ) {
    return isset( $args->one_page_nav ) && $args->one_page_nav;
  }
}
One_Page_Nav::init();
