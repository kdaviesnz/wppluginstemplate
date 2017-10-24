<?php
declare( strict_types = 1 );


namespace kdaviesnz\template;

/**
 * Class Template
 *
 * @package kdaviesnz\template
 */
class Template implements ITemplate
{

	/**
	 * Template constructor.
	 */
	public function __construct() {

	}

	/**
	 * Code called after plugins are loaded.
	 *
	 * @return Callable
	 */
	public function onPluginsLoaded() :Callable {
		return function() {

			add_action( 'init', $this->init() );

			// Admin_menu hook is only fired when we're in admin.
			add_action( 'admin_menu', function() {
				$this->admin();
			} );

			// Admin CSS and Javascript.
			add_action( 'admin_head', $this->adminHead() );
			add_action( 'admin_footer', $this->adminFoot() );
			add_action( 'wp_head', $this->head() );
			add_action( 'wp_footer', $this->foot() );

			// Shortcode.
			add_shortcode( 'TEMPLATESHORTCODE', TemplateView::shortcode() );

			// AJAX handlers.
			add_action( 'wp_ajax_', 'name of function' );
			add_action( 'wp_ajax_nopriv_', 'name of function' );

			// Filters.
			add_filter( 'the_content', TemplateView::filterPost() );
		};
	}


	/**
	 * Code called when plugin is activated.
	 *
	 * @return Callable
	 */
	public function onActivation() :Callable {
		return function() {
			// Add code to be called on activation here.
		};
	}

	/**
	 * Code called when plugin id deactivated.
	 *
	 * @return Callable
	 */
	public function onDeactivation() :Callable {
		return function() {
			// Add code to be caleld on deactivation here.
		};
	}

	/**
	 * Code called when init action is fired.
	 *
	 * @return bool
	 */
	public function init() {
		return function() {
			// Page type.
			$this->addTemplatePageType();

			// Meta boxes.
			add_action( 'add_meta_boxes', $this->metaBoxes() );

			// Save post handler.
			add_action(
				'save_post',
				TemplateModel::savePost()
			);
			return true;
		};
	}

	/**
	 * Executed when admin_menu hook is fired.
	 */
	public function admin() : bool {
		if ( current_user_can( 'manage_options' ) ) {
			$this->addMenuItems();
		}

		// Notification boxes.
		add_action( 'current_screen', function () {

			$screen = get_current_screen();

			if ( 'add' === $screen->action && 'post' === $screen->id ) {
				add_action( 'admin_notices', function () {
					?>
					<div class="notice notice-info">
						<h4>Notice to appear on new post page</h4>
						<p>
							<?php esc_html_e(
								'Description.',
								'template'
							); ?>
						</p>
					</div>
					<?php
				});
			}

			if ( 'add' === $screen->action && 'page' === $screen->id ) {
				add_action( 'admin_notices', function () {
					?>
					<div class="notice notice-info">
						<h4>Notice to appear on new page page</h4>
						<p>
							<?php esc_html_e(
								'Description.',
								'template'
							); ?>
						</p>
					</div>
					<?php
				});
			}

			$args = array();
			$posts = new \WP_Query( $args );

			if ( 'edit-post' === $screen->id && 'edit' === $screen->base ) {
				add_action( 'admin_notices', TemplateView::renderAllPostsNotice() );
			}

			if ( 'edit-page' === $screen->id && 'edit' === $screen->base ) {
				add_action( 'admin_notices', TemplateView::renderAllPagesNotice() );
			}

			if ( 'post' === $screen->id && 'post' === $screen->base ) {
				add_action( 'admin_notices', TemplateView::renderEditPostNotice() );
			}

			if ( 'page' === $screen->id && 'post' === $screen->base ) {
				add_action( 'admin_notices', TemplateView::renderEditPostNotice() );
			}

			if ( 'plugins' === $screen->id ) {
				add_action( 'admin_notices', TemplateView::renderPluginsNotice() );
			}
		});

		return true;
	}

