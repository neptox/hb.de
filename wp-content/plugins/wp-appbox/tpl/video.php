<div class="wpappbox video {STORECSS}">
	<div class="container">
		<div class="embed"><iframe src="{VIDEOURL}" frameborder="0" allowfullscreen></iframe></div>
		{QRCODE}
	</div>
	<a href="{APPLINK}"  title="{TITLE}" class="appbutton {STORECSS}"><span><?php _e('Download', 'wp-appbox'); ?> @<br />{STORE}</span></a>
	<div class="appdetails">
		<div class="apptitle">{RELOADLINK}<a href="{APPLINK}" title="{TITLE}" class="apptitle">{TITLE}</a></div>
		<div class="developer"><?php _e('Entwickler', 'wp-appbox'); ?>: {DEVELOPERLINK}</div>
		<div class="price"><?php _e('Preis', 'wp-appbox'); ?>: {PRICE} {RATING}</div>
	</div>
</div>