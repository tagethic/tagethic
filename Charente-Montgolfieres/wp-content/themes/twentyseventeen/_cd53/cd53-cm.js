/*
 * DC avril 2017 - Charente Montgolfières
 * 0545670145 ou 0613298032 ou 0609935714
 */
(function( $ ) {
	
	// Affichage du social-navigation en différé.. à cause du temps de calcul
	var t0 = setTimeout(function(){   
		$(".site-header >.social-navigation").addClass("socon"); 
		setTarget(); }, 700);
	function setTarget() {
		// Numéros de tél au survol menu social
		var phone = $("A[href='#phone']"), tels = $("#tels");
		if ( phone.length && tels.length ) {
			phone.mouseover(function() {
				$("#tels").show();
			}).mouseout(function() {
				$("#tels").hide();
			})	;
		}
	}
	$(".social-navigation A").each(function() {
			// tous les boutons exceptés #phone
			var u = $(this).attr("href").indexOf("#phone");
			if (u == -1) { u = $(this).attr("href").indexOf("/nous-contacter"); };
			// if (u == -1) { u = $(this).attr("href").indexOf("facebook."); };
			// if (u == -1) { u = $(this).attr("href").indexOf("youtube."); };
			// uniquement sur ordi
			if($(window).innerWidth() > 767 && (u == -1))  {$(this).attr("target","_blank");}
		});
	
	// Target = MONTG  pour tous les liens A href n'ayant pas de target:_blank de positionné
	$("A").each(function() {
		if( $(this).attr("href") !== "#" 
			&& $(this).attr("href") !== "#phone" 
			&& $(this).attr("target") !== "_blank" 
			&& $(window).innerWidth() > 767 
		)  {$(this).attr("target","MONTG");}
	});
	
	// Correction href ne comportant que #
	$("A[href='#']").each(function() {
		$(this).attr("href", "javascript:;").attr("onclick", "return false");
	});
	
	//
	// Formulaire de Contact 
	//
	$(".nous-contacter .wpcf7-form INPUT[type=submit], .formrens .wpcf7-form INPUT[type=submit]").attr("disabled", "disabled").addClass("btn-disabled");
	$(".wpcf7-form INPUT[name=emailconf]").attr("onpaste", "return false;");
	// Le bouton d'Envoi ne doit être valide que lorsque les deux champs emails sont équivalents et non-vides
	var emails = false;
	$(".nous-contacter .wpcf7-form INPUT[type=email]").change(function() {
		var email = $(".nous-contacter .wpcf7-form INPUT[name=email]"),
		emailc = $(".nous-contacter .wpcf7-form INPUT[name=emailconf]"),
		sub = $(".nous-contacter .wpcf7-form INPUT[type=submit]");
		
		if ( email.val() == emailc.val() && email.val() !== "" ) { 
			sub.removeAttr("disabled").removeClass("btn-disabled");
			emailc.removeClass("incomplet");
			emails = true;
			
		} else {
			sub.attr("disabled", "disabled").addClass("btn-disabled");
			emailc.addClass("incomplet"); 
		}
	});
	// 
	// Formulaire - Fiche de renseignements
	//
	$(".formrens .wpcf7-form INPUT[type=email], .formrens .wpcf7-form INPUT[type=checkbox]").change(function() {
		var email = $(".formrens .wpcf7-form INPUT[name=email]"),
		emailc = $(".formrens .wpcf7-form INPUT[name=emailconf]"),
		cgv = $(".formrens .wpcf7-form INPUT[type=checkbox]"),
		sub = $(".formrens .wpcf7-form INPUT[type=submit]");
		
		if ( email.val() == emailc.val() && email.val() !== "" ) { 
			if ( cgv.is(':checked')  ) { sub.removeAttr("disabled").removeClass("btn-disabled"); }
			emailc.removeClass("incomplet");
			emails = true;
		} else {
			sub.attr("disabled", "disabled").addClass("btn-disabled");
			emailc.addClass("incomplet"); 
		}
	});
	
	
	//
	// Ajax - Liste des Pays
	//
	var listepays = [
      "ActionScript",
      "AppleScript",
      "Asp",
      "BASIC",
      "C",
      "C++",
      "Clojure",
      "COBOL",
      "ColdFusion",
      "Erlang",
      "Fortran",
      "Groovy",
      "Haskell",
      "Java",
      "JavaScript",
      "Lisp",
      "Perl",
      "États-Unis",
      "PHP",
      "Python",
      "Ruby",
      "Scala",
      "Scheme"
    ];
	// $( "#pays" ).autoComplete({
      // source: listepays
    // });
	$("#pays").on('change keyup paste', function () {
		// doFiltre();
	});

	function doFiltre() {
		
		var str = $("#pays").val().toLowerCase(),
		ext = $.grep( listepays , function( n, i ) {  return (n.toLowerCase().indexOf(str) == 0); }),
		out = '<select id=\"selectPays\" multiple>';
		for(i=0;i<ext.length;i++) { out += "<option>"+ext[i]+"</option>"; }
		out += "</select>";
		
		if(! $("#selectPays").length ) {$("#pays").after(out); }
		var sel = $("#selectPays");
		sel.show();  
		sel.blur(function(){sel.hide();});
		$("#selectPays OPTION").click(function() { $("#pays").val( $(this).text() ); sel.hide(); });
	}
	
	
	
	
	// sub menu to toggle on click
	// DC : voir navigation.js dans theme\assets\js
	
	/*
	$(".btn-print").click(function() {
		if(! $(this).hasClass("btn-disabled") ) { window.print(); }
	});
	*/
	
	// test .formrens onSubmit
	var wpcf7Elm = document.querySelector( '.formrens .wpcf7' );
	if (wpcf7Elm) {
		wpcf7Elm.addEventListener( 'wpcf7mailsent', function( event ) {  // wpcf7submit
			sub = $(".formrens .wpcf7-form INPUT[type=submit]");
			sub.attr("disabled", "disabled").addClass("btn-disabled");
			window.print();
			return false;
		}, false );
	}
	
	/*
	 * à propos : rendre les boites cliquables
	 */
	 $(".apropos DIV").each(function() {
		 var a = $("A:first", this).attr("href");
		 $(this).click(function() { location.assign(a);});
	 });
	
	// goto smoothly
	$("A[href^='#']").click(function (e) {
		var a = $(this).attr("href"),
			t = ( $(a).length ? $(a).offset().top - 80 : -1 );
			e.preventDefault();
			if(t> -1) { 
				$('html,body').animate({'scrollTop' : t}, 1000);
			}
		});
	// goto Top
	// if(! $("#gotoTop").length) {$("body").append("<div id='gotoTop'>^</div>");}
	$(window).scroll(function() {
		if ($(this).scrollTop() >= 150) {        
			$('#gotoTop').fadeIn(200); 
		} else {
			$('#gotoTop').fadeOut(200);  
		}
	});
	$('#gotoTop').click(function() {  
		$('body,html').animate({
			scrollTop : 0            
		}, 500);
	});
	
	// Ouverture en MW
	function ouvreMW( lien, e ) {
		var mdlw = '  <div class="modal fade" id="myModal"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><button type="button" class="close mdlwclose" data-dismiss="modal">&times;</button></div><div class="modal-body"><p>...</p></div><button class="fermer">Fermer</button></div></div></div><div class="modal-backdrop fade in"></div>';
		//
		e.preventDefault();
		event.stopImmediatePropagation();
		// initialisation MW avec un contenu transitoire
		if(! $("#myModal").length) { 	$("BODY").append(mdlw); }
		var a = lien.attr("href"), H = screen.availHeight, offset = lien.offset().top - 100;
		$("#myModal .modal-body").html("<header class='entry-header'> <h1 class='entry-title'>. . .</h1></header>");		
		$("#myModal").addClass("in");
		$("#myModal, .modal-backdrop").addClass("in");
		$(".modal-header, .modal button, .modal-backdrop").click(function(){
			$("#myModal, .modal-backdrop").removeClass("in");
			$("BODY").removeClass("modalOn");
			//$('html,body').animate({'scrollTop' : offset}, 10); // pour ramener au bon niveau une fois MW fermé
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
				$("BODY").addClass("modalOn");
			}
		});
		
		return false;
		
	}
	
})( jQuery );
	