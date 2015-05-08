jQuery(document).ready(function() {
	jQuery(".table_name span").css("display","none");
	jQuery("#new_table").click(function() {
		jQuery("#wrcpt_new").slideDown("slow");
		jQuery("#new_table").hide();
		jQuery('#sidebar').hide();
		jQuery("#add_new_table h2").text("Pricing Table Name and Features");
		jQuery(".table_list").css("display","none");
	});
	jQuery(".table_name").mouseover(function(){
		var linkid = jQuery(this).attr("id");
		jQuery("td#" + linkid + " span").css("display","inline-block");
	});
	jQuery(".table_name").mouseout(function(){
		var linkid = jQuery(this).attr("id");
		jQuery("td#" + linkid + " span").css("display","none");
	});
	jQuery('#wrcpt-loading-image').bind('ajaxStart', function(){
		jQuery(this).css("display","inline-block");
	}).bind('ajaxComplete', function(){
		jQuery(this).css("display","none");
	});

	var featureName = jQuery('#feature_additem');
	jQuery('#addfeature').live('click', function() {
		jQuery('<tr class="featurebody"><td><input type="text" name="feature_name[]" placeholder="Enter Feature Name" required /></td><td><select name="feature_type[]" id="feature_type"><option value="text" selected="selected">Text</option><option value="check">Checkbox</option></select></td> <td><span id="remFeatute"></span></td></tr>').appendTo(featureName);
		jQuery('#remDisable').attr('id', 'remFeatute');
		return false;
	});
	jQuery('#remFeatute').live('click', function() {
		var num = jQuery('#feature_additem tr.featurebody').length;
		if (num - 1 === 1)
			jQuery('#remFeatute').attr('id', 'remDisable');
		jQuery(this).parents('tr.featurebody').remove();
		return false;
	});
});

