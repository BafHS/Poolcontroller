<?php  
    $page = $_SERVER['PHP_SELF'];
    $sec = "60";
?>
<html>
	<head>
		<title>Familie Knappe Cockpit</title>
		<link rel="stylesheet" type="text/css" href="../css/pool-style.css" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<link rel="shortcut icon" href="../img/dashboard1.png" type="image/ico" />
		<link rel="icon" href="../img/dashboard1.png" type="image/ico" />
		<link rel="apple-touch-icon" href="/_icons/apple-touch-icon.png">
		<link rel="apple-touch-icon" href="/_icons/apple-touch-icon-57x57.png" sizes="57x57">
		<link rel="apple-touch-icon" href="/_icons/apple-touch-icon-60x60.png" sizes="60x60">
		<link rel="apple-touch-icon" href="/_icons/apple-touch-icon-72x72.png" sizes="72x72">
		<link rel="apple-touch-icon" href="/_icons/apple-touch-icon-76x76.png" sizes="76x76">
		<link rel="apple-touch-icon" href="/_icons/apple-touch-icon-114x114.png" sizes="114x114">
		<link rel="apple-touch-icon" href="/_icons/apple-touch-icon-120x120.png" sizes="120x120">
		<link rel="apple-touch-icon" href="/_icons/apple-touch-icon-128x128.png" sizes="128x128">
		<link rel="apple-touch-icon" href="/_icons/apple-touch-icon-144x144.png" sizes="144x144">
		<link rel="apple-touch-icon" href="/_icons/apple-touch-icon-152x152.png" sizes="152x152">
		<link rel="apple-touch-icon" href="/_icons/apple-touch-icon-180x180.png" sizes="180x180">
		<link rel="apple-touch-icon" href="/_icons/apple-touch-icon-precomposed.png">

		<script src="jquery-2.1.3.min.js"></script> 
		<script src="jquery-2.2.0.min.js"></script> 
		<script src="highcharts.js"></script> 
		<script src="highcharts-more.js"></script> 
		<script src="solid-gauge.js"></script> 
	</head>
	<body>
		<div class="thermometers">
			<center>
 <?php 

	$version = "2.0 vom 22.03.2017";
	
	// Auslesen CPU Temp
	$cputemp=file_get_contents("/sys/class/thermal/thermal_zone0/temp");
	$cputemp = sprintf("%2.0f", $cputemp / 1000);
	
	//$alertinfo="CPU Wert = ".$cputemp;
	
	//Auslesen CPU LOad
	$cpuload=sys_getloadavg();
	//Auslesen Boot Zeit Controller
	$boottime=file_get_contents('/var/www/html/boottime.txt');
	//Auslesen Druck Kanal 0
	$channel0=file_get_contents('/var/www/html/Kanal0.txt');
	//Auslesen Druck Kanal 1
	$channel1=file_get_contents('/var/www/html/Kanal1.txt');
	//Auslesen Druck Kanal 2
	$channel2=file_get_contents('/var/www/html/Kanal2.txt');
	//Auslesen Druck Kanal 3
	$channel3=file_get_contents('/var/www/html/Kanal3.txt');
	//Auslesen Druck Kanal 4
	$channel4=file_get_contents('/var/www/html/Kanal4.txt');
	//Auslesen Druck Kanal 5
	$channel5=file_get_contents('/var/www/html/Kanal5.txt');
	//Auslesen Druck Kanal 6
	$channel6=file_get_contents('/var/www/html/Kanal6.txt');

	//Auslesen Laufzeit Pumpe in Sekunden/tag
	$pumptime=file_get_contents('/var/www/html/GPIO0.txt');
	$pumpstunde=gmdate("H", $pumptime);
	$pumpminute=gmdate("i", $pumptime);
	$pumpentime=$pumpstunde . "h " . $pumpminute ."m";

	//Auslesen Laufzeit Solarbypass  in Sekunden/tag
	$pumptime=file_get_contents('/var/www/html/GPIO1.txt');
	$pumpstunde=gmdate("H", $pumptime);
	$pumpminute=gmdate("i", $pumptime);
	$solartime=$pumpstunde . "h " . $pumpminute ."m";

	//Auslesen Laufzeit UWS  in Sekunden/tag
	$pumptime=file_get_contents('/var/www/html/GPIO2.txt');
	$pumpstunde=gmdate("H", $pumptime);
	$pumpminute=gmdate("i", $pumptime);
	$uwstime=$pumpstunde . "h " . $pumpminute ."m";

	//Auslesen Laufzeit Gartenspot  in Sekunden/tag
	$pumptime=file_get_contents('/var/www/html/GPIO3.txt');
	$pumpstunde=gmdate("H", $pumptime);
	$pumpminute=gmdate("i", $pumptime);
	$gartenspottime=$pumpstunde . "h " . $pumpminute ."m";

	//Auslesen Laufzeit Gartenlampe  in Sekunden/tag
	$pumptime=file_get_contents('/var/www/html/GPIO4.txt');
	$pumpstunde=gmdate("H", $pumptime);
	$pumpminute=gmdate("i", $pumptime);
	$gartenlampetime=$pumpstunde . "h " . $pumpminute ."m";

	//Auslesen Laufzeit Gartenpumpe  in Sekunden/tag
	$pumptime=file_get_contents('/var/www/html/GPIO5.txt');
	$pumpstunde=gmdate("H", $pumptime);
	$pumpminute=gmdate("i", $pumptime);
	$gartenpumpetime=$pumpstunde . "h " . $pumpminute ."m";

	//Auslesen Laufzeit Beregnung  in Sekunden/tag
	$pumptime=file_get_contents('/var/www/html/GPIO6.txt');
	$pumpstunde=gmdate("H", $pumptime);
	$pumpminute=gmdate("i", $pumptime);
	$beregnungtime=$pumpstunde . "h " . $pumpminute ."m";

	//Auslesen Laufzeit Reinigen  in Sekunden/tag
	$pumptime=file_get_contents('/var/www/html/GPIO13.txt');
	$pumpstunde=gmdate("H", $pumptime);
	$pumpminute=gmdate("i", $pumptime);
	$reinigentime=$pumpstunde . "h " . $pumpminute ."m";

	//Auslesen Laufzeit Filtern  in Sekunden/tag
	$pumptime=file_get_contents('/var/www/html/GPIO14.txt');
	$pumpstunde=gmdate("H", $pumptime);
	$pumpminute=gmdate("i", $pumptime);
	$filtertime=$pumpstunde . "h " . $pumpminute ."m";

	//aktuelle Zeit
	$now =  date("d.m.Y  H:i");
	
	//Abfrage Sommer oder Winter Betrieb 0=Winter   1=Sommer
	exec ("gpio -g read 12", $summer, $return );
	if ($summer[0] == 0){$modus= "Winter";}
	else {$modus= "Sommer";}

	//Lesen min max werte
	$poolmin=file_get_contents('/var/www/html/poolmin.txt');
	$poolmax=file_get_contents('/var/www/html/poolmax.txt');
	$poolnow=file_get_contents('/var/www/html/poolnow.txt');
	$temppool = sprintf("%2.0f", $poolnow);
	$ruecklaufmin=file_get_contents('/var/www/html/ruecklaufmin.txt');
	$ruecklaufmax=file_get_contents('/var/www/html/ruecklaufmax.txt');
	$ruecklaufnow=file_get_contents('/var/www/html/ruecklaufnow.txt');
	$tempruecklauf = sprintf("%2.0f", $ruecklaufnow);
	$solarmin=file_get_contents('/var/www/html/solarmin.txt');
	$solarmax=file_get_contents('/var/www/html/solarmax.txt');
	$solarnow=file_get_contents('/var/www/html/solarnow.txt');
	$tempsolar = sprintf("%2.0f", $solarnow);
	$outdoormin=file_get_contents('/var/www/html/outdoormin.txt');
	$outdoormax=file_get_contents('/var/www/html/outdoormax.txt');
	$outdoornow=file_get_contents('/var/www/html/outdoornow.txt');
	$tempoutdoor = sprintf("%2.0f", $outdoornow);
	$schuppenmin=file_get_contents('/var/www/html/schuppenmin.txt');
	$schuppenmax=file_get_contents('/var/www/html/schuppenmax.txt');
	$schuppennow=file_get_contents('/var/www/html/schuppennow.txt');
	$tempschuppen = sprintf("%2.0f", $schuppennow);
	
