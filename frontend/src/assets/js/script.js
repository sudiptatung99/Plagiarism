
$(document).ready(function(){
	
	"use strict";
	const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
	const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

});

$(window).on('load', function(){
	"use strict";
	setTimeout(function(){
		$('.preloader').addClass('inactive');
	}, 500);
	
});

