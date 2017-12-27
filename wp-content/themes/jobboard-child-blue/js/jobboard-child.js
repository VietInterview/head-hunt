jQuery(document).ready(function($){

	"use strict";

	var changeJobTabs = function( tabID ) {
		var root = $('#job-listing');
		root.find('.select-tab').hide();
		if ( tabID.length ) {
			root.find('#'+tabID).slideDown(300);
		}
		return false;
	},
	isMobile = function() {
		if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
			return true;
		}
		return false;
	},
	userMenuHover = function() {
		if ( ! isMobile ) {
			$('.dropdown.usermenu:not(.off)').hover( function (){
				$(this).addClass('open');
			}, function (){
				$(this).removeClass('open');
			});
		}
	};

	$(window).load(userMenuHover);
	$(window).resize(userMenuHover);

	$('#jobboard-search-tab').tabs();

	$('#job-category-dropdown,#job-type-dropdown,#resume_category,#resume_search_career_level').selectize();

	var $jobtabs = $('.jobs-listing-select .select').selectize({
		onChange: function( value ) {
			changeJobTabs( value );
		}
	});




	if ( $('body').hasClass('page-template-template-homepage') ) {
		$('select.init-slider').selectToUISlider({
			tooltip: true,
			labelSrc: 'text',
			labels: 2
		});
	}

	$('#alljobs').on('click', '.dashboard-pagination a.page-numbers', function(e){
		e.preventDefault();
		var link = $(this).attr('href');
		$('#alljobs').slideUp(200, function(){
		  $('#loadajax').show();
		  $(this).load(link + ' #alljobs .select-tab-content', function() {
			$('#loadajax').hide();
			$(this).slideDown(400);
		  });
		});
	});

});
