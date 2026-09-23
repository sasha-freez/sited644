(function( $ ){

  var OPTIONS = {
    classname: "b-slideshow",
    rootClass: ".b-slideshow",

    force: false,
    selfEvent: true,
    expanded: false,

    animation: "fade",
    speed: 300,
    title: "",
    fx: {},

    template: 
			'<div class="${classname}-photos">' +
			'</div>' +
			'<div class="${classname}-controls">' +
				'<h4 class="title">${title}</h4>' +
				'<div class="left"></div>' +
				'<div class="status">${status}</div>' +
				'<div class="right"></div>' +
				'<div class="clear"><div></div></div>' +
			'</div>',
    statusTemplate: "${current} из ${count}"
  };

  OPTIONS.fx.none = function(prev, next){
    prev.hide();
    next.show();
    console.log("none");
  };

  OPTIONS.fx.fade = function(prev, next){
    var self = this;
    next.show().css({ position: "absolute", left: "0", top: "0", opacity: "0" }).show();
    this.photosNode.css({ height: Math.max(prev.outerHeight(), next.outerHeight()) })
    prev.animate({ opacity: 0 }, OPTIONS.speed);
    next.animate({ opacity: 1 }, OPTIONS.speed, function(){
      self.photosNode.css({ height: next.outerHeight() })
      prev.hide();
    });
  }

  $(document).ready(function(){
    $(OPTIONS.rootClass).each(function(){
      new bSlideShow( this );
    });
    var slideshows = {},
        count = 1;
        slideshows[count] = [];
    $('.b-article-text p img:parent:not(".img-with-caption")').each(function(){
      var $cont = $(this);
      slideshows[count].push($cont);
      if(!$cont.next().filter('img')) {count++;slideshows[count] = [];}; 
    });
    $('.img-with-caption').each(function(){
      var $cont = $(this);
      slideshows[count].push($cont);
      if(!$cont.next().hasClass('img-with-caption')) {count++;slideshows[count] = [];};
    });

    for(var i in slideshows) {
      if(slideshows[i].length > 1) {
        var p = slideshows[i][0].parent();
        p.wrapInner('<div class="b-slideshow" />');
        p.children().children().each(function(){
          var $this = $(this);
          if(!$this.hasClass('img-with-caption') && !$this.is('img')) {
            $this.remove();
          }
                  });
        new bSlideShow( p.find('.b-slideshow').get(0) );
      }
    }
  });

  var bSlideShow = _Class.extend({
    init: function( node ){
      this.domNode = $(node);
      this.isWiki = (this.domNode.parent().hasClass('media-container')) ? true : false;
      if(this.create()){
        this.bindEvents();
      }
    },

    create: function(){
      this.photos = this.domNode.children().hide().eq(0).show().end();

      this.OPTIONS = $.extend(true, {}, OPTIONS)
      try{
        var o = this.domNode.attr("settings");
        if(o && o.length){
          o = eval('(' + o + ')');
          $.extend(true, this.OPTIONS, o);
        }
      } catch(e){ };

      if(this.photos.length <= 1 && !this.OPTIONS.force) return false;

      this.status = {
        count: this.photos.length,
        current: 1
      }


      var template = $.tmpl(this.OPTIONS.template, $.extend( true, {}, this.OPTIONS, { status: $.tmpl(this.OPTIONS.statusTemplate, this.status).text() } ));

      this.domNode.append(template);
      this.photos.appendTo(template.filter(this.OPTIONS.rootClass + "-photos"));
      this.photosNode = this.domNode.find(this.OPTIONS.rootClass + "-photos");
      this.controlsNode = this.domNode.find(this.OPTIONS.rootClass + "-controls");

      if(this.photos.length <= 1) this.controlsNode.children().not(".title, .clear").hide();

      this.title = '';
      try{
        this.title = this.domNode.parents(".b-article").find("h1");
        if(this.title.length)
          this.title = this.title.eq(0).text();
      } catch(e){ }

      return true;
    },

    bindEvents: function(){
      var self = this,
          elems = [];
      this.controlsNode
        .find(".left")
          .mousedown(function(){
            return false;
          })
          .click(function(){
            self.show( -1 );
            //track_event('Slideshow', 'Prev', self.title, self.status.current);
            return false;
          })
          .end()
        .find(".right")
          .mousedown(function(){
            return false;
          })
          .click(function(){
            self.show( 1 );
            //track_event('Slideshow', 'Next', self.title, self.status.current);
            return false;
          })
          .end()
        .find(".expand a")
          .click(function(){
            self.photos.removeAttr("style").show();
            self.photosNode.removeAttr("style");
            return false;
          }).end()
        .find('.fullscreen')
          .click(function(){
            $('.thumbs .galleria-image', self.controlsNode).eq(self.status.current-1).click();
            return false;
          })

      if(this.OPTIONS.selfEvent)
        this.photos.mousedown(function(){ return false; });
        elems = (this.photos.hasClass('img-with-caption')) ? this.photos.find('img') : this.photos;
        elems.click(function(){
            self.show( 1 );
            //track_event('Slideshow', 'Next', self.title, self.status.current);
            return false;
          });
    },

    show: function( dir ){
      if(!dir) dir = 1;

      var prev = this.photos.eq(this.status.current-1);

      this.status.current += dir;
      if(this.status.current < 1) this.status.current = this.status.count;
      if(this.status.current > this.status.count) this.status.current = 1;

      this.controlsNode.find(".status").html( $.tmpl(this.OPTIONS.statusTemplate, this.status) )

      var next = this.photos.eq(this.status.current-1);

      this.OPTIONS.fx[ this.OPTIONS.animation && $.isFunction(this.OPTIONS.fx[this.OPTIONS.animation]) ? this.OPTIONS.animation : "none" ].call(this, prev, next);

    },

    showAlt: function(obj) {
      this.altNode.text($(obj).attr('alt'));    }

  });

})( jQuery );

