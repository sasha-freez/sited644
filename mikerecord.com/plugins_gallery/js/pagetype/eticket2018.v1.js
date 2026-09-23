/** GENERATED: Mon Sep 12 10:24:30 PDT 2016 **/
var isMobile = false;

(function ($) {
    var isTouch = true;
    if ($("html").hasClass("no-touch")) {
        isTouch = false;
    }

	var mobileApple = /iP(od|ad|hone)/i.test(navigator.userAgent),
        ipod = /iPod/i.test(navigator.userAgent),
        iphone = /iPhone/i.test(navigator.userAgent),
        ipad = /iPad/i.test(navigator.userAgent),
        android = /Android/i.test(navigator.userAgent),
        palm = /webOS/i.test(navigator.userAgent),
        blackberry = /BlackBerry/i.test(navigator.userAgent);

    // set the html5 flags for the video player
    $.each([mobileApple,android,palm,blackberry], function(i,device) {
        if(!!device) {
            isMobile = true;
        }
    });

    
    var imgOffset = (isMobile) ? '220%' : '120%';

    /***************  IMAGE WAYPOINTS  *******************/
	jQuery('img').waypoint(function (event, direction) {
	    $this = jQuery(this);
	    if (typeof $this.attr("src") == "undefined" && typeof $this.data("src") != "undefined") {
	        var src = $this.data("src");
            if (typeof $this.data("mobilesrc") != "undefined" && isMobile) {
                var src = $this.data("mobilesrc");
            }

            $this.attr("src", src);
	        $this.data("src", "");
	    }
	}, {
	    offset: imgOffset
	});


    /****************************************************************/
    /*******************************************/
    //chapters
    var chapters = $(".chapter-location");
    var chapter_links = $(".nav-chapters li a");
	var chapterOffset = (window.location.href.indexOf('grantland.com') > -1) ? 200 : 0;
    //custom use for map and offset
    $('.chapter-location').waypoint(function (event, direction) {
        var active_section;
        active_section = $(this);
        var active_link;
		
		//handle headline still displaying when scrolling
		if (direction === "down" &&  $(this).attr("id") =="section-1") {
			$("#main-header hgroup").not(".header2").hide();
		} 
		else if (direction === "up" && $(this).attr("id") =="section-2"){
			$("#main-header hgroup").not(".header2").show();
		}
		else if (direction === "up" && $(this).attr("id") =="section-1"){
			$("#main-header hgroup").not(".header2").show();
		}
		

        if (direction === "up") {
            active_link = $('.nav-chapters li a[href="#' + $(this).attr("id") + '"]');
        } else {
            active_link = $('.nav-chapters li a[href="#' + active_section.attr("id") + '"]');
        }

        chapter_links.parent().removeClass("selected");
        if (active_link)
            active_link.parent().addClass("selected");

    }, {
        offset: chapterOffset
    });


    // if a anchortag exists in url - scroll after the previous image has been lazy loaded
    function checkPrevImgLoadedForScrollTo(anchorTag) {
        $img = $(anchorTag).closest("div.container").prev().find('img');
        if($img.attr("src") != "") {
            $.scrollTo(
                anchorTag, {
                duration: 2000
            });
        }
        $img.load(function() {
            $.scrollTo(
                anchorTag, {
                duration: 2000
            });
        });
        $.waypoints('refresh');
    }
    checkPrevImgLoadedForScrollTo('div.chapter-location[title='+window.location.hash.replace("#", "").replace("!","")+']');


    //only apply scrollTo for desktop
    if (isTouch == false) {
        /*
        chapter_links.live("click", function (event) {
            var navParent = $(this).parent();
            $.scrollTo(
                $(this).attr("href"), {
                duration: 2000,
                offset: {
                    'left': 0,
                    'top': -0.15 * $(window).height()
                }, //updated to add height of toolbar and map 200
                onAfter: function () {
                    $(".nav-chapters li").removeClass("selected");
                    $(navParent).addClass("selected");
                }
            });
        });
        */

        chapter_links.live("click", function (event) {
            setTimeout(function() {
                checkPrevImgLoadedForScrollTo('div.chapter-location[title='+window.location.hash.replace("#", "").replace("!","")+']');
            }, 1000);
        });
    }
    /*******************************************/

    /* map hotspots clicks						*/
    //only apply scrollTo for desktop
    if (isTouch == false) {
        $(".map-hotspots a").click(function (event) {
            $.scrollTo(
                $(this).attr("href"), {
                duration: 2000 //,
                //offset: { 'left':0, 'top':-0.15*$(window).height()-200 }	//updated to add height of toolbar and map 200
            });
        });
    }

    $('span.citation').mouseenter(function (event) {
        $(this).parent().prevAll(".glossary-"+$(this).attr('id').replace('refglossary-', '')).animate({
            opacity: 0.2
        }, 300).delay(100).animate({
            opacity: 1
        }, 500);
        /*
        $(this).parent().prev(".glossary").animate({
            opacity: 0.2
        }, 300).delay(100).animate({
            opacity: 1
        }, 500);
        */
        event.preventDefault();
    });

    window.onload = function () {
        skrollr.init({
            forceHeight: false
        });
    }

    conditionizr({
        scriptSrc: 'http://a.espncdn.com/prod/scripts/plugins/',
        touch: {
            scripts: true,
            styles: false,
            classes: false,
            customScript: false
        }
    });


    jQuery.getScript('http://a.espncdn.com/combiner/c/69?js=jquery.sharetools.longform.js', function () {
        canonical = jQuery('link[rel=canonical]').attr('href');
        jQuery('.mod-page-actions').sharetools(canonical);
    });


    jQuery('.icon-gallery').click(function (e) {
        e.preventDefault();
        var $this = jQuery(this),
            $parent = $this.parents('.image-container'),
            galleryId = parseInt($parent.attr('id').replace('gallery-', ''), 10),
            url = 'http://espn.go.com/espn/photos/gallery?id=' + galleryId + '&overrideCss=pagetype/otl/overlay-gallery.css&nocache3'

      	if (isMobile) {
      		url = url + '&version=mobile';
      		window.open(url,'_blank');
      	} else {
      		var html = '<div id="photo-gallery-overlay">';
    	    html += '<div class="iframe-container">';
    	    html += '<a class="close" href="#">Close</a>';
    	    html += '<iframe src="' + url + '" style="width:100%;"></iframe>';
    	    html += '</div>';
    	    html += '</div>';

    	    jQuery('body').append(html);
    	    jQuery("#photo-gallery-overlay .close").click(function (e) {
    	        e.preventDefault();
    	        jQuery("#photo-gallery-overlay").remove();
    	    });
      	}

       
    });

    jQuery('.icon-magnify, .elastislide-list li').click(function (e) {
        e.preventDefault();
        var $this = jQuery(this),
            $parent = $this.parents('.image-container');

            if($parent.length == 0) {
                url = $this.attr('href');
            } else {
                photoId = parseInt($parent.attr('id').replace('photo-', ''), 10),
                url = 'http://espn.go.com/espn/photos/gallery?id=' + photoId + '&overrideCss=pagetype/otl/overlay-enlarge.css';
            }

        if (isMobile) {
            url = url + '&version=mobile';
            window.open(url,'_blank');
        } else {
            var html = '<div id="photo-gallery-overlay">';
            html += '<div class="iframe-container">';
            html += '<a class="close" href="#">Close</a>';
            html += '<iframe src="' + url + '" style="width:100%;"></iframe>';
            html += '</div>';
            html += '</div>';

            jQuery('body').append(html);
            jQuery("#photo-gallery-overlay .close").click(function (e) {
                e.preventDefault();
                jQuery("#photo-gallery-overlay").remove();
            });
        }
    });

    var players = {}, loadedPlayers = {};
    var $videos = jQuery('body').find('.embed-video'),
        $podcasts = jQuery('body').find('.embed-podcast'),
        $others = jQuery('body').find('.embed-other');

    // let's find some videos
    if ($videos.length > 0) {
        $videos.each(function () {
            var $thisVideo = jQuery(this),
                videoElementId = $thisVideo.attr('id'),
                videoId = parseInt(videoElementId.replace('video-', ''), 10);
            loadVideoIframe(videoElementId, videoId);
        });
    }
    // let's find some podcasts
    if ($podcasts.length > 0) {
        $podcasts.each(function () {
            var $thisPodcast = jQuery(this),
                podcastElementId = $thisPodcast.attr('id'),
                podcastUrl = $thisPodcast.attr('href');
            loadPodcast(podcastElementId, podcastUrl);
        });
    }

    function loadVideoIframe(videoElementId, videoId) {
        var a = navigator.userAgent,
            $videoTriggers = jQuery('#' + videoElementId + ', #' + videoElementId + ' .video-icon');
            $video = jQuery('#' + videoElementId),
            subscriptions = [];

        if ((a.match(/Mobile/i))) {
            //$video.attr('href', 'http://m.espn.go.com/general/video.mp4?id=' + videoId + '&videoprofile=external&suite=wdgwespmobileweb')
            $video.replaceWith('<div style="background:black;position:relative; padding-bottom: 56.25%; height:0"><iframe style="position:absolute; width:100%; height:100%; top:0; left:0;" src="http://www.espn.com/core/video/iframe?id=' + videoId + '"></iframe></div>');
	} else {
            // expose the video player element when it's ready
            espn.video.subscribe("espn.video.ready", function () {
                var videoElId = espn.video.player && espn.video.player.embeddedPlayerId || videoElementId;
                players[videoElementId] = document.getElementById(videoElId);
            });

            jQuery(window).resize(function () {
                width = jQuery('#' + videoElementId).parent().width();
                height = width * (9 / 16);      
                try {
                    players[videoElementId].style.width = width + "px";
                    players[videoElementId].style.height = height + "px";
                } catch (e) {}
            });

            var playETicketVideo = function (e) {
                var targetEmbedEl = jQuery("#embed" + videoElementId);
                var videoIcon = targetEmbedEl.parent().parent().find('.video-icon');

                espn.video.remove();
                e.preventDefault();
                e.stopPropagation();
                if(jQuery('#' + videoElementId).find('img').length) {
                    $imgTag = jQuery('#' + videoElementId).find('img');
                    videoWidth = $imgTag.height() * (16/9);
                    videoHeight = $imgTag.height();
                } else if(jQuery('#' + videoElementId).parent().hasClass('video-container-wide')) { 
                    //videoWidth = jQuery('#' + videoElementId).parent().width();
                    videoHeight = jQuery('#' + videoElementId).parent().height();
                    videoWidth = videoHeight * (16/9);
                } else {
                    videoWidth = jQuery('#' + videoElementId).parent().width();
                    videoHeight = videoWidth * (9 / 16);
                }
				
				videoWidth = Math.round(videoWidth);

                subscriptions.push(espn.video.subscribe("espn.video.play", function() {
                    jQuery('#' + videoElementId).parent().siblings('hgroup').show();
                    jQuery('#embed'+videoElementId+'_MobileContainer').show(); // mobile html5 video player fix
                    videoIcon.attr('class', 'video-icon');
                    if (isMobile) {
                        jQuery('#' + videoElementId).parent().find('a.embed-video').hide();
                    } else {
                        jQuery('#' + videoElementId).parent().find('a.embed-video').css('visibility', 'hidden');
                    }
                }));
                
                // the "video bundle" removes the original target, and when you unembed
                // the player, a cloned target is returned
                subscriptions.push(espn.video.subscribe("espn.video.complete", function() {
                    jQuery('#' + videoElementId).parent().siblings('hgroup').show();
                    jQuery('#embed'+videoElementId+'_MobileContainer').hide(); // mobile html5 video player fix
                    videoIcon.attr('class', 'video-icon');
                    if (isMobile) {
                        jQuery('#' + videoElementId).parent().find('a.embed-video').show();
                    } else {
                        jQuery('#' + videoElementId).parent().find('a.embed-video').css('visibility', 'visible');
                    }

                    jQuery('#' + videoElementId).after(targetEmbedEl);
                    jQuery('#' + videoElementId).parent().find('a.embed-video').each(function () {
                        var $thisVideo = jQuery(this),
                            videoElementId = $thisVideo.attr('id'),
                            videoId = parseInt(videoElementId.replace('video-', ''), 10);
                        loadVideoIframe(videoElementId, videoId);
                    });

                    if(subscriptions.length) {
                        for(var s = 0; s < subscriptions.length; s++) {
                            espn.video.unsubscribe(subscriptions[s]);
                        }
                    }
                    subscriptions = [];
                }));

                /*subscriptions.push(espn.video.subscribe("espn.video.pause", function() {
                    jQuery('#' + videoElementId).parent().siblings('hgroup').show();
                    jQuery('#embed'+videoElementId+'_MobileContainer').hide(); // mobile html5 video player fix
                    videoIcon.attr('class', 'video-icon');
                    if (isMobile) {
                        jQuery('#' + videoElementId).parent().find('a.embed-video').show();
                    } else {
                        jQuery('#' + videoElementId).parent().find('a.embed-video').css('visibility', 'visible');
                    }
                }));*/
                
                // check if player is already loaded on the page - if it isn't embed
                espn.video.embed({
                    "id": videoId,
                    "cms": "espn",
                    "width": videoWidth,
                    "height": videoHeight,
                    "targetReplaceId": "embed"+videoElementId,
                    "player": "responsive12",
                    "autostart": true,
                    "endCard": false
                });

                jQuery('#' + videoElementId).parent().siblings('hgroup').hide();
                if (isMobile) {
                    videoIcon.attr('class', 'video-icon2');
                    jQuery('#' + videoElementId).parent().find('a.embed-video').hide();
                } else {
                    jQuery('#' + videoElementId).parent().find('a.embed-video').css('visibility', 'hidden');
                }

                $videoTriggers.off('click', playETicketVideo);
            };

            $videoTriggers.on('click', playETicketVideo);
        }
    }

    function loadPodcast(podcastElementId, podcastUrl) {
        if (swfobject.hasFlashPlayerVersion("8.0.00")) {
            var flashvars = {
                'soundLink': podcastUrl
            };
            var params = {
                wmode: "transparent",
                scale: "noorder",
                allowscriptaccess: "Always",
                allownetworking: "All",
                align: "left",
                salign: "lt"
            };
            var attributes = {};
            swfobject.embedSWF("http://a.espncdn.com/swf/espnradio/09/audio_player_circular_v2.swf", podcastElementId, "86", "70", "8.0.0", "", flashvars, params, attributes);
        } else {
            var $podcast = jQuery('#' + podcastElementId);
            if (Modernizr.audio) {
                $podcast.show().click(function (e) {
                    e.preventDefault();
                    $podcast.replaceWith('<audio src = "' + podcastUrl + '" controls style="width: 250px;"></audio>');
                });
            } else {
                $podcast.show();
            }
        }
    }

}(jQuery));
