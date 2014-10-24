    /*

     ============ appcuarium ============

     Alfie ® Platform JS SDK

     ====== Apps outside the box.® ======

     ------------------------------------
     Copyright © 2012-2014 Appcuarium
     ------------------------------------

     apps@appcuarium.com
     @author Sorin Gheata
     @version 1.2.13

     ====================================

     Alfie Weather Javascript Loader

     */
    (function(e,t,n,r){function s(t){t.parent().next().find("input").each(function(){e(this).attr("readonly",true)});t.parent().next().find(".search_woeid").removeClass("enabled").addClass("disabled")}function o(t){t.parent().next().find("input").each(function(){e(this).attr("readonly",false)});t.parent().next().find(".search_woeid").removeClass("disabled").addClass("enabled")}var i=e("body");i.on("click",".city-woeid",function(t){var n=e(this).attr("rel");e("#widgets-right .alfie-woeid").val(n);e("#widgets-right #cities").empty();e("#widgets-right #location-input").hide();e("#widgets-right .search_woeid").show();e("#widgets-right #search-location").val("");t.preventDefault()}).on("click",".search_woeid.enabled",function(t){var n=e(this);n.hide();e("#widgets-right #location-input").show();n.alfie({action:{searchDelayed:function(e){}}});t.preventDefault()});e("body").on("change",'input[value="manual_location"]',function(){e('input[value="automatic_location"]').attr("checked",false);o(e(this))});e("body").on("change",'input[value="automatic_location"]',function(){e('input[value="manual_location"]').attr("checked",false);s(e(this))});e(function(){e('input[value="manual_location"]').each(function(){var t=e(this);if(t.attr("checked")=="checked"){o(t)}});e('input[value="automatic_location"]').each(function(){var t=e(this);if(t.attr("checked")=="checked"){s(t)}})})})(jQuery,window,document)