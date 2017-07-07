jQuery(document).ready(function ($) {

	//report comment
	$('.report').click(function (e) {

		e.preventDefault();

		var $this = $(this);
		var $com_id = $this.data('id');

		$("#comment-"+$com_id).css({ opacity: 0.1 });
		$.ajax({
			url: '/article/report/'+$com_id,
			type: 'GET',
					
		});

	});
	
	//navbar action on scrolling
	function checkScroll(){
    var startY = $('.navbar').height() * 2; //The point where the navbar changes in px

    if($(window).scrollTop() > startY){
        $('.navbar').addClass("scrolled");
    }else{
        $('.navbar').removeClass("scrolled");
    }
}

if($('.navbar').length > 0){
    $(window).on("scroll load resize", function(){
        checkScroll();
    });
}
	//previous article button
	$('.previous').click(function (e) {

		e.preventDefault();

		var $this = $(this);
		var $art_id = $this.data('id');
		var $preArtid = $art_id-1;
		
		if($preArtid >=1){
			document.location.href="/article/"+$preArtid+"#art";
		}else{
			document.location.href="/";
		}
	});
	
	//next article button
	$('.next').click(function (e) {

		e.preventDefault();

		var $this = $(this);
		var $art_id = $this.data('id');
		var $preArtid = $art_id+1;
		
			document.location.href="/article/"+$preArtid+"#art";
	});
})