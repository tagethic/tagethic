( function( $ ) {
	"use strict";
	
// Floating block..
var _top = $("#content").offset().top + 100,
scrollIntervalID = setInterval(stickMenu, 100);

function stickMenu() {
	if($('.site-header').length && screen.availWidth > 780) {
		if ($(window).scrollTop() >= _top) {
			// bandeau réduit
			if (! $(".site-header").hasClass("fixe")) {
				$(".site-header").addClass("fixe");
				};
		} 
		if ($(window).scrollTop() <= _top/2) {
			// bandeau normal
			if ($(".site-header").hasClass("fixe")) {
				$(".site-header").removeClass("fixe");
				} ;	
		}
	}
	if($('.site-header').length && screen.availWidth <= 780) {
		// taille logo gérée dans header.php et css
		if ($(window).scrollTop() >= 5) {
			if ($("BODY").hasClass("admin-bar")) {$(".site-header").css("top",'0px');};
		}
		if ($(window).scrollTop() < 4) {
			if ($("BODY").hasClass("admin-bar")) {$(".site-header").css("top",'46px');};
		}
	}
}


/* Ouvrir un CV-Grid Post en Modal Win */
/* Ouvrir un Event Post en Modal Win */
$(".infos .pt-cv-wrapper .pt-cv-grid A, .vsel-meta-title A, .mwl").click(function(e){
	var mdlw = '  <div class="modal fade" id="myModal"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><button type="button" class="close mdlwclose" data-dismiss="modal">&times;</button></div><div class="modal-body"><p>...</p></div><button class="fermer">Fermer</button></div></div></div><div class="modal-backdrop fade in"></div>';
	//
	e.preventDefault();
	// initialisation MW avec un contenu transitoire
	if(! $("#myModal").length) { 	$("BODY").append(mdlw); }
	var a = $(this).attr("href"), H = screen.availHeight, offset = $(this).offset().top - 100;
	$("#myModal .modal-body").html("<header class='entry-header'> <h1 class='entry-title'>. . .</h1></header>");		
	$("#myModal").addClass("in");
	$("#myModal, .modal-backdrop").addClass("in");
	$(".modal-header, .modal button").click(function(){
		$("#myModal, .modal-backdrop").removeClass("in");
		$('html,body').animate({'scrollTop' : offset}, 10); // pour ramener au bon niveau une fois MW fermé
		}); 
	//
	// Chargement du contenu en async
	$.ajax({
		url : a,
		type : 'POST',			  /* voir single.php */
		data: { mw : 'mw' },  /* permet de différencier l'appel normal du Post */  
		success : function(rep) {  
			$("#myModal .modal-body").html(rep);	
			//$(".modal").css("max-height", (H * .85) +"px");
			//$(".modal-body").css("max-height", (H * .7) +"px");
		}
	});
});





/* sousmenu escamotable en mode mobile */
$("UL.menu > LI > A").click(function(e){ /* test click niveau 1 */
	if(screen.availWidth < 780) {
		e.preventDefault();
		var a = $(this).parent().children(".sub-menu");
		if (a.hasClass("shown")) {
			a.removeClass("shown");
		} else {
			$(".sub-menu").removeClass("shown");
			a.addClass("shown");
		};
	}
});

/* Formatage de la date des Events pour application de styles */
$(".vsel-meta > .vsel-meta-date").each(function(){
	var v = $(this).text().split(' ');
	if(v.length==3) {
		$(this).html("<div><div>"+v[0]+"</div>"+v[1]+"</div>");
	}
});


/* Traitement des logos Partenaires
/* ils sont issus de MCM 'partenaires' et le shortcode est intégré dans DIV.partenaires
/* - attribut.Title
/* - Click sur logo pointe vers url logée dans Légende
DIV.gallery-icon
   A
      IMG
DD.wp-caption-text
*/
$(".partenaires .gallery-icon IMG").each(function(){
	$(this).attr("title", $(this).attr("alt"));
	var alt = $(this).parent().parent().next("DD.wp-caption-text").text().replace(/\t/g, '').replace(/\n/g, '');
	$(this).parent().attr("href", alt).attr("target", "_blank");
});


/* Affichage date heure fête météo en page d'accueil
*/
if ($(".ephemeride").length) {
	 var timer=setInterval("Horloge()", 1000),
		d = new Date();
	Horloge();
	// Fête du jour
	// initialement:  <script type="text/javascript" src="//www.net-pratique.fr/services/saintdujour.php"></script>
	//if($(".ephemeride .nplien").length) {$(".ephemeride .nplien").attr("onclick","");}
	// Calcul local..
	if($(".ephemeride .fete").length) {$(".ephemeride .fete").html( ephemeris.getEphemeris( d.getDate(), d.getMonth()+1));}
	// Prévisions météo
	// faire un $_get de test-api-meteo.php et régler les styles
	$.get( "test-api-meteo.php", { e: 2 } ) 
		  .done(function( data ) {
			$("#mto").html(data);
		  })
		  .fail(function( data ) {
		  });
	
}
} )( jQuery );

function Horloge() {
	var d = new Date(),
		jour = ["dimanche","lundi","mardi","mercredi","jeudi","vendredi","samedi"],
		mois = ["janvier","février","mars","avril","mai","juin","juillet","août","septembre","octobre","novembre","décembre"]
		;
	document.getElementById("jhf").innerHTML =  jour[d.getDay()] + " " +d.getDate() + " " + mois[d.getMonth()] + " " + d.getFullYear() + "<span>" + d.getHours() + "h"+ (d.getMinutes()<10?'0':'')+d.getMinutes() + ":"+ (d.getSeconds()<10?'0':'')+ d.getSeconds() + "</span>";
}









