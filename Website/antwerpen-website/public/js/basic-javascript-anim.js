
jQuery(document).ready(function($){
    //follow button
    $('#follow-btn').mouseenter(function(){
        $(this).addClass('btn-success').removeClass('btn-default');
        $('.fa.fa-plus.following-icon').addClass('fa-check').removeClass('fa-plus');
    });

    $('#follow-btn').mouseleave(function(){
        $(this).addClass('btn-default').removeClass('btn-success');
        $('.fa.fa-check.following-icon').addClass('fa-plus').removeClass('fa-check');
    });

    $('#following-btn').mouseenter(function(){
        $(this).addClass('btn-danger').removeClass('btn-success');
        $('.fa.fa-check.following-icon').addClass('fa-times').removeClass('fa-check');
    });

    $('#following-btn').mouseleave(function(){
        $(this).addClass('btn-success').removeClass('btn-danger');
        $('.fa.fa-times.following-icon').addClass('fa-check').removeClass('fa-times');

    });


    //readmore: uitleg bij een fase tonen en weg doen.
    $('.cd-timeline-content p').readmore({
        speed: 500,
        embedCSS: true,
        collapsedHeight: 102,
        moreLink: '<a href="#0" data-id="{{$phase->idFase}}" style="float: left; width: 100px"><i class="fa fa-plus meerlezen_plus"></i> meer lezen</a>',
        lessLink: '<a href="#0" data-id="{{$phase->idFase}}" style="float: left; width: 100px"> <i class="fa fa-minus meerlezen_plus"></i> minder lezen</a>',
    });

    $("cd-timeline-question-form").readmore({
        speed: 500,
        embedCSS: true,
        collapsedHeight: 0,
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

    //show meerkeuze vragen input field on page reload.
    $(window).load(function(){
        var selectedOption = $("#soort_vraag option:selected").attr('value');

        function showMeerkeuze(){
            $('#meerkeuze-vragen').show('fast');
        }

        function hideMeerkeuze(){
            $('#meerkeuze-vragen').hide('fast');
        }

        if( selectedOption == 'Meerkeuze'){
            showMeerkeuze();
        }
    });


    //change pencil to 'bewerken' in admin panel info page
    // $('#project-round-image').mouseenter(function(){
    //     $('#project-round-image div a i').removeClass('fa fa-pencil-square-o');
    //     $('#project-round-image div a i').html('Bewerken');
    // });
    //
    // $('#project-round-image').mouseleave(function(){
    //     $('#project-round-image div a i').addClass('fa fa-pencil-square-o');
    //     $('#project-round-image div a i').html('');
    // });



});
