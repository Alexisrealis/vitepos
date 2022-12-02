<?php
/**
 * It is template of pos client
 *
 * @var \VitePos\Modules\POS_Settings $this
 *
 * @package vitepos
 */
?>
<!DOCTYPE html><html lang="en" ><head><meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="theme-color" content="<?php echo esc_html($this->get_pos_color_code()) ?>">
	<link rel="icon" href="<?php echo  esc_url($this->get_favicon()); ?>">
    <link rel="manifest" href="<?php echo  esc_url($this->get_manifest_link()); ?>">
	<title>pos</title>
	<script>
        self.addEventListener('fetch', function(event) {})
		var vitePosBase="<?php echo esc_url( site_url() ); ?>/";
		var viteposSWJs="<?php echo $this->get_sw_link(); ?>";
		var vitePos= {
		    version:"<?php echo esc_html($this->kernel_object->plugin_version); ?>",
			heart_bit: 30000,
			currencySymbol: '<?php echo esc_html( html_entity_decode( get_woocommerce_currency_symbol() ) ); ?>',
			decimalPlaces: 2,
			login_type:"<?php echo esc_html( strtoupper( \VitePos\Modules\POS_Settings::get_module_option( 'login_type' ) ) ); ?>",
			ca_prefix:"<?php echo esc_attr( hash( 'crc32b', site_url() ) . '_' ); ?>",
			pos_link:"<?php echo esc_html( \VitePos\Modules\POS_Settings::get_module_instance()->get_pos_link( true ) ); ?>",
			wcnonce: "<?php echo esc_html( wp_create_nonce( 'wp_rest' ) ); ?>",
			date_format: "<?php echo esc_html( vitepos_get_client_date_format() ); ?>",
			time_format: "<?php echo esc_html( vitepos_get_client_time_format() ); ?>",
			wc_amount: function ($amount) {
				return $amount.toFixed(vitePos.decimalPlaces)
			},
			wc_price: function ($amount) {
				$amount = parseFloat($amount);
                $amount=vitePos.wc_amount($amount)
                var price_format=<?php echo json_encode($this->get_price_format_settigns()); ?>;
                var rx=  /(\d+)(\d{3})/;
                $amount= String($amount).replace(/^\d+/, function(w){
                    while(rx.test(w)){
                        w= w.replace(rx, '$1'+price_format.thousand_separator+'$2');
                    }
                    return w;
                });
                return price_format.price_format.replace('{{amt}}', $amount);
			},
			roundingFactor: "D",//D=Discount, F=Fee, N=none
			assets_path:'<?php $this->get_plugin_esc_url( 'templates/pos-assets' ); ?>/',
			urls: {
				sys_login:"",
				heart_bit: vitePosBase + "wp-json/vitepos/v1/system/heart-bit",
				country_list: vitePosBase + "wp-json/vitepos/v1/basic/countries",
				settings: vitePosBase + "wp-json/vitepos/v1/basic/settings",
				current_user: vitePosBase + "wp-json/vitepos/v1/user/current-user",
				get_logged_user: vitePosBase + "wp-json/vitepos/v1/user/get-logged-user",
				product_list: vitePosBase + "wp-json/vitepos/v1/product/list",
				list_variation: vitePosBase + "wp-json/vitepos/v1/product/list-variation",
				order_list: vitePosBase + "wp-json/vitepos/v1/order/order-list",
                online_list: vitePosBase + "wp-json/vitepos/v1/order/online-list",
				order_details: vitePosBase + "wp-json/vitepos/v1/order/details",
                change_status: vitePosBase + "wp-json/vitepos/v1/order/change-status",
				initials_data: vitePosBase + "wp-json/vitepos/v1/product/initial-data",
				make_payment: vitePosBase + "wp-json/vitepos/v1/order/make-payment",
				sync_offline_order: vitePosBase + "wp-json/vitepos/v1/order/sync-offline-order",
				product_details: vitePosBase + "wp-json/vitepos/v1/product/details",
				create_product: vitePosBase + "wp-json/vitepos/v1/product/create",
				update_product: vitePosBase + "wp-json/vitepos/v1/product/update",
				category_list: vitePosBase + "wp-json/vitepos/v1/product/categories",
                all_category_list: vitePosBase + "wp-json/vitepos/v1/product/all-categories",
                attributes_list: vitePosBase + "wp-json/vitepos/v1/product/attributes",
				get_stock: vitePosBase + "wp-json/vitepos/v1/product/getStock",
				scan_product: vitePosBase + "wp-json/vitepos/v1/product/scan-product",
				vendor_list: vitePosBase + "wp-json/vitepos/v1/vendor/list",
				vendor_details: vitePosBase + "wp-json/vitepos/v1/vendor/details",
				create_vendor: vitePosBase + "wp-json/vitepos/v1/vendor/create",
				update_vendor_status: vitePosBase + "wp-json/vitepos/v1/vendor/update_status",
				delete_vendor: vitePosBase + "wp-json/vitepos/v1/vendor/delete-vendor",
				delete_customer: vitePosBase + "wp-json/vitepos/v1/customer/delete-customer",
				delete_user: vitePosBase + "wp-json/vitepos/v1/user/delete-user",
				close_cashDrawer: vitePosBase + "wp-json/vitepos/v1/user/close-cash-drawer",
				delete_product: vitePosBase + "wp-json/vitepos/v1/product/delete-product",
                make_favorite: vitePosBase + "wp-json/vitepos/v1/product/make-favorite",
                outlet_list: vitePosBase + "wp-json/vitepos/v1/outlet/list",
				all_outlet_list: vitePosBase + "wp-json/vitepos/v1/outlet/all-outlet-list",
				cash_drawer_info: vitePosBase + "wp-json/vitepos/v1/outlet/cash-drawer-info",
                cash_drawer_log: vitePosBase + "wp-json/vitepos/v1/outlet/cash-drawer-log",
                drawer_log_details: vitePosBase + "wp-json/vitepos/v1/outlet/details",
				purchase_list: vitePosBase + "wp-json/vitepos/v1/purchase/list",
				create_purchase: vitePosBase + "wp-json/vitepos/v1/purchase/create",
				purchase_details: vitePosBase + "wp-json/vitepos/v1/purchase/details",
				create_customer: vitePosBase + "wp-json/vitepos/v1/customer/create",
				check_unique: vitePosBase + "wp-json/vitepos/v1/customer/check-unique",
				create_user: vitePosBase + "wp-json/vitepos/v1/user/create",
				user_login: vitePosBase + "wp-json/vitepos/v1/user/login",
				user_logout: vitePosBase + "wp-json/vitepos/v1/user/logout",
				change_pass: vitePosBase + "wp-json/vitepos/v1/user/change-pass",
				change_pass_force: vitePosBase + "wp-json/vitepos/v1/user/change-pass-force",
				customer_list: vitePosBase + "wp-json/vitepos/v1/customer/list",
				customerList: vitePosBase + "wp-json/vitepos/v1/customer/customer-list",
				user_list: vitePosBase + "wp-json/vitepos/v1/user/list",
				role_list: vitePosBase + "wp-json/vitepos/v1/user/roles",
				customer_details: vitePosBase + "wp-json/vitepos/v1/customer/details",
				user_details: vitePosBase + "wp-json/vitepos/v1/user/details",
				outlet_panel: vitePosBase + "wp-json/vitepos/v1/user/outlet-panel",
				// tax_list: "",
			},
			translationObj: {
				availableLanguages: {
					en_US: "American English"
				},
				defaultLanguage: "en_US",
				translations: {
					"en_US": <?php echo json_encode( \VitePos\Libs\Client_Language::get_pos_languages( $this->kernel_object ) ); ?>
				}
			}
		}</script>
	<?php
	/**
	 * Its for pos client header
	 *
	 * @since 1.0
	 */
	do_action( 'vitepos-client-header' );
	?>
</head>
	<body><noscript><strong> <?php echo esc_html( $this->kernel_object->__( "We're sorry but pos doesn't work properly without JavaScript enabled. Please enable it to continue." ) ); ?></strong></noscript>
    <div id="app">
			<div class="pre-loader">
				<?php echo esc_html( $this->kernel_object->__( 'Please wait ..' ) ); ?>
			</div>
		</div>
	<?php
	/**
	 * Its for pos client header
	 *
	 * @since 1.0
	 */
	do_action( 'vitepos-client-footer' );
	?>
	</body>
	</html>
