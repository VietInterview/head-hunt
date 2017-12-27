/**
 * Custom JQuery for Load theme javascript plugins
 *
 * @package WordPress
 * @subpackage Job_Board
 * @since Job Board 1.0
 */

jQuery(document).ready(function($){
    // Inside of this function, $() will work as an alias for jQuery()
    // and other libraries also using $ will not be accessible under this shortcut

    "use strict";

    // Job search: Advanced Search toggle

    if( $('#advance-search-option').length ) {

      $('.advance-search-toggle, .btn-adv-search').click(function(){

        if($('#advance-search-option:visible').length){

          $('#advance-search-option').slideUp();

        }else{

          $('#advance-search-option').slideDown();

        }

        return false;

      });

    }


    // Multiple upload JS


    $('#portfolio_image').live('change', function(){

      var imgVal = $('#portfolio_image').val();
      if(imgVal=='') {
        console.log('No image is selected');
      } else {
        console.log('img val: '+imgVal);
        $(this).next('input').val('');
      }

    });

    // Smooth scrolling every anchor link
    /* Don't need it any more
    $('a').click(function(){
      $('html, body').animate({
        scrollTop: $( $.attr(this, 'href') ).offset().top
      }, 500);
      return false;
    });
    */



    /*-------------------------------------------*/
	/*	Homepage Slider	*/
	/*-------------------------------------------*/
	$(function(){
		var init_slider = slider.home_init;
		if(init_slider){
			$('#slider-wrapper').owlCarousel({
				items : 1,
				margin:0,
				dots:false,
				loop:true,
				lazyLoad:true,
				autoplay:home_slider.auto_play,
				autoplayTimeout:home_slider.auto_play_timeout,
				animateIn:home_slider.animate_in,
				animateOut:home_slider.animate_out,


			});
		}//endif;
	});

    // Keep the images fit the container in smaller screen
    $(function(){
    	$('#slider-wrapper .owl-item').imgLiquid();
    });

	$(function(){
		var init_slider = slider.home_init;
		if(init_slider){
			$('#slider-wrapper-flexslider').flexslider({
				animation: home_slider.flexslider_animation,
				slideshow: home_slider.flexslider_auto_slide,
				slideshowSpeed: home_slider.flexslider_delay,
				smoothHeight: true,
				controlNav: false
			});
		}
	});

    // Jobs Listings Tabs
    $(function(){
    	$('#job-listing-tabs').tabs({ hide: { effect: "fade", duration: 'fast' }, show: { effect: "fade", duration: 'fast' } });
    });


    // Jobs Package Tabs
    $(function(){
    	$('.package-tabs').tabs({ hide: { effect: "fade", duration: 'fast' }, show: { effect: "fade", duration: 'fast' } });
    });

    // Testimonial Carousel
    $(function(){
    	var sync1 = $('#testimonials-wrapper'),
    		sync2 = $('#testimonials-caption');

    	sync1.owlCarousel({
			items : 10,
			margin:5,
			center:true,
			loop:true,
			dots:false,
			nav:false,
			autoplay:true,
			autoplayTimeout:4000,
			autoWidth:true,
			mouseDrag:false,
			touchDrag:false,
			pullDrag:false,
			freeDrag:false,
		});

		function checkPosition(e){
			alert(e.item.index);
		}
    	sync2.owlCarousel({
    		mouseDrag:false,
			touchDrag:false,
			pullDrag:false,
			freeDrag:false,
			items : 1,
			dots:false,
			loop:true,
			nav:false,
			animateOut: 'fadeOutDown',
			animateIn: 'fadeInDown',

		});

		sync1.on('change.owl.carousel', function(event){
			sync2.trigger('next.owl.carousel');
		});

    });

    // Companies Listing Carousel
    $(function(){
    	$('.companies-listing-wrapper').owlCarousel({
			loop:true,
    		dots:false,
			nav:false,
			autoplay:true,
			autoplayTimeout:4000,
			autoWidth:true,
			mouseDrag:false,
			touchDrag:false,
			pullDrag:false,
			freeDrag:false,
			items:6,
    	});
    });


    // Company Portfolio Carousel
    $(function(){
      $('.company_portfolio_items').owlCarousel({
        loop:true,
        dots:false,
        nav:true,
        autoplay:true,
        autoplayTimeout:4000,
        autoWidth:true,
        mouseDrag:false,
        touchDrag:false,
        pullDrag:false,
        freeDrag:false,
        items:2,
      });
    });

    // Featured Job Carousel
    $( function(){
    	$('.featured-job-wrapper').owlCarousel({
    		loop:true,
    		dots:false,
			nav:true,
			navText : ['&nbsp;','&nbsp;'],
			autoplay:true,
			autoplayTimeout:4000,
			autoWidth:true,
			items:3,
    	});
    });

    // Featured Job Widget
    $( function(){
    	$('.featured-job-widget').owlCarousel({
    		loop:true,
    		dots:false,
			nav:true,
			navText : ['&nbsp;','&nbsp;'],
			autoplay:true,
			autoplayTimeout:4000,
			autoWidth:true,
			items:1,
    	});
    });

    // Post resume repeated Form submission
    $(function(){
    	var i=1;
    	$('.btn-add-url').on( 'click', function(){
    		var form_id = $(this).attr("data-form-id");
    		var form_html = $(form_id).html();
    		var limit = $(this).attr("data-limit");
			var insert = '<div class="repeated-form">'+form_html+'</div>';
			$(insert).insertBefore(form_id).slideDown('fast');
			if(i==limit && limit != ''){
				$(this).prop( 'disabled', true );
			}
			i++;
    	});


    	$(document).on('click', '.close-form', function(){
			var btn_id = $(this).attr("data-button-name");
			var btn_limit = $(this).attr("data-button-limit");

			$(this).parent().slideUp('fast', function(){
				$(this).remove();
			});
			if(i==btn_limit & btn_limit!=''){
				$(btn_id).prop('disabled', false);
			}
			i--;
		});

    });

    // Post company repeated forms
    $(function(){
      var i=1;
      $('.btn-add-service').on( 'click', function(){
        var form_id = $(this).attr("data-form-id");
        var form_html = $(form_id).html();
        var limit = $(this).attr("data-limit");
        var insert = '<div class="repeated-form">'+form_html+'</div>';
        $(insert).insertBefore(form_id).slideDown('fast');
        if(i==limit && limit != ''){
          $(this).prop( 'disabled', true );
        }
        i++;
      });


      $(document).on('click', '.close-form', function(){
        var btn_id = $(this).attr("data-button-name");
        var btn_limit = $(this).attr("data-button-limit");

        $(this).parent().slideUp('fast', function(){
          $(this).remove();
        });
        if(i==btn_limit & btn_limit!=''){
          $(btn_id).prop('disabled', false);
        }
        i--;
      });

    });


    // Post company repeated client form
    $(function(){
      var i=1;
      $('.btn-add-client').on( 'click', function(){
        var form_id = $(this).attr("data-form-id");
        var form_html = $(form_id).html();
        var limit = $(this).attr("data-limit");
        var insert = '<div class="repeated-form">'+form_html+'</div>';
        $(insert).insertBefore(form_id).slideDown('fast');
        if(i==limit && limit != ''){
          $(this).prop( 'disabled', true );
        }
        i++;
      });


      $(document).on('click', '.close-form', function(){
        var btn_id = $(this).attr("data-button-name");
        var btn_limit = $(this).attr("data-button-limit");

        $(this).parent().slideUp('fast', function(){
          $(this).remove();
        });
        if(i==btn_limit & btn_limit!=''){
          $(btn_id).prop('disabled', false);
        }
        i--;
      });

    });


    // Post portfolio repeated client form
    $(function(){
      var i=1;
      $('.btn-add-portfolio').on( 'click', function(){
        var form_id = $(this).attr("data-form-id");
        var form_html = $(form_id).html();
        var limit = $(this).attr("data-limit");
        var insert = '<div class="repeated-form">'+form_html+'</div>';
        $(insert).insertBefore(form_id).slideDown('fast');
        if(i==limit && limit != ''){
          $(this).prop( 'disabled', true );
        }
        i++;
      });


      $(document).on('click', '.close-form', function(){
        var btn_id = $(this).attr("data-button-name");
        var btn_limit = $(this).attr("data-button-limit");

        $(this).parent().slideUp('fast', function(){
          $(this).remove();
        });
        if(i==btn_limit & btn_limit!=''){
          $(btn_id).prop('disabled', false);
        }
        i--;
      });

    });


  /*-------------------------------------------*/
	/*	AJAX Contact Form Function	*/
	/*-------------------------------------------*/
	var ContactJobSeekerForm = function (){

		function success_status(responseText){
			if( responseText.message == 'not_human' ){
				$('.contact-form-human').slideDown('fast');
			}else{
				$('.contact-form-status').slideDown('fast');
				$('#contact-form').resetForm();
			}
			$('.btn-send-contact-form').button('reset');
			setTimeout(function() { $('#contact-resume-modal').modal('hide'); }, 2000);
		}

		function before_submit(){
			$('.btn-send-contact-form').button('loading');
		}

		var options = {
			resetForm:false,
			success:success_status,
			beforeSubmit:before_submit,
			dataType:'json'
		};
		$('#contact-form').ajaxForm(options);
		$('#contact-job-seeker').ajaxForm(options);

	};

	/*-------------------------------------------*/
	/*	AJAX delete post item function	*/
	/*-------------------------------------------*/
	var DeleteItemListForm = function (){

		function before_submit(formData, jqForm, options){
			var queryString = $.param(formData);

			var form_id = jqForm.attr( 'data-post-id' );

			var bool = confirm('Are you sure?');
			if( bool == false ){
				return false;
			}
		}

		function on_success(responseText, statusText, xhr, $form){
			var response = responseText.getElementsByTagName("response_data")[0].childNodes[0].nodeValue;
			$('#list-item-'+response).fadeOut('normal', function(){
				$(this).remove();
			});
		}
		var options = {
			success:on_success,
			beforeSubmit:before_submit,
			dataType:'xml'
		};
		$('body').find('.jobboard_delete_item').ajaxForm(options);

	};

	/*-------------------------------------------*/
	/*	AJAX featured post item function	*/
	/*-------------------------------------------*/

	var AddFeaturedForm = function (){

		function on_success(responseText, statusText, xhr, $form){
			var form = '<i class="fa fa-check"></i> Featured';
			$form.html(form);
		}

		var options = {
			success:on_success,
		}

		$('.jobboard_featured_item').ajaxForm(options);

	};

	/*-------------------------------------------*/
	/*	AJAX post status function	*/
	/*-------------------------------------------*/
	var ApplicationStatusForm = function (){

		function on_success(responseText, statusText, xhr, $form){
			$form.children('.application_icons').html('<i class="fa fa-check"></i>').delay('3000').fadeOut();
		}

		function before_submit(arr, $form, options){
			$form.append('<span class="application_icons"><i class="fa fa-refresh fa-spin"></i></span>');
		}

		var options = {
			success:on_success,
			beforeSubmit:before_submit
		}

		$('.application_status').on( 'change', function(){
			$(this).parent('.application_status_form').ajaxSubmit(options);
		});

	};

	/*-------------------------------------------*/
	/*	AJAX Bookmark	*/
	/*-------------------------------------------*/
	var AddBookmarkForm = function (){

		function on_success(responseText, statusText, xhr, $form){
            var response = responseText.getElementsByTagName("response_data")[0].childNodes[0].nodeValue;
			var btn_ed = $('#bookmark-button').attr('data-on-success');
			var btn_un = $('#bookmark-button').attr('data-on-finish');
			$('#bookmark-button').button('reset');
            if( response == 'add' ){
                $('#bookmark-button').html(btn_ed);
            }else{
                $('#bookmark-button').html(btn_un);
            }
		}

		function before_submit(){
			$('#bookmark-button').button('loading');
		}

		var options = {
			success:on_success,
			beforeSubmit:before_submit,
			dataType:'xml'
		}

		$('#bookmark-resume').ajaxForm(options);

	};

    
  /*-------------------------------------------*/
	/*	AJAX delete Bookmark                     */
	/*-------------------------------------------*/
	var UnBookmarkForm = function(){
		function before_submit(formData, jqForm, options){
			var queryString = $.param(formData);

			var form_id = jqForm.attr( 'data-post-id' );

			var bool = confirm('Are you sure?');
			if( bool == false ){
				return false;
			}
		}

		function on_success(responseText, statusText, xhr, $form){
			var response = responseText.getElementsByTagName("response_data")[0].childNodes[0].nodeValue;
			$('#list-bookmark-'+response).fadeOut('normal', function(){
				$(this).remove();
			});
		}
        
		var options = {
			success:on_success,
			beforeSubmit:before_submit,
			dataType:'xml'
		};

		$('.jobboard_resume_unbookmark').ajaxForm(options);
	};

	/*-------------------------------------------*/
	/*	Javascript Dropdown Menu	*/
	/*-------------------------------------------*/
	$(function(){

    var screenWidth = $(window).width();

    if( screenWidth > 767 ){

    } else {

  		$('li.menu-item-has-children > a').on('click', function(e){
  			e.preventDefault();
  			$(this).next('.sub-menu').slideToggle('fast');
  		});

    }

	});

	/*-------------------------------------------*/
	/*	Cross Browser Function	*/
	/*-------------------------------------------*/
	$(function(){
		$('.disable').disable=true;
		//$('#bookmark-button').popover();
        $('.resume-file button').click(function(){
          $('.resume-file a')
            .css('text-decoration', 'line-through')
            .attr('title', 'Mark as Deleted');
          $( "&nbsp;&nbsp;<small>Mark as Deleted</small>" ).insertAfter('.resume-file a');
          $('#resume_file_status').val('1');
          $(this).hide();
        });
	});


	/*-------------------------------------------*/
	/*	Jquery Plugin Function	*/
	/*-------------------------------------------*/

	$(function(){
		//Bootstrap Tooltip
		$('[data-toggle="tooltip"]').tooltip();
		//Selectize Plugin
		$('select#job_region, select#job_category').selectize({
          closeAfterSelect: true,
          create: true,
          sortField: 'text'
        });
        $('select#location, select#job_type, select#job_company, #refine-resume select, #post-resume select').selectize({
          closeAfterSelect: true,
          create: false,
          sortField: 'text'
        });
	});

	/*-------------------------------------------*/
	/*	Ajax Load Post Pagination	*/
	/*-------------------------------------------*/

	$(function(){
      $('#all_jobs').on('click', '.dashboard-pagination a.page-numbers', function(e){
        e.preventDefault();
        var link = $(this).attr('href');
        $('#all_jobs').slideUp(300, function(){
          $('#loadajax').show();
          $(this).load(link + ' #all_jobs', function() {
            $('#loadajax').hide();
            $(this).slideDown(800);
          });
        });
      });
    });

	/*-------------------------------------------*/
	/*	Remove Empty Field From Advance Search	 */
	/*-------------------------------------------*/

	$("#job-search-form,#resume-search-form").submit(function() {
		$(this).find(":input").filter(function(){ return !this.value; }).attr("disabled", "disabled");
		return true; // ensure form still submits
	});

	// Un-disable form fields when page loads, in case they click back after submission
	$( "#job-search-form,#resume-search-form" ).find( ":input" ).prop( "disabled", false );

	$(document).ready(function (){

		ContactJobSeekerForm();
		DeleteItemListForm();
		AddFeaturedForm();
		ApplicationStatusForm();
		AddBookmarkForm();
		UnBookmarkForm();

		/*-------------------------------------------*/
		/*	AJAX pagination on dashboard		  	 */
		/*-------------------------------------------*/

		//YOUR COMPANIES
		$('#company-list').on('click', '.dashboard-pagination a.page-numbers', function(e){
		  e.preventDefault();
		  var link = $(this).attr('href');
		  $('#company-list > .company-list-inner').slideUp(100, function(){
				$('#loadajax_companylist').show();
				$(this).load(link + ' #company-list > .company-list-inner', function() {
					$('#loadajax_companylist').hide();
					$(this).slideDown(500);
					DeleteItemListForm();
				});
		  });
		});

		//POSTED JOBS
		$('#job-list').on('click', '.dashboard-pagination a.page-numbers', function(e){
		  e.preventDefault();
		  var link = $(this).attr('href');
		  $('#job-list > .job-list-inner').slideUp(100, function(){
				$('#loadajax_joblist').show();
				$(this).load(link + ' #job-list > .job-list-inner', function() {
					$('#loadajax_joblist').hide();
					$(this).slideDown(500);
					DeleteItemListForm();
					AddFeaturedForm();
				});
		  });
		});

		//APPLICANTS
		$('#applicant-list').on('click', '.dashboard-pagination a.page-numbers', function(e){
		  e.preventDefault();
		  var link = $(this).attr('href');
		  $('#applicant-list > .applicant-list-inner').slideUp(100, function(){
				$('#loadajax_applist').show();
				$(this).load(link + ' #applicant-list > .applicant-list-inner', function() {
					$('#loadajax_applist').hide();
					$(this).slideDown(500);
					ApplicationStatusForm();
				});
		  });
		});

		//RESUME BOOKMARK
		$('#bookmark-list').on('click', '.dashboard-pagination a.page-numbers', function(e){
		  e.preventDefault();
		  var link = $(this).attr('href');
		  $('#bookmark-list > .bookmark-list-inner').slideUp(100, function(){
				$('#loadajax_bookmark').show();
				$(this).load(link + ' #bookmark-list > .bookmark-list-inner', function() {
					$('#loadajax_bookmark').hide();
					$(this).slideDown(500);
					UnBookmarkForm();
				});
		  });
		});

		//YOUR RESUME
		$('#resumelist').on('click', '.dashboard-pagination a.page-numbers', function(e){
		  e.preventDefault();
		  var link = $(this).attr('href');
		  $('#resumelist > .company-list-inner').slideUp(100, function(){
				$('#loadajax').show();
				$(this).load(link + ' #resumelist > .company-list-inner', function() {
					$('#loadajax').hide();
					$(this).slideDown(500);
					DeleteItemListForm();
				});
		  });
		});

		//YOUR JOB APPLICATION
		$('#applyresume').on('click', '.dashboard-pagination a.page-numbers', function(e){
		  e.preventDefault();
		  var link = $(this).attr('href');
		  $('#applyresume > .company-list-inner').slideUp(100, function(){
				$('#loadajax_applyresume').show();
				$(this).load(link + ' #applyresume > .company-list-inner', function() {
					$('#loadajax_applyresume').hide();
					$(this).slideDown(500);
					DeleteItemListForm();
				});
		  });
		});

	});

});// JQuery Wrapper, Don't delete this line !!!
