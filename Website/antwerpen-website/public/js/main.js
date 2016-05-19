/**
*Variabele bevat de map data van de Google Maps API
*
*@var map
*Variabele bevat het DOM element waar de map in wordt gerenderd
*
*@var mapElement
*/
var map;
var marker;
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
        marker = new google.maps.Marker({
                    position: {lat: 51.202257, lng: 4.419694},
                    map: map,
                    title: 'Klik hier Joren',
                });

        map.addListener('center_changed', function() {
            // 3 seconds after the center of the map has changed, pan back to the
            // marker.
            window.setTimeout(function() {
              map.panTo(marker.getPosition());
            }, 3000);
          });

    }
};

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

    function readMore(block, blocks, offset){

    }

    /**
    *Button behavior and Font awesome hover behaviors.
    *
    *
    */
    //dashboard
    /*$('#project-link .fa.fa-check, .media-heading').mouseenter(function(){
        $('#project-link .fa.fa-check').addClass('fa-times').removeClass('fa-check');
        $('#project-link button').addClass('btn-danger').removeClass('btn-success');
    });

    $('#project-link .fa.fa-times, .media-heading').mouseleave(function(){
        $('#project-link .fa.fa-times').addClass('fa-check').removeClass('fa-times');
        $('#project-link button').addClass('btn-success').removeClass('btn-danger');
    });*/


    //follow button
    $('#follow-btn').mouseenter(function(){
        $(this).addClass('btn-success').removeClass('btn-default');
        $('.fa.fa-plus').addClass('fa-check').removeClass('fa-plus');
    });

    $('#follow-btn').mouseleave(function(){
        $(this).addClass('btn-default').removeClass('btn-success');
        $('.fa.fa-check').addClass('fa-plus').removeClass('fa-check');
    });

    $('#following-btn').mouseenter(function(){
        $(this).addClass('btn-danger').removeClass('btn-success');
        $('.fa.fa-check').addClass('fa-times').removeClass('fa-check');
    });

    $('#following-btn').mouseleave(function(){
        $(this).addClass('btn-success').removeClass('btn-danger');
        $('.fa.fa-times').addClass('fa-check').removeClass('fa-times');

    });


    //readmore: uitleg bij een fase tonen en weg doen.
    $('.cd-timeline-content p').readmore({
        speed: 500,
        embedCSS: true,
        collapsedHeight: 102,
        moreLink: '<a href="#0" data-id="{{$phase->idFase}}" style="float: left; width: 100px"><i class="fa fa-plus meerlezen_plus"></i> meer lezen</a>',
        lessLink: '<a href="#0" data-id="{{$phase->idFase}}" style="float: left; width: 100px"> <i class="fa fa-minus meerlezen_plus"></i> minder lezen</a>',
    });

    //toon vragen formulier.
    $('#form-reveal').on('click', function(){
        $(this).hide();
        $('.cd-timeline-question-form').show('fast');
    });


    //admin panel vragen toevoegen animatie Meerkeuze vragen.
    $('#soort_vraag').change(function(){
        if( $('#soort_vraag').val() == 'Meerkeuze' )
        {
            $('#meerkeuze-vragen').show('fast');
        }
        else
        {
            $('#meerkeuze-vragen').hide('fast');
        }
    });
});
