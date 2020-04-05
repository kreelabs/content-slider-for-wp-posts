/*!
 * slider.lib.js v0.0.0, 04.08.2017
 * Lib to create slick slider for decks. Can be used for other purpose too.
 * Copyright (c) 2020 KreeLabs <hello@kreelabs.com, @kreelabs>.
 */

/** @private */
var SECTION_SLIDER = {
  /* stack of cards */
  cardStack: typeof DECK !== 'undefined' ? DECK.cards : {},

  /* current location hash */
  _hash: window.location.hash.length > 0 ? window.location.hash.replace(/#/g, '') : DECK.cards[0].slug,

  /* total elements in a deck */
  _total: typeof DECK !== 'undefined' ? DECK.total : 0,

  /* binary lock */
  _lock: false,

  /* holds current element */
  _currentElement: jQuery('.ss-current'),

  /* next element in a row */
  _nextElement: null,

  /*
   Show effect like the slide is being changed
   but there is no more to slide.
   */
  _slideEndAnim: '=2%',

  /*
   Smooth scroll based on path.
   */
  scroll: function (path) {
    var
      elm = jQuery('.ss-toc ol'),
      scrollPosition = elm.scrollTop(),
      scroll;

    if (path == 'prev') {
      scroll = scrollPosition - 70;
    }
    else {
      scroll = scrollPosition + 70;
    }

    elm.animate({
      scrollTop: scroll
    });
  },

  /*
   Calculate animation value for
   next/previous slide based on path.
   @private
   */
  _getNextSlideAnimation: function (path) {
    var
      forwardOffset = '+',
      backwardOffset = '-',
      anim = {
        first: backwardOffset + SECTION_SLIDER._slideEndAnim,
        after: forwardOffset + SECTION_SLIDER._slideEndAnim
      };

    if (path == 'next') {
      anim = {
        first: forwardOffset + SECTION_SLIDER._slideEndAnim,
        after: backwardOffset + SECTION_SLIDER._slideEndAnim
      }
    }

    return anim;

  },

  /*
   Animation that appears at  the end of slide.
   @private
   */
  _endAnimation: function (elm, path) {
    var anim = SECTION_SLIDER._getNextSlideAnimation(path);

    jQuery(elm).stop(true, true).animate({
      left: anim.first
    }, 200, function () {
      jQuery(elm).stop(true, true).animate({
        left: anim.after
      }, 200, function () {
        jQuery('.ss-card').removeClass('next');
        setTimeout(function () {
          SECTION_SLIDER._lock = false;
        }, 50);
      });
    });
  },

  /*
   Jump to the given state.
   This can be called from anywhere
   so we need to initialize both current
   and next element.
   */
  goToState: function (state, path) {
    if (typeof path === 'undefined') {
      path = 'next';
    }

    SECTION_SLIDER._currentElement = jQuery('.ss-current');
    SECTION_SLIDER._nextElement = jQuery('#' + state.card);
    SECTION_SLIDER._nextElement.addClass('next');
    SECTION_SLIDER.animate(path);
  },

  /* animate while switching state */
  animate: function (path) {
    var move = "-=100%";

    path = path || 'next';

    if (path === 'next') {
      move = '+=100%';
    }

    SECTION_SLIDER._currentElement.stop(true, true).animate({
      left: move
    }, 100, 'linear', function () {

      jQuery(this).css({
        display: 'none'
      }).removeClass('ss-animate ss-current next');

      SECTION_SLIDER._nextElement.stop(true, true).animate({
        left: 0
      }, 100, 'linear', function () {

        jQuery(this).addClass('ss-current');
        jQuery('#ss-page-number').html(jQuery(this).data('page'));

        var currentId = SECTION_SLIDER._nextElement.attr('id'),
          toc = jQuery('.ss-toc ol');

        jQuery('.ss-active-link').removeClass('ss-active-link');
        toc.find('[data-id="' + currentId + '"]').addClass('ss-active-link');

        if (jQuery().smoothScroll) {
          jQuery.smoothScroll({
            scrollElement: toc,
            scrollTarget: 'li.ss-active-link'
          });
        }

        jQuery('.ss-card').removeClass('next');

        setTimeout(function () {
          SECTION_SLIDER._lock = false;
          jQuery("html, body").animate({scrollTop: 0}, "slow");
        }, 50);
      });
    });
  },

  /* Change from one state to another */
  changeState: function (state) {
    var
      current = 0,
      next = 1,
      prev = 0,
      title,
      name,
      animate,
      url,
      stateObj,
      elm,
      me = this;

    var locationHash = window.location.hash;
    me._hash = locationHash.length > 0 ? locationHash.replace(/#/g, '') : DECK.cards[0].slug;

    jQuery.each(me.cardStack, function (i, v) {
      if (v.slug == me._hash) {
        current = i;
        next = ( i < (me._total - 1) ) ? i + 1 : i;
        prev = ( i > 0 ) ? i - 1 : i;
      }
    });

    me._currentElement = jQuery('#' + me.cardStack[current].slug);
    me._currentElement.addClass('ss-animate ss-current');

    name = me.cardStack[prev].slug;
    title = me.cardStack[prev].title;
    animate = (current !== prev);
    if (state == 'next') {
      name = me.cardStack[next].slug;
      title = me.cardStack[next].title;
      animate = (current !== next);
    }

    elm = '#' + name;
    me._nextElement = jQuery(elm);
    me._nextElement.addClass('next');
    url = window.location.href.replace(locationHash, '') + '#' + name;

    if (animate) {
      if (!(jQuery.browser.msie && parseFloat(jQuery.browser.version) < 10)) {
        stateObj = {card: name};
        history.pushState(stateObj, title, url);
      }

      SECTION_SLIDER.animate(state);
    }
    else {
      SECTION_SLIDER._endAnimation(elm, state);
    }
  }
};

//display first element
if (typeof SECTION_SLIDER.cardStack !== 'undefined' && SECTION_SLIDER.cardStack.length) {
  var initialElement = SECTION_SLIDER.cardStack[0].slug;
  jQuery.each(SECTION_SLIDER.cardStack, function (i, v) {
    if (v.slug == SECTION_SLIDER._hash) {
      initialElement = v.slug;
    }
  });

  jQuery('#' + initialElement).addClass('ss-current').css('left', 0);
  jQuery('li[data-id=' + initialElement + ']').addClass('ss-active-link');

  //hack for chrome
  jQuery(window).on('beforeunload', function () {
    setTimeout(function () {
      jQuery(window).scrollTop(0);
    }, 1);
  });

  //scroll to top on page load
  jQuery(document).ready(function () {
    setTimeout(function () {
      jQuery(window).scrollTop(0);
    }, 1);
  });

  jQuery('#ss-page-number').html(jQuery('.ss-current').data('page'));
}