	/**
	 * Add code to generate menu items on the admin page.
	 *
	 * @return bool
	 */
	public function addMenuItems() {

		add_menu_page(
			'Template Page Title',
			'Template Menu Title',
			'manage_options',
			'template_menu_slug',
			TemplateView::renderAdminForm(),
			plugins_url( '../images/gs_icon2.png',
				__FILE__ ),
			3
		);

		return true;
	}

	/**
	 * Code to generate html to go in the <head> tag on the admin pages.
	 */
	public function adminHead() {
		return function() {
			wp_register_style( 'template_admin_css', dirname( plugin_dir_url( __FILE__ ) ) . '/css/template_admin.css' );
			wp_enqueue_style( 'template_admin_css' );
		};
	}

	/**
	 * Code to generate html to go in the footer of admin pages.
	 */
	public function adminFoot() {
		return function() {
			wp_enqueue_script( 'jquery' );
			wp_register_script( 'gsdom_js', dirname( plugin_dir_url( __FILE__ ) ) . '/js/gsdom.js' );
			wp_enqueue_script( 'gsdom_js' );
			wp_register_script( 'template_admin_js', dirname( plugin_dir_url( __FILE__ ) ) . '/js/template_admin.js' );

			// Localize the script with new data.
			global $post;
			if ( ! empty( $post ) ) {
				$params = array(
					'ajax_url' => admin_url() . 'admin-ajax.php',
				);
				wp_localize_script( 'template_admin_js', 'template_params', $params );
				// Enqueued script with localized data.
				wp_enqueue_script( 'template_admin_js' );
			}
		};
	}

	/**
	 * Code to generate html to go in the <head> tag on the non-admin pages.
	 */
	public function head() {
		return function() {
			wp_register_style( 'template_css', dirname( plugin_dir_url( __FILE__ ) ) . '/css/template.css' );
			wp_enqueue_style( 'template_css' );
		};
	}

	/**
	 * Code to generate html to go in the footer of non-admin pages.
	 */
	public function foot() {
		return function() {
			wp_enqueue_script( 'jquery' );
			wp_register_script( 'gsdom_js', dirname( plugin_dir_url( __FILE__ ) ) . '/js/gsdom.js' );
			wp_enqueue_script( 'gsdom_js ' );

			wp_register_script( 'template_js', dirname( plugin_dir_url( __FILE__ ) ) . '/js/template.js' );

			// Localize the script with new data.
			$params = array(
				'ajax_url' => admin_url() . 'admin-ajax.php',
				'home_url' => get_home_url(),
			);
			wp_localize_script( 'template_js', 'template_params', $params );
			// Enqueued script with localized data.
			wp_enqueue_script( 'template_js' );
		};
	}

	/**
	 * Example code to add a new page type.
	 */
	public function addTemplatePageType() {

		$template_page_args = array(
			'public' => true,
			'query_var' => 'template',
			'supports' => array(
				'title',
			),
			'labels' => array(
				'name' => '',
				'singular_name' => '',
				'add_new' => 'Add New ',
				'add_new_item' => 'Add New ',
				'edit_item' => 'Edit ',
				'new_item' => 'New ',
				'view_item' => 'View ',
				'search_items' => 'Search ',
				'not_found' => 'No * Found',
				'not_found_in_trash' => 'No * Found In Trash',
			),
			'has_archive' => true,
			'hierachical' => true,
			'feeds' => true,
		);
		register_post_type( 'template_page', $template_page_args );
	}

	/**
	 * Render setting fields on the template page.
	 */
	public function metaBoxes() {
		return function (){
			// Ref: https://developer.wordpress.org/reference/functions/add_meta_box/.
			add_meta_box(
				'template_settings',
				'Template Settings',
				TemplateView::renderMetaboxes(),
				'post',
				'normal',
				'high'
			);
		};
	}
}