function wrcptdeletetable(ptable) {
	var answer = confirm ("Are you sure you want to delete?");
	if (answer) {
		jQuery.ajax({
			type: 'POST',
			url: wrcptajax.ajaxurl,
			data: {
				action: 'wrcpt_delete_pricing_table',
				packtable: ptable
			},
			success:function(data, textStatus, XMLHttpRequest){
				var linkid = '#wrcpt_' + ptable;
				jQuery(linkid).remove();
				jQuery(linkid).append(data);
			},
			error: function(MLHttpRequest, textStatus, errorThrown){
				alert(errorThrown);
			}
		});
	}
}
function wrcptaddpack(ptable) {
	jQuery.ajax({
		type: 'POST',
		url: wrcptajax.ajaxurl,
		data: {
			action: 'wrcpt_add_pricing_packages',
			packtable: ptable
		},
		success:function(data, textStatus, XMLHttpRequest){
			var linkid = '#wrcpt_list';
			var num = jQuery('.package_details').length;
			jQuery(linkid).html('');
			jQuery("#new_table").hide();
			jQuery('#sidebar').hide();
			jQuery(linkid).append(data);
			jQuery("#auto_column").click(function() {
				if(jQuery("#auto_column").is(":checked")){
					jQuery("label#col_width").slideDown("slow");
					jQuery("input#column_width").slideDown("slow");
					jQuery("label#cap_col_width").slideDown("slow");
					jQuery("input#cap_column_width").slideDown("slow");
				} else {
					jQuery("label#col_width").slideUp("slow");
					jQuery("input#column_width").slideUp("slow");
					jQuery("label#cap_col_width").slideUp("slow");
					jQuery("input#cap_column_width").slideUp("slow");
				}
			});
			if(jQuery("#auto_column").is(":checked")){
				jQuery("label#col_width").css("display","block");
				jQuery("input#column_width").css("display","block");
			}
			jQuery("#feature_caption").click(function() {
				if(jQuery("#feature_caption").is(":checked") && jQuery("#auto_column").is(":checked")){
					jQuery("label#cap_col_width").slideDown("slow");
					jQuery("input#cap_column_width").slideDown("slow");
				} else {
					jQuery("label#cap_col_width").slideUp("slow");
					jQuery("input#cap_column_width").slideUp("slow");
				}
			});
			if(jQuery("#feature_caption").is(":checked") && jQuery("#auto_column").is(":checked")){
				jQuery("label#cap_col_width").css("display","block");
				jQuery("input#cap_column_width").css("display","block");
			}
			jQuery(".table_list").css("width","100%");
			jQuery("#add_new_table h2").text("Add Pricing Table Column");
			jQuery(".postbox-container").css("width","100%");
			jQuery('#accordion_advance').accordion({
				collapsible: true,
				heightStyle: "content"
			});
			jQuery("#accordion1").accordion({
				collapsible: true,
				heightStyle: "content"
			});
			jQuery('.title_color1').wpColorPicker();
			jQuery('.table_bg1').wpColorPicker();
			jQuery('.price_color_big1').wpColorPicker();
			jQuery('.button_text_color1').wpColorPicker();
			jQuery('.button_text_hover1').wpColorPicker();
			jQuery('.button_color1').wpColorPicker();
			jQuery('.button_hover1').wpColorPicker();
			jQuery('.ribbon_text_color1').wpColorPicker();
			jQuery('.ribbon_bg1').wpColorPicker();
			jQuery('#addPackage').click(function () {
				var num = jQuery('.package_details').length,
				newNum  = new Number(num + 1),
				newElem = jQuery('#wrcpt-' + num).clone().attr('id', 'wrcpt-' + newNum).fadeIn('slow');
				newElem.find('#accordion' + num).attr('id', 'accordion' + newNum);
				newElem.find('#pcolumn' + num).attr('id', 'pcolumn' + newNum);
				newElem.find('.title_color' + num).attr('class', 'title_color' + newNum);
				newElem.find('.table_bg' + num).attr('class', 'table_bg' + newNum);
				newElem.find('.price_color_big' + num).attr('class', 'price_color_big' + newNum);
				newElem.find('.button_text_color' + num).attr('class', 'button_text_color' + newNum);
				newElem.find('.button_text_hover' + num).attr('class', 'button_text_hover' + newNum);
				newElem.find('.button_color' + num).attr('class', 'button_color' + newNum);
				newElem.find('.button_hover' + num).attr('class', 'button_hover' + newNum);
  				newElem.find('.ribbon_text_color' + num).attr('class', 'ribbon_text_color' + newNum);
				newElem.find('.ribbon_bg' + num).attr('class', 'ribbon_bg' + newNum);
				jQuery('#wrcpt-' + num).after(newElem);
				jQuery('.ptitle').focus();
				jQuery(function() {
			  		jQuery('#sortable_column').sortable({
			  			cancel: ".column_container"
			  		});
				});
				jQuery(".package_details").css("cursor","move");
				jQuery('#accordion' + newNum).accordion({
					collapsible: true,
					heightStyle: "content"
				});
				jQuery('#pcolumn' + newNum).text('Pricing Column ' + newNum);
				jQuery('#accordion' + newNum + ' .wp-color-result').remove();
				jQuery('.title_color' + newNum).wpColorPicker();
				jQuery('.table_bg' + newNum).wpColorPicker();
				jQuery('.price_color_big' + newNum).wpColorPicker();
				jQuery('.button_text_color' + newNum).wpColorPicker();
				jQuery('.button_text_hover' + newNum).wpColorPicker();
				jQuery('.button_color' + newNum).wpColorPicker();
				jQuery('.button_hover' + newNum).wpColorPicker();
				jQuery('.ribbon_text_color' + newNum).wpColorPicker();
				jQuery('.ribbon_bg' + newNum).wpColorPicker();
				jQuery('#wrcpt-1 #delDisable').attr('id', 'delPackage');
				jQuery('#wrcpt-' + newNum + ' #delDisable').attr('id', 'delPackage');
			});
			jQuery('#delPackage').live('click', function() {
				if (confirm("Are you sure you wish to remove this package? This cannot be undone!")) {
					var num = jQuery('.package_details').length;
					jQuery(this).parents('.package_details').slideUp('slow', function () {
						jQuery(this).remove();
						if (num -1 === 1) {
							jQuery('#delPackage').attr('id', 'delDisable');
							jQuery(".package_details").css("cursor","auto");
							jQuery("#sortable_column").sortable({ disabled: true });
						}
						jQuery('#addPackage').attr('disabled', false).prop('value', "New Column");
						var j = 1;
						for(i=1; i<=num; i++) {
							if(jQuery('#wrcpt-' + i).length != 0) {
								jQuery('#wrcpt-' + i).attr('id', 'wrcpt-' + j);
								jQuery("#pcolumn"+ i).text("Pricing Column " + j);
								jQuery("#pcolumn"+ i).attr("id", "pcolumn"+ j);
								jQuery('#accordion' + i).attr('id', 'accordion' + j);
								j++;
							}
						}
					});
				}
			});
 		},
		error: function(MLHttpRequest, textStatus, errorThrown){
			alert(errorThrown);
		}
	});
}
function wrcpteditpackages(pcount, ptable) {
	jQuery.ajax({
		type: 'POST',
		url: wrcptajax.ajaxurl,
		data: {
			action: 'wrcpt_edit_pricing_packages',
			packtable: ptable
		},
		success:function(data, textStatus, XMLHttpRequest){
			var linkid = '#wrcpt_list';
			jQuery(linkid).html('');
			jQuery("#new_table").hide();
			jQuery('#sidebar').hide();
			jQuery(linkid).append(data);
			jQuery("#auto_column").click(function() {
				if(jQuery("#auto_column").is(":checked")){
					jQuery("label#col_width").slideDown("slow");
					jQuery("input#column_width").slideDown("slow");
					jQuery("label#cap_col_width").slideDown("slow");
					jQuery("input#cap_column_width").slideDown("slow");
				} else {
					jQuery("label#col_width").slideUp("slow");
					jQuery("input#column_width").slideUp("slow");
					jQuery("label#cap_col_width").slideUp("slow");
					jQuery("input#cap_column_width").slideUp("slow");
				}
			});
			if(jQuery("#auto_column").is(":checked")){
				jQuery("label#col_width").css("display","block");
				jQuery("input#column_width").css("display","block");
			}
			jQuery("#feature_caption").click(function() {
				if(jQuery("#feature_caption").is(":checked") && jQuery("#auto_column").is(":checked")){
					jQuery("label#cap_col_width").slideDown("slow");
					jQuery("input#cap_column_width").slideDown("slow");
				} else {
					jQuery("label#cap_col_width").slideUp("slow");
					jQuery("input#cap_column_width").slideUp("slow");
				}
			});
			if(jQuery("#feature_caption").is(":checked") && jQuery("#auto_column").is(":checked")){
				jQuery("label#cap_col_width").css("display","block");
				jQuery("input#cap_column_width").css("display","block");
			}
			if(pcount == 1) {
				jQuery('#wrcpt-1 #delPackage').attr('id', 'delDisable');
			}
			jQuery(".table_list").css("width","100%");
			jQuery("#add_new_table h2").text("Edit Pricing Table");
			jQuery(".postbox-container").css("width","100%");
			jQuery(function() {
				jQuery('#sortable_column').sortable({
					cancel: ".column_container"
				});
			});
			jQuery(".package_details").css("cursor","move");
			jQuery('#accordion_advance').accordion({
				collapsible: true,
				heightStyle: "content"
			});
			for(i = 1; i <= pcount; i++) {
				jQuery('#accordion' + i).accordion({
					collapsible: true,
					heightStyle: "content"
				});
			}
			jQuery('.title_color').wpColorPicker();
			jQuery('.table_bg').wpColorPicker();
			jQuery('.price_color_big').wpColorPicker();
			jQuery('.button_text_color').wpColorPicker();
			jQuery('.button_text_hover').wpColorPicker();
			jQuery('.button_color').wpColorPicker();
			jQuery('.button_hover').wpColorPicker();
			jQuery('.ribbon_text_color').wpColorPicker();
			jQuery('.ribbon_bg').wpColorPicker();
			jQuery('#addPackage').click(function () {
				var num = jQuery('.package_details').length,
				newNum  = new Number(num + 1),
				newElem = jQuery('#wrcpt-' + num).clone().attr('id', 'wrcpt-' + newNum).fadeIn('slow');
				newElem.find('#pcolumn' + num).attr('id', 'pcolumn' + newNum);
				newElem.find('#accordion' + num).attr('id', 'accordion' + newNum);
				jQuery('#wrcpt-' + num).after(newElem);
				jQuery('.ptitle').focus();
				jQuery('#accordion' + newNum).accordion({
					collapsible: true,
					heightStyle: "content"
				});
				jQuery('#pcolumn' + newNum).text('Pricing Column ' + newNum);
				jQuery('#accordion' + newNum + ' .wp-color-result').remove();
				jQuery('.title_color').wpColorPicker();
				jQuery('.table_bg').wpColorPicker();
				jQuery('.price_color_big').wpColorPicker();
				jQuery('.button_text_color').wpColorPicker();
				jQuery('.button_text_hover').wpColorPicker();
				jQuery('.button_color').wpColorPicker();
				jQuery('.button_hover').wpColorPicker();
				jQuery('.ribbon_text_color').wpColorPicker();
				jQuery('.ribbon_bg').wpColorPicker();
				jQuery('#wrcpt-1 #delDisable').attr('id', 'delPackage');
				jQuery('#wrcpt-' + newNum + ' #delDisable').attr('id', 'delPackage');
			});
			jQuery('#delPackage').live('click', function() {
				var num = jQuery('.package_details').length;
				var answer = confirm ("Are you sure you wish to remove this package? This cannot be undone!");
				if (answer) {
					jQuery(this).parents('.package_details').slideUp('slow', function () {
						jQuery(this).remove();
						if (num -1 === 1) {
							jQuery('#delPackage').attr('id', 'delDisable');
							jQuery(".package_details").css("cursor","auto");
							jQuery("#sortable_column").sortable({ disabled: true });
						}
						jQuery('#addPackage').attr('disabled', false).prop('value', "New Column");
						var j = 1;
						for(i=1; i<=num; i++) {
							if(jQuery('#wrcpt-' + i).length != 0) {
								jQuery('#wrcpt-' + i).attr('id', 'wrcpt-' + j);
								jQuery("#pcolumn"+ i).text("Pricing Column " + j);
								jQuery("#pcolumn"+ i).attr("id", "pcolumn"+ j);
								jQuery('#accordion' + i).attr('id', 'accordion' + j);
								j++;
							}
						}
					});
				}
			});
		},
		error: function(MLHttpRequest, textStatus, errorThrown){
			alert(errorThrown);
		}
	});
}
function wrcpteditfeature(ptable) {
	jQuery.ajax({
		type: 'POST',
		url: wrcptajax.ajaxurl,
		data: {
			action: 'wrcpt_process_package_features',
			packtable: ptable
		},
		success:function(data, textStatus, XMLHttpRequest){
			var linkid = '#wrcpt_list';
			jQuery(linkid).html('');
			jQuery("#new_table").hide();
			jQuery('#sidebar').hide();
			jQuery(linkid).append(data);
			jQuery("#add_new_table h2").text("Edit Pricing Column Features");

			var featureName = jQuery('#feature_edititem');
			jQuery('#editfeature').live('click', function() {
				jQuery('<tr class="featurebody"><td><input type="text" name="feature_name[]" placeholder="Enter Feature Name" size="30" required /></td><td><select name="feature_type[]" id="feature_type"><option value="text" selected="selected">Text</option><option value="check">Checkbox</option></select></td> <td><span id="remFeatute"></span></td></tr>').appendTo(featureName);
				return false;
			});
			jQuery('#remFeatute').live('click', function() {
				jQuery(this).parents('tr.featurebody').remove();
				return false;
			});
			jQuery(function() {
				var fixHelper = function(e, ui) {
					ui.children().each(function() {
						jQuery(this).width(jQuery(this).width());
					});
					return ui;
				};
		  		jQuery('#feature_edititem tbody').sortable({
					helper: fixHelper
				}).disableSelection();
			});
		},
		error: function(MLHttpRequest, textStatus, errorThrown){
			alert(errorThrown);
		}
	});
}
function wrcptviewpack(tabid, ptable) {
	jQuery.ajax({
		type: 'POST',
		url: wrcptajax.ajaxurl,
		data: {
			action: 'wrcpt_view_pricing_packages',
			packtable: ptable,
			tableid: tabid
		},
		success:function(data, textStatus, XMLHttpRequest){
			var linkid = '#wrcpt_list';
			var replace_name = ptable.replace("_", " ");
			var pricing_table_name = replace_name.replace(/^([a-z\u00E0-\u00FC])|\s+([a-z\u00E0-\u00FC])/g, function(m){ return m.toUpperCase() });
			jQuery(linkid).html('');
			jQuery("#new_table").hide();
			jQuery('#sidebar').hide();
			jQuery(linkid).append(data);
			jQuery("#add_new_table h2.main-header").text("Preview of " + pricing_table_name);
			jQuery(".table_list").css("width","100%");
			jQuery(".postbox-container").css("width","100%");
		},
		error: function(MLHttpRequest, textStatus, errorThrown){
			alert(errorThrown);
		}
	});
}