?>
		<script>
			//function myFunction()
			//{
				//alert("<?php echo $alertinfo; ?>"); // this is the message in ""
			//}
		</script>

		<script type="text/javascript">
$(document).ready(function() {
    var pool  = {
        chart: {
            type: 'gauge',
	        backgroundColor: null,  /*Background transparent*/
	        spacingBottom: 0,
	        spacingTop: 0,
	        spacingLeft: 0,
	        spacingRight: 0,
			marginTop: 0,
			marginleft: 0,
			marginright: 0,
			marginbottom: 0,
        },
		title: {
		    text: '',
		    style: {
		        display: 'none'
		    }
		},
        pane: {
            startAngle: -90,
            endAngle: 90,
            background: [{
                backgroundColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, '#FFF'],
                        [1, '#333']
                    ]
                },
                borderWidth: 0,
                outerRadius: '109%'
            }, {
                backgroundColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, '#333'],
                        [1, '#FFF']
                    ]
                },
                borderWidth: 1,
                outerRadius: '107%'
            }, {
                // default background
            }, {
                backgroundColor: '#DDD',
                borderWidth: 0,
                outerRadius: '105%',
                innerRadius: '103%'
            }]
        },
        tooltip: {
            enabled: true
        },

    // the value axis
        yAxis: {
            minorTickInterval: 'auto',
            minorTickWidth: 1,
            minorTickLength: 10,
            minorTickPosition: 'inside',
            minorTickColor: '#666',

            tickPixelInterval: 30,
            tickWidth: 2,
            tickPosition: 'inside',
            tickLength: 10,
            tickColor: '#666',
            labels: {
                step: 2,
                rotation: 'auto'
            },
            title: {
                text: '°C'
            },
            plotBands: [{
                from: -30,
                to: 19,
                color: '#80aaff' // hellblau
            }, {
                from: 19,
                to: 31,
                color: '#00cc00' // yellow
            }, {
                from: 31,
                to: 60,
                color: '#DF5353' // red
            }]
        },
    };
    $('#pool').highcharts(Highcharts.merge(pool, {
        yAxis: {
            min: 0,
            max: 35
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Pool',
            data: [<?php  echo $temppool;?>], /////// Temp Value //////////
            dataLabels: {
                format: '<span class="thermometerslabel">{y}<strong>°</strong></span>',
                useHTML: true,
                borderWidth: 0,
            },
            tooltip: {
                valueSuffix: ' °C'
            }

        }]
    }));

    var solar  = {
        chart: {
            type: 'gauge',
	        backgroundColor: null,  /*Background transparent*/
	        spacingBottom: 0,
	        spacingTop: 0,
	        spacingLeft: 0,
	        spacingRight: 0,
			marginTop: 0,
			marginleft: 0,
			marginright: 0,
			marginbottom: 0,
        },
		title: {
		    text: '',
		    style: {
		        display: 'none'
		    }
		},
        pane: {
            startAngle: -120,
            endAngle: 120,
            background: [{
                backgroundColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, '#FFF'],
                        [1, '#333']
                    ]
                },
                borderWidth: 0,
                outerRadius: '109%'
            }, {
                backgroundColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, '#333'],
                        [1, '#FFF']
                    ]
                },
                borderWidth: 1,
                outerRadius: '107%'
            }, {
                // default background
            }, {
                backgroundColor: '#DDD',
                borderWidth: 0,
                outerRadius: '105%',
                innerRadius: '103%'
            }]
        },
        tooltip: {
            enabled: true
        },

    // the value axis
        yAxis: {
            minorTickInterval: 'auto',
            minorTickWidth: 1,
            minorTickLength: 10,
            minorTickPosition: 'inside',
            minorTickColor: '#666',

            tickPixelInterval: 30,
            tickWidth: 2,
            tickPosition: 'inside',
            tickLength: 10,
            tickColor: '#666',
            labels: {
                step: 2,
                rotation: 'auto'
            },
            title: {
                text: '°C'
            },
            plotBands: [{
                from: -30,
                to: 20,
                color: '#80aaff' // hellblau
            }, {
                from: 20,
                to: 30,
                color: '#00cc00' // yellow
            }, {
                from: 30,
                to: 60,
                color: '#DF5353' // red
            }]
        },
    };
    $('#solar').highcharts(Highcharts.merge(solar, {
        yAxis: {
            min: -20,
            max: 45
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Solar',
            data: [<?php  echo $tempsolar;?>], /////// Temp Value //////////
            dataLabels: {
                format: '<span class="thermometerslabel">{y}<strong>°</strong></span>',
                useHTML: true,
                borderWidth: 0,
            },
            tooltip: {
                valueSuffix: ' °C'
            }

        }]
    }));
    var outdoor  = {
        chart: {
            type: 'gauge',
	        backgroundColor: null,  /*Background transparent*/
	        spacingBottom: 0,
	        spacingTop: 0,
	        spacingLeft: 0,
	        spacingRight: 0,
			marginTop: 0,
			marginleft: 0,
			marginright: 0,
			marginbottom: 0,
        },
		title: {
		    text: '',
		    style: {
		        display: 'none'
		    }
		},
        pane: {
            startAngle: -120,
            endAngle: 120,
            background: [{
                backgroundColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, '#FFF'],
                        [1, '#333']
                    ]
                },
                borderWidth: 0,
                outerRadius: '109%'
            }, {
                backgroundColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, '#333'],
                        [1, '#FFF']
                    ]
                },
                borderWidth: 1,
                outerRadius: '107%'
            }, {
                // default background
            }, {
                backgroundColor: '#DDD',
                borderWidth: 0,
                outerRadius: '105%',
                innerRadius: '103%'
            }]
        },
        tooltip: {
            enabled: true
        },

    // the value axis
        yAxis: {
            minorTickInterval: 'auto',
            minorTickWidth: 1,
            minorTickLength: 10,
            minorTickPosition: 'inside',
            minorTickColor: '#666',

            tickPixelInterval: 30,
            tickWidth: 2,
            tickPosition: 'inside',
            tickLength: 10,
            tickColor: '#666',
            labels: {
                step: 2,
                rotation: 'auto'
            },
            title: {
                text: '°C'
            },
            plotBands: [{
                from: -30,
                to: 15,
                color: '#80aaff' // hellblau
            }, {
                from: 15,
                to: 28,
                color: '#00cc00' // yellow
            }, {
                from: 28,
                to: 60,
                color: '#DF5353' // red
            }]
        },
    };
    $('#outdoor').highcharts(Highcharts.merge(outdoor, {
        yAxis: {
            min: -20,
            max: 45
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Outdoor',
            data: [<?php  echo $tempoutdoor;?>], /////// Temp Value //////////
            dataLabels: {
                format: '<span class="thermometerslabel">{y}<strong>°</strong></span>',
                useHTML: true,
                borderWidth: 0,
            },
            tooltip: {
                valueSuffix: ' °C'
            }

        }]
    }));

    var schuppen  = {
        chart: {
            type: 'gauge',
	        backgroundColor: null,  /*Background transparent*/
	        spacingBottom: 0,
	        spacingTop: 0,
	        spacingLeft: 0,
	        spacingRight: 0,
			marginTop: 0,
			marginleft: 0,
			marginright: 0,
			marginbottom: 0,
        },
		title: {
		    text: '',
		    style: {
		        display: 'none'
		    }
		},
        pane: {
            startAngle: -120,
            endAngle: 120,
            background: [{
                backgroundColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, '#FFF'],
                        [1, '#333']
                    ]
                },
                borderWidth: 0,
                outerRadius: '109%'
            }, {
                backgroundColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, '#333'],
                        [1, '#FFF']
                    ]
                },
                borderWidth: 1,
                outerRadius: '107%'
            }, {
                // default background
            }, {
                backgroundColor: '#DDD',
                borderWidth: 0,
                outerRadius: '105%',
                innerRadius: '103%'
            }]
        },
        tooltip: {
            enabled: true
        },

    // the value axis
        yAxis: {
            minorTickInterval: 'auto',
            minorTickWidth: 1,
            minorTickLength: 10,
            minorTickPosition: 'inside',
            minorTickColor: '#666',

            tickPixelInterval: 30,
            tickWidth: 2,
            tickPosition: 'inside',
            tickLength: 10,
            tickColor: '#666',
            labels: {
                step: 2,
                rotation: 'auto'
            },
            title: {
                text: '°C'
            },
            plotBands: [{
                from: -30,
                to: 15,
                color: '#80aaff' // hellblau
                }, {
                from: 15,
                to: 28,
                color: '#00cc00' // grÃ¼n
            }, {
                from: 28,
                to: 60,
                color: '#DF5353' // rot
            }]
        },
    };
    $('#schuppen').highcharts(Highcharts.merge(schuppen, {
        yAxis: {
            min: -20,
            max: 45
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Schuppen',
            data: [<?php  echo $tempschuppen;?>], /////// Temp Value //////////
            dataLabels: {
                format: '<span class="thermometerslabel">{y}<strong>°</strong></span>',
                useHTML: true,
                borderWidth: 0,
            },
            tooltip: {
                valueSuffix: ' °C'
            }

        }]
    }));
	var gaugeOptions = {
		chart: {
			type: 'solidgauge',
			backgroundColor: null,
		},
		title: null,
		pane: {
			center: ['50%', '50%'],
			size: '100%',
			startAngle: -90,
			endAngle: 90,
			background: {
				backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || '#EEE',
				innerRadius: '60%',
				outerRadius: '100%',
				shape: 'arc'
			}
		},
		credits: {
			enabled: false
		},
		tooltip: {
			enabled: true
		},
	// the value axis
		yAxis: {
			stops: [
				[0.1, '#ff0000'], // red
				[0.5, '#ffff00'], // yellow
				[0.9, '#00ff00'], // green
				],
			labels: {
				enabled: true,
				distance: 0,
			},
			lineWidth: 0,
			minorTickInterval: null,
			title: {
				y: -90
			},
			labels: {
				y: +15
			}
		},
		plotOptions: {
			solidgauge: {
				innerRadius: '60%',
				outerRadius: '100%',
				dataLabels: {
					y: -37,
					borderWidth: 0,
					useHTML: true,
				}
			}
		}
};
// Druckleitung 0 Hauptleitung
    var druck0  = {
        chart: {
            type: 'gauge',
	        backgroundColor: null,  /*Background transparent*/
	        spacingBottom: 0,
	        spacingTop: 0,
	        spacingLeft: 0,
	        spacingRight: 0,
			marginTop: 0,
			marginleft: 0,
			marginright: 0,
			marginbottom: 0,
        },
		title: {
		    text: '',
		    style: {
		        display: 'none'
		    }
		},
        pane: {
            startAngle: -90,
            endAngle: 90,
            background: [{
                backgroundColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, '#FFF'],
                        [1, '#333']
                    ]
                },
                borderWidth: 0,
                outerRadius: '109%'
            }, {
                backgroundColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, '#333'],
                        [1, '#FFF']
                    ]
                },
                borderWidth: 1,
                outerRadius: '107%'
            }, {
                // default background
            }, {
                backgroundColor: '#DDD',
                borderWidth: 0,
                outerRadius: '105%',
                innerRadius: '103%'
            }]
        },
        tooltip: {
            enabled: true
        },

    // the value axis
        yAxis: {
            minorTickInterval: 'auto',
            minorTickWidth: 1,
            minorTickLength: 10,
            minorTickPosition: 'inside',
            minorTickColor: '#666',

            tickPixelInterval: 30,
            tickWidth: 2,
            tickPosition: 'inside',
            tickLength: 10,
            tickColor: '#666',
            labels: {
                step: 2,
                rotation: 'auto'
            },
            title: {
                text: 'Bar'
            },
            plotBands: [{
                from: 0,
                to: 2,
                color: '#DF5353' // red
            }, {
                from: 2,
                to: 5,
                color: '#00ff00' // green
            }]
        },
    };
    $('#druck0').highcharts(Highcharts.merge(druck0, {
        yAxis: {
            min: 0,
            max: 5
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'druck0',
            data: [<?php  echo $channel0;?>], /////// Temp Value //////////
            dataLabels: {
                format: '<span class="thermometerslabel">{y}</span>',
                useHTML: true,
                borderWidth: 0,
            },
            tooltip: {
                valueSuffix: ' Bar'
            }

        }]
    }));

