<?php
declare( strict_types = 1 );


namespace kdaviesnz\template;

/**
 * Class TemplateView
 *
 * @package kdaviesnz\template
 */
class TemplateView implements ITemplateView
{
	/**
	 * Renders shortcode.
	 *
	 * @return Callable
	 */
	public static function shortcode() :Callable {
		return function( array $atts ) {
			_e(
				'<p>Put html here that will be rendered on the page wherever [TEMPLATESHORTCODE] is used.</p>',
				'template'
			);
			return ob_get_clean();
		};
	}

	/**
	 * Renders admin form.
	 *
	 * @return Callable
	 */
	public static function renderAdminForm() :Callable {
		return function() {
			_e(
				'<p>Replace this with your admin form html.</p>',
				'template'
			);
		};
	}

	/**
	 * Render meta boxes.
	 *
	 * @return bool
	 */
	public static function renderMetaboxes() :Callable {
		return function ( $post ) {
			_e(
				'<p>Replace this with your metaboxes html.</p>',
				'template'
			);
		};
	}

	/**
	 * Code to filter post content.
	 *
	 * @return Callable
	 */
	public static function filterPost() :Callable {
		return function( $content ) {
			return $content;
		};
	}

	/**
	 * Notice to appear on Plugins page.
	 *
	 * @return Callable
	 */
	public static function renderPluginsNotice() :Callable {
		return function () {
			?>
			<div class="notice notice-info is-dismissible">
				<h4>Notice to appear on plugins page</h4>
				<p>
					<?php esc_html_e(
						'Description',
						'template'
					); ?>
				</p>
			</div>
			<?php
		};
	}

	/**
	 * Notice to appear on Edit Page page.
	 *
	 * @return Callable
	 */
	public static function renderEditPageNotice() :Callable {
		return function () {
			?>
			<div class="notice notice-info">
				<h4>Notice to appear on edit single page page.</h4>
				<p>
					<?php esc_html_e(
						'Description',
						'template'
					); ?>
				</p>
			</div>
			<?php
		};
	}

	/**
	 * Notice to appear on Edit Post page.
	 *
	 * @return Callable
	 */
	public static function renderEditPostNotice() :Callable {
		return function () {
			?>
			<div class="notice notice-info">
				<h4>Notice to appear on edit single post page.</h4>
				<p>
					<?php esc_html_e(
						'Description',
						'template'
					); ?>
				</p>
			</div>
			<?php
		};
	}

	/**
	 * Notice to appear on All Pages page.
	 *
	 * @return Callable
	 */
	public static function renderAllPagesNotice() :Callable {
		return function () {
			?>
			<div class="notice notice-info">
				<h4>Notice to appear on all pages page</h4>
				<p>
					<?php esc_html_e(
						'Description',
						'template'
					); ?>
				</p>
			</div>
			<?php
		};
	}

	/**
	 * Notice to appear on All Posts page.
	 *
	 * @return Callable
	 */
	public static function renderAllPostsNotice() :Callable {
		return function () {
			?>
			<div class="notice notice-info">
				<h4>Notice to appear on all posts page</h4>
				<p>
					<?php esc_html_e(
						'Description',
						'template'
					); ?>
				</p>
			</div>
			<?php
		};
	}

	public static function addPostsTableColumnHeader() :Callable {
        return function( array $defaults ) {
            $defaults["Template column"] = "Template Column";
            return $defaults;
        };
    }

    public static function addPostsTableColumnContent() :Callable {
        return function( string $column_name, int $post_ID ) {
            echo "Template column content";
        };
    }
}
