<div id="wrap">
	<div class="icon32" id="icon-fc-settings"> <br /> </div>

	<h2>Settings</h2>
	<p>Genral Settings</p>
	<?php
	if ($errMsg != "") {
		?>
		<p style="color: #CC0066;"><?php print $errMsg; ?></p>
		<?php
	}
	?>
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
						<label for="FC_delete_font_color">Font Colors:</label><br />
						<div class="FC_note">To delete colors check the box in the top left corner and click the Delete Colors button below it.</div>
						<div id="FC-font-colors-div" style="float: left;width: 300px;">
						</div>
						<div style="clear: both;"></div>
						<input style="margin-bottom: 50px;" type="button" value="Add Font Color" onclick="javascript:FC_add_new_color('font');" /> &nbsp;&nbsp;
						<input type="button" value="Delete Colors" onclick="javascript:FC_delete_font_colors();" /><br />
						<label for="FC_delete_bg_color">Background Colors:</label>
						<div class="FC_note">To delete colors check the box in the top left corner and click the Delete Colors button below it.</div>
						<div id="FC-bg-colors-div" style="float: left;width: 300px;">
						</div>
						<div style="clear: both;"></div>
						<input type="button" value="Add Background Color" onclick="javascript:FC_add_new_color('bg');" /> &nbsp;&nbsp;
						<input type="button" value="Delete Colors" onclick="javascript:FC_delete_bg_colors();" />
					</div>

					<?php print (get_option('FC_grad_color_1') != '' && get_option('FC_bg_color_1') == ''); ?>
					<h3><label for="FC_general_settings">General Settings</label></h3>
					<div id="FC-general-settings-div" class="FC-options-container">
						<label for="FC_preserve_settings">Preserve Settings On Deactivation: </label>
						<input type="checkbox" name="FC_preserve_settings" id="FC_preserve_settings" value="1"<?php print (get_option('FC_preserve_settings') == 1)? ' checked="checked"' : ''; ?> /><br />
						
						<label for="FC_random_font_count">Random Font Count:  </label>
						<input type="text" name="FC_random_font_count" id="FC_random_font_count" value="<?php print get_option("FC_random_font_count"); ?>" /><br />
						
						<label for="FC_background_type">Background Type:  </label>
						<select name="FC_background_type" id="FC_background_type"><option value="gradient">Gradient</option><option value="random_shape"<?php print (get_option("FC_background_type") == 'random_shape')? ' selected="selected"':''; ?>>Random Shapes</option></select><br />
						
						<div id="random_shape_settings" style="height: 100px;display: none;">
							<label for="FC_section_count">Background Sections:  </label><input type="text" name="FC_section_count" id="FC_section_count" value="<?php print get_option("FC_section_count"); ?>" /><br />
							<div class="FC_note">The number of sections that the background will be broken into for a shape to be drawn in. Max: 100</div>
							<label for="FC_shape_count">Shape Count:  </label><input type="text" name="FC_shape_count" id="FC_shape_count" value="<?php print get_option("FC_shape_count"); ?>" /><br />
							<div class="FC_note">The number of random shapes to be drawn</div>
						</div>
						
						<div id="gradient_settings" style="height: 100px;display: none;">
							<label for="FC_gradient_transitions">Gradient Transitions:  </label><input type="text" name="FC_gradient_transitions" id="FC_gradient_transitions" value="<?php print get_option("FC_gradient_transitions"); ?>" /><br />
							<div class="FC_note">The number of transitions from one color to the other. Max: 100</div>
						</div>
						
						<br />
						<label for="FC_case_sensitive">Case Sensitive:  </label>
						<input type="checkbox" name="FC_case_sensitive" id="FC_case_sensitive" value="1"<?php print (get_option('FC_case_sensitive') == 1)? ' checked="checked"' : ''; ?> /><br />
						
						<label for="FC_add_to_comments">Add To Comment Form:  </label>
						<input type="checkbox" name="FC_add_to_comments" id="FC_add_to_comments" value="1"<?php print (get_option('FC_add_to_comments') == 1)? ' checked="checked"' : ''; ?> /><br />
						
						<label for="FC_add_to_registration">Add To Registration Form:  </label>
						<input type="checkbox" name="FC_add_to_registration" id="FC_add_to_registration" value="1"<?php print (get_option('FC_add_to_registration') == 1)? ' checked="checked"' : ''; ?> /><br />
						
						<label for="FC_add_to_login">Add To Login Form:  </label>
						<input type="checkbox" name="FC_add_to_login" id="FC_add_to_login" value="1"<?php print (get_option('FC_add_to_login') == 1)? ' checked="checked"' : ''; ?> /><br />
						
						<label for="FC_add_jquery_to_header">Add jQuery To Header:  </label>
						<input type="checkbox" name="FC_add_jquery_to_header" id="FC_add_jquery_to_header" value="1"<?php print (get_option('FC_add_jquery_to_header') == 1)? ' checked="checked"' : ''; ?> /><br />
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