// Druckleitung 1 Kreislauf1
    var druck1  = {
        chart: {
            type: 'gauge',
	        backgroundColor: null,  /*Background transparent*/
	        spacingBottom: 0,
	        spacingTop: 0,
	        spacingLeft: 0,
	        spacingRight: 0,
			marginTop: 0,
			marginleft: 0,
			marginright: 0,
			marginbottom: 0,
        },
		title: {
		    text: '',
		    style: {
		        display: 'none'
		    }
		},
        pane: {
            startAngle: -90,
            endAngle: 90,
            background: [{
                backgroundColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, '#FFF'],
                        [1, '#333']
                    ]
                },
                borderWidth: 0,
                outerRadius: '109%'
            }, {
                backgroundColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, '#333'],
                        [1, '#FFF']
                    ]
                },
                borderWidth: 1,
                outerRadius: '107%'
            }, {
                // default background
            }, {
                backgroundColor: '#DDD',
                borderWidth: 0,
                outerRadius: '105%',
                innerRadius: '103%'
            }]
        },
        tooltip: {
            enabled: true
        },

    // the value axis
        yAxis: {
            minorTickInterval: 'auto',
            minorTickWidth: 1,
            minorTickLength: 10,
            minorTickPosition: 'inside',
            minorTickColor: '#666',

            tickPixelInterval: 30,
            tickWidth: 2,
            tickPosition: 'inside',
            tickLength: 10,
            tickColor: '#666',
            labels: {
                step: 2,
                rotation: 'auto'
            },
            title: {
                text: 'Bar'
            },
            plotBands: [{
                from: 0,
                to: 2,
                color: '#DF5353' // red
            }, {
                from: 2,
                to: 5,
                color: '#00ff00' // green
            }]
        },
    };
    $('#druck1').highcharts(Highcharts.merge(druck1, {
        yAxis: {
            min: 0,
            max: 5
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'druck0',
            data: [<?php  echo $channel1;?>], /////// Temp Value //////////
            dataLabels: {
                format: '<span class="thermometerslabel">{y}</span>',
                useHTML: true,
                borderWidth: 0,
            },
            tooltip: {
                valueSuffix: ' Bar'
            }

        }]
    }));
