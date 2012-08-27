<?php
class FlexibleCaptcha {
	var $dimensions;
	var $image;
	var $fonts;
	var $string;
	var $fontDirectory;
	var $absPath;
	var $urlPath;
	var $nonce;

	public function __construct($absPath, $urlPath) {
		$this->absPath = $absPath;
		$this->urlPath = $urlPath;
		$this->fontDirectory = get_option('FC_stored_font_dir');
		if ($this->fontDirectory == '') {
			$uploadDir = wp_upload_dir();
			$this->fontDirectory = $uploadDir['basedir'] . "/fc-fonts/";
		}
	}
	
	function activate() {
		global $wpdb;
		$sql = "CREATE TABLE ".$wpdb->prefix."FC_captcha_store (
			time datetime DEFAULT NULL,
			captcha varchar(255) default '',
			cookie_val varchar(255) default '',
			PRIMARY KEY FC_cookie_key (cookie_val)
			);";
	
		if($wpdb->get_var("SHOW TABLES LIKE '".$wpdb->prefix."FC_captcha_store'") != $wpdb->prefix."FC_captcha_store") {
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
		}

		if (get_option('FC_default_width') == '') {
			update_option('FC_default_width', 100);
		}
		if (get_option('FC_default_height') == '') {
			update_option('FC_default_height', 30);
		}
		if (get_option('FC_random_font_count') == '') {
			update_option('FC_random_font_count', 2);
		}
		if (get_option('FC_font_color') == '') {
			update_option('FC_font_color', array(246, 247, 239));
		}
		if (get_option('FC_grad_color_1') == '') {
			update_option('FC_grad_color_1', array(3, 19, 161));
		}
		if (get_option('FC_grad_color_2') == '') {
			update_option('FC_grad_color_2', array(245, 12, 12));
		}
		if (get_option('FC_gradient_transitions') == '') {
			update_option('FC_gradient_transitions', 5);
		}
		if (get_option('FC_case_sensitive') == '') {
			update_option('FC_case_sensitive', 0);
		}
		if (get_option('FC_add_to_registration') == '') {
			update_option('FC_add_to_registration', 1);
		}
		if (get_option('FC_add_to_comments') == '') {
			update_option('FC_add_to_comments', 1);
		}
		if (get_option('FC_add_to_registration') == 1 || get_option('FC_add_to_comments') == 1) {
			update_option('FC_add_jquery_to_header', 1);
		}

