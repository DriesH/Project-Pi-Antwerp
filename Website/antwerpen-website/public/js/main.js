jQuery(document).ready(function($){

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


	var pathname = window.location.pathname;

	if ((pathname.search("bewerken") >= 0 || pathname.search("nieuw") >= 0) ) {

		window.onbeforeunload = function() {
	        return "Als u deze pagina verlaat zullen de huidige aanpassingen niet opgeslagen worden.";
	    }
	}




});
