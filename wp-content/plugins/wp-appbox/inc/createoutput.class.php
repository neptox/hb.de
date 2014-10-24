<?php
	error_reporting(0);
	
	class CreateOutput {
		
		function checkAttributs($attr) {
			if($attr['store'] == '') return('nostore');
			elseif($attr['appid'] == '') return('noappid');
			else return(true);
		}
		
		function has_user_permissions() {
			$userdata = get_userdata(get_current_user_id());
			if(intval($userdata->user_level) >= 2) return true;
			else false;
		}
		
		function loadTemplate($style) {
			ob_start();
			include('tpl/'.$style.'.php');
			$tpl = ob_get_contents();
			print_r($tpl);
			ob_end_clean();
			return($tpl);
		}
		
		function getTheAppData($store, $appid) {
			$app_info = new GetAppInfoAPI;
			$thegetfunction = 'get'.$store;
			return($app_info->$thegetfunction($appid));
		}
		
		function theQRCode($app_data, $size ='400', $EC_level='L', $margin='0') {
			global $ItemInfo;
			$url = urlencode($this->theAppLink($app_data));
			$url = 'http://chart.apis.google.com/chart?cht=qr&chl='.$url.'&chs='.$size.'x'.$size.'&chld='.$EC_level.'|'.$margin;
			return('<div class="qrcode"><img src="'.$url.'" alt="'.$this->theAppTitle($app_data).'" /></div>');
			//echo('http://chart.apis.google.com/chart?cht=qr&chl='.$url.'&chs='.$size.'x'.$size.'&chld=L|0');
		}
		
		function theAppTitle($app_data) {
			//$title = shorten_title_author($app_data->app_title, 'title');
			$title = $app_data->app_title;
			return($title);
		}
		
		function theDeveloper($app_data, $link = true) {
			//$developer = shorten_title_author($app_data->app_author, 'author');
			$developer = $app_data->app_author;
			$developer_url = $app_data->author_store_url;
			if(($developer_url == '') || (!$link)) return($developer);
			else return('<a href="'.$developer_url.'">'.$developer.'</a>');
		}
		
		function theAppID($app_data) {
			return($app_data->app_id);
		}
		
		function theAppIcon($app_data) {
			if(($app_data->icon_bg != '') && ($app_data->storename_css == 'windowsstore')) return($app_data->banner_icon.'" style="'.$app_data->icon_bg);
			return($app_data->banner_icon);
		}
		
		function theAppLink_AppStore($link) {
			$dev_id = '11ltUj';
			$options = get_option('wpAppbox');
			if($options['wpAppbox_user_affiliateids']) {
				$author_id = get_the_author_meta('id');
				if($options['wpAppbox_user'.$author_id.'_apple_global']) {
					$affid = ($options['wpAppbox_user'.$author_id.'_apple_sponsored'] == true) ? $dev_id : $options['wpAppbox_user'.$author_id.'_apple'];
				}
			}
			if($affid == '') $affid = ($options['wpAppbox_affid_sponsored']) ? $dev_id : $options['wpAppbox_affid'];
			if($affid != '') {
				if(strpos($link, '?') !== false) $link = $link.'&amp;at='.$affid;
				else $link = $link.'?at='.$affid;
			}
			return($link);
		}
		
		function theAppLink_AndroidPit($link) {
			$dev_id = '622817';
			$options = get_option('wpAppbox');
			if($options['wpAppbox_user_affiliateids']) {
				$author_id = get_the_author_meta('id');
				if($options['wpAppbox_user'.$author_id.'_affilinet_global']) {
					$affid = ($options['wpAppbox_user'.$author_id.'_affilinet_sponsored'] == true) ? $dev_id : $options['wpAppbox_user'.$author_id.'_affilinet'];
				}
			}
			if($affid == '') $affid = ($options['wpAppbox_affid_affilinet_sponsored']) ? $dev_id : $options['wpAppbox_affid_affilinet'];
			if($affid != '') $link = 'http://partners.webmasterplan.com/click.asp?ref='.$affid.'&site=8170&type=text&tnb=36&diurl='.$link;
			return($link);
		}
		
		function theAppLink_AmazonApps($link, $appid) {
			$dev_id = 'derscom08-21';
			$options = get_option('wpAppbox');
			if($options['wpAppbox_user_affiliateids']) {
				$author_id = get_the_author_meta('id');
				if($options['wpAppbox_user'.$author_id.'_amazonpartnernet_global']) {
					$affid = ($options['wpAppbox_user'.$author_id.'_amazonpartnernet_sponsored'] == true) ? $dev_id : $options['wpAppbox_user'.$author_id.'_amazonpartnernet'];
				}
			}
			if($affid == '') $affid = ($options['wpAppbox_affid_amazonpartnernet_sponsored']) ? $dev_id : $options['wpAppbox_affid_amazonpartnernet'];
			if($affid != '') $link = $link.'ref=as_li_tf_tl?ie=UTF8&camp=1638&creative=6742&creativeASIN='.$appid.'&linkCode=am2&tag='.$affid;
			return($link);
		}
		
		function theAppLink_URLshortener_TinyURL($link) {
			$ch = curl_init();  
			$timeout = 5;  
			curl_setopt($ch, CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$link);  
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);  
			$data = curl_exec($ch);  
			curl_close($ch);  
			return($data); 
		}
		
		function theAppLink($app_data) {
			$options = get_option('wpAppbox');
			$link = $app_data->app_store_url;
			if(strpos($link, 'apple.com')) $link = $this->theAppLink_AppStore($link);
			if(strpos($link, 'androidpit')) $link = $this->theAppLink_AndroidPit($link);
			if(strpos($link, 'amazon.')) $link = $this->theAppLink_AmazonApps($link, $this->theAppID());
			if($options['wpAppbox_urlshortener'] != '0') {
				switch($options['wpAppbox_urlshortener']) {
					case 'tinyurl':
						$link = $this->theAppLink_URLshortener_TinyURL($link);
						break;
				}
			}
			return($link);
		}
		
		function theBanner($app_data) {
			return($app_data->banner_image);
		}
		
		function theVideo($app_data) {
			return($app_data->app_video);
		}
		
		function theStoreName($app_data) {
			return($app_data->storename);
		}
		
		function theRating($app_data) {
			$options = get_option('wpAppbox');
			if($options['wpAppbox_showrating']) {
				$rating = $app_data->app_rating;
				if($rating == '') return('');
				$rating = str_replace(',', '.', $rating);
				$rating = number_format($rating, 2);
				$rating = round($rating, 1);
				if($rating <= 0.3) $rating_stars = '00';
				if($rating >= 0.4 && $rating <= 0.7) $rating_stars = '05';
				if($rating >= 0.8 && $rating <= 1.3) $rating_stars = '10';
				if($rating >= 1.4 && $rating <= 1.7) $rating_stars = '15';
				if($rating >= 1.8 && $rating <= 2.3) $rating_stars = '20';
				if($rating >= 2.4 && $rating <= 2.7) $rating_stars = '25';
				if($rating >= 2.8 && $rating <= 3.3) $rating_stars = '30';
				if($rating >= 3.4 && $rating <= 3.7) $rating_stars = '35';
				if($rating >= 3.8 && $rating <= 4.3) $rating_stars = '40';
				if($rating >= 4.4 && $rating <= 4.8) $rating_stars = '45';
				if($rating >= 4.9) $rating_stars = '50';
				return('<div title="'.$rating.' '.__('von 5 Sternen', 'wp-appbox').'" class="rating-stars stars'.$rating_stars.'"></div>');
			}
		}
		
		function theStoreCSS($app_data) {
			return($app_data->storename_css);
		}
		
		function theScreenshots($app_screenshots, $app_id) {
			$screenshots_out = '';
			foreach($app_screenshots as $appshots) $screenshots_out .= '<li><img src="'.$appshots->screen_shot.'" alt="" /></li>';
			return($screenshots_out);
		}
		
		function thePrice($app_data, $price) {
			if(($app_data->app_price == $price) || ($price == '')) return($app_data->app_price);
			else return('<span class="oldprice">'.$price.'</span> '.$app_data->app_price);
		}
		
		function theReloadLink($app_data) {
			$options = get_option('wpAppbox');
			if($options['wpAppbox_show_reload_link'] && has_user_permissions()) return('<a href="'.get_permalink().'?wpappbox_reload_cache&amp;wpappbox_appid='.$app_data->app_id.'" title="'.__('App-Daten neu laden', 'wp-appbox').'" class="reload-link">&#8635;</a> ');
		}
		
		function errorOutput($error_type, $store = '', $app_id = '', $style = 'simple') {
			$options = get_option('wpAppbox');
			switch($error_type) {
				case 'nostore':
					$output = __('Der App Store wurde nicht erkannt.', 'wp-appbox');
					break;
				case 'noappid':
					$output = __('Die App-ID wurde nicht erkannt.', 'wp-appbox');
					break;
				case 'notfound':
					$output = __('Die App wurde nicht im Store gefunden.', 'wp-appbox');
					break;
				case 'fallback':
					if($style != 'compact') $output = loadTemplate('simple');
					else $output = loadTemplate('compact');
					preg_match('~(<span class="developer">.*</span>)~i', $output, $replacement);
					$output = str_replace($replacement[1], '', $output);
					preg_match('~(<span class="price">.*</span>)~i', $output, $replacement);
					$output = str_replace($replacement[1], '', $output);
					switch($store) {
						case 'googleplay':
							if($style == 'compact') $fallback_descr = __('Temporären Erkennung als Bot', 'wp-appbox');
							else $fallback_descr = __('Aufgrund einer temporären Erkennung als Bot können momentan leider keine App-Details angezeigt werden.', 'wp-appbox');
							break;
						case 'steam':
							if($style == 'compact') $fallback_descr = __('Altersverifikation erforderlich', 'wp-appbox');
							else $fallback_descr = __('Das Spiel benötigt eine Altersverifikation über die Steam-Webseite, daher können leider keine weiteren Informationen angezeigt werden.', 'wp-appbox');
							break;
					}
					if($style != 'compact') $fallback_descr = '<span class="fallback">'.$fallback_descr.'</span>';
					preg_match('~(<a .* class="apptitle">.*</a><br />)~i', $output, $replacement);
					$output = str_replace($replacement[1], $replacement[1].$fallback_descr, $output);
					return($output);
					break;
				default:
					$output = __('Es ist ein unbekannter Fehler aufgetreten.', 'wp-appbox');
					break;
			}
			if($error_type != 'fallback') $output = '<!-- WP-Appbox (Store: '.$store.' // ID: '.$app_id.') --><div class="wpappbox error"><span>'.$output.' :-( #wpappbox</span></div><!-- /WP-Appbox -->';
			if(($options['wpAppbox_error_onlyforauthor'] == false) || has_user_permissions() || isset($_GET['wpappbox_show_errormessages'])) return($output);
		}
	
		function theOutput($attr) {
			if($this->checkAttributs($attr) === true) {
				$app_info = $this->getTheAppData($attr['store'], $attr['appid']);
				if($app_info === 0) return($this->errorOutput('notfound', $attr['store'], $attr['appid']));
				else {
					$app_data = $app_info['General']['0'];
					$app_screenshots = $app_info['ScreenShots'];
					if((($attr['style'] === 'screenshots') || ($attr['style'] === 'screenshots-only')) && (count($app_info['ScreenShots']) == 0)) {
						$attr['style'] = CreateAttributs::getStandardStyle($attr['store']);
						if(($attr['style'] === 'screenshots') || ($attr['style'] === 'screenshots-only')) $attr['style'] = 'simple';
					}
					if(($attr['style'] === 'banner') && ($app_data->banner_image == '')) {
						$attr['style'] = CreateAttributs::getStandardStyle($attr['store']);
						if($attr['style'] === 'banner') $attr['style'] = 'simple';
					}
					if(($attr['style'] === 'video') && ($app_data->app_video == '')) {
						$attr['style'] = CreateAttributs::getStandardStyle($attr['store']);
						if($attr['style'] === 'video') $attr['style'] = 'simple';
					}
					if($app_data->fallback == '1') $template = $this->errorOutput('fallback', $app_data->storename_css, $attr['appid'], $attr['style']);
					else $template = loadTemplate($attr['style']);
					$template = str_replace('{WPAPPBOXVERSION}', WPAPPBOX_PLUGIN_VERSION, $template);
					$template = str_replace('{APPID}', $this->theAppID($app_data), $template);
					$template = str_replace('{ICON}', $this->theAppIcon($app_data), $template);
					$template = str_replace('{TITLE}', $this->theAppTitle($app_data), $template);
					$template = str_replace('{STORE}', $this->theStoreName($app_data), $template);
					$template = str_replace('{RATING}', $this->theRating($app_data), $template);
					$template = str_replace('{STORECSS}', $this->theStoreCSS($app_data), $template);
					$template = str_replace('{APPLINK}', $this->theAppLink($app_data), $template);
					$template = str_replace('{DEVELOPERLINK}', $this->theDeveloper($app_data), $template);
					$template = str_replace('{PRICE}', $this->thePrice($app_data, $attr['oldprice']), $template);
					if($attr['showqrcode']) $template = str_replace('{QRCODE}', $this->theQRCode($app_data), $template);
					else $template = str_replace('{QRCODE}', '', $template);
					if($attr['style'] == 'video') $template = str_replace('{VIDEOURL}', $this->theVideo($app_data), $template);
					if($attr['style'] == 'banner') $template = str_replace('{BANNER}', $this->theBanner($app_data), $template);
					if(($attr['style'] == 'screenshots') || ($attr['style'] == 'screenshots-only')) $template = str_replace('{SCREENSHOTS}', $this->theScreenshots($app_screenshots, $this->theAppID($app_data)), $template);
					if($attr['nofollow']) $template = str_replace('<a ', '<a rel="nofollow" ', $template);
					if($attr['targetblank']) $template = str_replace('<a ', '<a target="_blank" ', $template);
					$template = str_replace('{RELOADLINK}', $this->theReloadLink($app_data), $template);
					if(!is_feed()) $template = '<!-- WP-Appbox (Store: '.$this->theStoreCSS($app_data).' // ID: '.$this->theAppID($app_data).') -->'.$template.'<!-- /WP-Appbox -->';
					return($template);
				}
			}
			else return($this->errorOutput($this->checkAttributs($attr)));
		}
			
	}

?>