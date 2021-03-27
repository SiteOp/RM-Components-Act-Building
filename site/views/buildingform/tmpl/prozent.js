  // Funktion zum berechnen der Summe 
    (function( $ ){ 
        $.fn.sum=function () {
            let sum=0;
            $(this).each(function(index, element){
                if($(element).val()!="")
                    sum += parseFloat($(element).val());
            });
         return sum;
        }; 
    })( jQuery );

    // Progressbar erstellen
    function makeProgress(percent_sum){
        $("#progress").removeClass();
        $("#progress").css("width", percent_sum + "%").text(percent_sum + " %");
        if (percent_sum > 100){
            $("#progress").addClass('progress-bar progress-bar-striped bg-danger');
        }
        else if (percent_sum == 100){
            $("#progress").addClass('progress-bar progress-bar-striped bg-success');
        }
        else if(percent_sum > 70) {
            $("#progress").addClass('progress-bar progress-bar-striped bg-info');
        }
        else {
            $("#progress").addClass('progress-bar progress-bar-striped'); 
        }
    }

	// Falls keine Nummer oder Wert dann 0
	function check(x) { 
		if($.isNumeric(x) && x >= 0) {
			return x;
		}
		else {
			return 0;
		}
	};

	function loadData() { 
		let routestotal = $('#jform_routestotal').val();    // Hole die Routenanzahl Total
		let total_line = $('#total_lines ').text();			// Hole die Gesamtzahl der Linien 
		let density = (parseFloat(routestotal/total_line).toFixed(1)); // Routendichte berechnen
		$('#density').text(check(density));				   // Routendichte eintragen
		let sum_percent =  $('#percent_val input').sum();	// Summe der Prozentwerte
		$('#jform_percent').val(sum_percent);			    // Sum/Prozente in das Inputfield der Progressbar eintragen. Formular kann bei über 100 nicht gesendet werden
		makeProgress(sum_percent); 							// Funktion der Progressbar aufrufen
		let percent0 =  (100 - sum_percent);				// Wenn nicht 100% dann Restwert als Percent0 
		let percent3  = check($('#percent3').val());
		let percent4  = check($('#percent4').val());
		let percent5  = check($('#percent5').val());
		let percent6  = check($('#percent6').val());
		let percent7  = check($('#percent7').val());
		let percent8  = check($('#percent8').val());
		let percent9  = check($('#percent9').val());
		let percent10 = check($('#percent10').val());
		let percent11 = check($('#percent11').val());
		let percent12 = check($('#percent12').val());

		// Erstelle ein Object mit den Werten Grad und Prozentwerte
		let obj_percent = {'0': percent0,'3':percent3, '4':percent4,'5':percent5,'6':percent6, '7':percent7,'8':percent8,'9':percent9, '10':percent10,'11':percent11,'12':percent12};
		let json_percent = JSON.stringify(obj_percent);		// Konvertierung  JS object to JSON string
		$('#percentsoll').val(json_percent);  				// Werte als Value des Hidden Fields percentsoll verwenden
		let total3  = ((routestotal/100) * percent3);       // Berechnung der Routenanzahl ((Gesamt Routenanzahl / 100) X Prozentwert)
		let total4  = ((routestotal/100) * percent4);
		let total5  = ((routestotal/100) * percent5);
		let total6  = ((routestotal/100) * percent6);
		let total7  = ((routestotal/100) * percent7);
		let total8  = ((routestotal/100) * percent8);
		let total9  = ((routestotal/100) * percent9);
		let total10 = ((routestotal/100) * percent10);
		let total11 = ((routestotal/100) * percent11);
		let total12 = ((routestotal/100) * percent12);
		$('#routes_grade3').val(parseFloat(total3).toFixed(1));// Trage die berechnete Routenanzahl in das Readonly-Field
		$('#routes_grade4').val(parseFloat(total4).toFixed(1));
		$('#routes_grade5').val(parseFloat(total5).toFixed(1));
		$('#routes_grade6').val(parseFloat(total6).toFixed(1));
		$('#routes_grade7').val(parseFloat(total7).toFixed(1));
		$('#routes_grade8').val(parseFloat(total8).toFixed(1));
		$('#routes_grade9').val(parseFloat(total9).toFixed(1));
		$('#routes_grade10').val(parseFloat(total10).toFixed(1));
		$('#routes_grade11').val(parseFloat(total11).toFixed(1));
		$('#routes_grade12').val(parseFloat(total12).toFixed(1));
		let routes3  = check($('#routes_grade3').val());      // Var für das JSON Objekt der Routen
		let routes4  = check($('#routes_grade4').val());
		let routes5  = check($('#routes_grade5').val());
		let routes6  = check($('#routes_grade6').val());
		let routes7  = check($('#routes_grade7').val());
		let routes8  = check($('#routes_grade8').val());
		let routes9  = check($('#routes_grade9').val());
		let routes10 = check($('#routes_grade10').val());
		let routes11 = check($('#routes_grade11').val());
		let routes12 = check($('#routes_grade12').val());
		let routes_undified = (routestotal - $('#allroutes input').sum() ); // Wenn nicht 100% dann übrige Routen

		// Erstelle ein Object mit den Werten Grad und Routenanzahl
		let obj_routes = {'3':routes3, '4':routes4,'5':routes5,'6':routes6, '7':routes7,'8':routes8,'9':routes9, '10':routes10,'11':routes11,'12':routes12,'13':routes_undified};
		let json_routes = JSON.stringify(obj_routes);		// Konvertierung  JS object to JSON string
		$('#routessoll').val(json_routes);  				// Werte als Value des Hidden Fields routessoll verwenden
		//console.log(json_routes);
	};
	$(document).ready(function () {                          // Beim Laden die Daten holen und eintragen
			loadData();
	});
	$('#gradetable, #jform_routestotal').change(function() { // Nach Veränderung der Daten nochmals die Daten holen
		loadData();
	});