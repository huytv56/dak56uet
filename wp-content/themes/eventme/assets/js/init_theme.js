jQuery(document).ready(function () {
        theme.init();
        theme.initEventSlider();
        theme.initIsotope();
        theme.initTestimonials();        
        //theme.initLastTweet();
        theme.initAnimation();   
        jQuery(".gallery_schedule").owlCarousel({
        singleItem: true,
        pagination: false,
        navigation: true,        
        navigationText: ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
      });
});

jQuery(window).load(function () {
    jQuery('body').scrollspy({
        offset: 100,
        target: '.navigation'
    });
    jQuery(window).stellar({
        horizontalScrolling: false
    });
});

jQuery(document).ready(function(){
    jQuery('#sidebar img').addClass('img-responsive');
    jQuery('#sidebar img').css('display','inline-block');    
});
