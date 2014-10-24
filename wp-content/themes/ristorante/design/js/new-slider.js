// Jquery no conflict mode
$j = jQuery.noConflict();

/* ******************************************************************************************
 * Bootstrap
 * ******************************************************************************************/
$j(window).load(function() {

        /*---------------------------------------------------*/
        /*------ SET HERE WRAPPER UL OF THE SLIDER ----------*/
        /*---------------------------------------------------*/
        /*----*/       var sliderUl = '#slider';      /*-----*/
        /*---------------------------------------------------*/
        /*---------------------------------------------------*/
        /*---------------------------------------------------*/
        
        $j(sliderUl).children('li').first().addClass('active');
        var delay = $j('#slider-delay').html();
        var animTime = $j('#slider-animTime').html();
        
        setInterval( "nextImage($j('"+sliderUl+"'),"+animTime+")", delay );	
	        
        var bgImg = $j(sliderUl).children('li').children('img');
        var htmlBg = $j('.htmlBgcover').html();
        //alert(htmlBg);
        resizeImg(bgImg);
        
        //var $w = $j(window).height()+500;
        $j('.background #slider li').css('height','100%');
        
        $j(window).resize(function() {
            resizeImg(bgImg);
            try{
                singleBg = $j('.background').children('img');
                resizeImg(singleBg);
            }catch(e){}
        });         
        try{
            singleBg = $j('.background').children('img');
            resizeImg(singleBg);
        }catch(e){}
        $j('.loader').fadeOut();
});

function nextImage(wrapperUl, animTime){
    this.wrapperUl = wrapperUl;    
    
    var $active = wrapperUl.children('li.active');

    if ( $active.length == 0 ) $active = wrapperUl.children('li:last');

    // use this to pull the images in the order they appear in the markup
    var $next =  $active.next().length ? $active.next()
        : wrapperUl.children('li:first');
        
    $active.addClass('last-active');

    $next.css({opacity: 0.0})
        .addClass('active')
        .animate({opacity: 1.0}, animTime, function() {
            $active.removeClass('active last-active');
        });
}

function resizeImg(bgImg) {  
    var imgwidth = bgImg.width();
    var imgheight = bgImg.height();
    
    var winwidth = $j(window).width();
    var winheight = $j(window).height()+100;

    var widthratio = winwidth / imgwidth;
    var heightratio = winheight / imgheight;

    var widthdiff = heightratio * imgwidth;
    var heightdiff = widthratio * imgheight;

    if(heightdiff>winheight) {
    bgImg.css({
        width: winwidth+'px',
        height: heightdiff+'px'
    });
    } else {
    bgImg.css({
        width: widthdiff+'px',
        height: winheight+'px'
    });		
    }
} 