/*!
 * @file ss-scripts.js
 *
 * Scripts for Section Slider Plugin
 *
 * @author KreeLabs
 *
 * Copyright (c) 2020 KreeLabs <hello@kreelabs.com, @kreelabs>.
 */

jQuery(document).ready(function ($) {
  $('.ss-social').on('click', 'a', function () {
    var href = $(this).data('href'),
      title = $(this).data('title'),
      left = (screen.width / 2) - (600 / 2),
      top = (screen.height / 2) - (350 / 2);

    window.open(href, title, "width=600, height=350, left=" + left + " top" + top);
  });

  //disable key navigation in < ie10
  if (!(jQuery.browser.msie && parseFloat(jQuery.browser.version) < 10)) {
    $(document).keyup(function (e) {
      if (e.which == 37 && !SECTION_SLIDER._lock) { //left
        SECTION_SLIDER._lock = true;
        SECTION_SLIDER.changeState('prev');
      }
      else if (e.which == 39 && !SECTION_SLIDER._lock) { //right
        SECTION_SLIDER._lock = true;
        SECTION_SLIDER.changeState('next');
      }
    });
  }

  //animate on table of contents click
  $('.ss-deck-toc-nav').click(function (e) {
    var locationHash = window.location.hash,
      elementId = locationHash.replace(/#/g, ''),
      href = $(this).parent().data('id');

    if (elementId != href) {
      jQuery('.ss-card').removeClass('next');
      SECTION_SLIDER.goToState({card: href});

      if (!(jQuery.browser.msie && parseFloat(jQuery.browser.version) < 10)) {
        var url = window.location.href.replace(locationHash, '') + '#' + href;
        var stateObj = {card: href}, title = 0;

        jQuery.each(SECTION_SLIDER.cardStack, function (i, v) {
          if (v.slug == href) {
            title = i;
          }
        });

        history.pushState(stateObj, SECTION_SLIDER.cardStack[title].title, url);
      }
    }
  });

  /*
   Smooth scroll. Require for smooth scroll
   at the initial page load.
   */
  if (jQuery().smoothScroll) {
    jQuery.smoothScroll({
      scrollElement: jQuery('.ss-toc ol'),
      scrollTarget: 'li.ss-active-link'
    });
  }
});

window.onpopstate = function (event) {
  if (history.state !== null) {
    jQuery('.ss-card').removeClass('next');

    SECTION_SLIDER.goToState(history.state, 'prev');
  }
};
