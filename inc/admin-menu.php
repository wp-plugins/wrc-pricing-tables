<?php
add_action('admin_menu', 'wrcpt_register_menu');
define( 'WRCPT_DOMAIN', 'wrc-pricing-tables' );
function wrcpt_register_menu() {
	add_menu_page('WRC Pricing Table', 'Pricing Tables', 'add_users', __FILE__, 'wrcpt_plugin_menu', plugins_url('wrc-pricing-tables/images/icon.png'));
	add_submenu_page(__FILE__, __('WRCPT Lists', WRCPT_DOMAIN ), __('All Pricing Tables', WRCPT_DOMAIN ), 'add_users', __FILE__, 'wrcpt_plugin_menu');
	add_submenu_page(__FILE__, 'WRCPT Guide', 'Guide', 'add_users', 'wrcpt_guide', 'wrcpt_guide_page');
}
function wrcpt_guide_page() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	include ( WRCPT_PLUGIN_PATH . 'inc/wrcpt-guide.php' );
}
function wrcpt_plugin_menu() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	include ( WRCPT_PLUGIN_PATH . 'inc/process-table.php' );
}
include ( WRCPT_PLUGIN_PATH . 'lib/process_table-option.php' );
include ( WRCPT_PLUGIN_PATH . 'inc/add-package.php' );
include ( WRCPT_PLUGIN_PATH . 'inc/modify-package.php' );
include ( WRCPT_PLUGIN_PATH . 'inc/process-feature.php' );
include ( WRCPT_PLUGIN_PATH . 'inc/display-package.php' );
include ( WRCPT_PLUGIN_PATH . 'inc/wrc-sidebar.php' );
if(isset($_POST['new_pricing_table']) && $_POST['new_pricing_table'] == "newtable") {
	if( isset( $_POST['wrcpt_add_new'] ) ) { wrcpt_add_new_table(); }
}
?>