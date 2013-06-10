<div id="wrap">
	<div class="icon32" id="icon-fc-settings"> <br /> </div>

	<h2>Settings</h2>
	<p>Genral Settings</p>
	<div id="poststuff" class="metabox-holder">
		<div id="post-body">
			<div id="post-body-content">
				<div id="FC-settings-div" class="stuffbox" style="width: 98%">
					<h3><label for="FC_default_width">Default Dimensions</label></h3>
					<div id="FC-default-dim-div" class="FC-options-container">
						Width: <input type="text" name="FC_default_width" id="FC_default_width" value="<?php print get_option("FC_default_width"); ?>" /><br />
						Height: <input type="text" name="FC_default_height" id="FC_default_height" value="<?php print get_option("FC_default_height"); ?>" /><br />
					</div>
					<h3><label for="FC_default_width">Request key</label></h3>
					<div id="FC-request-key-div" class="FC-options-container">
						Key: <input type="text" name="FC_request_key" id="FC_request_key" value="<?php print get_option("FC_request_key"); ?>" />
					</div>

					<h3><label for="FC_colors">Colors</label></h3>
					<div id="FC-colors-div" class="FC-options-container">
						<?php $FC_font_color = get_option('FC_font_color'); ?>
						Font: <input type="text" name="FC_font_color_r" id="FC_font_color_r" value="<?php print $FC_font_color[0]; ?>" size="3" readonly="readonly" />
						&nbsp;<input type="text" name="FC_font_color_g" id="FC_font_color_g" value="<?php print $FC_font_color[1]; ?>" size="3" readonly="readonly" />
						&nbsp;<input type="text" name="FC_font_color_b" id="FC_font_color_b" value="<?php print $FC_font_color[2]; ?>" size="3" readonly="readonly" />
						&nbsp;<input type="text" id="FC_font_color_display" size="3" readonly="readonly" /><br /><br />

						<?php $FC_grad_color_1 = get_option('FC_grad_color_1'); ?>
						Gradient 1: <input type="text" name="FC_grad_color_1_r" id="FC_grad_color_1_r" value="<?php print $FC_grad_color_1[0]; ?>" size="3" readonly="readonly" />
						&nbsp;<input type="text" name="FC_grad_color_1_g" id="FC_grad_color_1_g" value="<?php print $FC_grad_color_1[1]; ?>" size="3" readonly="readonly" />
						&nbsp;<input type="text" name="FC_grad_color_1_b" id="FC_grad_color_1_b" value="<?php print $FC_grad_color_1[2]; ?>" size="3" readonly="readonly" />
						&nbsp;<input type="text" id="FC_grad_color_1_display" size="3" readonly="readonly" /><br /><br />

						<?php $FC_grad_color_2 = get_option('FC_grad_color_2'); ?>
						Gradient 2: <input type="text" name="FC_grad_color_2_r" id="FC_grad_color_2_r" value="<?php print $FC_grad_color_2[0]; ?>" size="3" readonly="readonly" />
						&nbsp;<input type="text" name="FC_grad_color_2_g" id="FC_grad_color_2_g" value="<?php print $FC_grad_color_2[1]; ?>" size="3" readonly="readonly" />
						&nbsp;<input type="text" name="FC_grad_color_2_b" id="FC_grad_color_2_b" value="<?php print $FC_grad_color_2[2]; ?>" size="3" readonly="readonly" />
						&nbsp;<input type="text" id="FC_grad_color_2_display" size="3" readonly="readonly" /><br /><br />
					</div>

					<h3><label for="FC_general_settings">General Settings</label></h3>
					<div id="FC-general-settings-div" class="FC-options-container">
						Preserve Settings On Deactivation: <input type="checkbox" name="FC_preserve_settings" id="FC_preserve_settings" value="1"<?php print (get_option('FC_preserve_settings') == 1)? ' checked="checked"' : ''; ?> /><br />
						Random Font Count: <input type="text" name="FC_random_font_count" id="FC_random_font_count" value="<?php print get_option("FC_random_font_count"); ?>" /><br />
						Gradient Transitions: <input type="text" name="FC_gradient_transitions" id="FC_gradient_transitions" value="<?php print get_option("FC_gradient_transitions"); ?>" /><br />
						Case Sensitive: <input type="checkbox" name="FC_case_sensitive" id="FC_case_sensitive" value="1"<?php print (get_option('FC_case_sensitive') == 1)? ' checked="checked"' : ''; ?> /><br />
						Add To Comment Form: <input type="checkbox" name="FC_add_to_comments" id="FC_add_to_comments" value="1"<?php print (get_option('FC_add_to_comments') == 1)? ' checked="checked"' : ''; ?> /><br />
						Add To Registration Form: <input type="checkbox" name="FC_add_to_registration" id="FC_add_to_registration" value="1"<?php print (get_option('FC_add_to_registration') == 1)? ' checked="checked"' : ''; ?> /><br />
						Add To Login Form: <input type="checkbox" name="FC_add_to_login" id="FC_add_to_login" value="1"<?php print (get_option('FC_add_to_login') == 1)? ' checked="checked"' : ''; ?> /><br />
						Add jQuery To Header: <input type="checkbox" name="FC_add_jquery_to_header" id="FC_add_jquery_to_header" value="1"<?php print (get_option('FC_add_jquery_to_header') == 1)? ' checked="checked"' : ''; ?> /><br />
					</div>
					<hr />
					<div style="text-align: center;">
						<input type="button" name="FC_submit_settings" value="Submit" onmousedown="FC_submit_settings();" />
					</div>
				</div>
				<div id="FC-fonts-div" class="stuffbox" style="width: 98%">

					<h3><label for="FC_font_upload">Fonts</label></h3>
					<div id="FC-font-files-div" class="FC-options-container">
						<form method="post" action="" enctype="multipart/form-data">
							Font File: <input type="file" name="FC_font_upload" id="FC_font_upload" value="" /><br />
							<input type="submit" name="submit_font_file" value="Submit" />
						</form>
						<hr />
						<br /><br />
						<div>
							<?php
							if (is_array($fontFiles)) {
								foreach ($fontFiles as $key=>$font) {
									print '<div style="border-bottom: 1px solid #000000;" id="FC_font_file_'.$key.'"><input type="image" style="margin: 0px; padding: 0px;" src="'.$this->urlPath.'/images/delete.png" class="delete_font" onmousedown="FC_delete_font_file(\''.$font.'\', '.$key.');" />'.$this->fontDirectory . $font.'</div>';
								}
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>