<?php 
	header("HTTP/1.1 200 OK");
	header("Status: 200") ;
	header("Content-type: text/javascript");
?>

<?php include(dirname(__FILE__).'/functions.js'); ?>

<?php 
	require_once('../../../../wp-blog-header.php'); 
	$settings = get_option("wpAppbox");
	$option = $options['wpAppbox_button_default'];
?>

tinymce.PluginManager.add('wpAppbox_CombinedButton', function(editor, url) {
	editor.addButton('wpAppbox_AppboxButton', {
		type: 'menubutton',
		icon: 'icon wpappbox-tinymce-button',
		menu: [
		
			<?php if(($settings['wpAppbox_button_appbox_amazonapps']) || ($option == '1')) { ?>
				{ text: 'Amazon Apps', onclick : function() {
					tinyMCE.activeEditor.execCommand('mceInsertContent', false, wpAppbox_amazonapps_button());
				}},
			<?php } ?>
			
			<?php if(($settings['wpAppbox_button_appbox_androidpit']) || ($option == '1')) { ?>
				{ text: 'AndroidPit', onclick : function() {
					tinyMCE.activeEditor.execCommand('mceInsertContent', false, wpAppbox_androidpit_button());
				}},
			<?php } ?>
			
			<?php if(($settings['wpAppbox_button_appbox_appstore']) || ($option == '1')) { ?>
				{ text: '(Mac) App Store', onclick : function() {
					tinyMCE.activeEditor.execCommand('mceInsertContent', false, wpAppbox_appstore_button());
				}},
			<?php } ?>
			
			<?php if(($settings['wpAppbox_button_appbox_chromewebstore']) || ($option == '1')) { ?>
				{ text: 'Chrome Web Store', onclick : function() {
					tinyMCE.activeEditor.execCommand('mceInsertContent', false, wpAppbox_chromewebstore_button());
				}},
			<?php } ?>
			
			<?php if(($settings['wpAppbox_button_appbox_firefoxaddon']) || ($option == '1')) { ?>
				{ text: 'Firefox Addons', onclick : function() {
					tinyMCE.activeEditor.execCommand('mceInsertContent', false, wpAppbox_firefoxaddon_button());
				}},
			<?php } ?>
			
			<?php if(($settings['wpAppbox_button_appbox_firefoxmarketplace']) || ($option == '1')) { ?>
				{ text: 'Firefox Marketplace', onclick : function() {
					tinyMCE.activeEditor.execCommand('mceInsertContent', false, wpAppbox_firefoxmarketplace_button());
				}},
			<?php } ?>
			
			<?php if(($settings['wpAppbox_button_appbox_goodoldgames']) || ($option == '1')) { ?>
				{ text: 'Good Old Games (GOG)', onclick : function() {
					tinyMCE.activeEditor.execCommand('mceInsertContent', false, wpAppbox_goodoldgames_button());
				}},
			<?php } ?>
			
			<?php if(($settings['wpAppbox_button_appbox_googleplay']) || ($option == '1')) { ?>
				{ text: 'Google Play Apps', onclick : function() {
					tinyMCE.activeEditor.execCommand('mceInsertContent', false, wpAppbox_googleplay_button());
				}},
			<?php } ?>
			
			<?php if(($settings['wpAppbox_button_appbox_operaaddons']) || ($option == '1')) { ?>
				{ text: 'Opera Addons', onclick : function() {
					tinyMCE.activeEditor.execCommand('mceInsertContent', false, wpAppbox_operaaddons_button());
				}},
			<?php } ?>
			
			<?php if(($settings['wpAppbox_button_appbox_windowsstore']) || ($option == '1')) { ?>
				{ text: 'Windows Store', onclick : function() {
					tinyMCE.activeEditor.execCommand('mceInsertContent', false, wpAppbox_windowsstore_button());
				}},
			<?php } ?>
			
			<?php if(($settings['wpAppbox_button_appbox_windowsphone']) || ($option == '1')) { ?>
				{ text: 'Windows Phone Store', onclick : function() {
					tinyMCE.activeEditor.execCommand('mceInsertContent', false, wpAppbox_windowsphone_button());
				}},
			<?php } ?>
			
			<?php if(($settings['wpAppbox_button_appbox_samsungapps']) || ($option == '1')) { ?>
				{ text: 'Samsung Apps', onclick : function() {
					tinyMCE.activeEditor.execCommand('mceInsertContent', false, wpAppbox_samsungapps_button());
				}},
			<?php } ?>
			
			<?php if(($settings['wpAppbox_button_appbox_steam']) || ($option == '1')) { ?>
				{ text: 'Steam', onclick : function() {
					tinyMCE.activeEditor.execCommand('mceInsertContent', false, wpAppbox_steam_button());
				}},
			<?php } ?>
			
			<?php if(($settings['wpAppbox_button_appbox_wordpress']) || ($option == '1')) { ?>
				{ text: 'WordPress Plugins', onclick : function() {
					tinyMCE.activeEditor.execCommand('mceInsertContent', false, wpAppbox_wordpress_button());
				}},
			<?php } ?>
			
		]
	});
});