  /*============== Main Js Start ========*/

(function ($) {
  "use strict";

  /*============== Header Hide Click On Body Js ========*/
  $('.navbar-toggler.header-button').on('click', function() {
    if($('.body-overlay').hasClass('show')){
      $('.body-overlay').removeClass('show');
    }else{
      $('.body-overlay').addClass('show');
    }
  });
  $('.body-overlay').on('click', function() {
    $('.header-button').trigger('click');
  });

  /* ==========================================
  *     Start Document Ready function
  ==========================================*/
  $(document).ready(function () {


  
    /*========== Password Show and hide Js==========*/
    $(".input-group .input--icon").click(function () {
      var input = $($(this).attr("rel"));
      var eyeOfcls = $($(this).toggleClass("eye-off"));
      if (input.attr("type") == "password") {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }
    }); 

    /*============** Mgnific Popup **============*/
    $(".image-popup").magnificPopup({
      type: "image",
      gallery: {
          enabled: true,
      },
    });

    $('.popup_video').magnificPopup({
        type: 'iframe',
    });

    /*========================= Slick Slider Js Start ==============*/
    $('.podcast-team-slider').slick({
      slidesToShow: 2,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 2000,
      speed: 1500,
      dots: false,
      pauseOnHover: false,
      arrows: false,
      responsive: [
          {
            breakpoint: 1199,
            settings: {
              arrows: false,
              slidesToShow: 2,
              dots: false,
            }
          },
          {
            breakpoint: 991,
            settings: {
              arrows: false,
              slidesToShow: 1
            }
          },
          {
            breakpoint: 767,
            settings: {
              arrows: false,
              slidesToShow: 1
            }
          }
        ]
    });

    /*========================= Podcasst Episode Js Start ==============*/
    $('.podcast-episode-slider').slick({
      slidesToShow: 4,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 2000,
      speed: 1500,
      dots: false,
      pauseOnHover: false,
      arrows: false,
      responsive: [
          {
            breakpoint: 1199,
            settings: {
              arrows: false,
              slidesToShow: 2,
              dots: false,
            }
          },
          {
            breakpoint: 991,
            settings: {
              arrows: false,
              slidesToShow: 1
            }
          },
          {
            breakpoint: 767,
            settings: {
              arrows: false,
              slidesToShow: 1
            }
          }
        ]
    });


    $('.testimonial-slider').slick({
      slidesToShow: 2,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 2000,
      speed: 1500,
      dots: false,
      pauseOnHover: false,
      arrows: false,
      responsive: [
          {
            breakpoint: 1199,
            settings: {
              arrows: false,
              slidesToShow: 2,
              dots: false,
            }
          },
          {
            breakpoint: 991,
            settings: {
              arrows: false,
              slidesToShow: 2
            }
          },
          {
            breakpoint: 767,
            settings: {
              arrows: false,
              slidesToShow: 1
            }
          }
        ]
    });

  /* ========================= Latest Slider Js Start ===============*/
  $('.client-slider').slick({
  slidesToShow: 6,
  slidesToScroll: 1,
  autoplay: true,
  autoplaySpeed: 1000,
  pauseOnHover: true,
  speed: 2000 ,
  dots: false,
  arrows: false,
  prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-long-arrow-alt-left"></i></button>',
  nextArrow: '<button type="button" class="slick-next"><i class="fas fa-long-arrow-alt-right"></i></button>',
  responsive: [
      {
        breakpoint: 1199,
        settings: {
          slidesToShow:6,
        }
      },
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 5
        }
      },
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 4
        }
      },
      {
        breakpoint: 400,
        settings: {
          slidesToShow: 3
        }
      }
    ]
});

  /*======================= Mouse hover Js Start ============*/
    $('.search-box__ button').on('mouseover', function() {
      $('.search-box__ button').removeClass('active')
      $(this).addClass('active')
    }); 

    /*================== Sidebar Menu Js Start =============== */
    // Sidebar Dropdown Menu Start
    $(".has-dropdown > a").click(function() {
      $(".sidebar-submenu").slideUp(200);
      if (
        $(this)
          .parent()
          .hasClass("active")
      ) {
        $(".has-dropdown").removeClass("active");
        $(this)
          .parent()
          .removeClass("active");
      } else {
        $(".has-dropdown").removeClass("active");
        $(this)
          .next(".sidebar-submenu")
          .slideDown(200);
        $(this)
          .parent()
          .addClass("active");
      }
    });

    /*==================== Sidebar Icon & Overlay js ===============*/
      $(".dashboard-body__bar-icon").on("click", function() {
        $(".sidebar-menu").addClass('show-sidebar'); 
        $(".sidebar-overlay").addClass('show'); 
      });
      $(".sidebar-menu__close, .sidebar-overlay").on("click", function() {
        $(".sidebar-menu").removeClass('show-sidebar'); 
        $(".sidebar-overlay").removeClass('show'); 
      });


    /*======================= Event Details Like Js Start =======*/
    $('.hit-like').each(function() {
      $(this).on(click(function() {
        $(this).toggleClass('liked')
      }));
    });

    /* ========================= Odometer Counter Js Start ========== */
      $(".counterup-item").each(function () {
        $(this).isInViewport(function (status) {
          if (status === "entered") {
            for (var i = 0; i < document.querySelectorAll(".odometer").length; i++) {
              var el = document.querySelectorAll('.odometer')[i];
              el.innerHTML = el.getAttribute("data-odometer-final");
            }
          }
        });
      });

    /* =================== User Profile Upload Photo Js Start ========== */
    function readURL(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {
              $('#imagePreview').css('background-image', 'url('+e.target.result +')');
              $('#imagePreview').hide();
              $('#imagePreview').fadeIn(650);
          }
          reader.readAsDataURL(input.files[0]);
      }
    }
    $("#imageUpload").change(function() {
      readURL(this);
    });

  });
  /*==========================================
  *      End Document Ready function
  // ==========================================*/

  /*========================= Preloader Js Start =====================*/
    // $(window).on("load", function(){
    //   $('.preloader').fadeOut(); 
    // })
    $(window).on("load", function(){
      $("#loading").fadeOut();
    })

    /*========================= Header Sticky Js Start ==============*/
    $(window).on('scroll', function() {
      if ($(window).scrollTop() >= 300) {
        $('.header').addClass('fixed-header');
      }
      else {
          $('.header').removeClass('fixed-header');
      }
    }); 
    
    /*============================ Scroll To Top Icon Js Start =========*/
    var btn = $('.scroll-top');

    $(window).scroll(function() {
      if ($(window).scrollTop() > 300) {
        btn.addClass('show');
      } else {
        btn.removeClass('show');
      }
    });

    btn.on('click', function(e) {
      e.preventDefault();
      $('html, body').animate({scrollTop:0}, '300');
    })

    /*============================ Search =========*/
    $('#searchTerm').keyup(function() {
      var searchTerm = $(this).val(); // Get the current value of the input field
      if (searchTerm.length >= 1) { // Only execute if the search term is at least 3 characters long
        $('.search-wrap').addClass('your-desired-class'); // Add the desired class to the search-results div
      } else {
        $('.search-wrap').removeClass('your-desired-class'); // Remove the class if the search term is less than 3 characters long
      }
    });
    
})(jQuery);


