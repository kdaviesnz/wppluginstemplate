<?php
declare( strict_types = 1 );


namespace kdaviesnz\template;


/**
 * Class TemplateModel
 *
 * @package kdaviesnz\template
 */
class TemplateModel implements ITemplateModel
{
	/**
	 * Code called when a post is saved.
	 *
	 * @return Callable
	 */
	public static function savePost() :Callable {
		return function( int $post_id ) {
			// Put code here to be called when a post is saved.
		};
	}
}