// Druckleitung 2 Kreislauf2
    var druck2  = {
        chart: {
            type: 'gauge',
	        backgroundColor: null,  /*Background transparent*/
	        spacingBottom: 0,
	        spacingTop: 0,
	        spacingLeft: 0,
	        spacingRight: 0,
			marginTop: 0,
			marginleft: 0,
			marginright: 0,
			marginbottom: 0,
        },
		title: {
		    text: '',
		    style: {
		        display: 'none'
		    }
		},
        pane: {
            startAngle: -90,
            endAngle: 90,
            background: [{
                backgroundColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, '#FFF'],
                        [1, '#333']
                    ]
                },
                borderWidth: 0,
                outerRadius: '109%'
            }, {
                backgroundColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, '#333'],
                        [1, '#FFF']
                    ]
                },
                borderWidth: 1,
                outerRadius: '107%'
            }, {
                // default background
            }, {
                backgroundColor: '#DDD',
                borderWidth: 0,
                outerRadius: '105%',
                innerRadius: '103%'
            }]
        },
        tooltip: {
            enabled: true
        },

    // the value axis
        yAxis: {
            minorTickInterval: 'auto',
            minorTickWidth: 1,
            minorTickLength: 10,
            minorTickPosition: 'inside',
            minorTickColor: '#666',

            tickPixelInterval: 30,
            tickWidth: 2,
            tickPosition: 'inside',
            tickLength: 10,
            tickColor: '#666',
            labels: {
                step: 2,
                rotation: 'auto'
            },
            title: {
                text: 'Bar'
            },
            plotBands: [{
                from: 0,
                to: 2,
                color: '#DF5353' // red
            }, {
                from: 2,
                to: 5,
                color: '#00ff00' // green
            }]
        },
    };
    $('#druck2').highcharts(Highcharts.merge(druck2, {
        yAxis: {
            min: 0,
            max: 5
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'druck0',
            data: [<?php  echo $channel2;?>], /////// Temp Value //////////
            dataLabels: {
                format: '<span class="thermometerslabel">{y}</span>',
                useHTML: true,
                borderWidth: 0,
            },
            tooltip: {
                valueSuffix: ' Bar'
            }

        }]
    }));
