<?php
/**
 * Discussions Tab for WooCommerce Products - WooCommerce compatibility.
 *
 * @version 1.4.2
 * @since   1.4.0
 * @author  Thanks to IT
 */

namespace WPFactory\WC_Products_Discussions_Tab;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'WPFactory\WC_Products_Discussions_Tab\WC_Compatibility' ) ) {

	class WC_Compatibility {

		/**
		 * Init.
		 *
		 * @version 1.4.0
		 * @since   1.4.0
		 */
		function init() {
			// On WooCommerce 6.7.0, they've tried to separate reviews from comments and it created problems on admin.
			$this->fix_wc_670();
		}

		/**
		 * Fix product reviews change from WooCommerce 6.7.0.
		 *
		 * WooCommerce tried to separate the reviews from comments and that created some problems on admin.
		 *
		 * @version 1.4.0
		 * @since   1.4.0
		 *
		 * @see https://github.com/woocommerce/woocommerce/compare/6.6.1...6.7.0?diff=split
		 * @see \WC_Comments
		 * @see \Automattic\WooCommerce\Internal\Admin\ProductReviews\Reviews
		 * @see \Automattic\WooCommerce\Internal\Admin\ProductReviews\ReviewsCommentsOverrides;
		 */
		function fix_wc_670() {
			add_filter( 'admin_comment_types_dropdown', array( $this, 'exclude_review_from_admin_comment_types_dropdown' ), PHP_INT_MAX );
			add_filter( 'comments_list_table_query_args', array( $this, 'add_post_type_to_admin_comments_list_table_and_remove_reviews' ), PHP_INT_MAX );
			add_action( 'before_woocommerce_init', array( $this, 'prevent_wc_from_removing_products_from_comment_clauses' ) );
			add_filter( 'gettext', array( $this, 'fix_comment_title' ), PHP_INT_MAX, 2 );
			add_filter( 'get_comment', array( $this, 'fix_get_comment' ), PHP_INT_MAX );
			add_filter( 'parent_file', array( $this, 'fix_menu_item' ), PHP_INT_MAX );
		}

		/**
		 * fix_menu_item.
		 *
		 * @version 1.4.0
		 * @since   1.4.0
		 *
		 * @param $parent_file
		 *
		 * @return string
		 */
		function fix_menu_item( $parent_file ) {
			global $submenu_file, $current_screen;
			if (
				isset( $current_screen->id, $_GET['c'] ) &&
				'comment' === $current_screen->id &&
				'yes' === get_option( 'alg_dtwp_fix_reviews_change', 'yes' )
			) {
				$comment_id = absint( $_GET['c'] );
				$comment    = get_comment( $comment_id );
				if ( isset( $comment->comment_parent ) && $comment->comment_parent > 0 ) {
					$comment = get_comment( $comment->comment_parent );
				}
				if ( isset( $comment->comment_post_ID ) && alg_wc_pdt_get_comment_type_id() === $comment->comment_type ) {
					$parent_file  = 'edit-comments.php';
					$submenu_file = '';
				}
			}
			return $parent_file;
		}

		/**
		 * fix_comment_title.
		 *
		 * @version 1.4.0
		 * @since   1.4.0
		 *
		 * @param $translation
		 * @param $text
		 *
		 * @return string
		 */
		function fix_comment_title( $translation, $text ) {
			global $comment;
			if (
				is_admin() &&
				! empty( $comment ) &&
				alg_wc_pdt_get_comment_type_id() === $comment->comment_type &&
				'yes' === get_option( 'alg_dtwp_fix_reviews_change', 'yes' ) &&
				false !== strpos( $translation, 'Review' )
			) {
				$translation = false !== strpos( $translation, 'Edit' ) ? __( 'Edit comment', 'discussions-tab-for-woocommerce-products' ) : __( 'Moderate comment', 'discussions-tab-for-woocommerce-products' );
			}
			return $translation;
		}

		/**
		 * fix_get_comment.
		 *
		 * @version 1.4.2
		 * @since   1.4.0
		 *
		 * @param $_comment
		 *
		 * @return array|false|null|\WP_Comment|\WP_Error
		 */
		function fix_get_comment( $_comment ) {
			global $comment;
			if (
				is_admin() &&
				! empty( $screen = get_current_screen() ) &&
				'comment' === $screen->base &&
				$comment &&
				$_comment->comment_ID === $comment->comment_parent &&
				alg_wc_pdt_get_comment_type_id() === $comment->comment_type &&
				'yes' === get_option( 'alg_dtwp_fix_reviews_change', 'yes' )
			) {
				$_comment = $comment;
			}
			return $_comment;
		}

		/**
		 * exclude_review_from_admin_comment_types_dropdown.
		 *
		 * @version 1.4.0
		 * @since   1.4.0
		 *
		 * @param $types
		 *
		 * @return mixed
		 */
		function exclude_review_from_admin_comment_types_dropdown( $types ) {
			if (
				isset( $types['review'] ) &&
				'yes' === get_option( 'alg_dtwp_fix_reviews_change', 'yes' )
			) {
				unset( $types['review'] );
			}
			return $types;
		}

		/**
		 * add_post_type_to_admin_comments_list_table_and_remove_reviews.
		 *
		 * @version 1.4.0
		 * @since   1.4.0
		 *
		 * @param $args
		 *
		 * @return mixed
		 */
		function add_post_type_to_admin_comments_list_table_and_remove_reviews( $args ) {
			if ( 'yes' === get_option( 'alg_dtwp_fix_reviews_change', 'yes' ) ) {
				if ( ! empty( $args['post_type'] ) && 'any' !== $args['post_type'] ) {
					$post_types = (array) $args['post_type'];
				} else {
					$post_types = get_post_types();
				}
				$post_types[]      = 'product';
				$args['post_type'] = $post_types;
				$args['type__not_in'] = 'review';
			}
			return $args;
		}

		/**
		 * prevent_wc_from_removing_products_from_comment_clauses.
		 *
		 * @see WC_Comments::init()
		 *
		 * @version 1.4.0
		 * @since   1.4.0
		 */
		function prevent_wc_from_removing_products_from_comment_clauses() {
			if ( 'yes' === get_option( 'alg_dtwp_fix_reviews_change', 'yes' ) ) {
				remove_filter( 'comments_clauses', array( \Automattic\WooCommerce\Internal\Admin\ProductReviews\ReviewsUtil::class, 'comments_clauses_without_product_reviews' ), 10 );
			}
		}
	}
}