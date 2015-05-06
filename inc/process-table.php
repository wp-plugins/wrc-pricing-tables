<?php
$package_table = get_option('packageTables');
$url = htmlspecialchars($_SERVER['HTTP_REFERER']);
?>
<div class="wrap">
	<div id="add_new_table" class="postbox-container" style="width:75%;">
	<h2 class="main-header">Pricing Tables <a href="#" id="new_table" class="add-new-h2">Add New</a><span id="wrcpt-loading-image"></span></h2>
	<form id='wrcpt_new' method="post" action="">
		<input type="hidden" name="new_pricing_table" value="newtable" />
		<div id="tablenamediv">
			<div class="tablenamewrap">
				<h3>Pricing Table Name</h3>
				<input type="text" name="pricing_table" size="30" value="" id="title" autocomplete="off" placeholder="Enter Pricing Table Name" required />
			</div>
			<div id="pricingfeaturediv">
				<div class="pricingfeaturewrap">
					<h3>Pricing Column Features</h3>
					<table id="feature_additem" cellspacing="0">
						<tr class="featheader">
							<th>Features<a href="#" class="wrc_tooltip" rel="Enter your pricing table features in the text box. A feature is a distinctive characteristic of a good or service that sets it apart from similar items. Means of providing benefits to customers."></a></th>
							<th>Type</th>
							<th>Actions</th>
						</tr>
						<tr class="featurebody">
							<td><input type="text" name="feature_name[]" value="" placeholder="Enter Feature Name" required /></td>
							<td>
								<select name="feature_type[]" id="feature_type">
									<option value="text" selected="selected">Text</option>
									<option value="check">Checkbox</option>
								</select>
							</td>
							<td><span id="remDisable"></span></td>
						</tr>
					</table>
					<input type="button" id="addfeature" class="button-primary" value="Add New" />
				</div>
			</div>
			<input type="submit" id="wrcpt_add_new" name="wrcpt_add_new" class="button-primary" value="<?php _e('Add Table'); ?>" />
		</div>
	</form>
	<?php if($package_table) { ?>
		<div class="table_list">
			<form id='wrcpt_edit_form' method="post" action="" enctype="multipart/form-data">
				<input type="hidden" name="wrcpt_edit_process" value="editprocess" />
				<table id="wrcpt_list" class="form-table">
					<thead>
						<tr>
							<th>ID</th>
							<th>Table Name</th>
							<th>Shortcode</th>
							<th>Visible</th>
						</tr>
					</thead>
			<?php
			$table_lists = explode(', ', $package_table);
			foreach($table_lists as $key => $list) {
				$list_item = ucwords(str_replace('_', ' ', $list));
				$package_lists = get_option($list);
				$package_feature = get_option($list.'_feature');
				$packageCombine = get_option($list.'_option');
				$package_item = explode(', ', $package_lists);
				$packageCount = count($package_item);
				$tableId = $key+1;
			?>
				<?php if($package_feature) { ?>
					<?php if(get_option($list) && $packageCount > 0) { ?>
						<tbody id="wrcpt_<?php echo $list; ?>">
							<tr <?php if($tableId % 2 == 0) { echo 'class="alt"'; } ?>>
								<td><?php echo $tableId; ?></td>
								<td class="table_name" id="<?php echo $list; ?>">
									<div onclick="wrcpteditpackages(<?php echo $packageCount; ?>, '<?php echo $list; ?>')"><?php echo $list_item; ?></div>
									<span id="edit_package" onclick="wrcpteditpackages(<?php echo $packageCount; ?>, '<?php echo $list; ?>')">Edit Columns</span>
									<span id="add_feature" onclick="wrcpteditfeature('<?php echo $list; ?>')">Edit Features</span>
									<span id="view_package" onclick="wrcptviewpack(<?php echo $tableId; ?>, '<?php echo $list; ?>')">Preview</span>
									<span id="remTable" onclick="wrcptdeletetable('<?php echo $list; ?>')">Delete</span>
								</td>
								<td class="wrc_shortcode"><?php echo '[wrc-pricing-table id="'.$tableId.'"]'; ?></td>
								<td><?php if($packageCombine['enable'] == 'yes') {_e('Yes');} else {_e('No');} ?></td>
							</tr>
						</tbody>
					<?php } else { ?>
						<tbody id="wrcpt_<?php echo $list; ?>">
							<tr <?php if($tableId % 2 == 0) { echo 'class="alt"'; } ?>>
								<td><?php echo $tableId; ?></td>
								<td class="table_name" id="<?php echo $list; ?>">
									<div onclick="wrcptaddpack('<?php echo $list; ?>')"><?php echo $list_item; ?></div>
									<span id="add_package" onclick="wrcptaddpack('<?php echo $list; ?>')">Add Columns</span>
									<span id="add_feature" onclick="wrcpteditfeature('<?php echo $list; ?>')">Edit Features</span>
									<span id="remTable" onclick="wrcptdeletetable('<?php echo $list; ?>')">Delete</span>
								</td>
								<td class="wrcpt_notice"><span>Mouseover on the table name in the left and clicked on <strong>Add Columns</strong> link. After adding pricing columns you will get the <strong>SHORTCODE</strong> here.</td>
								<td>No</td>
							</tr>
						</tbody>
					<?php } ?>
				<?php } else { ?>
					<tbody id="wrcpt_<?php echo $list; ?>">
						<tr <?php if($tableId % 2 == 0) { echo 'class="alt"'; } ?>>
							<td><?php echo $tableId; ?></td>
							<td class="table_name" id="<?php echo $list; ?>">
								<div onclick="wrcpteditfeature('<?php echo $list; ?>')"><?php echo $list_item; ?></div>
								<span id="add_feature" onclick="wrcpteditfeature('<?php echo $list; ?>')">Add Features</span>
								<span id="remTable" onclick="wrcptdeletetable('<?php echo $list; ?>')">Delete</span>
							</td>
							<td class="wrcpt_notice"><span>Mouseover on the table name in the left and clicked on <strong>Add Feature</strong> link. To get started you have to add some pricing features first. After that, you will be able to add pricing columns. After adding pricing columns you will get the <strong>SHORTCODE</strong> here.</span></td>
							<td>No</td>
						</tr>
					</tbody>
				<?php } ?>
			<?php } ?>
				</table>
			</form>
		</div>
	<?php } else { ?>
		<div class="table_list">
			<p class="get_started">You didn't add any pricing tables yet! Click on <strong>Add New</strong> button to get started. If you feel trouble to understand what to do, then navigate to <strong>Pricing Tables >> Guide</strong> and follow the guidelines described there.</p>
		</div>
	<?php } ?>
	</div><!-- End postbox-container -->
	<?php wrcpt_sidebar(); ?>
</div>