// Druckleitung 3 Kreislauf3
    var druck3  = {
        chart: {
            type: 'gauge',
	        backgroundColor: null,  /*Background transparent*/
	        spacingBottom: 0,
	        spacingTop: 0,
	        spacingLeft: 0,
	        spacingRight: 0,
			marginTop: 0,
			marginleft: 0,
			marginright: 0,
			marginbottom: 0,
        },
		title: {
		    text: '',
		    style: {
		        display: 'none'
		    }
		},
        pane: {
            startAngle: -90,
            endAngle: 90,
            background: [{
                backgroundColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, '#FFF'],
                        [1, '#333']
                    ]
                },
                borderWidth: 0,
                outerRadius: '109%'
            }, {
                backgroundColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, '#333'],
                        [1, '#FFF']
                    ]
                },
                borderWidth: 1,
                outerRadius: '107%'
            }, {
                // default background
            }, {
                backgroundColor: '#DDD',
                borderWidth: 0,
                outerRadius: '105%',
                innerRadius: '103%'
            }]
        },
        tooltip: {
            enabled: true
        },

    // the value axis
        yAxis: {
            minorTickInterval: 'auto',
            minorTickWidth: 1,
            minorTickLength: 10,
            minorTickPosition: 'inside',
            minorTickColor: '#666',

            tickPixelInterval: 30,
            tickWidth: 2,
            tickPosition: 'inside',
            tickLength: 10,
            tickColor: '#666',
            labels: {
                step: 2,
                rotation: 'auto'
            },
            title: {
                text: 'Bar'
            },
            plotBands: [{
                from: 0,
                to: 2,
                color: '#DF5353' // red
            }, {
                from: 2,
                to: 5,
                color: '#00ff00' // green
            }]
        },
    };
    $('#druck3').highcharts(Highcharts.merge(druck3, {
        yAxis: {
            min: 0,
            max: 5
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'druck0',
            data: [<?php  echo $channel3;?>], /////// Temp Value //////////
            dataLabels: {
                format: '<span class="thermometerslabel">{y}</span>',
                useHTML: true,
                borderWidth: 0,
            },
            tooltip: {
                valueSuffix: ' Bar'
            }

        }]
    }));

})
</script>
		<meta http-quiv="Content-Type" content="text/html;charset=UTF-8">
		<div class="thermometers">
			<center>
				<table>
					<tr>
						<td colspan="8" align="right">
							<div class="header" >Familie Knappe in Schönow (Pool)</div>
						</td>
					</tr>
					<tr>
						<td colspan="2" class="responsiveCell">
							<div class="label" >Pool</div>
						</td>
						<td colspan="2" class="responsiveCell">
							<div class="label" >Solar</div>
						</td>
						<td colspan="2" class="responsiveCell">
							<div class="label" >Garten</div>
						</td>
						<td colspan="2" class="responsiveCell">
							<div class="label" >Schuppen</div>
						</td>
					</tr>
					<tr>
						<td colspan="2" class="responsiveCell">
							<div class="highcharttemp" id="pool"></div>
							<div class="minmax">
								<font color=4B4FFB>↓</font><?php echo $poolmin;?>°&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color=f40303>↑</font><?php echo $poolmax;?>° 
							</div>
						</td>
						<td colspan="2" class="responsiveCell">
							<div class="highcharttemp" id="solar"></div>
							<div class="minmax">
								<font color=4B4FFB>↓</font><?php echo $solarmin;?>°&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color=f40303>↑</font><?php echo $solarmax;?>° 
							</div>
						</td>
						<td colspan="2" class="responsiveCell">
							<div class="highcharttemp" id="outdoor"></div>
							<div class="minmax">
								<font color=4B4FFB>↓</font><?php echo $outdoormin;?>°&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color=f40303>↑</font><?php echo $outdoormax;?>° 
							</div>
						</td>
						<td colspan="2" class="responsiveCell">
							<div class="highcharttemp" id="schuppen"></div>
							<div class="minmax">
								<font color=4B4FFB>↓</font><?php echo $schuppenmin;?>°&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color=f40303>↑</font><?php echo $schuppenmax;?>° 
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2"><div class="label">Zuleitung</div></td>
						<td colspan="2"><div class="label">Kreis 1</div></td>
						<td colspan="2"><div class="label">Kreis 2</div></td>
						<td colspan="2"><div class="label">Kreis 3</div></td>
					</tr>
				   <tr>
						<td colspan="2" class="responsiveCell">
							<div class="highcharttemp" id="druck0"></div>
							<!--<div class="highchartpressure " id="druck0"></div>-->
						</td>
						<td colspan="2" class="responsiveCell">
							<div class="highcharttemp" id="druck1"></div>
						</td>
						<td colspan="2" class="responsiveCell">
							<div class="highcharttemp" id="druck2"></div>
						</td>
						<td colspan="2" class="responsiveCell">
							<div class="highcharttemp" id="druck3"></div>
						</td>
					</tr>
				</table>
				<table>
					<tr>
						<td colspan="3" class="labelswitch">Pool</div></td>
						<td colspan="3" class="labelswitch">Beregnung</div></td>
						<td colspan="3" class="labelswitch">Licht</div></td>
					</tr>
					<tr>
						<td><div class="labelswitch">Automatik</div></td>
						<td><div class="labelswitch">Pumpe</div></td>
						<td><div class="labelswitch">Solarbypass</div></td>
						<td><div class="labelswitch">Automatik</div></td>
						<td><div class="labelswitch">Pumpe</div></td>
						<td><div class="labelswitch">Ventil</div></td>
						<td><div class="labelswitch">UWS</div></td>
						<td><div class="labelswitch">Kugellampe</div></td>
						<td><div class="labelswitch">Gartenspot</div></td>
					</tr>
					<tr>
						<?php
						/*Pin 
						0	Poolpumpe
						1	Solarbypass
						2	UWS
						3	Gartenlampe
						4	Spot
						5	Wasserpumpe
						6	Magnetventil
						7	frei
						12	Sommer
						13	reinigen
						14	filtern
						24	automatic
						*/
						//Abfrage Status der GPIO Pins 0, 1, 2, 3, 4
						$val_array = array(0,0,0,0,0,0,0,0,0);
						for ( $i= 0; $i<8; $i++) {
							//system("gpio -g mode ".$i." out");
							exec ("gpio -g read ".$i, $val_array[$i], $return );
						};
						//Abfrage Status der GPIO Pins  12, 13 ,14
						$val_array1 = array(0,0,0);
						for ( $i= 13; $i<15; $i++) {
							//system("gpio -g mode ".$i." out");
							exec ("gpio -g read ".$i, $val_array1[$i], $return );
						};
						//Abfrage Automatic oder Manuell Betrieb 0=manuell   1=Automatic
						exec ("gpio -g read 24", $automatic, $return );
						//Automatic
						// 1 = EIN   0=AUS  
							echo ("<td><div class='onoffswitch'>");
							if ($summer[0] == 0){
									echo ("<img id='button_".$i."' src='../img/wintermode.png'");
									echo ("</div></td>\n");
								}
							else {
								//Manuell
								$i = 24;
								if ($automatic[0] == 0 ) {
									echo ("<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' disabled='disabled' id='flipswitch_".$i."'/>");
									}
								//Automatic
								if ($automatic[0] == 1 ) {
									echo ("<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' checked='checked' disabled='disabled' id='flipswitch_".$i."'/>");
									}
								echo ("<label class='onoffswitch-label' for='flipswitch_".$i."' >");
								echo ("<span class='onoffswitch-inner'></span>");
								echo ("<span class='onoffswitch-switch'></span>");
								echo ("</label>");
								echo ("</div><div class='labelswitch'>");
								echo ("Pool</div></td>\n");	 
							};	 
						//for loop  Pumpe, Solar nur Anzeige und Winterbetrieb
						// 0 = EIN   1=AUS  wegen Relaisplatte
							for ($i = 0; $i < 2; $i++) {
								echo ("<td><div class='onoffswitch'>");
								if ($summer[0] == 0){
										echo ("<img id='button_".$i."' src='../img/wintermode.png'");
										echo ("</div></td>\n");
									}
								else {
									//Manuell
									if ($val_array[$i][0] == 1 ) {
										echo ("<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' disabled='disabled' id='flipswitch_".$i."'/>");
										}
									//Automatic
									if ($val_array[$i][0] == 0 ) {
										echo ("<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' checked='checked' disabled='disabled' id='flipswitch_".$i."'/>");
										}
									echo ("<label class='onoffswitch-label' for='flipswitch_".$i."' >");
									echo ("<span class='onoffswitch-inner'></span>");
									echo ("<span class='onoffswitch-switch'></span>");
									echo ("</label></div>");
									if ($i == 0) {echo ("<div class='labelswitch'>".$pumpentime."</div></td>\n");};
									if ($i == 1) {echo ("<div class='labelswitch'>".$solartime."</div></td>\n");};
								};	 
							};	 
						//Abfrage Automatic oder Manuell Betrieb Regner 0=manuell   1=Automatic
						exec ("gpio -g read 26", $automaticregner, $return );
						//Automatic
						// 1 = EIN   0=AUS  
							echo ("<td><div class='onoffswitch'>");
							if ($summer[0] == 0){
									echo ("<img id='button_".$i."' src='../img/wintermode.png'");
									echo ("</div></td>\n");
								}
							else {
								//Manuell
								$i = 26;
								if ($automaticregner[0] == 0 ) {
									echo ("<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' id='flipswitch_".$i."'/>");
									}
								//Automatic
								if ($automaticregner[0] == 1 ) {
									echo ("<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' checked='checked' id='flipswitch_".$i."'/>");
									}
								echo ("<label class='onoffswitch-label' for='flipswitch_".$i."' >");
								echo ("<span class='onoffswitch-inner'></span>");
								echo ("<span class='onoffswitch-switch'></span>");
								echo ("</label>");
								echo ("</div><div class='labelswitch'>");
								echo ("Beregnung</div></td>\n");	 
							};	 
						//Relais Gartenpumpe und Magnetventil
						// 0 = EIN   1=AUS
							for ( $i= 5; $i<7; $i++) {
								echo ("<td><div class='onoffswitch'>");
								if ($summer[0] == 0){
										echo ("<img id='button_".$i."' src='../img/wintermode.png'");
										echo ("</div></td>\n");
									}
								else {
									//Manuell
									if ($val_array[$i][0] == 1 ) {
										echo ("<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' disabled='disabled' id='flipswitch_".$i."'/>");
										}
									//Automatic
									if ($val_array[$i][0] == 0 ) {
										echo ("<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' checked='checked' disabled='disabled' id='flipswitch_".$i."'/>");
										}
									echo ("<label class='onoffswitch-label' for='flipswitch_".$i."' >");
									echo ("<span class='onoffswitch-inner'></span>");
									echo ("<span class='onoffswitch-switch'></span>");
									echo ("</label></div>");
									if ($i == 5) {echo ("<div class='labelswitch'>".$gartenpumpetime."</div></td>\n");};
									if ($i == 6) {echo ("<div class='labelswitch'>".$beregnungtime."</div></td>\n");};
								};	 
							};
						//for loop UWS, Gartensport und Gartenlampe  Schalten und Winterbetrieb
						// 0 = EIN   1=AUS  wegen Relaisplatte inklusive Schalten
							for ($i = 2; $i < 5; $i++) {
								echo ("<td><div class='onoffswitch'>");
								if ($summer[0] == 0 && $i == 2){
										echo ("<img id='button_".$i."' src='../img/wintermode.png'");
										echo ("</div></td>\n");
									}
								else {
									//Manuell
									if ($val_array[$i][0] == 1 ) {
										echo ("<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' disabled='disabled' id='flipswitch_".$i."'/>");
										}
									//Automatic
									if ($val_array[$i][0] == 0 ) {
										echo ("<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' checked='checked' disabled='disabled' id='flipswitch_".$i."'/>");
										}
									echo ("<label class='onoffswitch-label' for='flipswitch_".$i."' >");
									echo ("<span class='onoffswitch-inner'></span>");
									echo ("<span class='onoffswitch-switch'></span>");
									echo ("</label></div>");
									if ($i == 2) {echo ("<div class='labelswitch'>".$uwstime."</div></td>\n");};
									if ($i == 3) {echo ("<div class='labelswitch'>".$gartenspottime."</div></td>\n");};
									if ($i == 4) {echo ("<div class='labelswitch'>".$gartenlampetime."</div></td>\n");};
								};	 
							};	 
						?>
					</tr>	
					<tr>
						<td colspan="2">
							<div class="last-update" ><a href="../public/history.html" target="_blank">
								<img id="temphistory_1" src='../img/statistik.png'/><br />
								Temperatur All</a></div>
						</td>
						<td colspan="2">
							<div class="last-update" ><a href="../public/temphistory.html" target="_blank">
								<img id="temphistory_1" src='../img/statistik.png'/><br />
								Temperatur 60 Tage</a></div>
						</td>
						<td colspan="2" >
							<div class="last-update" ><a href="../wetter/index.html" target="_blank" >
								<img id="temphistory_1" src='../img/weather.png'/><br />
								Wetter</a></div>
						</td>
						<td colspan="3" >
							<div class="last-update" ><a href="../prod/index.php" target="_blank">
							<img  id="admin_1" src='../img/familie.png'/><br />
							Familie</a></div>
						</td>
					</tr>
			</table>
			<table>
					<tr>
						<td colspan="2"><div class="disclaimercenter" >Status vom: <?php echo $now;?></div></td>
						<td colspan="2"><div class="disclaimercenter" >Betriebsart: <?php echo $modus;?></div></td>
						<td colspan="2"><div class="disclaimercenter" >Refresh: <?php echo $sec;?>  Sekunden</div></td>
						<td colspan="2"><div class="disclaimercenter" >Version: <?php echo $version;?></div></td>
					</tr>
					<tr>
						<td colspan="2"><div class="disclaimercenter" >CPU Temperatur: <?php echo $cputemp;?>°C</div></td>
						<td colspan="2"><div class="disclaimercenter" >CPU Auslastung: <?php echo $cpuload[0];?>%</div></td>
						<td colspan="2"><div class="disclaimercenter" >Systemstart: <?php echo $boottime;?></div></td>
						<td colspan="2"><div class="disclaimercenter" >© 2016 by Thorben Knappe</div></td>
					</tr>
			</table>
			<!--<input type="button" onclick="myFunction()" value="© 2016 by Thorben Knappe">-->
			</div>
		</div>
		</center>
		</div>
				</body>
</html>

