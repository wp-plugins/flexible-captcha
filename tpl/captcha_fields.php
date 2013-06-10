<script type="text/javascript" language="javascript">
	var loadingImg = new Image();
	loadingImg.src='<?php print $this->urlPath; ?>/images/ajax-loader.gif';
	function FC_regenerate_captcha() {
		var dims = new Array(jQuery('#FC_captcha_image').attr('width'), jQuery('#FC_captcha_image').attr('height'));
		jQuery('#FC_captcha_image').css('width', dims[0]);
		jQuery('#FC_captcha_image').css('height', dims[1]);
		jQuery('#FC_captcha_image').attr('src', loadingImg.src);
		jQuery('#FC_captcha_image').attr('src', '<?php print home_url(); ?>?FC_captcha_request=<?php print $requestKey; ?>&rs='+new Date().getTime()+'&cwidth=<?php print $width; ?>&cheight=<?php print $height; ?>');
		
	}
	jQuery(function() {
		jQuery('#FC_image_refresh').click(function(e) {
			FC_regenerate_captcha();
			e.preventDefault();
		});
	});
</script>
<div id="FC_captcha_input_label">Enter the text from the image below</div>
<div id="FC_captcha_input_container">
  <input type="text" name="FC_captcha_input" id="FC_captcha_input" value="" />
</div>
<div id="FC_captcha_image_container">
  <img id="FC_captcha_image" width="<?php print $width; ?>" height="<?php print $height; ?>" src="<?php print home_url(); ?>?FC_captcha_request=<?php print $requestKey; ?>&rs=<?php print time(); ?>&cwidth=<?php print $width; ?>&cheight=<?php print $height; ?>" />&nbsp;<img id="FC_image_refresh" src="<?php print $this->urlPath; ?>/images/arrows_refresh.png" />
</div>