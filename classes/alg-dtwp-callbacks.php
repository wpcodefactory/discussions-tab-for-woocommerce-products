<?php
/**
 * Discussions tab for WooCommerce Products - Callbacks
 *
 * @version 1.0.1
 * @since   1.0.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'Alg_DTWP_Callbacks' ) ) {

	class Alg_DTWP_Callbacks {

		/**
		 * @var Alg_DTWP_Core
		 */
		public $core;

		/**
		 * @var Alg_DTWP_Registry
		 */
		public $registry;

		/**
		 * Alg_DTWP_Callbacks constructor.
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 *
		 * @param Alg_DTWP_Core $core
		 */
		function __construct( Alg_DTWP_Core $core ) {
			$this->core     = $core;
			$this->registry = $this->core->registry;
		}

		/**
		 * Create admin settings sections
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		public function admin_create_sections() {
			$this->registry->get_admin_settings()->create_sections();
		}

		/**
		 * Filters "plugin_action_link" for the admin_settings
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 *
		 * @param $links
		 *
		 * @return array
		 */
		public function admin_plugin_action_links( $links ) {
			return $this->registry->get_admin_settings()->get_action_links( $links );
		}

		/**
		 * Creates settings page
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 *
		 * @param $settings
		 *
		 * @return array
		 */
		public function admin_wc_get_settings_pages( $settings ) {
			$settings[] = new Alg_DTWP_Admin_Settings_Page();
			return $settings;
		}

		/**
		 * Creates initial general settings (enable|disable plugin)
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 *
		 * @param $settings
		 *
		 * @return array
		 */
		public function admin_wc_get_settings_general( $settings ) {
			return $this->registry->get_admin_settings()->create_main_general_settings( $settings );
		}

		/**
		 * Adds discussions tab
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 *
		 * @param $tabs
		 *
		 * @return mixed
		 */
		public function discussions_add_discussions_tab( $tabs ) {
			return $this->registry->get_discussions_tab()->add_discussions_tab( $tabs );
		}

		/**
		 * Adds discussions comment type in comment form
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		public function discussions_comment_form() {
			$this->registry->get_discussions()->add_discussions_comment_type_in_form();
		}

		/**
		 * Adds discussions comment type in comment data
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 *
		 * @param $comment_data
		 *
		 * @return mixed
		 */
		public function discussions_preprocess_comment( $comment_data ) {
			return $this->registry->get_discussions()->add_discussions_comment_type_in_comment_data( $comment_data );
		}

		/**
		 * Hides discussions comments on default callings
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		public function discussions_pre_get_comments( \WP_Comment_Query $query ) {
			$this->registry->get_discussions()->hide_discussion_comments_on_default_callings( $query );
		}

		/**
		 * Loads discussion comments
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 *
		 * @param $args
		 *
		 * @return mixed
		 */
		public function discussions_filter_comments_template_query_args( $args ) {
			return $this->registry->get_discussions()->filter_discussions_comments_template_query_args( $args );
		}

		/**
		 * Swaps woocommerce template (single-product-reviews.php) with default comments template
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 *
		 * @param $template
		 *
		 * @return mixed
		 */
		public function discussions_comments_template_loader( $template ) {
			return $this->registry->get_discussions()->load_discussions_comments_template( $template );
		}

		/**
		 * Fixes comment_parent input and cancel button
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		public function discussions_js_fix_comment_parent_id_and_cancel_btn() {
			$this->registry->get_discussions()->js_fix_comment_parent_id_and_cancel_btn();
		}

		/**
		 * Tags the respond form so it can have it's ID changed
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		public function discussions_create_respond_form_wrapper_start() {
			$this->registry->get_discussions()->create_respond_form_wrapper_start();
		}

		/**
		 * Tags the respond form so it can have it's ID changed
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		public function discussions_create_respond_form_wrapper_end() {
			$this->registry->get_discussions()->create_respond_form_wrapper_end();
		}

		/**
		 * Change reply link respond id
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 *
		 * @param $args
		 */
		public function discussions_change_reply_link_respond_id( $args ) {
			return $this->registry->get_discussions()->change_reply_link_respond_id( $args );
		}

		/**
		 * Fixes comments number
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 *
		 * @param $count
		 * @param $post_id
		 */
		public function discussions_fix_comments_number( $count, $post_id ) {
			return $this->registry->get_discussions()->fix_discussions_comments_number( $count, $post_id );
		}

		/**
		 * Fixes products reviews count
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 *
		 * @param $count
		 * @param $product
		 *
		 * @return array|int
		 */
		public function discussions_fix_reviews_number( $count, $product ) {
			return $this->registry->get_discussions()->fix_reviews_number( $count, $product );
		}

		/**
		 * Adds discussions comment type in admin comment types dropdown
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 *
		 * @param $types
		 *
		 * @return mixed
		 */
		public function discussions_admin_comment_types_dropdown( $types ) {
			return $this->registry->get_discussions()->add_discussions_in_admin_comment_types_dropdown( $types );
		}

		/**
		 * Adds a discussions metabox in product edit page
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		public function discussions_add_comments_cmb() {
			$this->registry->get_discussions_comments_cmb()->add_comments_cmb();
		}

		/**
		 * Override woocommerce locate template
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 *
		 * @param $template
		 * @param $template_name
		 * @param $template_path
		 *
		 * @return string
		 */
		public function functions_woocommerce_locate_template( $template, $template_name, $template_path ) {
			return $this->registry->get_functions()->woocommerce_locate_template( $template, $template_name, $template_path );
		}

		/**
		 * Get avatar
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 *
		 * @param $avatar
		 * @param $id_or_email
		 * @param $args
		 *
		 * @return bool|string
		 */
		public function discussions_get_avatar($avatar, $id_or_email, $args){
			return $this->registry->get_discussions()->get_avatar($avatar, $id_or_email, $args);
		}

		/**
		 * Enqueues main scripts
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		public function functions_load_main_scripts() {
			return $this->registry->get_functions()->load_main_scripts();
		}

		/**
		 * Filters params passed to wp_list_comments function
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 *
		 * @param $args
		 *
		 * @return mixed
		 */
		public function discussions_filter_wp_list_comments_args( $args ) {
			return $this->registry->get_discussions()->filter_wp_list_comments_args( $args );
		}

		/**
		 * Filters the class of wp_list_comments wrapper
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 *
		 * @param $class
		 */
		public function discussions_filter_wp_list_comments_wrapper_class( $class ) {
			return $this->registry->get_discussions()->filter_wp_list_comments_wrapper_class( $class );
		}

		/**
		 * Filters the comment class
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 * @param $class
		 *
		 * @return mixed
		 */
		public function discussions_filter_comment_class( $class ) {
			return $this->registry->get_discussions()->filter_comment_class( $class );
		}

		/**
		 * Fixes Hub theme get_comment_type()
		 *
		 * @version 1.0.1
		 * @since   1.0.1
		 *
		 * @param $type
		 *
		 * @return string
		 */
		public function discussions_fix_hub_get_comment_type( $type ) {
			return $this->registry->get_discussions()->fix_hub_get_comment_type( $type );
		}

		/**
		 * Changes comment link to "#discussion-"
		 *
		 * @version 1.0.2
		 * @since   1.0.2
		 * @param            $link
		 * @param WP_Comment $comment
		 * @param            $args
		 * @param            $cpage
		 *
		 * @return mixed
		 */
		public function discussions_change_comment_link($link, $comment, $args, $cpage){
			return $this->registry->get_discussions()->change_comment_link($link, $comment, $args, $cpage);
		}

		/**
		 * Opens discussions tab in frontend after a discussion comment is posted
		 *
		 * @version 1.0.2
		 * @since   1.0.2
		 */
		public function discussions_js_open_discussions_tab() {
			$this->registry->get_discussions()->js_open_discussions_tab();
		}

	}
}