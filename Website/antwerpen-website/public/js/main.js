/**
*Variabele bevat de map data van de Google Maps API
*
*@var map
*/
var map;

window.initMap = function() {
    map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 51.202257, lng: 4.419694},
            zoom: 10
        });
};

jQuery(document).ready(function($){


    var $grid = $('.grid').masonry({
                    columnWidth: '.thumbnail',
                    itemSelector: '.thumbnail',
                });
    $grid.imagesLoaded().progress(function(){
        $grid.masonry('layout');
    });

    /*$('.carousel').slick({
        infinite: true,
        speed: 1000,
        arrows: true,
        dots: true,
        fade: true,
        autoplay: true,
        autoplaySpeed: 3000,
        swipeToSlide: true,
        useCSS: true
    });*/

	var timelineBlocks = $('.cd-timeline-block'),
		offset = 1;

	//hide timeline blocks which are outside the viewport
	hideBlocks(timelineBlocks, offset);

	//on scolling, show/animate timeline blocks when enter the viewport
	$(window).on('scroll', function(){
		(!window.requestAnimationFrame)
			? setTimeout(function(){ showBlocks(timelineBlocks, offset); }, 100)
			: window.requestAnimationFrame(function(){ showBlocks(timelineBlocks, offset); });
	});

	function hideBlocks(blocks, offset) {
		blocks.each(function(){
			( $(this).offset().top > $(window).scrollTop()+$(window).height()*offset ) && $(this).find('.cd-timeline-img, .cd-timeline-content').addClass('is-hidden');
		});
	}

	function showBlocks(blocks, offset) {
		blocks.each(function(){
			( $(this).offset().top <= $(window).scrollTop()+$(window).height()*offset && $(this).find('.cd-timeline-img').hasClass('is-hidden') ) && $(this).find('.cd-timeline-img, .cd-timeline-content').removeClass('is-hidden').addClass('bounce-in');
		});
	}
});
