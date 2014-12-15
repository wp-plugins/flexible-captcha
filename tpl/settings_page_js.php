<script type="text/javascript" language="javascript" src="<?php print $this->urlPath . "/js/colorpicker.js"; ?>"></script>
<script type="text/javascript" language="javascript">
	var FC_bg_colors = <?php print json_encode(get_option('FC_bg_colors')); ?>;
	var FC_font_colors = <?php print json_encode(get_option('FC_font_colors')); ?>;
	function FC_submit_settings() {
		var checkBoxes = {
			'FC_case_sensitive': 0,
			'FC_add_to_comments': 0,
			'FC_add_to_registration': 0,
			'FC_add_to_login': 0,
			'FC_add_jquery_to_header': 0,
			'FC_preserve_settings': 0
		};
		
		var postObject = {
			'FC_case_sensitive': 0,
			'FC_add_to_comments': 0,
			'FC_add_to_registration': 0,
			'FC_add_to_login': 0,
			'FC_add_jquery_to_header': 0,
			'FC_preserve_settings': 0,
			'FC_random_font_count': jQuery('#FC_random_font_count').val(),
			'FC_background_type': jQuery('#FC_background_type').val(),
			'FC_font_colors': FC_font_colors,
			'FC_bg_colors': FC_bg_colors,
			'FC_section_count': jQuery('#FC_section_count').val(),
			'FC_shape_count': jQuery('#FC_shape_count').val(),
			'FC_gradient_transitions': jQuery('#FC_gradient_transitions').val(),
			'FC_default_width': jQuery('#FC_default_width').val(),
			'FC_default_height': jQuery('#FC_default_height').val(),
			'FC_request_key': jQuery('#FC_request_key').val(),
			'FC_nonce': '<?php print $this->nonce; ?>'
		};

		for(var key in checkBoxes) {
			if (jQuery('#'+key).attr('checked')) {
				checkBoxes[key] = 1;
			}
			postObject[key] = checkBoxes[key];
		}

		var loadElement = jQuery('#FC-settings-div');
		var revertHtml = loadElement.html();
		loadElement.html('<div style="width: 100%;text-align: center;"><img src="<?php print $this->urlPath . "/images/ajax-loader-round.gif"; ?>"></div>');
		jQuery.post(encodeURI(ajaxurl + '?action=FC_submit_settings'), postObject, function (result) {
			alert(result);
			loadElement.html(revertHtml);
			jQuery('#FC_random_font_count').val(postObject['FC_random_font_count']);
			jQuery('#FC_gradient_transitions').val(postObject['FC_gradient_transitions']);
			jQuery('#FC_background_type').val(postObject['FC_background_type']);
			jQuery('#FC_shape_count').val(postObject['FC_shape_count']);
			jQuery('#FC_section_count').val(postObject['FC_section_count']);
			for(var key in checkBoxes) {
				if (checkBoxes[key] == 1) {
					jQuery('#'+key).attr('checked', true);
				} else {
					jQuery('#'+key).attr('checked', false);
				}
			}

			jQuery('#FC_request_key').val(postObject['FC_request_key']);

			jQuery('#FC_default_width').val(postObject['FC_default_width']);
			jQuery('#FC_default_height').val(postObject['FC_default_height']);

			FC_rebuild_colors();
			FC_add_listeners();
		});

		return false;
	}

	function FC_delete_font_file(fontFile, rowId) {
		var loadElement = jQuery('#FC-font-files-div .inside');
		var revertHtml = loadElement.html();
		loadElement.html('<div style="width: 100%;text-align: center;"><img src="<?php print $this->urlPath . "/images/ajax-loader.gif"; ?>"></div>');
		jQuery.post(encodeURI(ajaxurl + '?action=FC_delete_font_file'), { 'FC_font_file': fontFile, 'FC_nonce': '<?php print $this->nonce; ?>' }, function (result) {
			alert(result);
			loadElement.html(revertHtml);
			jQuery('#FC_font_file_'+rowId).remove();
		});
		return false;
	}
	
	function FC_rebuild_colors() {
		jQuery('#FC-font-colors-div, #FC-bg-colors-div').html('');
		FC_add_color_pickers();
	}
	
	function FC_delete_font_colors() {
		if (confirm('Do you really want to delete the selected Font Colors?')) {
			selectedIndexes = new Array();
			jQuery('.FC_delete_font_color').each(function() {
				if (jQuery(this).attr('checked')) {
					selectedIndexes[selectedIndexes.length] = jQuery(this).val();
				}
			});

			//sort indexes so we start removing at the highest index.
			selectedIndexes.sort(function(a, b){return b-a});
			for (var i=0; i<selectedIndexes.length; i++) {
				FC_font_colors.splice(selectedIndexes[i],1);
			}
			FC_rebuild_colors();
		}
	}

	function FC_delete_bg_colors(colorIndex) {
		if (confirm('Do you really want to delete the selected Background Colors?')) {
			selectedIndexes = new Array();
			jQuery('.FC_delete_bg_color').each(function() {
				if (jQuery(this).attr('checked')) {
					selectedIndexes[selectedIndexes.length] = jQuery(this).val();
				}
			});

			//sort indexes so we start removing at the highest index.
			selectedIndexes.sort(function(a, b){return b-a});
			for (var i=0; i<selectedIndexes.length; i++) {
				FC_bg_colors.splice(selectedIndexes[i],1);
			}
			FC_rebuild_colors();
		}
	}

	function FC_add_new_color(colorType) {
		if (colorType == 'font') {
			colorIndex = FC_font_colors.length;
			FC_font_colors[colorIndex] = [0, 0, 0];
			FC_add_font_color(colorIndex);
		} else if (colorType == 'bg') {
			colorIndex = FC_bg_colors.length;
			FC_bg_colors[colorIndex] = [0, 0, 0];
			FC_add_bg_color(colorIndex);
		}
	}
	
	function FC_add_font_color(colorIndex) {
		jQuery('#FC-font-colors-div').append(
			'<div id="FC_font_color_'+colorIndex+'_div" class="FC_font_color_div" style="width: 90px;height: 30px;float: left;margin: 5px;">&nbsp;</div>'
			+'<input name="FC_delete_font_color" class="FC_delete_font_color" type="checkbox" value="'+colorIndex+'" style="margin: 5px 0px 0px -95px;float: left;" />'
		);
		
		jQuery('#FC_font_color_'+colorIndex+'_div').ColorPicker({
			onSubmit: function(hsb, hex, rgb, el) {
				FC_font_colors[colorIndex] = [rgb.r, rgb.g, rgb.b];
				jQuery('#FC_font_color_'+colorIndex+'_div').css('backgroundColor', 'rgb('+rgb.r+', '+rgb.g+', '+rgb.b+')');
				jQuery(el).ColorPickerHide();
			},
			onBeforeShow: function () {
				jQuery(this).ColorPickerSetColor({r: FC_font_colors[colorIndex][0], g: FC_font_colors[colorIndex][1], b: FC_font_colors[colorIndex][2]});
			}
		});

		jQuery('#FC_font_color_'+colorIndex+'_div').css('backgroundColor', 'rgb('+FC_font_colors[colorIndex][0]+', '+FC_font_colors[colorIndex][1]+', '+FC_font_colors[colorIndex][2]+')');
	}
	
	function FC_add_bg_color(colorIndex) {
		jQuery('#FC-bg-colors-div').append(
			'<div id="FC_bg_color_'+colorIndex+'_div" class="FC_bg_color_div" style="width: 90px;height: 30px;float: left;margin: 5px;">&nbsp;</div>'
			+'<input name="FC_delete_bg_color" class="FC_delete_bg_color" type="checkbox" value="'+colorIndex+'" style="margin: 5px 0px 0px -95px;float: left;" />'
		);

		jQuery('#FC_bg_color_'+colorIndex+'_div').ColorPicker({
			onSubmit: function(hsb, hex, rgb, el) {
				FC_bg_colors[colorIndex] = [rgb.r, rgb.g, rgb.b];
				jQuery('#FC_bg_color_'+colorIndex+'_div').css('backgroundColor', 'rgb('+rgb.r+', '+rgb.g+', '+rgb.b+')');
				jQuery(el).ColorPickerHide();
			},
			onBeforeShow: function () {
				jQuery(this).ColorPickerSetColor({r: FC_bg_colors[colorIndex][0], g: FC_bg_colors[colorIndex][1], b: FC_bg_colors[colorIndex][2]});
			}
		});

		jQuery('#FC_bg_color_'+colorIndex+'_div').css('backgroundColor', 'rgb('+FC_bg_colors[colorIndex][0]+', '+FC_bg_colors[colorIndex][1]+', '+FC_bg_colors[colorIndex][2]+')');
	}
	
	function FC_add_color_pickers() {
		for(var i=0; i<FC_font_colors.length; i++) {
			FC_add_font_color(i);
		}

		for(var i=0; i<FC_bg_colors.length; i++) {
			FC_add_bg_color(i);
		}

	}

	function FC_add_listeners() {
		jQuery('#FC_background_type').change(function() {
			if (jQuery(this).val() == 'gradient') {
				jQuery('#gradient_settings').css('display', '');
				jQuery('#random_shape_settings').css('display', 'none');

			} else if (jQuery(this).val() == 'random_shape') {
				jQuery('#gradient_settings').css('display', 'none');
				jQuery('#random_shape_settings').css('display', '');
			}
		});
		jQuery('#FC_background_type').change();
	}
	

	jQuery(function() {
		FC_add_color_pickers();
		FC_add_listeners();
	});
</script>