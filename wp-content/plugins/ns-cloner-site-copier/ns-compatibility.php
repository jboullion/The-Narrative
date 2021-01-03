<?php
/**
 * Cloner Compatibility filters / functions.
 *
 * Location for any plugin-specific fixes, filters, or patches to keep them from cluttering up the main plugin.
 *
 * @package NS_Cloner
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Add known plugins with global tables to the global table list
 */
add_filter(
	'ns_cloner_global_table_patterns',
	function( $global_patterns ) {
		$plugin_patterns = [
			'domain_mapping.*',   // Domain mapping tables.
			'3wp_broadcast_.*',   // 3wp broadcast tables.
			'bp_.*',              // BuddyPress tables.
		];
		return array_merge( $global_patterns, $plugin_patterns );
	}
);

/**
 * Don't drop main slimstat table because it will cause a foreign key error
 * NOTE: this may cause problems in clone over mode - will have to address that down the road if necessary
 */
add_filter(
	'ns_cloner_do_drop_target_table',
	function( $do, $table ) {
		if ( strpos( $table, 'slim_stats' ) !== false ) {
			$do = false;
		}
		return $do;
	},
	10,
	2
);

/**
 * Skip copying options certain plugin options, because they will be created first
 * by the plugin and will result in a duplicate key error, or cause some other problem.
 */
add_filter(
	'ns_cloner_do_copy_row',
	function( $do, $row ) {
		$plugin_opts = [];
		// Jetpack.
		$plugin_opts = array_merge( $plugin_opts, [ 'jetpack_activated', 'jetpack_private_options' ] );
		// WC Multilingual
		$plugin_opts = array_merge( $plugin_opts, [ 'wcml_currency_switcher_template_objects' ] );
		// WP Mail SMTP.
		$plugin_opts = array_merge( $plugin_opts, [ 'mail_bank_update_database', 'mail-bank-version-number', 'mb_admin_notice' ] );
		// WordFence.
		$plugin_opts = array_merge( $plugin_opts, [ 'wordfence_installed' ] );
		// Yoast WP SEO.
		$plugin_opts = array_merge( $plugin_opts, [ 'wpseo_ryte'] );
		// Woo Discount Rules.
		$plugin_opts = array_merge( $plugin_opts, [ 'awdr_activity_log_version' ] );
		// Skip copying any of the above listed option rows.
		if ( isset( $row['option_name'] ) && in_array( $row['option_name'], $plugin_opts, true ) ) {
			$do = false;
		}
		return $do;
	},
	10,
	2
);

/**
 * Clear WP Engine cache on completion because cloned sites won't use the correct
 * theme + options without flushing if object caching is enabled.
 * Based from https://github.com/a7/wpe-cache-flush/ and issue #1 on that repo.
 */
add_action(
	'ns_cloner_process_finish',
	function() {
		if ( defined( 'PWP_NAME' ) ) {
			$wpe_nonce    = wp_create_nonce( PWP_NAME . '-config' );
			$wpe_endpoint = 'admin.php?page=wpengine-common&purge-all=1&_wpnonce=' . $wpe_nonce;
			wp_remote_get( is_multisite() ? network_admin_url( $wpe_endpoint ) : admin_url( $wpe_endpoint ) );
		}
	},
	10,
	99
);
