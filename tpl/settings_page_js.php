<script type="text/javascript" language="javascript" src="<?php print $this->urlPath . "/js/colorpicker.js"; ?>"></script>
<script type="text/javascript" language="javascript">
	function FC_submit_settings() {
		var randomFontCount = jQuery('#FC_random_font_count').val();
		var gradientTransitions = jQuery('#FC_gradient_transitions').val();
		
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
			'FC_gradient_transitions': jQuery('#FC_gradient_transitions').val(),
			'FC_default_width': jQuery('#FC_default_width').val(),
			'FC_default_height': jQuery('#FC_default_height').val(),
			'FC_request_key': jQuery('#FC_request_key').val(),
			'FC_font_color': {
				0: jQuery('#FC_font_color_r').val(),
				1: jQuery('#FC_font_color_g').val(),
				2: jQuery('#FC_font_color_b').val()
			},
			'FC_grad_color_1': {
				0: jQuery('#FC_grad_color_1_r').val(),
				1: jQuery('#FC_grad_color_1_g').val(),
				2: jQuery('#FC_grad_color_1_b').val()
			},
			'FC_grad_color_2': {
				0: jQuery('#FC_grad_color_2_r').val(),
				1: jQuery('#FC_grad_color_2_g').val(),
				2: jQuery('#FC_grad_color_2_b').val()
			},
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

			//Reset Colors
			jQuery('#FC_font_color_r').val(postObject['FC_font_color'][0]);
			jQuery('#FC_font_color_g').val(postObject['FC_font_color'][1]);
			jQuery('#FC_font_color_b').val(postObject['FC_font_color'][2]);
			jQuery('#FC_grad_color_1_r').val(postObject['FC_grad_color_1'][0]);
			jQuery('#FC_grad_color_1_g').val(postObject['FC_grad_color_1'][1]);
			jQuery('#FC_grad_color_1_b').val(postObject['FC_grad_color_1'][2]);
			jQuery('#FC_grad_color_2_r').val(postObject['FC_grad_color_2'][0]);
			jQuery('#FC_grad_color_2_g').val(postObject['FC_grad_color_2'][1]);
			jQuery('#FC_grad_color_2_b').val(postObject['FC_grad_color_2'][2]);
			add_color_pickers();
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
	
	function add_color_pickers() {
		jQuery('#FC_font_color_r, #FC_font_color_g, #FC_font_color_b, #FC_font_color_display').ColorPicker({
			onSubmit: function(hsb, hex, rgb, el) {
				jQuery('#FC_font_color_r').val(rgb.r);
				jQuery('#FC_font_color_g').val(rgb.g);
				jQuery('#FC_font_color_b').val(rgb.b);
				jQuery('#FC_font_color_display').css('backgroundColor', 'rgb('+rgb.r+', '+rgb.g+', '+rgb.b+')');
				jQuery(el).ColorPickerHide();
			},
			onBeforeShow: function () {
				var font_color_r = jQuery('#FC_font_color_r').val();
				var font_color_g = jQuery('#FC_font_color_g').val();
				var font_color_b = jQuery('#FC_font_color_b').val();
				jQuery(this).ColorPickerSetColor({r: font_color_r, g: font_color_g, b: font_color_b});
			}
		});

		jQuery('#FC_grad_color_1_r, #FC_grad_color_1_g, #FC_grad_color_1_b, #FC_grad_color_1_display').ColorPicker({
			onSubmit: function(hsb, hex, rgb, el) {
				jQuery('#FC_grad_color_1_r').val(rgb.r);
				jQuery('#FC_grad_color_1_g').val(rgb.g);
				jQuery('#FC_grad_color_1_b').val(rgb.b);
				jQuery('#FC_grad_color_1_display').css('backgroundColor', 'rgb('+rgb.r+', '+rgb.g+', '+rgb.b+')');
				jQuery(el).ColorPickerHide();
			},
			onBeforeShow: function () {
				var grad_color_r = jQuery('#FC_grad_color_1_r').val();
				var grad_color_g = jQuery('#FC_grad_color_1_g').val();
				var grad_color_b = jQuery('#FC_grad_color_1_b').val();
				jQuery(this).ColorPickerSetColor({r: grad_color_r, g: grad_color_g, b: grad_color_b});
			}
		});

		jQuery('#FC_grad_color_2_r, #FC_grad_color_2_g, #FC_grad_color_2_b, #FC_grad_color_2_display').ColorPicker({
			onSubmit: function(hsb, hex, rgb, el) {
				jQuery('#FC_grad_color_2_r').val(rgb.r);
				jQuery('#FC_grad_color_2_g').val(rgb.g);
				jQuery('#FC_grad_color_2_b').val(rgb.b);
				jQuery('#FC_grad_color_2_display').css('backgroundColor', 'rgb('+rgb.r+', '+rgb.g+', '+rgb.b+')');
				jQuery(el).ColorPickerHide();
			},
			onBeforeShow: function () {
				var grad_color_r = jQuery('#FC_grad_color_2_r').val();
				var grad_color_g = jQuery('#FC_grad_color_2_g').val();
				var grad_color_b = jQuery('#FC_grad_color_2_b').val();
				jQuery(this).ColorPickerSetColor({r: grad_color_r, g: grad_color_g, b: grad_color_b});
			}
		});

		var color_r = jQuery('#FC_font_color_r').val();
		var color_g = jQuery('#FC_font_color_g').val();
		var color_b = jQuery('#FC_font_color_b').val();
		jQuery('#FC_font_color_display').css('backgroundColor', 'rgb('+color_r+', '+color_g+', '+color_b+')');

		var color_r = jQuery('#FC_grad_color_1_r').val();
		var color_g = jQuery('#FC_grad_color_1_g').val();
		var color_b = jQuery('#FC_grad_color_1_b').val();
		jQuery('#FC_grad_color_1_display').css('backgroundColor', 'rgb('+color_r+', '+color_g+', '+color_b+')');

		var color_r = jQuery('#FC_grad_color_2_r').val();
		var color_g = jQuery('#FC_grad_color_2_g').val();
		var color_b = jQuery('#FC_grad_color_2_b').val();
		jQuery('#FC_grad_color_2_display').css('backgroundColor', 'rgb('+color_r+', '+color_g+', '+color_b+')');
	}
	jQuery(function() {
		add_color_pickers();
	});
</script>