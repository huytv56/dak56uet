jQuery(document).ready(function () {
	// gallery for schedule
      jQuery(".gallery_schedule").owlCarousel({
        singleItem: true,
        pagination: false,
        navigation: true,
        direction: 'rtl',
        navigationText: ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
      });
});