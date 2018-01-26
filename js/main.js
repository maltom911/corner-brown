/*$(function(){
	
	 Efekt Smooth Scroll 
	
	$('a[href*="#"]:not([href="#"])').click(function(){
		$('body').animate( { scrollTop: $(this.hash).offset().top - 50 }, 500 );
	});*/

/* Scroll menu color change */
$(document).ready(function () {
    $(".smooth").on('click', function (event) {

        if (this.hash !== "") {
            event.preventDefault();
            var hash = this.hash;
            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 800, function () {
                window.location.hash = hash;
            });
        }
    });

    animateFlipBox();
});

$(window).scroll(function () {
    animateFlipBox();
});

console.log($(document).scrollTop());
/*scroll count*/
function animateFlipBox() {
    if ($(window).scrollTop() >= 623) {
        $('.count').each(function () {
            $(this).prop('Counter', 0).animate({
                Counter: $(this).attr('data-text')
            }, {
                duration: 3000,
                easing: 'swing',
                step: function (now) {
                    $(this).text(Math.ceil(now));
                }
            });
        });
    }
};


$(document).ready(function () {
    $('.hover').hover(function () {
        $(this).addClass('flip');
    }, function () {
        $(this).removeClass('flip');
    });
});

$(document).ready(function () {
    $('.corner').css('display', 'none');
    $('.corner').show(2000);
});

function initMap() {
    var uluru = {
        lat: -25.363,
        lng: 131.044
    };
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 4,
        center: uluru
    });
    var marker = new google.maps.Marker({
        position: uluru,
        map: map
    });
}

/*Opis produktu*/
$(document).ready(function () {
    $('#show-hide-btn').on('click', function (event) {
        $('#show-hide').slideToggle(1000);
     });
});