		if (!file_exists($this->fontDirectory)) {
			@mkdir($this->fontDirectory);
		}
		if (get_option('FC_uploaded_fonts') == '') {
			$includedFonts = array('Sansation_Bold.ttf', 'Sansation_Bold_Italic.ttf', 'Sansation_Italic.ttf', 'Sansation_Light.ttf', 'Sansation_Light_Italic.ttf', 'Sansation_Regular.ttf');
			foreach($includedFonts as $fontFile) {
				if (!file_exists($this->fontDirectory . $fontFile)) {
					@copy($this->absPath . "/fonts/" . $fontFile, $this->fontDirectory . $fontFile);
				}
			}
			update_option('FC_uploaded_fonts', $includedFonts);
		}
	}

	function deactivate() {
		global $wpdb;
		//Delete database tables and options if the option to preserve is set to 0.
		if (get_option("FC_preserve_settings") == "0") {
			$wpdb->query("DROP TABLE IF EXISTS `".$wpdb->prefix."FC_captcha_store");
			
			delete_option('FC_request_key');
			delete_option('FC_default_width');
			delete_option('FC_default_height');
			delete_option('FC_random_font_count');
			delete_option('FC_font_color');
			delete_option('FC_grad_color_1');
			delete_option('FC_grad_color_2');
			delete_option('FC_gradient_transitions');
			delete_option('FC_case_sensitive');
			delete_option('FC_add_to_registration');
			delete_option('FC_add_to_comments');
			delete_option('FC_add_jquery_to_header');
			
			if (is_array(get_option('FC_uploaded_fonts'))) {
				foreach(get_option('FC_uploaded_fonts') as $fontFile) {
					if (file_exists($this->fontDirectory . $fontFile)) {
						@unlink($this->fontDirectory . $fontFile);
					}
				}
				delete_option('FC_uploaded_fonts');
			}
			
			if (file_exists($this->fontDirectory)) {
				@unlink($this->fontDirectory);
			}
			
			
		}
	}
	
	function setup_nonce() {
		$this->nonce = wp_create_nonce(plugin_basename(__FILE__));
	}
	
	function admin_menu() {
		global $wpdb;
		$plugin_page=add_menu_page('Flexible Captcha', 'Flexible Captcha', 'activate_plugins', 'Flexible_Captcha', array($this, 'settings_page'), $this->urlPath."/images/fc-icon-16x16.png");
		add_action('admin_head-'.$plugin_page, array($this, 'admin_styles'));
		add_action('admin_head-'.$plugin_page, array($this, 'settings_page_head'));
		add_action('admin_head-'.$plugin_page, array($this, 'common_js'));
	}

	function settings_page() {
		if (array_key_exists('submit_font_file', $_POST)) {
			$this->handle_font_upload();
		}
		$fontFiles = get_option('FC_uploaded_fonts');
		require_once($this->absPath . "/tpl/settings.php");
	}

	function handle_font_upload() {
		if (!file_exists($this->fontDirectory . $_FILES['FC_font_upload']['name']) && move_uploaded_file( $_FILES['FC_font_upload']['tmp_name'], $this->fontDirectory . $_FILES['FC_font_upload']['name'] )) {
			$fontFiles = get_option('FC_uploaded_fonts');
			if (!is_array($fontFiles)) {
				$fontFiles = array();
			}
			$fontFiles[] = $_FILES['FC_font_upload']['name'];
			update_option('FC_uploaded_fonts', $fontFiles);
		}
	}

	function delete_font_file() {
		if (wp_verify_nonce( $_POST['FC_nonce'], plugin_basename(__FILE__) )) {
			$fontFiles = get_option('FC_uploaded_fonts');
			foreach($fontFiles as $key=>$font) {
				if ($font == $_POST['FC_font_file']) {
					unset($fontFiles[$key]);
					unlink($this->fontDirectory . $_POST['FC_font_file']);
				}
			}
			update_option('FC_uploaded_fonts', $fontFiles);
			print "Font files were successfully removed.";
		}
		exit;
	}
	
	function settings_page_head() {
		?>
		<link type="text/css" rel="stylesheet" href="<?php print $this->urlPath; ?>/css/colorpicker.css" />
		<?php
		require_once($this->absPath . "/tpl/settings_page_js.php");
	}

	function admin_styles() {
		?>
		<style type="text/css">
			#icon-fc-settings {
				background: url("<?php print $this->urlPath; ?>/images/fc-icon-32x32.png") no-repeat scroll 0px 0px transparent;
			}
		</style>
		<?php
	}
	
	function common_js() {
	}

	function get_request_key() {
		$requestKey = get_option('FC_request_key');
		if ($requestKey == "") {
			$requestKey = md5('supersecretrequestkey');
			update_option('FC_request_key', $requestKey);
		}
		return $requestKey;
	}
	
	function display_captcha_shortcode($atts, $content=null) {
		extract( shortcode_atts( array('width' => get_option('FC_default_width'), 'height' => get_option('FC_default_height')), $atts ) );
		return $this->get_captcha_fields_display($width, $height);
	}
	
	function get_captcha_fields_display($width, $height) {
		$requestKey = $this->get_request_key();
		ob_start();
		require_once($this->absPath . "/tpl/captcha_fields.php");
		return ob_get_clean();
	}
	
	function check_for_captcha_request($wp_query) {
		$requestKey = $this->get_request_key();
		if ($_GET['FC_captcha_request'] == $requestKey) {
			##Set width
			if (is_numeric($_GET['cwidth']) && $_GET['cwidth'] < 1000 && $_GET['cwidth'] >= 100) {
				$width = $_GET['cwidth'];
			} else {
				$width = get_option('FC_default_width');
			}

			##Set height
			if (is_numeric($_GET['cheight']) && $_GET['cheight'] < 1000 && $_GET['cheight'] >= 16) {
				$height = $_GET['cheight'];
			} else {
				$height = get_option('FC_default_height');
			}

			$this->gen_image($width, $height);
		}
	}
	
	public function set_fonts($fontCount) {
		$fontFiles = get_option('FC_uploaded_fonts');
		if (is_array($fontFiles)) {
			for($i=0; $i<$fontCount; $i++) {
				$this->fonts[]=$this->fontDirectory . $fontFiles[mt_rand()&(sizeof($fontFiles)-1)];
			}
		} else {
			$this->fonts[] = $this->fontDirectory . 'Sansation_Regular.ttf';
		}
	}
	
	public function gen_image($width=0, $height=0) {
		$this->dimensions['width']=$width;
		$this->dimensions['height']=$height;
		$randomFonts = (is_numeric(get_option('FC_random_font_count')))? get_option('FC_random_font_count') : 2;
		$this->set_fonts($randomFonts);
		
		$this->image = @imagecreatetruecolor($this->dimensions['width'], $this->dimensions['height']);
		$this->gen_gradient($this->image, 0, 0);
		#$backgroundColor = @imagecolorallocate($this->image, 0, 0, 0);
		#imageloadfont();
		$this->gen_string();
		header("Pragma: no-cache");
		header("cache-Control: no-cache, must-revalidate");
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Content-type: image/png");
		@imagepng($this->image);
		@imagedestroy($this->image);
		exit;
	}

	public function gen_string() {
		global $wpdb;
		#session_start();
		$count=0;
		$this->string="";
		$fontColor = get_option('FC_font_color');
		if (!is_array($fontColor) || !is_numeric($fontColor[0]) || !is_numeric($fontColor[1]) || !is_numeric($fontColor[2])) {
			$fontColor = array(147, 149, 152);
		}
		
		$textColor = @imagecolorallocate($this->image, $fontColor[0], $fontColor[1], $fontColor[2]);
		while ($count < (int)($this->dimensions['width'] / 16)) {
			$char="";
			switch(mt_rand()&5) {
				case 0:
					$char .= chr(mt_rand(65,79));
					break;
				case 4:
					$char .= chr(mt_rand(80,90));
					break;
				case 1:
					$char .= chr(mt_rand(109,122));
					break;
				case 3:
					$char .= chr(mt_rand(97,108));
					break;
				case 2:
				case 5:
					$char .= mt_rand(2,9);
					break;
			}
			imagettftext($this->image, mt_rand(13,16), 0, ($count*16), mt_rand(16, $this->dimensions['height']), $textColor, $this->fonts[mt_rand()&sizeof($this->fonts)-1], $char);
			$this->string .= $char;
			$count++;
		}
		$cookieVal = md5(mt_rand(9999, 9999999999) * mt_rand(9999, 9999999999));
		setcookie('FC_captcha_key', $cookieVal);
		$wpdb->insert($wpdb->prefix."FC_captcha_store", array("time"=>date("Y-m-d H:i:s"), "captcha"=>$this->string, "cookie_val"=>$cookieVal));
	}




	public function set_gradient_colors() {
		$gradColor1 = get_option('FC_grad_color_1');
		$gradColor2 = get_option('FC_grad_color_2');
		if (!is_array($gradColor1) || !is_numeric($gradColor1[0]) || !is_numeric($gradColor1[1]) || !is_numeric($gradColor1[2])) {
			$gradColor1 = array(30,144,255);
		}

		if (!is_array($gradColor2) || !is_numeric($gradColor2[0]) || !is_numeric($gradColor2[1]) || !is_numeric($gradColor2[2])) {
			$gradColor2 = array(255, 0, 0);
		}

		switch (mt_rand(1,4)) {
			case 1:
			case 4:
				$this->gradientColors[0] = $gradColor1;
				$this->gradientColors[1] = $gradColor2;
				break;
			case 2:
			case 3:
				$this->gradientColors[0] = $gradColor2;
				$this->gradientColors[1] = $gradColor1;
				break;
		}
	}

	public function gen_gradient($im, $x1, $y1) {
		$this->set_gradient_colors();
		$gradientTrans = (is_numeric(get_option('FC_gradient_transitions')))? get_option('FC_gradient_transitions') : 5;
		for($x=0;$x<$gradientTrans;$x++) {
			$color0=($this->gradientColors[0][0]-$this->gradientColors[1][0])/$this->dimensions['width'];
			$color1=($this->gradientColors[0][1]-$this->gradientColors[1][1])/$this->dimensions['width'];
			$color2=($this->gradientColors[0][2]-$this->gradientColors[1][2])/$this->dimensions['width'];
			if ($x%2) {
				for ($i=0;$i<=$this->dimensions['width']/$gradientTrans;$i++)
				{
					$red=$this->gradientColors[0][0]-floor($i*$color0*$gradientTrans);
					$green=$this->gradientColors[0][1]-floor($i*$color1*$gradientTrans);
					$blue=$this->gradientColors[0][2]-floor($i*$color2*$gradientTrans);
					$col= imagecolorallocate($im, $red, $green, $blue);
					imageline($im, $x1+($this->dimensions['width']/$gradientTrans*$x)+$i, $y1, $x1+($this->dimensions['width']/$gradientTrans*$x)+$i, $y1+$this->dimensions['height'], $col);
				}
			} else {
				for ($i=0;$i<=$this->dimensions['width']/$gradientTrans;$i++)
				{
					$red=$this->gradientColors[1][0]+floor($i*$color0*$gradientTrans);
					$green=$this->gradientColors[1][1]+floor($i*$color1*$gradientTrans);
					$blue=$this->gradientColors[1][2]+floor($i*$color2*$gradientTrans);
					$col= imagecolorallocate($im, $red, $green, $blue);
					imageline($im, $x1+($this->dimensions['width']/$gradientTrans*$x)+$i, $y1, $x1+($this->dimensions['width']/$gradientTrans*$x)+$i, $y1+$this->dimensions['height'], $col);
				}
			}
		}
	}
	
	function check_captcha_val() {
		global $wpdb;
		$caseSensitive = get_option('FC_case_sensitive');
		if (array_key_exists('FC_captcha_key', $_COOKIE) && $_REQUEST['FC_captcha_input'] != "") {
			if ($caseSensitive == 1) {
				$sql = "SELECT COUNT(*) FROM ".$wpdb->prefix."FC_captcha_store WHERE cookie_val LIKE BINARY '%s' AND captcha LIKE BINARY '%s'";
			} else {
				$sql = "SELECT COUNT(*) FROM ".$wpdb->prefix."FC_captcha_store WHERE cookie_val LIKE BINARY '%s' AND captcha='%s'";
			}
			
			if ($wpdb->get_var($wpdb->prepare($sql, $_COOKIE['FC_captcha_key'], $_REQUEST['FC_captcha_input'])) == 1) {
				$returnVal = true;
			} else {
				$returnVal = false;
			}
			$deleteQuery = "DELETE FROM ".$wpdb->prefix."FC_captcha_store WHERE cookie_val='%s'";
			$result = $wpdb->query($wpdb->prepare($deleteQuery, $_COOKIE['FC_captcha_key']));
		} else {
			$returnVal = false;
		}
		return $returnVal;
	}

	function submit_default_dimensions() {
		if (wp_verify_nonce( $_POST['FC_nonce'], plugin_basename(__FILE__) )) {
			##Set width
			if (is_numeric($_POST['FC_default_width']) && $_POST['FC_default_width'] < 1000 && $_POST['FC_default_width'] >= 100) {
				update_option('FC_default_width', $_POST['FC_default_width']);
			}

			##Set height
			if (is_numeric($_POST['FC_default_height']) && $_POST['FC_default_height'] < 1000 && $_POST['FC_default_width'] >= 16) {
				update_option('FC_default_height', $_POST['FC_default_height']);
			}
			
			print "Default dimentions successfully saved.";
		}
		die();
	}

	function submit_request_key() {
		if (wp_verify_nonce( $_POST['FC_nonce'], plugin_basename(__FILE__) )) {
			if ($_POST['FC_request_key'] != '') {
				##Set request key
				update_option('FC_request_key', $_POST['FC_request_key']);
				print "Request key successfully saved.";
			} else {
				print "Request key not saved.  The submitted key did not have a value.";
			}
		}
		die();
	}

	function submit_general_settings() {
		if (wp_verify_nonce( $_POST['FC_nonce'], plugin_basename(__FILE__) )) {
			if (is_numeric($_POST['FC_random_font_count']) && $_POST['FC_random_font_count'] < 100) {
				update_option('FC_random_font_count', $_POST['FC_random_font_count']);
			}
			
			if (is_numeric($_POST['FC_gradient_transitions']) && $_POST['FC_gradient_transitions'] < 100) {
				update_option('FC_gradient_transitions', $_POST['FC_gradient_transitions']);
			}
			
			if ($_POST['FC_case_sensitive'] == 1) {
				update_option('FC_case_sensitive', 1);
			} else {
				update_option('FC_case_sensitive', 0);
			}

			if ($_POST['FC_add_to_comments'] == 1) {
				update_option('FC_add_to_comments', 1);
			} else {
				update_option('FC_add_to_comments', 0);
			}
			
			if ($_POST['FC_add_to_registration'] == 1) {
				update_option('FC_add_to_registration', 1);
			} else {
				update_option('FC_add_to_registration', 0);
			}
			
			if ($_POST['FC_add_jquery_to_header'] == 1 || get_option('FC_add_to_registration') == 1 || get_option('FC_add_to_comments') == 1) {
				update_option('FC_add_jquery_to_header', 1);
			} else {
				update_option('FC_add_jquery_to_header', 0);
			}
			
			if ($_POST['FC_preserve_settings'] == 1) {
				update_option('FC_preserve_settings', 1);
			} else {
				update_option('FC_preserve_settings', 0);
			}
			
			print "Settings successfully saved.";
		}
		die();
	}
	
	function submit_colors() {
		if (wp_verify_nonce( $_POST['FC_nonce'], plugin_basename(__FILE__) )) {
			##Set font_color
			if (is_array($_POST['FC_font_color']) && is_numeric($_POST['FC_font_color'][0]) && is_numeric($_POST['FC_font_color'][1]) && is_numeric($_POST['FC_font_color'][2])) {
				update_option('FC_font_color', $_POST['FC_font_color']);
			}
			
			if (is_array($_POST['FC_grad_color_1']) && is_numeric($_POST['FC_grad_color_1'][0]) && is_numeric($_POST['FC_grad_color_1'][1]) && is_numeric($_POST['FC_grad_color_1'][2])) {
				update_option('FC_grad_color_1', $_POST['FC_grad_color_1']);
			}

			if (is_array($_POST['FC_grad_color_2']) && is_numeric($_POST['FC_grad_color_2'][0]) && is_numeric($_POST['FC_grad_color_2'][1]) && is_numeric($_POST['FC_grad_color_2'][2])) {
				update_option('FC_grad_color_2', $_POST['FC_grad_color_2']);
			}
			print "Colors successfully saved.";
		}
		die();
	}

	function add_to_comment_form() {
		if (get_option('FC_add_to_comments') == 1) {
			print $this->get_captcha_fields_display(get_option('FC_default_width'), get_option('FC_default_height'));
		}
	}

	function add_to_registration_form() {
		if (get_option('FC_add_to_comments') == 1) {
			print $this->get_captcha_fields_display(get_option('FC_default_width'), get_option('FC_default_height'));
		}
	}

	function check_registration_submit($login, $email, $errors) {
		if (get_option('FC_add_to_registration') == 1 && !$this->check_captcha_val()) {
			$errors->add('bad_captcha', "<strong>ERROR</strong>: The entered text did not match the captcha image.");
		}
	}

	function check_comment_submit($commentdata) {
		if (get_option('FC_add_to_comments') == 1 && !$this->check_captcha_val()) {
			wp_die( __( 'Error: The entered text did not match the captcha image.  Use your browsers back button and try again.' ) );
			exit;
		}
		return $commentdata;
	}

	function add_jquery_to_header() {
		if (get_option('FC_add_jquery_to_header') == 1) {
			wp_enqueue_script("jquery");
		}
	}

}
?>