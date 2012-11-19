<script type="text/javascript" language="javascript" src="<?php print $this->urlPath . "/js/colorpicker.js"; ?>"></script>
<script type="text/javascript" language="javascript">
	function FC_submit_default_dimensions() {
		var default_width = jQuery('#FC_default_width').val();
		var default_height = jQuery('#FC_default_height').val();
		

		var load_element = jQuery('#FC-default-dim-div .inside');
		var revertHtml = load_element.html();
		load_element.html('<div style="width: 100%;text-align: center;"><img src="<?php print $this->urlPath . "/images/ajax-loader.gif"; ?>"></div>');
		jQuery.post(encodeURI(ajaxurl + '?action=FC_submit_default_dimensions'), { 'FC_default_width': default_width, 'FC_default_height': default_height, 'FC_nonce': '<?php print $this->nonce; ?>' }, function (result) {
			alert(result);
			load_element.html(revertHtml);
			jQuery('#FC_default_width').val(default_width);
			jQuery('#FC_default_height').val(default_height);
		});
	}

	function FC_submit_request_key() {
		var requestKey = jQuery('#FC_request_key').val();
		var loadElement = jQuery('#FC-request-key-div .inside');
		var revertHtml = loadElement.html();
		loadElement.html('<div style="width: 100%;text-align: center;"><img src="<?php print $this->urlPath . "/images/ajax-loader.gif"; ?>"></div>');
		jQuery.post(encodeURI(ajaxurl + '?action=FC_submit_request_key'), { 'FC_request_key': requestKey, 'FC_nonce': '<?php print $this->nonce; ?>' }, function (result) {
			alert(result);
			loadElement.html(revertHtml);
			jQuery('#FC_request_key').val(requestKey);
		});
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

	function FC_submit_general_settings() {
		var randomFontCount = jQuery('#FC_random_font_count').val();
		var gradientTransitions = jQuery('#FC_gradient_transitions').val();
		
		var checkBoxes = {'FC_case_sensitive': 0, 'FC_add_to_comments': 0, 'FC_add_to_registration': 0, 'FC_add_jquery_to_header': 0, 'FC_preserve_settings': 0};
		
		var postObject = { 'FC_random_font_count': randomFontCount, 'FC_gradient_transitions': gradientTransitions, 'FC_case_sensitive': 0, 'FC_add_to_comments': 0, 'FC_add_to_registration': 0, 'FC_add_jquery_to_header': 0, 'FC_preserve_settings': 0, 'FC_nonce': '<?php print $this->nonce; ?>' };

		for(var key in checkBoxes) {
			if (jQuery('#'+key).attr('checked')) {
				checkBoxes[key] = 1;
			}
			postObject[key] = checkBoxes[key];
		}
		
		var loadElement = jQuery('#FC-general-settings-div .inside');
		var revertHtml = loadElement.html();
		loadElement.html('<div style="width: 100%;text-align: center;"><img src="<?php print $this->urlPath . "/images/ajax-loader.gif"; ?>"></div>');
		jQuery.post(encodeURI(ajaxurl + '?action=FC_submit_general_settings'), postObject, function (result) {
			alert(result);
			loadElement.html(revertHtml);
			jQuery('#FC_random_font_count').val(randomFontCount);
			jQuery('#FC_gradient_transitions').val(gradientTransitions);
			
			for(var key in checkBoxes) {
				if (checkBoxes[key] == 1) {
					jQuery('#'+key).attr('checked', true);
				} else {
					jQuery('#'+key).attr('checked', false);
				}
			}
		});
		return false;
	}
	
	function FC_submit_colors() {
		var font_color = new Array(jQuery('#FC_font_color_r').val(), jQuery('#FC_font_color_g').val(), jQuery('#FC_font_color_b').val());
		var grad_color_1 = new Array(jQuery('#FC_grad_color_1_r').val(), jQuery('#FC_grad_color_1_g').val(), jQuery('#FC_grad_color_1_b').val());
		var grad_color_2 = new Array(jQuery('#FC_grad_color_2_r').val(), jQuery('#FC_grad_color_2_g').val(), jQuery('#FC_grad_color_2_b').val());
				
		var load_element = jQuery('#FC-colors-div .inside');
		var revertHtml = load_element.html();
		load_element.html('<div style="width: 100%;text-align: center;"><img src="<?php print $this->urlPath . "/images/ajax-loader.gif"; ?>"></div>');
		jQuery.post(encodeURI(ajaxurl + '?action=FC_submit_colors'), { 'FC_font_color': font_color, 'FC_grad_color_1': grad_color_1, 'FC_grad_color_2': grad_color_2, 'FC_nonce': '<?php print $this->nonce; ?>' }, function (result) {
			alert(result);
			load_element.html(revertHtml);
			
			//Reset Colors
			jQuery('#FC_font_color_r').val(font_color[0]);
			jQuery('#FC_font_color_g').val(font_color[1]);
			jQuery('#FC_font_color_b').val(font_color[2]);
			jQuery('#FC_grad_color_1_r').val(grad_color_1[0]);
			jQuery('#FC_grad_color_1_g').val(grad_color_1[1]);
			jQuery('#FC_grad_color_1_b').val(grad_color_1[2]);
			jQuery('#FC_grad_color_2_r').val(grad_color_2[0]);
			jQuery('#FC_grad_color_2_g').val(grad_color_2[1]);
			jQuery('#FC_grad_color_2_b').val(grad_color_2[2]);
			add_color_pickers();
		});
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