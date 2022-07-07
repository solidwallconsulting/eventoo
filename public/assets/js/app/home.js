$(document).ready(function(){


    $('.sponsors-carrousel').owlCarousel({
        loop:true,
        margin:25,
        nav:true,
        dots:true,
        autoplay:true,
        autoplayTimeout:5000,
        autoplayHoverPause:true,

        
        
        responsive:{
            0:{
                items:2
            },
            600:{
                items:3
            },
            1000:{
                items:3
            }
        }
    })



    $(".exposants-carrousel").owlCarousel({
        loop:true,
        margin:25,
        nav:true,
        dots:true,
        autoplay:true,
        autoplayTimeout:5000,
        autoplayHoverPause:true,
 
        
        responsive:{
            0:{
                items:2
            },
            600:{
                items:3
            },
            1000:{
                items:3
            }
        }
    })


    $(".participants-carrousel").owlCarousel({
        loop:true,
        margin:25,
        nav:true,
        dots:true,
        autoplay:true,
        autoplayTimeout:5000,
        autoplayHoverPause:true,
 
        
        responsive:{
            0:{
                items:2
            },
            600:{
                items:3
            },
            1000:{
                items:3
            }
        }
    })


})