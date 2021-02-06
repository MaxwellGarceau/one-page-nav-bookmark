/**
 * Initializes .one-page-nav menus
 */
(function($) {
  $(document).ready(function() {
    var $onePageNavs = $('.one-page-nav');
    if ($onePageNavs.length > 0) {
      var args = {
        easing: 'linear',
      };
      $onePageNavs.onePageNav(args);
    }
  });
})(jQuery);

/**
 * Add and remove body class for hiding menu
 */
(function($) {
  $(document).ready(function() {

    /**
     * If Open/Close trigger are clicked then toggle the menu
     */
    $('.one-page-nav-trigger').on('click', function() {
      toggleOnePageNav();
    });

    /**
     * If a menu item is clicked and the screen size is less than 1370 close the menu
     */
    $('.one-page-nav .menu-item > a').on('click', function() {
      if ($(window).width() <= 1370) {
        closeOnePageNav();
      }
    });

    function closeOnePageNav() {
      if (!$('body').hasClass('one-page-nav-hidden')) {
        $('body').addClass('one-page-nav-hidden');
      }
    }

    function toggleOnePageNav() {
      if ($('body').hasClass('one-page-nav-hidden')) {
        $('body').removeClass('one-page-nav-hidden');
      } else {
        $('body').addClass('one-page-nav-hidden');
      }
    }

  });
})(jQuery);
