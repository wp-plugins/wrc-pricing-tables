<?php
function wrcpt_add_new_table() {
	$pricing_table = $_POST['pricing_table'] != '' ? trim(preg_replace('/[^A-Za-z0-9-]+/', '_', sanitize_text_field( $_POST['pricing_table'] ))) : '';
	if($pricing_table) {
		$package_table = get_option('packageTables');
		$table_lists = explode(', ', $package_table);
		if(!isset($package_table)) {
			add_option('packageTables', $pricing_table);
		} elseif(empty($package_table)){
			update_option('packageTables', $pricing_table);
		} else {
			if(in_array($pricing_table, $table_lists)) {
				$new_pricing_table = 'another_' . $pricing_table;
				$pricing_table_lists = $package_table . ', ' . $new_pricing_table;
				update_option('packageTables', $pricing_table_lists);
			} else {
				$pricing_table_lists = $package_table . ', ' . $pricing_table;
				update_option('packageTables', $pricing_table_lists);
			}
		}
		$fn = 1;
		$package_feature = $pricing_table.'_feature';
		$feature_type = $_POST['feature_type'];
		if(isset($_POST['feature_name'])) {
			foreach($_POST['feature_name'] as $key => $feature) {
				if($feature) {
					$feature_name['fitem'.$fn] = sanitize_text_field( $feature );
					$feature_name['ftype'.$fn] = $feature_type[$key];
					$fn++;
				} else {
					$feature_name['fitem'.$fn] = '';
					$feature_name['ftype'.$fn] = '';
					$fn++;
				}
			}
			add_option($package_feature, $feature_name);
		}
	}
}
function wrcpt_add_package_features() {
	$fn = 1;
	$package_feature = $_POST['package_feature'] != '' ? $_POST['package_feature'] : '';
	$feature_type = $_POST['feature_type'];
	if($package_feature) {
		if(isset($_POST['feature_name'])) {
			foreach($_POST['feature_name'] as $key => $feature) {
				if($feature) {
					$feature_name['fitem'.$fn] = sanitize_text_field( $feature );
					$feature_name['ftype'.$fn] = $feature_type[$key];
					$fn++;
				} else {
					$feature_name['fitem'.$fn] = '';
					$feature_name['ftype'.$fn] = '';
					$fn++;
				}
			}
			add_option($package_feature, $feature_name);
		}
	}
}
function wrcpt_update_package_features() {
	$fn = 1; $count_item = 0;
	$feature_type = isset($_POST['feature_type']) ? $_POST['feature_type'] : '';
	$package_feature = $_POST['package_feature'] != '' ? $_POST['package_feature'] : '';
	$feature_lists = get_option($package_feature);
	$pricing_table = $_POST['pricing_table'] != '' ? sanitize_text_field( $_POST['pricing_table'] ) : '';
	$package_lists = get_option($pricing_table);
	$packageOptions = explode(', ', $package_lists);
	if(isset($_POST['feature_name'])) { $count_item = count($_POST['feature_name']); }
	if($count_item > 0) {
		$feature_value = $_POST['feature_value'];
		$tooltips = $_POST['tooltips'];
		$sn = 0; $fd = 1;
		foreach($_POST['feature_name'] as $key => $feature) {
			if($feature) {
				$feature_name['fitem'.$fn] = sanitize_text_field( $feature );
				$feature_name['ftype'.$fn] = $feature_type[$fn-1];
				$fn++;
			}
			foreach($packageOptions as $item => $option) {
				$packageItem = get_option($option);
				if(array_key_exists($key, $feature_lists)) {
					$packageItem['fitem'.$fd] = $feature_value[$sn];
					$packageItem['tip'.$fd] = $tooltips[$sn];
					update_option($option, $packageItem);
					$sn++;
				} else {
					$packageItem['fitem'.$fd] = '';
					$packageItem['tip'.$fd] = '';
					update_option($option, $packageItem);
				}
			}
			$fd++;
		}
		update_option($package_feature, $feature_name);
	} else {
		$feature_name[] = '';
		delete_option($package_feature);
	}
	foreach($packageOptions as $key => $option) {
		$packageItem = get_option($option);
		$feature_item = (count($packageItem) - 39)/2;
		for($i = 1; $i <= $feature_item; $i++) {
			if($i > $count_item) {
				$feature_key = 'fitem'.$i;
				$tip_key = 'tip'.$i;
				unset($packageItem[$feature_key]);
				unset($packageItem[$tip_key]);
				update_option($option, $packageItem);
			}
		}
		$i = 1;
	}
}
function wrcpt_edit_pricing_table($edited_table, $pricing_table) {
	if($pricing_table && $pricing_table != $edited_table) {
		$package_table = get_option('packageTables');
		$table_item = explode(', ', $package_table);
		foreach($table_item as $key => $value) {
			if($value == $edited_table) {
				if(in_array($pricing_table, $table_item)) {
					$pricing_table = 'another_' . $pricing_table;
					$new_package_table[$key] = $pricing_table;
				} else {
					$new_package_table[$key] = $pricing_table;
				}
			} else {
				$new_package_table[$key] = $value;
			}
		}
		$new_package_table = implode(', ', $new_package_table);
		update_option('packageTables', $new_package_table);
		$edited_table_value = get_option($edited_table);
		if($edited_table_value) {
			delete_option($edited_table);
			add_option($pricing_table, $edited_table_value);
		}
		$edited_feature_value = get_option($edited_table.'_feature');
		if($edited_feature_value) {
			delete_option($edited_table.'_feature');
			add_option($pricing_table.'_feature', $edited_feature_value);
		}
		$edited_option_value = get_option($edited_table.'_option');
		if($edited_option_value) {
			delete_option($edited_table.'_option');
			add_option($pricing_table.'_option', $edited_option_value);
		}
		return $pricing_table;
	} else {
		return $edited_table;
	}
}
function wrcpt_delete_pricing_table() {
	$pricing_table = $_POST['packtable'];
	$package_table_lists = get_option('packageTables');
	$package_lists = get_option($pricing_table);
	if(isset($package_lists)) {
		if($package_lists) {
			$table_packages = explode(', ', $package_lists);
			foreach($table_packages as $package) { delete_option($package); }
		}
		delete_option($pricing_table);
	}
	$package_feature_lists = get_option($pricing_table.'_feature');
	$package_option_lists = get_option($pricing_table.'_option');
	if(isset($package_feature_lists)) { delete_option($pricing_table.'_feature'); }
	if(isset($package_option_lists)) { delete_option($pricing_table.'_option'); }
	$package_table_lists = explode(', ', $package_table_lists);
	$package_table_diff = array_diff($package_table_lists, array($pricing_table));
	if($package_table_diff) {
		$new_package_table_lists = implode(', ', $package_table_diff);
		update_option('packageTables', $new_package_table_lists);
	} else {
		delete_option('packageTables');
		delete_option('packageCount');
	}
	die;
}
add_action( 'wp_ajax_nopriv_wrcpt_delete_pricing_table', 'wrcpt_delete_pricing_table' );
add_action( 'wp_ajax_wrcpt_delete_pricing_table', 'wrcpt_delete_pricing_table' );
function wrcpt_update_pricing_table($pricing_table, $package_lists) {
	$package_count = get_option('packageCount');
	if(!isset($package_count)) {
		$package_count = 1;
		add_option('packageCount', $package_count);
	} elseif($package_count == 0) {
		$package_count = 1;
		update_option('packageCount', $package_count);
	} else {
		$package_count = $package_count + 1;
		update_option('packageCount', $package_count);
	}
	$optionName = 'packageOptions' . $package_count;
	if(!isset($package_lists)) {
		$package_lists = $optionName;
		add_option($pricing_table, $package_lists);
	} elseif(empty($package_lists)){
		$package_lists = $optionName;
		update_option($pricing_table, $package_lists);
	} else {
		$package_lists = $package_lists . ', ' . $optionName;
		update_option($pricing_table, $package_lists);
	}
	return $optionName;
}
function wrcpt_save_pricing_packages() {
	$fc = 0; $tc = 0;
	$pricing_table = $_POST['pricing_table'] != '' ? $_POST['pricing_table'] : '';
	$pricing_table_name = $_POST['pricing_table_name'] != '' ? trim(preg_replace('/[^A-Za-z0-9-]+/', '_', sanitize_text_field( $_POST['pricing_table_name'] ))) : $pricing_table;
	$pricing_table = wrcpt_edit_pricing_table($pricing_table, $pricing_table_name);
	$package_text_values = array( 'maxcol' => 'max_column', 'cwidth' => 'container_width', 'ctsize' => 'caption_size', 'tsize' => 'title_size', 'psbig' => 'price_size_big', 'pssmall' => 'price_size_small', 'btsize' => 'button_text_size', 'rtsize' => 'ribbon_text_size' );
	foreach($package_text_values as $key => $value) {
		if( isset( $_POST[$value] ) ) {
			$optionValue_text[$key] = sanitize_text_field( $_POST[$value] );
		}
	}
	$wrcpt_option = isset($_POST['wrcpt_option']) ? $_POST['wrcpt_option'] : 'no';
	$feature_caption = isset($_POST['feature_caption']) ? $_POST['feature_caption'] : 'no';
	$enlarge_column = isset($_POST['enlarge_column']) ? $_POST['enlarge_column'] : 'no';
	$disable_shadow = isset($_POST['disable_shadow']) ? $_POST['disable_shadow'] : 'no';
	$enable_tooltip = isset($_POST['enable_tooltip']) ? $_POST['enable_tooltip'] : 'no';
	$enable_ribbon = isset($_POST['enable_ribbon']) ? $_POST['enable_ribbon'] : 'no';
	$table_option = $pricing_table.'_option';
	$optionValue_check = array( 'enable' => $wrcpt_option, 'ftcap' => $feature_caption, 'encol' => $enlarge_column, 'dscol' => $disable_shadow, 'entips' => $enable_tooltip, 'enribs' => $enable_ribbon );
	$optionValue = array_merge($optionValue_text, $optionValue_check);
	add_option($table_option, $optionValue);
	$package_text_options = array( 'type' => 'package_type', 'price' => 'price_number', 'cent' => 'price_fraction', 'unit' => 'price_unit', 'plan' => 'package_plan', 'btext' => 'button_text', 'blink' => 'button_link', 'rtext' => 'ribbon_text', 'tbcolor' => 'table_bg', 'rbcolor' => 'ribbon_bg', 'tcolor' => 'title_color', 'pcbig' => 'price_color_big', 'rtcolor' => 'ribbon_text_color', 'btcolor' => 'button_text_color', 'bthover' => 'button_text_hover', 'bcolor' => 'button_color', 'bhover' => 'button_hover' );
	$package_features = $_POST['feature_value'] != '' ? $_POST['feature_value'] : '';
	$package_tooltips = $_POST['tooltips'] != '' ? $_POST['tooltips'] : '';
	$checkbox_value = $_POST['checkbox_value'] != '' ? $_POST['checkbox_value'] : '';
	$table_feature = $pricing_table.'_feature';
	$feature_items = get_option($table_feature);
	foreach($_POST['pricing_packages'] as $key => $package) {
		$vl = 1; $fk = 1;
		$package_lists = get_option($pricing_table);
		$optionName = wrcpt_update_pricing_table($pricing_table, $package_lists);
		$package_count = get_option('packageCount');
		$new_package_lists = get_option($pricing_table);
		$packageOptions = explode(', ', $new_package_lists);
		$list_count = count($packageOptions);
		foreach($feature_items as $fkey => $item) {
			if($fkey == 'fitem'.$fk) {
				if($feature_items['ftype'.$fk] == 'text') {
					if($package_features[$fc]) { $feature_value[$fkey] = sanitize_text_field( $package_features[$fc] ); }
					else { $feature_value[$fkey] = ''; }
				} else {
					if($package_features[$fc] == $checkbox_value) {
						$feature_value[$fkey] = 'yes';
					}
					else {
						$feature_value[$fkey] = 'no';
						$fc--;
					}
				}
				if($package_tooltips) {
					if($package_tooltips[$tc]) {
						$tooltips['tip'.$vl] = sanitize_text_field( $package_tooltips[$tc] );
						$vl++;
					} else {
						$tooltips['tip'.$vl] = '';
						$vl++;
					}
				}
				$fc++; $tc++;
			} else { $fk++; }
		}
		foreach($package_text_options as $pkey => $value) {
			if( isset( $_POST[$value] ) ) {
				$packValue = $_POST[$value];
				$packageOptions_text[$pkey] = sanitize_text_field( $packValue[$key] );
			}
		}
		$packageOptions_extra = array( 'pid' => $package_count, 'order' => $list_count );
		$mergePackages = array_merge($packageOptions_extra, $packageOptions_text, $feature_value, $tooltips);
		add_option($optionName, $mergePackages);
	}
}
function wrcpt_delete_pricing_packages($pricing_table, $new_lists) {
	$old_package_lists = get_option($pricing_table);
	$packageOptions = explode(', ', $old_package_lists);
	$package_diff = array_diff($packageOptions, $new_lists);
	foreach($package_diff as $delpack) { delete_option($delpack); }
}
function wrcpt_update_pricing_package() {
	$fc = 0; $tc = 0; $temp_id = 0; $cf = 1;
	$pricing_table = $_POST['pricing_table'] != '' ? $_POST['pricing_table'] : '';
	$pricing_table_name = $_POST['pricing_table_name'] != '' ? trim(preg_replace('/[^A-Za-z0-9-]+/', '_', sanitize_text_field( $_POST['pricing_table_name'] ))) : $pricing_table;
	$pricing_table = wrcpt_edit_pricing_table($pricing_table, $pricing_table_name);
	$package_text_values = array( 'maxcol' => 'max_column', 'cwidth' => 'container_width', 'ctsize' => 'caption_size', 'tsize' => 'title_size', 'psbig' => 'price_size_big', 'pssmall' => 'price_size_small', 'btsize' => 'button_text_size', 'rtsize' => 'ribbon_text_size' );
	foreach($package_text_values as $key => $value) {
		if( isset( $_POST[$value] ) ) {
			$optionValue_text[$key] = sanitize_text_field( $_POST[$value] );
		}
	}
	$wrcpt_option = isset($_POST['wrcpt_option']) ? $_POST['wrcpt_option'] : 'no';
	$feature_caption = isset($_POST['feature_caption']) ? $_POST['feature_caption'] : 'no';
	$enlarge_column = isset($_POST['enlarge_column']) ? $_POST['enlarge_column'] : 'no';
	$disable_shadow = isset($_POST['disable_shadow']) ? $_POST['disable_shadow'] : 'no';
	$enable_tooltip = isset($_POST['enable_tooltip']) ? $_POST['enable_tooltip'] : 'no';
	$enable_ribbon = isset($_POST['enable_ribbon']) ? $_POST['enable_ribbon'] : 'no';
	$table_option = $pricing_table.'_option';
	$optionValue_check = array( 'enable' => $wrcpt_option, 'ftcap' => $feature_caption, 'encol' => $enlarge_column, 'dscol' => $disable_shadow, 'entips' => $enable_tooltip, 'enribs' => $enable_ribbon );
	$optionValue = array_merge($optionValue_text, $optionValue_check);
	update_option($table_option, $optionValue);
	wrcpt_delete_pricing_packages($pricing_table, $_POST['pricing_packages']);
	$package_id = $_POST['package_id'] != '' ? $_POST['package_id'] : '';
	$order_id =  $_POST['order_id'] != '' ? $_POST['order_id'] : '';
	$package_type = $_POST['package_type'] != '' ? $_POST['package_type'] : '';
	$package_text_options = array( 'type' => 'package_type', 'price' => 'price_number', 'cent' => 'price_fraction', 'unit' => 'price_unit', 'plan' => 'package_plan', 'btext' => 'button_text', 'blink' => 'button_link', 'rtext' => 'ribbon_text', 'tbcolor' => 'table_bg', 'rbcolor' => 'ribbon_bg', 'tcolor' => 'title_color', 'pcbig' => 'price_color_big', 'rtcolor' => 'ribbon_text_color', 'btcolor' => 'button_text_color', 'bthover' => 'button_text_hover', 'bcolor' => 'button_color', 'bhover' => 'button_hover' );
	$package_features = $_POST['feature_value'] != '' ? $_POST['feature_value'] : '';
	$package_tooltips = $_POST['tooltips'] != '' ? $_POST['tooltips'] : '';
	$checkbox_value = $_POST['checkbox_value'] != '' ? $_POST['checkbox_value'] : '';
	$table_feature = $pricing_table.'_feature';
	$feature_items = get_option($table_feature);
	foreach($_POST['pricing_packages'] as $key => $package) {
		$vl =1;  $fk = 1;
		$packVal = get_option('packageOptions' . $package_id[$key]);
		if($packVal['type'] == $package_type[$key]) {
			$optionName = 'packageOptions' . $package_id[$key];
			$order_id[$key] = $key+1;
		} else {
			$package_lists = get_option($pricing_table);
			$optionName = wrcpt_update_pricing_table($pricing_table, $package_lists);
			$package_id[$key] = get_option('packageCount');
			$order_id[$key] = $key+1;
		}
		$package_order[] = $optionName;
		foreach($feature_items as $fkey => $item) {
			if($fkey == 'fitem'.$fk) {
				if($feature_items['ftype'.$fk] == 'text') {
					if($package_features[$fc]) { $feature_value[$fkey] = sanitize_text_field( $package_features[$fc] ); }
					else { $feature_value[$fkey] = ''; }
				} else {
					if(array_key_exists('ftype'.$cf, $package_features)) {
						$feature_value[$fkey] = 'yes';
						$cf++; $fc--;
					}
					else {
						$feature_value[$fkey] = 'no';
						$cf++; $fc--;
					}
				}
				if($package_tooltips) {
					if($package_tooltips[$tc]) {
						$tooltips['tip'.$vl] = sanitize_text_field( $package_tooltips[$tc] );
						$vl++;
					} else {
						$tooltips['tip'.$vl] = '';
						$vl++;
					}
				}
				$fc++; $tc++;
			} else { $fk++; }
		}
		foreach($package_text_options as $pkey => $value) {
			if( isset( $_POST[$value] ) ) {
				$packValue = $_POST[$value];
				$packageOptions_text[$pkey] = sanitize_text_field( $packValue[$key] );
			}
		}
		$packageOptions_extra = array( 'pid' => $package_id[$key], 'order' => $order_id[$key] );
		$mergePackages = array_merge($packageOptions_extra, $packageOptions_text, $feature_value, $tooltips);
		update_option($optionName, $mergePackages);
	}
	$table_lists = implode(', ', $package_order);
	update_option($pricing_table, $table_lists);
}
?>