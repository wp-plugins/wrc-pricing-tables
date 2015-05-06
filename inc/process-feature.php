<?php
function wrcpt_process_package_features() {
	$i = 1; $fp = 1;
	$pricing_table = $_POST['packtable'];
	$package_feature = get_option($pricing_table.'_feature');
	$featureNum = count($package_feature)/2;
	$package_lists = get_option($pricing_table);
	$packageOptions = explode(', ', $package_lists);
?>
	<input type="hidden" name="process_feature" value="feature" />
	<div id="tablenamediv">
	<?php if($package_feature) { ?>
		<div id="pricingfeaturediv">
			<div class="pricingfeaturewrap">
				<h3>Pricing Column Features</h3>
				<table id="feature_edititem" cellspacing="0">
					<thead>
						<tr class="featheader">
							<th>Features<a href="#" class="wrc_tooltip" rel="Enter your pricing table features in the text box. A feature is a distinctive characteristic of a good or service that sets it apart from similar items. Means of providing benefits to customers."></a></th>
							<th>Type</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
					<?php for($i = 1; $i <= $featureNum; $i++) { ?>
						<tr class="featurebody">
							<td><input type="text" name="feature_name[<?php echo 'fitem'.$i; ?>]" value="<?php echo $package_feature['fitem'.$i]; ?>" placeholder="Enter Feature Name" size="30" required />
							<?php
							foreach($packageOptions as $option => $value) {
								$packageItem = get_option($value);
							?>
								<input type="hidden" name="feature_value[]" value="<?php echo $packageItem['fitem'.$fp]; ?>" />
								<input type="hidden" name="tooltips[]" value="<?php echo $packageItem['tip'.$fp]; ?>" />
							<?php } $fp++; ?>
							</td>
							<td>
								<select name="feature_type[]" id="feature_type">
									<?php if($package_feature['ftype'.$i] == 'text') { ?>
									<option value="text" selected="selected">Text</option>
									<option value="check">Checkbox</option>
									<?php } elseif($package_feature['ftype'.$i] == 'check') { ?>
									<option value="text">Text</option>
									<option value="check" selected="selected">Checkbox</option>
									<?php } else { ?>
									<option value="text" selected="selected">Text</option>
									<option value="check">Checkbox</option>
									<?php } ?>
								</select>
							</td>
							<td><span id="remFeatute"></span></td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
				<input type="button" id="editfeature" class="button-primary" value="Add New" />
			</div>
		</div>
		<input type="hidden" name="pricing_table" value="<?php echo $pricing_table; ?>" />
		<input type="hidden" name="package_feature" value="<?php echo $pricing_table.'_feature'; ?>" />
		<input type="submit" id="wrcpt_upfeature" name="wrcpt_upfeature" class="button-primary" value="<?php echo 'Update Feature'; ?>" />
	<?php } else { ?>
		<div id="pricingfeaturediv">
			<div class="pricingfeaturewrap">
				<h3>Pricing Column Features</h3>
				<table id="feature_edititem" cellspacing="0">
					<tr class="featheader">
						<th>Features<a href="#" class="wrc_tooltip" rel="Enter your pricing table features in the text box. A feature is a distinctive characteristic of a good or service that sets it apart from similar items. Means of providing benefits to customers."></a></th>
						<th>Type</th>
						<th>Actions</th>
					</tr>
					<tr class="featurebody">
						<td><input type="text" name="feature_name[]" value="" placeholder="Enter Feature Name" size="30" required /></td>
						<td>
							<select name="feature_type[]" id="feature_type">
								<option value="text" selected="selected">Text</option>
								<option value="check">Checkbox</option>
							</select>
						</td>
						<td><span id="remFeatute"></span></td>
					</tr>
				</table>
				<input type="button" id="editfeature" class="button-primary" value="Add New" />
			</div>
		</div>
		<input type="hidden" name="package_feature" value="<?php echo $pricing_table.'_feature'; ?>" />
		<input type="submit" id="wrcpt_addfeature" name="wrcpt_addfeature" class="button-primary" value="<?php echo 'Add Feature'; ?>" /> 
	<?php } ?>
	</div>
	<div class="wrcpt-clear"></div>
	<div class="table_list">
		<p class="feature_notice">*** You can reorder features by dragging with the mouse ***</p>
	</div>
<?php
	die;
}
add_action( 'wp_ajax_nopriv_wrcpt_process_package_features', 'wrcpt_process_package_features' );
add_action( 'wp_ajax_wrcpt_process_package_features', 'wrcpt_process_package_features' );

if(isset($_POST['process_feature']) && $_POST['process_feature'] == "feature") {
	if( isset( $_POST['wrcpt_addfeature'] ) ) { wrcpt_add_package_features(); }
	if( isset( $_POST['wrcpt_upfeature'] ) ) { wrcpt_update_package_features(); }
}
?>