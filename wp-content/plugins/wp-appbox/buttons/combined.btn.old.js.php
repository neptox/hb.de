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


(function() {
    tinymce.create('tinymce.plugins.wpAppbox_CombinedButton', {

    	
        createControl: function(n, cm) {
            switch (n) {
                case 'wpAppbox_AppboxButton':
                var c = cm.createSplitButton('wpAppbox_AppboxButton', {
                    title : 'WP-Appbox',
                    image : '../wp-content/plugins/wp-appbox/buttons/appbox.btn.png',
                    onclick : function() {showMenu();}
                });
                c.onRenderMenu.add(function(c, m) {
                 		
                <?php if(($settings['wpAppbox_button_appbox_amazonapps']) || ($option == '1')) { ?>      
                  m.add({title : 'Amazon Apps', onclick : function() {
                  	tinyMCE.activeEditor.execCommand('mceInsertContent',false,wpAppbox_amazonapps_button())
                  }});
                <?php } ?>
                
                <?php if(($settings['wpAppbox_button_appbox_androidpit']) || ($option == '1')) { ?>
                	m.add({title : 'AndroidPit', onclick : function() {
                		tinyMCE.activeEditor.execCommand('mceInsertContent',false,wpAppbox_androidpit_button())
                	}});
                <?php } ?>
                
                <?php if(($settings['wpAppbox_button_appbox_appstore']) || ($option == '1')) { ?>
					m.add({title : '(Mac) App Store', onclick : function() {
						tinyMCE.activeEditor.execCommand('mceInsertContent',false,wpAppbox_appstore_button())
					}});
				<?php } ?>
				
				<?php if(($settings['wpAppbox_button_appbox_chromewebstore']) || ($option == '1')) { ?>      
					m.add({title : 'Chrome Web Store', onclick : function() {
				    tinyMCE.activeEditor.execCommand('mceInsertContent',false,wpAppbox_chromewebstore_button())
				    }});
				<?php } ?>
				
				<?php if(($settings['wpAppbox_button_appbox_firefoxaddon']) || ($option == '1')) { ?>      
				  m.add({title : 'Firefox Erweiterungen', onclick : function() {
				  	tinyMCE.activeEditor.execCommand('mceInsertContent',false,wpAppbox_firefoxaddon_button())
				  }});
				<?php } ?>
     
		     	<?php if(($settings['wpAppbox_button_appbox_firefoxmarketplace']) || ($option == '1')) { ?>  
		          m.add({title : 'Firefox Marketplace', onclick : function() {
		          	tinyMCE.activeEditor.execCommand('mceInsertContent',false,wpAppbox_firefoxmarketplace_button())
		          }});
		     	<?php } ?>
		     	
		     	<?php if(($settings['wpAppbox_button_appbox_goodoldgames']) || ($option == '1')) { ?>
		     		m.add({title : 'Good Old Games (GOG.com)', onclick : function() {
		     			tinyMCE.activeEditor.execCommand('mceInsertContent',false,wpAppbox_goodoldgames_button())
		     		}});
		     	<?php } ?>
     	
     			<?php if(($settings['wpAppbox_button_appbox_googleplay']) || ($option == '1')) { ?>	
			         m.add({title : 'Google Play', onclick : function() {
			     		tinyMCE.activeEditor.execCommand('mceInsertContent',false,wpAppbox_googleplay_button())
			         }});
			   	<?php } ?>
			   	   
			   	<?php if(($settings['wpAppbox_button_appbox_operaaddons']) || ($option == '1')) { ?>	
			   	   m.add({title : 'Opera Add-ons', onclick : function() {
			   			tinyMCE.activeEditor.execCommand('mceInsertContent',false,wpAppbox_operaaddons_button())
			   	   }});
			   		<?php } ?>
			         
			  	<?php if(($settings['wpAppbox_button_appbox_windowsstore']) || ($option == '1')) { ?>	
			         m.add({title : 'Windows Store', onclick : function() {
			     		tinyMCE.activeEditor.execCommand('mceInsertContent',false,wpAppbox_windowsstore_button())
			         }});
	   			<?php } ?>
	
				<?php if(($settings['wpAppbox_button_appbox_windowsphone']) || ($option == '1')) { ?>
			         m.add({title : 'Windows Phone Store', onclick : function() {
			     		tinyMCE.activeEditor.execCommand('mceInsertContent',false,wpAppbox_windowsphone_button())
			         }});
		 		 <?php } ?>
		 		 
				<?php if(($settings['wpAppbox_button_appbox_samsungapps']) || ($option == '1')) { ?>      
				  m.add({title : 'Samsung Apps', onclick : function() {
				  	tinyMCE.activeEditor.execCommand('mceInsertContent',false,wpAppbox_samsungapps_button())
				  }});
				<?php } ?>
			
				<?php if(($settings['wpAppbox_button_appbox_steam']) || ($option == '1')) { ?>      
				  m.add({title : 'Steam', onclick : function() {
				  	tinyMCE.activeEditor.execCommand('mceInsertContent',false,wpAppbox_steam_button())
				  }});
				<?php } ?>
			   
			   	<?php if(($settings['wpAppbox_button_appbox_wordpress']) || ($option == '1')) { ?>      
			         m.add({title : 'WordPress Plugin Verzeichnis', onclick : function() {
			         	tinyMCE.activeEditor.execCommand('mceInsertContent',false,wpAppbox_wordpress_button())
			         }});
	 			<?php } ?>
			         
                });
                return c;
            }
            return null;
        }
    });
    tinymce.PluginManager.add('wpAppboxCombined', tinymce.plugins.wpAppbox_CombinedButton);
})();