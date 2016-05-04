/**
*Variabele bevat de map data van de Google Maps API
*
*@var map
*Variabele bevat het DOM element waar de map in wordt gerenderd
*
*@var mapElement
*/
var map;
var mapElement = document.getElementById('map');

/**
*Google map api initialiseren
*
*@method initMap
*/
window.initMap = function() {
    if(mapElement != null){
        map = new google.maps.Map(mapElement, {
                center: {lat: 51.202257, lng: 4.419694},
                zoom: 10
            });
    }
};

jQuery(document).ready(function($){
    var $grid = $('.grid').masonry({
                    columnWidth: '.thumbnail',
                    itemSelector: '.thumbnail',
                });

    console.log($grid);

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

    console.log(timelineBlocks);

	//hide timeline blocks which are outside the viewport
	hideBlocks(timelineBlocks, offset);

	//on scolling, show/animate timeline blocks when enter the viewport
	$(window).on('scroll', function(){
		(!window.requestAnimationFrame)
			? setTimeout(function(){ showBlocks(timelineBlocks, offset); }, 100)
			: window.requestAnimationFrame(function(){ showBlocks(timelineBlocks, offset); });
	});

    $('.cd-read-more').on('click', function(){
        var data_id_btn = $(this).attr("data-id");
        var content = $("*[data-id='" + data_id_btn + "']").first().animate({
            height: 800
        });
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

    function readMore(block, blocks, offset){

    }


});
