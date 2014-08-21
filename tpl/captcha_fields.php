<script type="text/javascript" language="javascript">
	var loadingImg = new Image();
	loadingImg.src='<?php print $this->urlPath; ?>/images/ajax-loader.gif';
	function FC_regenerate_captcha_<?php print $uniqueFieldID; ?>() {
		var dims = new Array(jQuery('#FC_captcha_image_<?php print $uniqueFieldID; ?>').attr('width'), jQuery('#FC_captcha_image_<?php print $uniqueFieldID; ?>').attr('height'));
		jQuery('#FC_captcha_image_<?php print $uniqueFieldID; ?>').css('width', dims[0]);
		jQuery('#FC_captcha_image_<?php print $uniqueFieldID; ?>').css('height', dims[1]);
		jQuery('#FC_captcha_image_<?php print $uniqueFieldID; ?>').attr('src', loadingImg.src);
		jQuery('#FC_captcha_image_<?php print $uniqueFieldID; ?>').attr('src', '<?php print home_url(); ?>?FC_captcha_request=<?php print $requestKey; ?>&rs='+new Date().getTime()+'&cwidth=<?php print $width; ?>&cheight=<?php print $height; ?>&uniqueID=<?php print $uniqueFieldID; ?>');
		
	}
	jQuery(function() {
		jQuery('#FC_image_refresh_<?php print $uniqueFieldID; ?>').click(function(e) {
			FC_regenerate_captcha_<?php print $uniqueFieldID; ?>();
			e.preventDefault();
		});
	});
</script>
<div id="FC_captcha_input_label_<?php print $uniqueFieldID; ?>">Enter the text from the image below</div>
<div class="FC_captcha_input_container" id="FC_captcha_input_container_<?php print $uniqueFieldID; ?>">
  <input type="text" name="FC_captcha_input" id="FC_captcha_input_<?php print $uniqueFieldID; ?>" value="" />
  <input type="hidden" name="FC_captcha_unique_id" id="FC_captcha_unique_id_<?php print $uniqueFieldID; ?>" value="<?php print $uniqueFieldID; ?>" />
</div>
<div id="FC_captcha_image_container_<?php print $uniqueFieldID; ?>" class="FC_captcha_image_container">
  <img id="FC_captcha_image_<?php print $uniqueFieldID; ?>" width="<?php print $width; ?>" height="<?php print $height; ?>" src="<?php print home_url(); ?>?FC_captcha_request=<?php print $requestKey; ?>&rs=<?php print time(); ?>&cwidth=<?php print $width; ?>&cheight=<?php print $height; ?>&uniqueID=<?php print $uniqueFieldID; ?>" />&nbsp;<img class="FC_image_refresh" id="FC_image_refresh_<?php print $uniqueFieldID; ?>" src="<?php print $this->urlPath; ?>/images/arrows_refresh.png" />
</div>