<?php
/**
 * Genesis Framework.
 *
 * WARNING: This file is part of the core Genesis Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package Genesis\Images
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/genesis/
 */

/**
 * Pull an attachment ID from a post, if one exists.
 *
 * @since 0.1.0
 *
 * @param integer $index Optional. Index of which image to return from a post. Default is 0.
 *
 * @return integer|boolean Returns image ID, or false if image with given index does not exist.
 */
function genesis_get_image_id( $index = 0, $post_id = null ) {

	$image_ids = array_keys(
		get_children(
			array(
				'post_parent'    => $post_id ? $post_id : get_the_ID(),
				'post_type'	     => 'attachment',
				'post_mime_type' => 'image',
				'orderby'        => 'menu_order',
				'order'	         => 'ASC',
			)
		)
	);

	if ( isset( $image_ids[ $index ] ) ) {
		return $image_ids[ $index ];
	}

	return false;

}

/**
 * Return an image pulled from the media gallery.
 *
 * Supported $args keys are:
 *
 *  - format   - string, default is 'html'
 *  - size     - string, default is 'full'
 *  - num      - integer, default is 0
 *  - attr     - string, default is ''
 *  - fallback - mixed, default is 'first-attached'
 *
 * Applies `genesis_get_image_default_args`, `genesis_pre_get_image` and `genesis_get_image` filters.
 *
 * @since 0.1.0
 *
 * @uses genesis_get_image_id() Pull an attachment ID from a post, if one exists.
 *
 * @param array|string $args Optional. Image query arguments. Default is empty array.
 *
 * @return string|boolean Return image element HTML, URL of image, or false.
 */
function genesis_get_image( $args = array() ) {

	$defaults = array(
		'post_id'  => null,
		'format'   => 'html',
		'size'     => 'full',
		'num'      => 0,
		'attr'     => '',
		'fallback' => 'first-attached',
		'context'  => '',
	);

	/**
	 * A filter on the default parameters used by `genesis_get_image()`.
	 *
	 * @since unknown
	 */
	$defaults = apply_filters( 'genesis_get_image_default_args', $defaults, $args );

	$args = wp_parse_args( $args, $defaults );

	//* Allow child theme to short-circuit this function
	$pre = apply_filters( 'genesis_pre_get_image', false, $args, get_post() );
	if ( false !== $pre )
		return $pre;

	//* If post thumbnail (native WP) exists, use its id
	if ( has_post_thumbnail( $args['post_id'] ) && ( 0 === $args['num'] ) ) {
		$id = get_post_thumbnail_id( $args['post_id'] );
	}
	//* Else if the first (default) image attachment is the fallback, use its id
	elseif ( 'first-attached' === $args['fallback'] ) {
		$id = genesis_get_image_id( $args['num'], $args['post_id'] );
	}
	//* Else if fallback id is supplied, use it
	elseif ( is_int( $args['fallback'] ) ) {
		$id = $args['fallback'];
	}

	//* If we have an id, get the html and url
	if ( isset( $id ) ) {
		$html = wp_get_attachment_image( $id, $args['size'], false, $args['attr'] );
		list( $url ) = wp_get_attachment_image_src( $id, $args['size'], false, $args['attr'] );
	}
	//* Else if fallback html and url exist, use them
	elseif ( is_array( $args['fallback'] ) ) {
		$id   = 0;
		$html = $args['fallback']['html'];
		$url  = $args['fallback']['url'];
	}
	//* Else, return false (no image)
	else {
		return false;
	}

	//* Source path, relative to the root
	$src = str_replace( home_url(), '', $url );

	//* Determine output
	if ( 'html' === mb_strtolower( $args['format'] ) )
		$output = $html;
	elseif ( 'url' === mb_strtolower( $args['format'] ) )
		$output = $url;
	else
		$output = $src;

	//* Return false if $url is blank
	if ( empty( $url ) ) $output = false;

	//* Return data, filtered
	return apply_filters( 'genesis_get_image', $output, $args, $id, $html, $url, $src );
}

/**
 * Echo an image pulled from the media gallery.
 *
 * Supported $args keys are:
 *
 *  - format - string, default is 'html', may be 'url'
 *  - size   - string, default is 'full'
 *  - num    - integer, default is 0
 *  - attr   - string, default is ''
 *
 * @since 0.1.0
 *
 * @uses genesis_get_image() Return an image pulled from the media gallery.
 *
 * @param array|string $args Optional. Image query arguments. Default is empty array.
 *
 * @return false Returns false if URL is empty.
 */
function genesis_image( $args = array() ) {

	$image = genesis_get_image( $args );

	if ( $image )
		echo $image;
	else
		return false;

}

/**
 * Return registered image sizes.
 *
 * Return a two-dimensional array of just the additionally registered image sizes, with width, height and crop sub-keys.
 *
 * @since 0.1.7
 *
 * @global array $_wp_additional_image_sizes Additionally registered image sizes.
 *
 * @return array Two-dimensional, with width, height and crop sub-keys.
 */
function genesis_get_additional_image_sizes() {

	global $_wp_additional_image_sizes;

	if ( $_wp_additional_image_sizes )
		return $_wp_additional_image_sizes;

	return array();

}

/**
 * Return all registered image sizes arrays, including the standard sizes.
 *
 * Return a two-dimensional array of standard and additionally registered image sizes, with width, height and crop sub-keys.
 *
 * Here, the standard sizes have their sub-keys populated by pulling from the options saved in the database.
 *
 * @since 1.0.2
 *
 * @uses genesis_get_additional_image_sizes() Return registered image sizes.
 *
 * @return array Two-dimensional, with width, height and crop sub-keys.
 */
function genesis_get_image_sizes() {

	global $_wp_additional_image_sizes;

	$sizes = array();

	foreach ( get_intermediate_image_sizes() as $_size ) {

		if ( in_array( $_size, array( 'thumbnail', 'medium', 'large' ) ) ) {

			$sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
			$sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
			$sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );

		} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {

			$sizes[ $_size ] = array(
				'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
				'height' => $_wp_additional_image_sizes[ $_size ]['height'],
				'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
			);

		}

	}

	return $sizes;

}

function genesis_get_image_sizes_for_customizer() {

	$sizes = array();

	foreach ( (array) genesis_get_image_sizes() as $name => $size ) {
		$sizes[ $name ] = $name . ' (' . absint( $size['width'] ) . ' &#x000D7; ' . absint( $size['height'] ) . ')';
	}

	return $sizes;

}