
lv.ui.Gallery = function () {
	var root;

	this.el_ = root = jQuery('.main_content');

	this.controlNext_ = root.find('.slider_controls .up');

	this.controlPrev_ = root.find('.slider_controls .down');

	this.images_ = root.find('.slider_images');

	this.items_ = root.find('.slider_desc_item');

	this.itemLink_ = root.find('.slider_link');

	this.init_();
	this.initResize_()

};

/** @define {boolean} is slide effects enable */
lv.ui.Gallery.ENABLED = true;


/** @type {string} active class for item */
lv.ui.Gallery.CLASS_ACTIVE = 'active';


/** @type {string} class for prev images */
lv.ui.Gallery.CLASS_TRANSITION_OUT = 'transitionOut';


/** @type {string} class for next images */
lv.ui.Gallery.CLASS_TRANSITION_IN = 'transitionIn';


/** @type {string} current item */
lv.ui.Gallery.CURRENT_ITEM = null;


/** @type Array.<Function> all section ID */
lv.ui.Gallery.img = [];


/** @enum {number} images counter */
lv.ui.Gallery.counter = 0;


lv.ui.Gallery.prototype.init_ = function () {

	this.images_.children().each(function (i) {
		lv.ui.Gallery.img.push(jQuery(this).attr('id'));
	});

	this.itemLink_.on('click', jQuery.proxy(
		this.initItems_, this));

	this.items_.find('.item_hover1').on('click', jQuery.proxy(
		this.initItems_, this));

	this.controlPrev_.on('click', jQuery.proxy(
		this.bindControlsPrev_, this));

	this.controlNext_.on('click', jQuery.proxy(
		this.bindControlsNext_, this));

};


lv.ui.Gallery.prototype.initItems_ = function (event) {
	var element, parent, elementId;

	element = jQuery(event.currentTarget);
	parent = element.parent();
	elementId = element.attr('rel');

	if (parent.hasClass(lv.ui.Gallery.CLASS_ACTIVE) === false) {
		this.removeItemAll_();
		parent.addClass(lv.ui.Gallery.CLASS_ACTIVE);
		this.detectCurrentActive_(elementId);
		lv.ui.Gallery.CURRENT_ITEM = elementId;
		lv.ui.Gallery.counter = lv.ui.Gallery.img.indexOf(lv.ui.Gallery.CURRENT_ITEM);
	} else {
		return false
	}

	return false
};


lv.ui.Gallery.prototype.transitionOut_ = function (item) {
	item.addClass(lv.ui.Gallery.CLASS_TRANSITION_OUT);
};


lv.ui.Gallery.prototype.transitionIn_ = function (item) {
	item.addClass(lv.ui.Gallery.CLASS_TRANSITION_IN);
};


lv.ui.Gallery.prototype.removeItemAll_ = function () {
	this.items_.children().removeClass(lv.ui.Gallery.CLASS_ACTIVE);
	this.images_.find('.slider_pic').addClass(lv.ui.Gallery.CLASS_TRANSITION_OUT);
	this.images_.find('.slider_pic').removeClass(lv.ui.Gallery.CLASS_TRANSITION_IN);
};


lv.ui.Gallery.prototype.bindControlsPrev_ = function (event) {
	var element;

	element = jQuery(event.currentTarget);
  lv.ui.Gallery.CURRENT_ITEM = lv.ui.Gallery.img[lv.ui.Gallery.counter];
	this.next_();
	this.removeItemAll_();
	this.detectCurrentActive_(lv.ui.Gallery.CURRENT_ITEM);
};


lv.ui.Gallery.prototype.bindControlsNext_ = function (event) {
	var element;

	element = jQuery(event.currentTarget);

  this.prev_();
	this.removeItemAll_();
  lv.ui.Gallery.CURRENT_ITEM = lv.ui.Gallery.img[lv.ui.Gallery.counter];
  this.detectCurrentActive_(lv.ui.Gallery.CURRENT_ITEM);
};


lv.ui.Gallery.prototype.next_ = function () {
	if (lv.ui.Gallery.img.indexOf(lv.ui.Gallery.CURRENT_ITEM) < lv.ui.Gallery.img.length - 1) {
		lv.ui.Gallery.counter = lv.ui.Gallery.img.indexOf(lv.ui.Gallery.CURRENT_ITEM);
		lv.ui.Gallery.counter++;
	}
  //return to first items;
  if(lv.ui.Gallery.img.indexOf(lv.ui.Gallery.CURRENT_ITEM) == lv.ui.Gallery.img.length -1) {
    lv.ui.Gallery.counter = 0;
  }

};

lv.ui.Gallery.prototype.prev_ = function () {
  if (lv.ui.Gallery.img.indexOf(lv.ui.Gallery.CURRENT_ITEM) == 0) {
    lv.ui.Gallery.counter = lv.ui.Gallery.img.length - 1;
  }
	if (lv.ui.Gallery.img.indexOf(lv.ui.Gallery.CURRENT_ITEM) > 0) {
		lv.ui.Gallery.counter = lv.ui.Gallery.img.indexOf(lv.ui.Gallery.CURRENT_ITEM);
		lv.ui.Gallery.counter--;
	}
};

lv.ui.Gallery.prototype.detectCurrentActive_ = function (current) {
	var num;

	num = current.toString().substring(3) - 1;
	this.items_.find('#' + current).addClass(lv.ui.Gallery.CLASS_ACTIVE);
	this.transitionIn_(this.images_.find('#' + current).children());
	this.transitionOut_(this.images_.find('#sp_' + num).children());
};


lv.ui.Gallery.prototype.initResize_ = function () {
	var newHeight, the;

	the = this;

	this.images_.find('.slider_images_pic').first().resize(function () {
		newHeight = jQuery(this).height();
		the.images_.css({
			height: newHeight + 'px'
		});
	}).resize();

};



jQuery(document).on('ready', function () {
	'use strict';
	new lv.ui.Gallery();
});