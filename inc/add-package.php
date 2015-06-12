<?php
function wrcpt_add_pricing_packages() {
	$pricing_table = $_POST['packtable'];
	$pricing_table_name = ucwords(str_replace('_', ' ', $pricing_table));
	$package_feature = get_option($pricing_table.'_feature');
	$featureNum = count($package_feature)/2;
	$checkValue = uniqid('yes');
?>
	<div id="tablecolumndiv">
		<div class="tablecolumnwrap">
			<h3>Pricing Table Columns</h3>
			<div id="addButtons"><a href="#" class="button button-large" id="addPackage">New Column</a></div>
			<div id="sortable_column">
				<div id="wrcpt-1" class="package_details">
					<h4 id="pcolumn1">Pricing Column 1</h4>
					<span id="delDisable"></span>
			  		<div id="accordion1" class="column_container">
			  			<h3 class="ptitle">Pricing Column Details</h3>
			  			<div class="element-input">
							<h4>Package Name<a href="#" class="wrc_tooltip" rel="Enter your pricing package name here. You can also enter a short description of the package name. There are many users who choose a package based on the name, instead of features. So, a short description might help users to select the appropriate package."></a></h4>
			  				<label class="input-title">Package Name</label>
			  				<input type="text" name="package_type[]" class="medium" id="package_type" value="" placeholder="e.g. Enterprise" /><hr />
							<h4>Package Pricing<a href="#" class="wrc_tooltip" rel="Enter package price, unit (currency) and plan here."></a></h4>
			  				<label class="input-title">Package Price</label>
			  				<input name="price_number[]" type="text" class="col_price" value="" placeholder="0" />&nbsp;.&nbsp;<input name="price_fraction[]" type="number" class="col_price" value="" min="0" max="99" placeholder="00" />
			  				<label class="input-title">Price Unit</label>
			  				<input name="price_unit[]" id="price_unit" type="text" class="medium" value="" placeholder="e.g. $" />
			  				<label class="input-title">Price Plan</label>
			  				<input name="package_plan[]" id="package_plan" type="text" class="medium" value="" placeholder="e.g. month" /><hr />
							<h4>Package Features<a href="#" class="wrc_tooltip" rel="Enter your package feature values and feature ToolTips here. To show the tick icon write 'yes' in the TextBox or mark the checkbox and to show cross icon write 'no' or leave blank the TextBox or unmark the checkbox."></a></h4>
			  				<?php
			  				if($package_feature) {
			  					for($i = 1; $i <= $featureNum; $i++) {
			  				?>
								<?php if($package_feature['ftype'.$i] == 'text') { ?>
									<label class="input-title"><?php echo $package_feature['fitem'.$i]; ?></label>
									<input type="text" class="medium" name="feature_value[]" id="feature_value" value="" placeholder="Feature Value" />
									<textarea name="tooltips[]" id="tooltips" class="medium" cols="27" rows="2" placeholder="Enter Tooltip"></textarea><hr />
								<?php } else { ?>
									<label class="input-check"><?php echo $package_feature['fitem'.$i]; ?></label>
									<input type="checkbox" name="feature_value[]" class="tickbox" id="feature_value" value="<?php echo $checkValue; ?>" /> 
									<textarea name="tooltips[]" id="tooltips" class="medium" cols="27" rows="2" placeholder="Enter Tooltip"></textarea><hr />
								<?php } ?>
			  				<?php
			  					}
			  				} else { echo '<label class="input-title">Please add some features to get feature list.</label>'; }
			  				?>
							<h4>Package Button<a href="#" class="wrc_tooltip" rel="Enter your call to action text and call to action URL here. The URL is usually either a payment link or a page where users can create an account."></a></h4>
			  				<label class="input-title">Button Text</label>
			  				<input type="text" name="button_text[]" class="medium" id="button_text" value="" placeholder="e.g. Buy Now!" />
			  				<label class="input-title">Button Link</label>
			  				<input type="text" name="button_link[]" class="medium" id="button_link" value="" placeholder="e.g. http://example.com" />
							<h4>Package Ribbon<a href="#" class="wrc_tooltip" rel="Enter your package ribbon text here to make packages more attractive to users, like 'best', 'new', 'hot' etc."></a></h4>
			  				<label class="input-title">Ribbon Text</label>
			  				<input type="text" name="ribbon_text[]" class="medium" id="ribbon_text" value="" placeholder="e.g. Best" />
			  			</div>
			  			<h3 class="ptitle">Pricing Column Colors</h3>
			  			<div class="element-input">
							<table>
								<!--Background Color -->
								<tr class="table-header">
									<td>Background Colors</td>
								</tr>
								<tr class="table-input">
									<th><label class="input-title">Table Background Color</label></th>
									<td><input type="text" name="table_bg[]" class="table_bg1" id="table_bg" value="#44A3D5" /></td>
								</tr>
								<tr class="table-input">
									<th><label class="input-title">Ribbon Background Color</label></th>
									<td><input type="text" name="ribbon_bg[]" class="ribbon_bg1" id="ribbon_bg" value="#CB0000" /></td>
								</tr>
								<!--Font Color -->
								<tr class="table-header">
									<td>Font Colors</td>
								</tr>
								<tr class="table-input">
									<th><label class="input-title">Title Font Color</label></th>
									<td><input type="text" name="title_color[]" class="title_color1" id="title_color" value="#FFFFFF" /></td>
								</tr>
								<tr class="table-input">
									<th><label class="input-title">Price Font Color</label></th>
									<td><input type="text" name="price_color_big[]" class="price_color_big1" id="price_color_big" value="#FFFFFF" /></td>
								</tr>
								<tr class="table-input">
									<th><label class="input-title">Ribbon Font Color</label></th>
									<td><input type="text" name="ribbon_text_color[]" class="ribbon_text_color1" id="ribbon_text_color" value="#333333" /></td>
								</tr>
								<!--Button Color -->
								<tr class="table-header">
									<td>Button Colors</td>
								</tr>
								<tr class="table-input">
									<th><label class="input-title">Button Font Color</label></th>
									<td><input type="text" name="button_text_color[]" class="button_text_color1" id="button_text_color" value="#FFFFFF" /></td>
								</tr>
								<tr class="table-input">
									<th><label class="input-title">Button Font Hover Color</label></th>
									<td><input type="text" name="button_text_hover[]" class="button_text_hover1" id="button_text_hover" value="#000000" /></td>
								</tr>
								<tr class="table-input">
									<th><label class="input-title">Button Color</label></th>
									<td><input type="text" name="button_color[]" class="button_color1" id="button_color" value="#333333" /></td>
								</tr>
								<tr class="table-input">
									<th><label class="input-title">Button Hover Color</label></th>
									<td><input type="text" name="button_hover[]" class="button_hover1" id="button_hover" value="#cccccc" /></td>
								</tr>
							</table>
						</div>
			  			<input type="hidden" name="pricing_packages[]" value="" />
			  		</div>	<!-- End of column_container -->
				</div>	<!-- End of package_details -->
			</div>	<!--sortable_column -->
		</div>	<!--tablecolumnwrap -->
	</div>	<!--tablecolumndiv -->
	<div class="wrcpt-clear"></div>
	<div id="settingcolumndiv">
		<div class="settingcolumnwrap">
			<h3>Pricing Table Settings</h3>
			<div id="accordion_advance" class="package_advance">
				<h3 class="ptitle">General Settings</h3>
				<div class="advance-input">
					<label class="input-check">Enable Pricing Table:
					<input type="checkbox" name="wrcpt_option" class="tickbox" id="wrcpt_option" value="yes" /></label>
					<label class="input-title">Modify Pricing Table Name</label>
					<input type="text" name="pricing_table_name" class="medium" id="pricing_table_name" value="<?php echo $pricing_table_name; ?>" />
					<label class="input-title">Pricing Table Container Width<a href="#" class="wrc_tooltip" rel="Enter the total width of your pricing table here."></a></label>
					<input type="text" name="container_width" class="medium" id="container_width" value="99%" placeholder="e.g. 99%" />
					<label class="input-title">Number of Columns per Row<a href="#" class="wrc_tooltip" rel="If your pricing table has a lot of columns, then you can split the columns according to the rows by entering the number of columns in the right TextBox."></a></label>
					<input type="number" name="max_column" class="medium" id="max_column" value="4" placeholder="e.g. 6" />
					<label class="input-title">Space Between Columns</label>
					<input type="text" name="column_space" class="medium" id="column_space" value="1px" placeholder="e.g. 1px" />
					<label class="input-check">Disable Auto Column Width:
					<input type="checkbox" name="auto_column" class="tickbox" id="auto_column" value="yes" /></label>
					<label class="input-title" id="col_width">Each Columns Width</label> 
					<input type="text" name="column_width" class="medium" id="column_width" value="" placeholder="e.g. 200px" />
					<label class="input-check">Enable Caption Column:<a href="#" class="wrc_tooltip" rel="If you want to show feature items name separately on the left of the pricing table instead of showing beside each feature values of the pricing columns, then mark this checkbox."></a>
					<input type="checkbox" name="feature_caption" class="tickbox" id="feature_caption" value="yes" /></label>
					<label class="input-title" id="cap_col_width">Caption Column Width</label>
					<input type="text" name="cap_column_width" class="medium" id="cap_column_width" value="" placeholder="e.g. 250px" />
					<label class="input-check">Enlarge Column on Hover:
					<input type="checkbox" name="enlarge_column" class="tickbox" id="enlarge_column" value="yes" /></label>
					<label class="input-check">Disable Shadow on Highlight:
					<input type="checkbox" name="disable_shadow" class="tickbox" id="disable_shadow" value="yes" /></label>
					<label class="input-check">Enable Feature Tooltips:
					<input type="checkbox" name="enable_tooltip" class="tickbox" id="enable_tooltip" value="yes" /></label>
					<label class="input-check">Enable Package Ribbons:
					<input type="checkbox" name="enable_ribbon" class="tickbox" id="enable_ribbon" value="yes" /></label>
				</div>
				<h3 class="ptitle">Font Settings</h3>
				<div class="advance-input">
					<label class="input-title">Pricing Table Name Font Size</label>
					<input type="text" name="caption_size" class="medium" id="caption_size" value="" placeholder="e.g. 36px" />
					<label class="input-title">Title Font Size</label>
					<input type="text" name="title_size" class="medium" id="title_size" value="" placeholder="e.g. 24px" />
					<label class="input-title">Price Font Size (Big)</label>
					<input type="text" name="price_size_big" class="medium" id="price_size_big" value="" placeholder="e.g. 60px" />
					<label class="input-title">Price Font Size (Small)</label>
					<input type="text" name="price_size_small" class="medium" id="price_size_small" value="" placeholder="e.g. 24px" />
					<label class="input-title">Button Text Font Size</label>
					<input type="text" name="button_text_size" class="medium" id="button_text_size" value="" placeholder="e.g. 12px" />
					<label class="input-title">Ribbon Text Font Size</label>
					<input type="text" name="ribbon_text_size" class="medium" id="ribbon_text_size" value="" placeholder="e.g. 12px" />
				</div>
			</div>	<!--package_advance -->
		</div>	<!--settingcolumnwrap -->
	</div>	<!--settingcolumndiv -->
	<div class="wrcpt-clear"></div>
	<input type="hidden" name="pricing_table" value="<?php echo $pricing_table; ?>" />
	<input type="hidden" name="checkbox_value" value="<?php echo $checkValue; ?>" />
	<input type="submit" id="wrcpt_add" name="wrcpt_add" class="button-primary" value="<?php _e('Add Package'); ?>" />
<?php
	die;
}
add_action( 'wp_ajax_nopriv_wrcpt_add_pricing_packages', 'wrcpt_add_pricing_packages' );
add_action( 'wp_ajax_wrcpt_add_pricing_packages', 'wrcpt_add_pricing_packages' );

if(isset($_POST['wrcpt_edit_process']) && $_POST['wrcpt_edit_process'] == "editprocess") {
	if( isset( $_POST['wrcpt_add'] ) ) { wrcpt_save_pricing_packages(); }
}
?>