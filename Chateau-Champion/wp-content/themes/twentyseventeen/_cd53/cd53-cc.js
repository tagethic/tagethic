
(function( $ ) {
	// Actions des boutons du disclaimer
	// script permettant de fixer la variable de session.
	$(".btn-oui").click(function(){
		
		 $.get( "/setnodsclm.php", { e: 'ok' } ) 
		  .done(function( data ) {
			$("#dsclm").remove();
			$("#odsclm").remove();
			$("BODY").removeClass("dsclm");
		  })
		  .fail(function( data ) {
		  });
		
	});
	$(".btn-non").click(function(){
		$("#dsclm P:nth-child(2)").html("Vous n'êtes pas majeur. <br>Vous ne pouvez pas entrer dans le site. ");
		$("#dsclm P:nth-child(3)").html(" ");
	});
	
	// Affichage du social-navigation en différé.. à cause du temps de calcul
	var t0 = setTimeout(function(){   
		$(".site-header >.social-navigation").addClass("socon"); 
		//$(".social-navigation").slideToggle(""); 
		setTargetBlank(); }, 700);
	function setTargetBlank() {
		$(".social-navigation A").each(function() {
			// var u = $(this).attr("href").indexOf("http");
			var u = $(this).attr("href").indexOf("tripadvisor.");
			if (u == -1) { u = $(this).attr("href").indexOf("facebook."); };
			if (u>=0) {$(this).attr("target","_blank");}
		});
	}
	
	// Correctif href sur icone flag Fr
	$("A[href$='/fr/'").each(function() {
		var h = $(this).attr("href");
		$(this).attr("href", h.replace('/fr/',''));
	});
	// Correctif H2 SPAN - Commercialisation
	// Ajout d'une puce numéro carrée
	var xCx=1;
	$("H2.trfs").each(function() {
		$(this).prepend("<span>"+xCx+"</span> ");
		xCx++;
	});
	/* Traitement des logos Partenaires
	/* ils sont issus de MCM 'partenaires' et le shortcode doit être intégré dans DIV.partenaires
	/* - attribut.Title de l'Image
	/* - Click sur logo pointe vers url logée dans Légende
	DIV.gallery-icon
	   A
		  IMG
	DD.wp-caption-text
	*/
	$(".partenaires .gallery-icon IMG").each(function(){
		var a = $(this).attr("alt"),
			t = $(this).parent().parent().next("DD.wp-caption-text"),
			alt = t.text().replace(/\t/g, '').replace(/\n/g, '');
		// IMG.title = IMG.Alt
		$(this).attr("title", a);
		// correctif du lien sur IMG + target=_blank
		$(this).parent().attr("href", alt).attr("target", "_blank");
		// Nouvelle légende de IMG affichée
		t.text( $(this).attr("alt") );
	});
	
	

	// Grille tarifaire en fonction des pays
	var txtFrLivraison='', 
	consigne='',
	// mdlLivr = "<b>Pour une livraison à l'étranger : {pays}</b><p></p><ul><li>Le carton de 12 bouteilles : {cout} &euro; TTC</li></ul><p class='rouge'>Prix du port : 1 magnum = 2 bouteilles<br>Emballage carton compris pour des <b>lots de 1, 3, 6, 12 bouteilles</b></p>",
	// mdlLivr = "<b>Pour une livraison à l'étranger : {pays}</b><p></p><ul><li>Le carton de 12 bouteilles : {cout} &euro; TTC</li></ul>",
	mdlLivr = "<b>Pays sélectionné: {pays}</b><p></p>",
	paysSelectionne;
	$( "select#listepays" ).change(function() {
		$( "select#listepays option:selected" ).each(function() {
			if( $("#flivraison").length ) {
				// Sauvegarde du contenu pour la France..
				if (txtFrLivraison=='' ) { txtFrLivraison= $("#flivraison").html(); }
				if (consigne=='' ) { consigne= $("#consigne").html(); }
				//
				var pays = $( this ).text(), val =  $( this ).attr("value");
				paysSelectionne = pays;
				if (val=='fr') { $("#flivraison").html( txtFrLivraison ); }
				else { $("#flivraison").html( mdlLivr.replace('{pays}', pays).replace('{cout}', val ) + "<p class='rouge'>"+ consigne+"</p>" ); }
				CalculeQtes();
			}
		});
	  })
	  .trigger( "change" );
	  
	// Calcul des Quantités sélectionnées et résumé dans #msel
	$(".millesimes.selection INPUT").change(function() {
		CalculeQtes();
	});
	
	// Calcule des Quantités 
	// et Ajout du Pays sélectionné dans #msel
	function CalculeQtes() {
		var out="";
		$(".millesimes.selection INPUT").each(function(e) {
			var v = Number( $(this).val() ),
				  u = $(this).data("unit");
			if (v!=="" && v!==0) {
				if(v <=1) { u = u.replace("(s)",""); }
				out += $(this).data("aoc") + " : &nbsp; " + v + " " + u +(v>1?"s":"")+ "\n";
			}
		});
		out += (paysSelectionne!==""?"\nPays sélectionné : " +paysSelectionne:"");
		$("#msel").html( out );
	}
	
	// Calcul des Activités sélectionnées et résumé dans #msel
	$(".oeno-selection INPUT").change(function() {
		CalculeActivites();
	});
	function CalculeActivites() {
		var out="", obj = [], xx;
		$(".oeno-selection INPUT").each(function(e) {
			// params : nb_person, date_souhaitée, EN|FR
			// data : c (clé pour concordance), oeno (titre activité)
			var a=false, v = $(this).val(),
			   c = $(this).data("c"),
			   t = ($(this).data("oeno")?$(this).data("oeno"):false);
			switch($(this).attr("type")) {
				case 'text' : 
					if($(this).attr("name")=="date") { a = "date";}
					if($(this).attr("name")=="qte") { a = "personnes";}
					break;
				case 'radio' : 
					if($(this).attr("checked")) { a = "langue"; } 
					break;
				}
			if(! obj[c]) obj[c] = [];
			if(a) { obj[c][a] = v; }
			if(t) { obj[c]["titre"] = t; }
		});
		// On parcourt le tableau Obj pour ne retenir que les items dont le nb personnes != ""
		for(x=0;x<obj.length;x++){
			xx = obj[x];
			if(xx.personnes!=="") { out+=" * "+xx.titre+"\n  - Pour "+xx.personnes+" personne"+(xx.personnes>1?"s":"")+"\n  - Date souhaitée : "+(xx.date?xx.date:" non précisée")+"\n  - En "+(xx.langue=="EN"?"anglais":"français")+"\n \n"; }
		}
		$("#msel").html( out );
	}  
	
	// goto smoothly
	$("A[href^='#']").click(function (e) {
		var a = $(this).attr("href"),
			t = $(a).offset().top - 80;
			e.preventDefault();
			$('html,body').animate({'scrollTop' : t}, 1000);
		});
	// goto Top
	//if(! $("#gotoTop").length) {$("body").append("<div id='gotoTop'>^</div>");}
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


