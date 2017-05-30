/*
 * DC avril 2017 - Charente Montgolfières
 * 0545670145 ou 0613298032 ou 0609935714
 * V1 : 17 mai 2017
 * V1a : ajout masque de saisie DateN
 */
 var scripts_url = "http://tagethic.fr/c/charente-montgolfieres/wp-content/themes/twentyseventeen/_cd53/";
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
				var t = $(this).offset().top - 120;
				tels.offset({ top: Math.round(t) });
				$("#tels:hidden").show();
			}).mouseout(function() {
				$("#tels:visible").hide();
			})	;
			// $("#tels").click(function() { $("#tels").hide(); });
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
	//
	// Formulaire - Fiche de renseignements
	//
	// 17 mai : ajout test saisie 'daten'  
	var vEmails=false, vDaten=false, vCGV=false, vNom=false, vPrenom=false, vPoids=false, vTaille=false, vPhone=false, vPays=true, vAdresse=false;
	var paysSelectionne="France";
	$(".formrens .wpcf7-form INPUT[name=daten]").change(function() {
		// RegExp : test with https://regex101.com/
		var re = /^[0-9]{1,2}[/]{1}[0-9]{1,2}[/]{1}[0-9]{4}$/;
		var x = $(this).val().split("/"),
		err = "",
		daten = $(this);
		vDaten = false;
		if (re.test( daten.val() )) {
			// format à tester : jj/mm/aaaa
			if ( ( x[0] >0 && x[0] <= 31) && ( x[1] >0 && x[1] <= 12) && ( x[2] >1920 && x[2] <= 2020) ) { 
				vDaten = true;
			} else {
				if ( x[0] < 0 || x[0] > 31 ) { err += '<span role="alert" class="wpcf7-not-valid-tip err">Le jour est incorrect : '+x[0]+'</span>'; }
				if ( x[1] > 12 ) { err += '<span role="alert" class="wpcf7-not-valid-tip err">Le mois est incorrect : '+x[1]+'</span>'; }
				if ( x[2] < 1920 || x[2] > 2020 ) { err += '<span role="alert" class="wpcf7-not-valid-tip err">Êtes-vous sûr de l\'année de naissance : '+x[2]+'</span>'; }
			}
		}
		if($(".err").length) {$(".err").remove(); }
		if(! vDaten) {
			if (err == "") {	err = '<span role="alert" class="wpcf7-not-valid-tip err">Format de date incorrect. Exemple : 31/01/1977</span>'; }
			daten.after( err );
		}
	});
	$(".formrens .wpcf7-form INPUT[type=checkbox]").change(function() {
		var cgv = $(this);
		if ( cgv.is(':checked')  ) { vCGV = true; } else { vCGV = false; }
		if($(".err").length) {$(".err").remove(); }
		if(! vCGV) {
			var err = '<span role="alert" class="wpcf7-not-valid-tip err">Vous devez accepter les C.G.V.</span>';
			cgv.after( err );
		}
	});
	$(".formrens .wpcf7-form INPUT[name=nom]").change(function() {
		var nom = $(this);	
		// RegExp : test with https://regex101.com/
		var re = /^[^&<>,?;.:/!§%*µ$£^¨+=})\]@\\_|\[\(\{#~0-9]+$/,
			err = "";
		vNom = false;
		if (! re.test( nom.val() )) {  err = '<span role="alert" class="wpcf7-not-valid-tip err">Le nom est incorrect.</span>'; }
		else { vNom = true; }
		if($(".err").length) {$(".err").remove(); }
		if(! vNom) {
			if( err=="") { err = '<span role="alert" class="wpcf7-not-valid-tip err">Vous devez entrer un nom.</span>'; }
			nom.after( err );
		}
	});
	$(".formrens .wpcf7-form INPUT[name=prenom]").change(function() {
		var prenom = $(this);
		// RegExp : test with https://regex101.com/
		var re = /^[^&<>,?;.:/!§%*µ$£^¨+=})\]@\\_|\[\(\{#~0-9]+$/,
			err = "";
		vPrenom = false;
		if (! re.test( prenom.val() )) {  err = '<span role="alert" class="wpcf7-not-valid-tip err">Le prénom est incorrect.</span>'; }
		else { vPrenom = true; }
		if($(".err").length) {$(".err").remove(); }
		if(! vPrenom) {
			if( err=="") { err = '<span role="alert" class="wpcf7-not-valid-tip err">Vous devez entrer un prénom.</span>'; }
			prenom.after( err );
		}
	});
	$(".formrens .wpcf7-form INPUT[name=poids]").change(function() {
		var poids = $(this);
		// RegExp : test with https://regex101.com/
		var re = /\d+/,
			err = "";
		vPoids = false;
		if (! re.test( poids.val() )) {  err = '<span role="alert" class="wpcf7-not-valid-tip err">Le poids semble incorrect.</span>'; }
		else { vPoids = true; }
		if( poids.val() < 35 )  {  err += '<span role="alert" class="wpcf7-not-valid-tip err">Êtes-vous sûr du poids indiqué ?</span>';  vPoids = false; }
		if( poids.val() > 150 )  {  err += '<span role="alert" class="wpcf7-not-valid-tip err">Êtes-vous sûr du poids indiqué ?</span>';  vPoids = false; }
		if($(".err").length) {$(".err").remove(); }
		if(! vPoids) {
			if( err=="") { err = '<span role="alert" class="wpcf7-not-valid-tip err">Vous devez entrer un poids.</span>'; }
			poids.after( err );
		}
	});
	$(".formrens .wpcf7-form INPUT[name=taille]").change(function() {
		var taille = $(this);
		// RegExp : test with https://regex101.com/
		var re = /\d+/,
			err = "";
		vTaille = false;
		if (! re.test( taille.val() )) {  err += '<span role="alert" class="wpcf7-not-valid-tip err">La taille semble incorrecte.</span>'; }
		else { vTaille = true; }
		if( taille.val() < 140)  {  err += '<span role="alert" class="wpcf7-not-valid-tip err">La taille indiquée en cm est inférieure à celle requise.</span>';  vTaille = false; }
		if( taille.val() > 220 )  {  err += '<span role="alert" class="wpcf7-not-valid-tip err">Êtes-vous sûr de la taille indiquée en cm ?</span>';  vTaille = false; }
		if($(".err").length) {$(".err").remove(); }
		if(! vTaille) {
			if( err=="") { err = '<span role="alert" class="wpcf7-not-valid-tip err">Vous devez entrer une taille.</span>'; }
			taille.after( err );
		}
	});
	$(".formrens .wpcf7-form INPUT[name=phone]").change(function() {
		var phone = $(this);
		// RegExp : test with https://regex101.com/
		var re = /^[+]{0,1}[0-9\(\). ]{6,20}$/,
			err = "";
		vPhone = false;
		if (! re.test( phone.val() )) {  err += '<span role="alert" class="wpcf7-not-valid-tip err">Le numéro de téléphone semble incorrect.</span>'; }
		else { vPhone = true; }

		if($(".err").length) {$(".err").remove(); }
		if(! vPhone) {
			if( err=="") { err = '<span role="alert" class="wpcf7-not-valid-tip err">Vous devez entrer un numéro de téléphone.</span>'; }
			phone.after( err );
		}
	});
	$(".formrens .wpcf7-form INPUT[type=email]").change(function() {
		var email = $(".formrens .wpcf7-form INPUT[name=email]"),
		emailc = $(".formrens .wpcf7-form INPUT[name=emailconf]"),
		err = "";		
		// test consistence emails
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		if($(".err").length) {$(".err").remove(); }
		if (! re.test( email.val() )) {
			err = '<span role="alert" class="wpcf7-not-valid-tip err">Adresse email incorrecte.</span>';
			email.after( err );
		}
		if (! re.test( emailc.val() )) {
			err = '<span role="alert" class="wpcf7-not-valid-tip err">Adresse email de confirmation incorrecte.</span>';
			emailc.after( err );
		}
		// test égalité des deux champs
		if ( email.val() == emailc.val() ) { 
			emailc.removeClass("incomplet");
			emails = true;
			vEmails = true;
		} else {
			emailc.addClass("incomplet"); 
			vEmails = false;
			err = '<span role="alert" class="wpcf7-not-valid-tip err">Les deux adresses email ne sont pas équivalentes.</span>';
			emailc.after( err );
		}
	});
	
	$(".formrens BUTTON").click(function() {
		// Vérif globale de tous les champs
		if($(".err").length) {$(".err").remove(); }
		if(! vDaten) {
			var err = '<span role="alert" class="wpcf7-not-valid-tip err">Format de date incorrect. Exemple : 31/01/1977</span>';
			$(".formrens .wpcf7-form INPUT[name=daten]").after( err );
		}
		if(! vCGV) {
			var err = '<span role="alert" class="wpcf7-not-valid-tip err">Vous devez accepter les C.G.V.</span>';
			$(".formrens .wpcf7-form INPUT[type=checkbox]").after( err );
		}
		if(! vEmails) {
			var err = '<span role="alert" class="wpcf7-not-valid-tip err">Les adresses email sont incomplètes.</span>';
			$(".formrens .wpcf7-form INPUT[name=email]").after( err );
		}
		if(! vNom) {
			var err = '<span role="alert" class="wpcf7-not-valid-tip err">Vous devez entrer un nom.</span>';
			$(".formrens .wpcf7-form INPUT[name=nom]").after( err );
		}
		if(! vPrenom) {
			var err = '<span role="alert" class="wpcf7-not-valid-tip err">Vous devez entrer un prénom.</span>';
			$(".formrens .wpcf7-form INPUT[name=prenom]").after( err );
		}
		if(! vPoids) {
			var err = '<span role="alert" class="wpcf7-not-valid-tip err">Vous devez entrer un poids.</span>';
			$(".formrens .wpcf7-form INPUT[name=poids]").after( err );
		}
		if(! vTaille) {
			var err = '<span role="alert" class="wpcf7-not-valid-tip err">Vous devez entrer une taille.</span>';
			$(".formrens .wpcf7-form INPUT[name=taille]").after( err );
		}
		if(! vPhone) {
			var err = '<span role="alert" class="wpcf7-not-valid-tip err">Vous devez entrer un numéro de téléphone.</span>';
			$(".formrens .wpcf7-form INPUT[name=phone]").after( err );
		}
		if( $("#pays").val() !== paysSelectionne ) { vPays=false; }
		if(! vPays) {
			var err = '<span role="alert" class="wpcf7-not-valid-tip err">Vous devez sélectionner un pays.</span>';
			$(".formrens .wpcf7-form INPUT[name=nationalite]").after( err );
		}
		if( $(".formrens .wpcf7-form TEXTAREA[name=adresse]").val() !== "" ) { vAdresse=true; }
		if(! vAdresse) {
			var err = '<span role="alert" class="wpcf7-not-valid-tip err">Vous devez entrer une adresse.</span>';
			$(".formrens .wpcf7-form TEXTAREA[name=adresse]").after( err );
		}
		
		// Dans le cas où tout est OK
		if( vDaten && vCGV && vEmails && vNom && vPrenom && vPoids && vTaille && vPhone && vPays && vAdresse ) { 
			window.print(); 
			if( ! $("#resetForm").length ) { 
				$(".formrens BUTTON").after( "<input type='button' id='resetForm' value='Vider les champs du formulaire'>" ); 
				$("#resetForm").click(function() {
					$(".formrens .wpcf7-form")[0].reset();
					vEmails=false; vDaten=false; vCGV=false; vNom=false; vPrenom=false; vPoids=false; vTaille=false; vPhone=false; vPays=true; vAdresse=false;
					paysSelectionne="France";
					if($(".err").length) {$(".err").remove(); }
				});
			}
		}
		
	});
	
	
	//
	// Liste des Pays
	// var listepays = []
	// 
	$("#pays").on('change keyup paste', function () {
		doFiltre();
	});
	var paysloaded=false;
	if ( $("#pays").length ) {
		var url = scripts_url+"liste-pays.js";
		$.getScript( url )
		  .done(function( script, textStatus ) {
			paysloaded=true;
		  });
	}

	function doFiltre() {
		
		if (  paysloaded && typeof listepays === "object" ) {
			if ($("#pays").val() !== "") {
				
				var str = $("#pays").val().toLowerCase(),
				ext = $.grep( listepays , function( n, i ) {  return (n.toLowerCase().indexOf(str) == 0); }),
				out = '<ul id=\"selectPays\">';
				for(i=0;i<ext.length;i++) { out += "<li>"+ext[i]+"</li>"; }
				out += "</ul>";
				
				if(! $("#select-pays-container").length ) { $("#pays").after("<div id=\"select-pays-container\"></div>");  }
				
				var sel = $("#select-pays-container");
				sel.html( out );  
				$("#selectPays").mouseover(function() { $(this).focus(); $("#pays").blur(); });
				$("#pays").mouseover(function() { $(this).focus(); });
				$('.formrens').click(function() { sel.html(''); });
				$("#selectPays LI").click(function() { $("#pays").val( $(this).text() ); sel.html(""); paysSelectionne=$(this).text(); vPays=true; });
				
			}
		}
	}
	
	
	
	
	// sub menu to toggle on click
	// DC : voir navigation.js dans theme\assets\js
	
	

	
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
	
	
})( jQuery );
	