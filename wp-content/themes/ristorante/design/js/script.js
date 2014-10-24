$j = jQuery.noConflict();

$j(function() {

	var isTouch = navigator.userAgent.toLowerCase().match(/(i#phone|ipod|ipad|android)/);

	Wpml_change_flag();

	CustomizeMenu();

	RollUpMenu();

	//ApplyColorbox();

	ApplyFancyboxVideo();

	InitMisc();

	HoverZoomInit();

	OpenCloseShortcode();

	DatePickers();

	SmallRoomViewerDescription();

	RoomThumb();

	HomeRoomViewerActivateForm();

	notificationClose();

	transformSelect();

  	//hideCFinputs();

});

function hideCFinputs(){
  $j('.wpcf7 form p').each(function(){
    $j(this).find('input').focus(function(){
      $j(this).parent().parent().find('label').fadeOut('slow');
    });
    $j(this).find('input').focusout(function(){
      $j(this).parent().parent().find('label').fadeIn('slow');
    });

    $j(this).find('textarea').focus(function(){
      $j(this).parent().parent().find('label').fadeOut('slow');
    });
    $j(this).find('textarea').focusout(function(){
      $j(this).parent().parent().find('label').fadeIn('slow');
    });
  });
}

function HomeRoomViewerActivateForm(){
  if($j("#showRoomSearchByDefault").text() == "false"){
    $j("#subpage-room-options-container-left").css({'display':'none'});
    $j("#showHideHousing").removeClass('show');
  } else {
    $j("#room-controls-1").find("img").addClass("active");
    $j(".reservation-form").css({"display":"block"});
  }
}

function SmallRoomViewerDescription(){
  $j("#showHideHousing").click(function(){
	  if( $j(this).hasClass('show') == true )
    {
      //$j("#subpage-room-options-container-left").hide('slow');
      $j("#subpage-room-options-container-left").hide("slide",{direction: "left"},'fast');
      $j(this).removeClass('show');
      $j(this).addClass('hide');
    }
    else
    {
      //$j("#subpage-room-options-container-left").show('slow');
      $j("#subpage-room-options-container-left").show("slide",{direction: "left"},'fast');
      $j(this).removeClass('hide');
      $j(this).addClass('show');
    }
	});
}

function RoomThumb(){
  $j("#roomThumb").attr({'src':$j("#roomThumbCont").val()});
}

function PopulateForm(form){
  var sendFormLink = $j("#"+form).find("#formLink").val();
  var room = $j("#"+form).find('#room :selected').text();
  var roomVal = $j("#"+form).find('#room :selected').val();
  var roomThumb = $j("#"+form).find('#room :selected').val();

  var dateFrom = 0;
  var dateFromDefaultText = "";
  var dateTo = 0;
  var dateToDefaultText = "";

  var inputs = [];
  $j("#formEnabledInputs").children().each(function(){
    inputs.push($j(this).text());
  });
  var count = inputs.length + 1;    //4

  if($j.inArray("From",inputs) != -1){
    dateFrom = $j("#"+form).find("#datePicker1").val();
    dateFromDefaultText = $j("#inputName1").text();
  }

  if($j.inArray("To",inputs) != -1){
    dateTo = $j("#"+form).find("#datePicker2").val();
    dateToDefaultText = $j("#inputName2").text();
  }

  if(roomVal != "NULL"){count--;}
  if(dateFrom != dateFromDefaultText && dateFrom != 0){count--;}
  if(dateTo != dateToDefaultText && dateTo != 0){count--;}

  if(sendFormLink != ""){
    if(count == 0){
      //console.log(window.location.href);
      if(sendFormLink.indexOf("?") != -1)
      {
        $j(window.location).attr('href', sendFormLink+'&roomname='+room+'&from='+dateFrom+'&to='+dateTo+'&roomthumb='+roomThumb);
      }
      else
      {
        $j(window.location).attr('href', sendFormLink+'?roomname='+room+'&from='+dateFrom+'&to='+dateTo+'&roomthumb='+roomThumb);
      }
    }
    else{
      // alert or something :-)
      alert('Please fill in the form to proceed');
    }
  } else {
    alert("Set the form properly in the admin");
  }
}

function DatePickers(){
    var dateFormatVar = $j("#datepickerFormat").text();

    $j( ".datePicker" ).datepicker({dateFormat : dateFormatVar});
    //$j( "#datePicker2" ).datepicker({dateFormat : dateFormatVar});
}

function Wpml_change_flag()
{
	$j('.wpml.icon').hover(function() {
		$j('#language-bubble').stop(true,true).fadeIn();
	}, function() {
		$j('#language-bubble').stop(true,true).fadeOut();
	});
}

function CustomizeMenu(){
	$j(".mainmenu > ul > li").each(function(){
		if($j(this).has('ul').length){
			$j(this).addClass("parent");
		}
	});
}

function RollUpMenu(){

	var time = parseInt($j('#mainmenu-dropdown-duration').text());
	var easing = $j('#mainmenu-dropdown-easing').text();

	var isiPad = navigator.userAgent.match(/iPad/i) != null;

	click = 0;
	// For use within iPad developer UIWebView
	// Thanks to Andrew Hedges!
	var ua = navigator.userAgent;
	var isiPad = /iPad/i.test(ua) || /iPhone OS 5/i.test(ua) || /iPhone OS 5_1/i.test(ua);

	$j(".mainmenu ul").find('ul').each(function(){
		$j(this).css({'display':'block', 'visibility':'none'});
	});

	$j(".mainmenu").find('ul').children('li').each(function(){
		if($j(this).has('ul').length){
			var submenu = $j(this).children('ul');
			var submenuHeight =  submenu.height();
			var ieFix = '270px';
				$j(this).hover(function(){
					submenu.css({'display':'block', 'height':'0'}).animate({height: submenuHeight}, time, easing);
					}, function(){
					submenu.css({'display':'none','height':submenuHeight});
				});
			submenu.css({'width':ieFix});
		}
	});

	$j(".mainmenu ul").find('ul').each(function(){
	$j(this).css({'display':'none', 'visibility':'visible'});
	});
}

function ApplyColorbox(){
	// Apply fancybox on all images
	$j(".menu-thumb").colorbox({rel: 'group', maxHeight:"95%"});
	$j("a[href$='gif']").colorbox({rel: 'group', maxHeight:"95%"});
	$j("a[href$='jpg']").colorbox({rel: 'group', maxHeight:"95%"});
	$j("a[href$='png']").colorbox({rel: 'group', maxHeight:"95%"});
}

function ApplyFancyboxVideo(){
	// AIT-Portfolio videos
	$j(".ait-portfolio a.video-type").click(function() {

		var address = this.href
		if(address.indexOf("youtube") != -1){
			// Youtube Video
			$j.fancybox({
				'padding'		: 0,
				'autoScale'		: false,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic',
				'title'			: this.title,
				'width'			: 680,
				'height'		: 495,
				'href'			: this.href.replace(new RegExp("watch\\?v=", "i"), 'v/'),
				'type'			: 'swf',
				'swf'			: {
					'wmode'		: 'transparent',
					'allowfullscreen'	: 'true'
				}
			});
		} else if (address.indexOf("vimeo") != -1){
			// Vimeo Video
			// parse vimeo ID
			var regExp = /http:\/\/(www\.)?vimeo.com\/(\d+)($|\/)/;
			var match = this.href.match(regExp);

			if (match){
			    $j.fancybox({
					'padding'		: 0,
					'autoScale'		: false,
					'transitionIn'	: 'elastic',
					'transitionOut'	: 'elastic',
					'title'			: this.title,
					'width'			: 680,
					'height'		: 495,
					'href'			: "http://player.vimeo.com/video/"+match[2]+"?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff",
					'type'			: 'iframe'
				});
			} else {
			    alert("not a vimeo url");
			}
		}
		return false;
	});

	// Images shortcode
	$j("a.sc-image-link.video-type").click(function() {

		var address = this.href
		if(address.indexOf("youtube") != -1){
			// Youtube Video
			$j.fancybox({
				'padding'		: 0,
				'autoScale'		: false,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic',
				'title'			: this.title,
				'width'			: 680,
				'height'		: 495,
				'href'			: this.href.replace(new RegExp("watch\\?v=", "i"), 'v/'),
				'type'			: 'swf',
				'swf'			: {
					'wmode'		: 'transparent',
					'allowfullscreen'	: 'true'
				}
			});
		} else if (address.indexOf("vimeo") != -1){
			// Vimeo Video
			// parse vimeo ID
			var regExp = /http:\/\/(www\.)?vimeo.com\/(\d+)($|\/)/;
			var match = this.href.match(regExp);

			if (match){
			    $j.fancybox({
					'padding'		: 0,
					'autoScale'		: false,
					'transitionIn'	: 'elastic',
					'transitionOut'	: 'elastic',
					'title'			: this.title,
					'width'			: 680,
					'height'		: 495,
					'href'			: "http://player.vimeo.com/video/"+match[2]+"?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff",
					'type'			: 'iframe'
				});
			} else {
			    alert("not a vimeo url");
			}
		}
		return false;
	});
}


function InitMisc() {
  $j('#content input, #content textarea').each(function(index) {
    var id = $j(this).attr('id');
    var name = $j(this).attr('name');
    if(id != undefined && name != undefined){
		if (id.length == 0 && name.length != 0) {
			$j(this).attr('id', name);
		}
	}
  });

  $j('#content form').find('label').inFieldLabels();

  $j('.rule span').click(function() {
	  $j.scrollTo(0, 1000, {axis:'y'});
	  return false;
  });

}


function HoverZoomInit() {
  //// Post images
  //$j('#content .entry-thumbnail a').hoverZoom({overlayColor:'#333333',overlayOpacity: 0.8});

  // default wordpress gallery
  $j('#content .gallery-item a').hoverZoom({overlayColor:'#333333',overlayOpacity: 0.8,zoom:0});

  // ait-portfolio
  $j('#content .ait-portfolio a').hoverZoom({overlayColor:'#333333',overlayOpacity: 0.8,zoom:0});

  // schortcodes
  $j('#content a.sc-image-link').hoverZoom({overlayColor:'#333333',overlayOpacity: 0.8,zoom:0});

}


function OpenCloseShortcode(){

	//$j('#content .frame .frame-close.closed').parent().find('.frame-wrap').hide();
	$j('#content .frame .frame-close.closed .close.text').hide();
	$j('#content .frame .frame-close.closed .open.text').show();

	$j('#content .frame .frame-close').click(function(){
		if($j(this).hasClass('closed')){
			var $butt = $j(this);
			$j(this).parent().find('.frame-wrap').slideDown('slow',function(){
				$butt.removeClass('closed');
				$butt.find('.close.text').show();
				$butt.find('.open.text').hide();
			});
		} else {
			var $butt = $j(this);
			$j(this).parent().find('.frame-wrap').slideUp('slow',function(){
				$butt.addClass('closed');
				$butt.find('.close.text').hide();
				$butt.find('.open.text').show();
			});

		}

	});
}

function notificationClose() {
	$j('.sc-notification').children('a.close').click( function(event) {
		event.preventDefault();
		$j(this).parent().fadeOut('slow');
	});
}

function transformSelect() {
	$j('.widget_reservation form').jqTransform();
}