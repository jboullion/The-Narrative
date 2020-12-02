<?php
	// add "Shop Manager" role to "webadmin" user upon plugin activation
	register_activation_hook('woocommerce/woocommerce.php', 'sp_woocommerce_activation', 9999);
	function sp_woocommerce_activation() {
		$user = get_user_by('login', 'webadmin');
		if(is_object($user)) {
			$caps = get_user_meta($user->ID, 'wp_capabilities', true);
			if(is_array($caps)) {
				$caps['shop_manager'] = 1;
				update_user_meta($user->ID, 'wp_capabilities', $caps);
			}
		}
	}
	
	// if the woocommerce class doesn't exist, get out
	if(!class_exists('WooCommerce')) { return; }
   
	// hide admin bar from customers
	if(!is_admin() && !current_user_can('administrator') && !current_user_can('web_administrator')) {
		add_filter('show_admin_bar', '__return_FALSE');
	}

	//If all variations share the same price, the price does not show by default. So this filter will force Woocommerce to always show a variable products price
	add_filter( 'woocommerce_show_variation_price', '__return_true' );

	/**
	 * Updates the billing fields -- removes "Town" from "Town/City" and 
	 * reorders the billing fields so that the password field for adding an account
	 * is preceeded by the email field rather than the phone field. If the phone
	 * field is left in place, browsers offer to save the phone number/password combination
	 * for the account, rather than the email/password combination
	 */
	add_filter('woocommerce_checkout_fields' , 'sp_update_fields');
	if(!function_exists('sp_update_fields')) {
		function sp_update_fields( $fields ) {
			
			$fields['billing']['billing_city']['label'] = 'City';
			$fields['billing']['billing_city']['placeholder'] = 'City';
			$fields['shipping']['shipping_city']['label'] = 'City';
			$fields['shipping']['shipping_city']['placeholder'] = 'City';
			
			$new_fields = array();
			$new_fields['billing']['billing_country'] = $fields['billing']['billing_country'];
			$new_fields['billing']['billing_first_name'] = $fields['billing']['billing_first_name'];
			$new_fields['billing']['billing_last_name'] = $fields['billing']['billing_last_name'];
			$new_fields['billing']['billing_company'] = $fields['billing']['billing_company'];
			$new_fields['billing']['billing_address_1'] = $fields['billing']['billing_address_1'];
			$new_fields['billing']['billing_address_2'] = $fields['billing']['billing_address_2'];
			$new_fields['billing']['billing_city'] = $fields['billing']['billing_city'];
			$new_fields['billing']['billing_state'] = $fields['billing']['billing_state'];
			$new_fields['billing']['billing_postcode'] = $fields['billing']['billing_postcode'];
			$new_fields['billing']['billing_email'] = $fields['billing']['billing_email'];			
			$new_fields['billing']['billing_phone'] = $fields['billing']['billing_phone'];
			
			$fields['billing'] = $new_fields['billing'];
			
			return $fields;
		}
	}