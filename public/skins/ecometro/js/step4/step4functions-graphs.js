// Shortcut with fail-safe usage of $. Keep in mind that a reference
// to the jQuery function is passed into the anonymous function.
// Use $() without fear of conflicts.
jQuery(function ($) {

	var data1 = [   
	    [1.5, 20],
	    [5.5, 20],
	    [9.5, 20],	  	   	    	    
	    [13.5, 20],
	    [17.5, 20],	    
	];

	var data2 = [   
	    [2.5, 11],	   
	    [6.5, 11],	 
	    [10.5, 11],
	    [14.5, 11],	 
	    [18.5, 11],    
	];

	var data3 = [   
	    [1.5, 20],
	    [5.5, 20],
	    [9.5, 20],	  	   	    	    
	    [13.5, 20],
	    [17.5, 20],
	];

	var data4 = [   
	    [2.5, 11],	   
	    [6.5, 11],	 
	    [10.5, 11],
	    [14.5, 11],	 
	    [18.5, 11],	 
	];
 	
 	var data5 = [   
	    [1.5, 25],	    
	];

	var data6 = [   
	    [2.5, 20],	    
	];

	var dataset1 = [
	    { label: "Calentamiento global", data: data1, hoverable: false },
	    { label: "Energía primaria", data: data2, yaxis: 2, hoverable: false}
	];

	var dataset2 = [
	    { label: "Calentamiento global", data: data3, hoverable: false },
	    { label: "Energía primaria", data: data4, yaxis: 2, hoverable: false}
	];

	var dataset3 = [
	    { label: "Calentamiento global", data: data5, hoverable: false },
	    { label: "Energía primaria", data: data6, yaxis: 2, hoverable: false}
	];

	var ticks1 = [
    	[2, "Prod1"], [6, "Prod2"], [10, "Prod3"], [14, "Prod4"], [18, "Prod5"]];
    var	ticks2 = [
    	[2, "Cimentaciones"], [6, "Estructuras"], [10, "Cerramientos"], [14, "Prod4"], [18, "Prod5"]];
   var ticks3 = [[2, "Total"]]; 	
 
 	var options1 = {
		series: {
			bars: {
				align: 'center',
				show: true,				
				lineWidth: 0,                
                fillColor: {
                    colors: [{
                        opacity: 1
                    }, {
                        opacity: 1
                    }]
                }				
			}
		},
		bars: {
			align: "center",
			barWidth: 1
		},
		xaxis: {
			min: 0,
			max: 20,			
            ticks: ticks1,
            tickLength: 0
        },
        yaxes: [{min: 0,
        	max: 30,
            axisLabel: "Calentamiento global<br> [kgCO2-eq.]",
            axisLabelUseHtml: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial',
            axisLabelPadding: 3
        }, {min: 0, max: 30,axisLabel: "Energía primaria<br> [MJ]",
            axisLabelUseHtml: true, position: "right"}],
        legend: {            
            labelBoxBorderColor: "#000000",
            position: "nw",
            container: $('.legends')
        },
        grid: {
            hoverable: false,
            borderWidth: 1,
            backgroundColor: null,            
        },
        colors: ["#000000", "#555555"]
    };

    var options2 = {
		series: {
			bars: {
				align: 'center',
				show: true,				
				lineWidth: 0,                
                fillColor: {
                    colors: [{
                        opacity: 1
                    }, {
                        opacity: 1
                    }]
                }				
			}
		},
		bars: {
			align: "center",
			barWidth: 1
		},
		xaxis: {
			min: 0,
			max: 20,				
            ticks: ticks2,
            tickLength: 0
        },
        yaxes: [{
        	min: 0,
        	max: 30,
            axisLabel: "Calentamiento global<br> [kgCO2-eq.]",
            axisLabelUseHtml: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial',
            axisLabelPadding: 3
        }, {min: 0, max: 30, axisLabel: "Energía primaria<br> [MJ]",
            axisLabelUseHtml: true, position: "right"}],
        legend: {            
            labelBoxBorderColor: "#000000",
            position: "nw",
            container: $('.legends')
        },
        grid: {
            hoverable: false,
            borderWidth: 1,
            backgroundColor: null,            
        },
        colors: ["#000000", "#555555"]
    };

    var options3 = {
		series: {
			bars: {
				align: 'center',
				show: true,				
				lineWidth: 0,                
                fillColor: {
                    colors: [{
                        opacity: 1
                    }, {
                        opacity: 1
                    }]
                }				
			}
		},
		bars: {
			align: "center",
			barWidth: 1
		},
		xaxis: {		
			min: 0,
			max: 4,	
            ticks: ticks3,
            tickLength: 0
        },
        yaxes: [{
        	min: 0,
        	max: 30,
            axisLabel: "Calentamiento global<br> [kgCO2-eq.]",
            axisLabelUseHtml: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial',
            axisLabelPadding: 3
        }, {min: 0, max: 30,axisLabel: "Energía primaria<br> [MJ]",
            axisLabelUseHtml: true, position: "right"}],
        legend: {            
            labelBoxBorderColor: "#000000",
            position: "nw",
            container: $('.legends')
        },
        grid: {
            hoverable: false,
            borderWidth: 1,
            backgroundColor: null,            
        },
        colors: ["#000000", "#555555"]
    };
	
	if($("#placeholder").length) {
		$.plot("#placeholder", dataset1, options1);
	}

	if($("#placeholder1").length) {
		$.plot("#placeholder1", dataset2, options2);
	}
	
	if($("#placeholder2").length) {
		$.plot("#placeholder2", dataset3, options3);
	}
	
	// Add the Flot version string to the footer
	$("#footer").prepend("Flot " + $.plot.version + " &ndash; ");
});