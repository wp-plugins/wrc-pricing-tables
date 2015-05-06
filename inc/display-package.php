<?php
function wrcpt_view_pricing_packages() {
	$i = 1;
	$pricing_table = $_POST['packtable'];
	$tableId = $_POST['tableid'];
	$package_lists = get_option($pricing_table);
	$packageOptions = explode(', ', $package_lists);
	$packageCount = count($packageOptions);
?>
	<div id="tabledisplaydiv">
		<h3><span id="editPackages" class="button button-large" onclick="wrcpteditpackages(<?php echo $packageCount; ?>, '<?php echo $pricing_table; ?>')">Edit Columns</span></h3>
		<?php echo do_shortcode('[wrc-pricing-table id="'.$tableId.'"]'); ?>
	</div>
<?php
	die;
}
add_action( 'wp_ajax_nopriv_wrcpt_view_pricing_packages', 'wrcpt_view_pricing_packages' );
add_action( 'wp_ajax_wrcpt_view_pricing_packages', 'wrcpt_view_pricing_packages' );
?>