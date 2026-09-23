(function ($) {

	$.fn.sharetools = function (url) {
		var $recommendLinks = this.find('.facebook-recommend a'),
			$tweetLinks = this.find('.twitter-tweet a'),
			$commentLinks = $('.echo-comments a, .fb-comments a'),
			$emailLinks = this.find('.espn-email a'),
			$followLinks = $('.twitter-follow a'),
			$printLinks = $('.print a'),
			$insiderLinks = $('.insider a'),
			$recommendCounts = this.find('.facebook-recommend .count'),
			$tweetCounts = this.find('.twitter-tweet .count'),
			$commentCounts = this.find('.echo-comments .count'),
			$fbCommentCounts = this.find('.fb-comments .count'),
			$commentCountsLong = this.find('.echo-comments-long .count'),
			$fbCommentCountsLong = this.find('.fb-comments-long .count'),
			$pageActionsTop = $('#page-actions-top'),
			$verticalShare = $('#page-actions-top .mod-page-actions.vert'),
			$pageActionsBottom = $('#page-actions-bottom'),
			$window = $(window),
			recommendCountNum,
			tweetCountNum,
			commentCountNum,
			sluglessUrl,
			count;

		function fixCounts(countString) {
			countString = countString + '';
			countString = countString.replace('+', '');
			count = parseInt(countString, 10);
			if (count > 999) {
				count = Math.floor(count / 1000);
				count = count + 'K';
			}
			if (count === '5K') {
				count = '5K+';
			}
			return count;
		}

		if ($recommendCounts.length > 0 || $fbCommentCounts.length > 0 || $fbCommentCountsLong.length > 0) {
			var query = "SELECT url, total_count, commentsbox_count FROM link_stat WHERE url='" + url + "'";
			$.ajax({
				url: 'https://graph.facebook.com/fql',
				data : {
					q : query
				},
				dataType: 'jsonp',
				cache: true,
				context: this,
				success: function(data) {
					if (!!data && !!data.data && !!data.data[0]) {
						if ($recommendCounts.length > 0) {
							recommendCountNum = data.data[0].total_count;
							if (typeof (recommendCountNum) !== 'undefined') {
								recommendCountNum = fixCounts(recommendCountNum);
								$recommendCounts.each(function (i, v) {
									$(this).html(recommendCountNum);
								});
							}
						}
						if ($fbCommentCounts.length > 0) {
							commentCountNum = data.data[0].commentsbox_count;
							if (typeof (commentCountNum) !== 'undefined') {
								commentCountNum = fixCounts(commentCountNum);
								$fbCommentCounts.each(function (i, v) {
									$(this).html(commentCountNum);
								});
							}
						}
						if ($fbCommentCountsLong.length > 0) {
							commentCountNum = data.data[0].commentsbox_count;
							if (typeof (commentCountNum) !== 'undefined') {
								$fbCommentCountsLong.each(function (i, v) {
									$(this).html(commentCountNum);
								});
							}
						}
					}
				}
			});
		}

		if ($tweetCounts.length > 0) {
			$.ajax({
				type: 'GET',
				dataType: 'jsonp',
				url: 'http://cdn.api.twitter.com/1/urls/count.json?url=' + escape(url),
				cache: true,
				success: function (data) {
					tweetCountNum = data.count;
					if (typeof (tweetCountNum) !== 'undefined') {
						tweetCountNum = fixCounts(tweetCountNum);
						$tweetCounts.each(function (i, v) {
							$(this).html(tweetCountNum);
						});
					}
				}
			});
		}

		if ($commentCounts.length > 0 || $commentCountsLong.length > 0) {
			sluglessUrl = url;
			var parameterStart = sluglessUrl.indexOf('/_/'),
				baseUrl,
				parameters,
				i;

			if (parameterStart > -1) {
				baseUrl = sluglessUrl.substring(0, parameterStart);
				parameters = sluglessUrl.substring(parameterStart + 3);
				parameters = parameters.split('/');
				for (i = 0; i < parameters.length; i++) {
					if (parameters[i] === '') {
						parameters.splice(i, 1);
						i++;
					}
				}
				if (parameters.length % 2 === 1) {
					parameters.splice(parameters.length - 1, 1);
				}
				parameters = parameters.join('/');
				sluglessUrl = baseUrl + '/_/' + parameters;
			}

			$.ajax({
				url: 'http://api.echoenabled.com/v2/mux?appkey=dev.espn.go.com&requests=[{%22id%22:%22count1%22,%20%22method%22:%22count%22,%20%22q%22:%22childrenof:' + escape(sluglessUrl) + '%20source:espn.go.com,ESPN type:comment state:Untouched,ModeratorApproved -user.state:ModeratorBanned,ModeratorDeleted children source:espn.go.com,ESPN type:comment state:Untouched,ModeratorApproved -user.state:ModeratorBanned,ModeratorDeleted%22},]',
				dataType: 'jsonp',
				success: function (data) {
					commentCountNum = data.count1.count;
					if (data.count1.errorCode === 'more_than') {
						commentCountNum = data.count1.errorMessage;
					}
					if ($commentCountsLong.length > 0){
						$commentCountsLong.each(function (i, v) {
							$(this).html(commentCountNum);
						});					
					} 
					else{
						commentCountNum = fixCounts(commentCountNum);
						$commentCounts.each(function (i, v) {
							$(this).html(commentCountNum);
						});
					}
				}
			});
		}

		$recommendLinks.bind('click', function (e) {
			e.preventDefault();
			var href = $(this).attr('href');
			if (espn.core.isMobile) {
				href = href.replace('www.facebook.com','m.facebook.com');
				href = href + '&display=touch';
				window.location.href = href;
			} else {
				href = href + '&display=popup';
				window.open(href, '_blank', 'width=550,height=420,scrollbars=no,resizable=yes');
			}
			if (typeof (anTrackLink) !== 'undefined') {
				if($(this).parents(".vert").length > 0) {
					anTrackLink(this, 'espn', 'Facebook', 'vertical-share');
				} else if($(this).parents("#page-actions-top, .page-actions-top").length > 0) {
					anTrackLink(this, 'espn', 'Facebook', 'horizontal-share');
				} else if($(this).parents("#page-actions-bottom, .page-actions-bottom").length > 0) {
					anTrackLink(this, 'espn', 'Facebook', 'bottom-share');
				} else {
					anTrackLink(this, 'espn', 'facebook', 'recommend');
				}
			}
		});

		$tweetLinks.bind('click', function (e) {
			if (typeof (anTrackLink) !== 'undefined') {
				if($(this).parents(".vert").length > 0) {
					anTrackLink(this, 'espn', 'Twitter', 'vertical-share');
				} else if($(this).parents("#page-actions-top, .page-actions-top").length > 0) {
					anTrackLink(this, 'espn', 'Twitter', 'horizontal-share');
				} else if($(this).parents("#page-actions-bottom, .page-actions-bottom").length > 0) {
					anTrackLink(this, 'espn', 'Twitter', 'bottom-share');
				} else {
					anTrackLink(this, 'espn', 'twitter', 'tweet');
				}
			}
			if (typeof(twttr) === 'undefined') {
				var href = $(this).attr('href');
				window.open(href, '_blank', 'width=550,height=420,scrollbars=no,resizable=yes');
				// need to return false in case the main twitter intents js is here
				return false;
			}
		});

		$followLinks.bind('click', function (e) {
			e.preventDefault();
			var href = $(this).attr('href');
			window.open(href, '_blank', 'width=550,height=420,scrollbars=no,resizable=yes');
		});

		$commentLinks.bind('click', function (e) {
			if (typeof (anTrackLink) !== 'undefined') {
				if($(this).parents(".vert").length > 0) {
					anTrackLink(this, 'espn', 'Comments', 'vertical-share');
				} else if($(this).parents("#page-actions-top, .page-actions-top").length > 0) {
					anTrackLink(this, 'espn', 'Comments', 'horizontal-share');
				} else if($(this).parents("#page-actions-bottom, .page-actions-bottom").length > 0) {
					anTrackLink(this, 'espn', 'Comments', 'bottom-share');
				} else {
					anTrackLink(this, 'espn', 'comments', 'comment');
				}
			}
			if (e.metaKey || e.ctrlKey) {
				return;
			} else {
				e.preventDefault();
				var href = $(this).attr('href');
				setTimeout(function () {
					window.location = href;
				}, 500);
			}
		});

		$emailLinks.bind('click', function (e) {
			e.preventDefault();
			if (typeof (anTrackLink) !== 'undefined') {
				if($(this).parents(".vert").length > 0) {
					anTrackLink(this, 'espn', 'Email', 'vertical-share');
				} else if($(this).parents("#page-actions-top, .page-actions-top").length > 0) {
					anTrackLink(this, 'espn', 'Email', 'horizontal-share');
				} else if($(this).parents("#page-actions-bottom, .page-actions-bottom").length > 0) {
					anTrackLink(this, 'espn', 'Email', 'bottom-share');
				} else {
					anTrackLink(this, 'espn', 'email', 'email');
				}
			}
			var href = $(this).attr('href');
			window.open(href, '_blank', 'noresizable,noscrollbars,width=400,height=500');
		});

		$printLinks.bind('click', function (e) {
			if (typeof (anTrackLink) !== 'undefined') {
				if($(this).parents(".vert").length > 0) {
					anTrackLink(this, 'espn', 'Print', 'vertical-share');
				} else if($(this).parents("#page-actions-top, .page-actions-top").length > 0) {
					anTrackLink(this, 'espn', 'Print', 'horizontal-share');
				} else if($(this).parents("#page-actions-bottom, .page-actions-bottom").length > 0) {
					anTrackLink(this, 'espn', 'Print', 'bottom-share');
				} else {
					anTrackLink(this, 'espn', 'print', 'print');
				}
			}
		});

		$insiderLinks.bind('click', function (e) {
			if (typeof (anTrackLink) !== 'undefined') {
				if($(this).parents(".vert").length > 0) {
					anTrackLink(this, 'espn', 'Insider', 'vertical-share');
				} else if($(this).parents("#page-actions-top, .page-actions-top").length > 0) {
					anTrackLink(this, 'espn', 'Insider', 'horizontal-share');
				} else if($(this).parents("#page-actions-bottom, .page-actions-bottom").length > 0) {
					anTrackLink(this, 'espn', 'Insider', 'bottom-share');
				} else {
					anTrackLink(this, 'espn', 'insider', 'insider');
				}
			}
		});

		function setPageActionStyles(defaultPosition, originalTop, hidePosition) {
			var	isFixed = ($verticalShare.css('position') === 'fixed');
			articleHeight = $('.article').outerHeight();
			socialHeight = $('#page-actions-top .mod-page-actions.vert').outerHeight();
			var vertAbsPosition = (articleHeight - (socialHeight/2)-12) + 'px';

			if($('#comments').length > 0) {
				hidePosition = $('#comments').height() + $('#comments').offset().top - ($window.height() * 0.5);
			}

			if (window.innerWidth >= 1044) {
				if ($window.scrollTop() > hidePosition) {
					//set absolute
					isFixed = false;
					$verticalShare.css({
						'position': 'absolute',
						'top': vertAbsPosition
					});
				} else if ($window.scrollTop() > defaultPosition && !(isFixed)) {
					$verticalShare.css({
						'position': 'fixed',
						'top': 0
					});
					if($('body.sharing-mix')) {
						displayVertMenu();
					}
					isFixed = true;
				} else if ($window.scrollTop() <= defaultPosition && isFixed) {
					$verticalShare.css({
						'position': 'relative',
						'top': originalTop,
						'display': 'none'
					});
					if($('body.sharing-mix')) {
						displayHzMenu();
					}
					isFixed = false;
				}
			
			} else {
				$verticalShare.css({
					'position': 'relative',
					'top': 0,
					'display': 'none'
				});
				if($('body.sharing-mix')) {
					displayHzMenu();
				}
				isFixed = false;
			}
		}
		
		function displayHzMenu() {
			$('body').addClass('sharing-hz');
			$('.mod-page-actions.hz').show();
		}
		function displayVertMenu() {
			$('.mod-page-actions.vert').hide();
			$('body').addClass('sharing-vert');
			$('#page-actions-top .mod-page-actions.vert').show();
		}

		$('document').ready(function () {
			var $window = $(window),
				$pageActionsTop = $('#page-actions-top .mod-page-actions').first(),
				$authorBio = $('.mod-author-bio'),
				authorPosition = 0,
				hasSeenAuthorBio = false,
				hidePosition = $(document).height();
				
			if($pageActionsTop.length > 0) {
				//var defaultPosition = $pageActionsTop.offset().top,
				//updated so that the vertical doesn't display until the horizontal is out of view    
				var defaultPosition = $pageActionsTop.offset().top + 20,
					originalTop = $pageActionsTop.css('top');
			}

			if ($pageActionsBottom.length > 0) {
				hidePosition = $pageActionsBottom.offset().top - ($window.height() * 0.5);
			}

			if ($authorBio.length > 0) {
				authorPosition = $authorBio.offset().top - ($window.height() * 0.5);
			}
			if($('#comments').length > 0) {
				hidePosition = $('#comments').height() + $('#comments').offset().top - ($window.height() * 0.5);
			}

			$window.scroll(function () {
				if($pageActionsTop.length > 0) {
					setPageActionStyles(defaultPosition, originalTop, hidePosition);
				}
				
				

				/*if ($authorBio.length > 0) {
					if ($window.scrollTop() > authorPosition) {
						if (!hasSeenAuthorBio) {
							if (typeof (anTrackLink) !== 'undefined') {
								anTrackLink(this, 'espn', 'authorbio', 'seen');
							}
							hasSeenAuthorBio = true;
						}
					}
				}*/
			});

			$window.resize(function () {
				if($pageActionsTop.length > 0) {
					setPageActionStyles(defaultPosition, originalTop, hidePosition);
				}
			});
		});
		return $(this);
	};
	
	'espn.core.init'.namespace();
	
	espn.core.init.tools = function(id, url) {
		jQuery('.mod-page-actions-' + id).sharetools(url);
	}
})(jQuery);