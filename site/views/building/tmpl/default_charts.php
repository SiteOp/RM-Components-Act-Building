<?php
/**
 * @version    CVS: 1.1.3
 * @package    Com_Act
 * @author     Richard Gebhard <gebhard@site-optimierer.de>
 * @copyright  2019 Richard Gebhard
 * @license    GNU General Public License Version 2 oder später; siehe LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

use \Joomla\CMS\Factory;
use \Joomla\CMS\Language\Text;

$doc = Factory::getDocument();
//$doc->addScript('node_modules/chart.js/dist/Chart.bundle.min.js');
//$doc->addScript('node_modules/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js');
$doc->addScript('node_modules/chartjs-plugin-labels/build/chartjs-plugin-labels.min.js');

$json = json_decode($this->item->routessoll, true);
//print_R($json);


// Erstelle Variablen für Gesamtgrad (3.Grad, 4.Grad usw)
$soll_grade_13 = $json['13']; 
$soll_grade_3  = $json['3'];  // 3
$soll_grade_4  = $json['4'];  // 4
$soll_grade_5  = $json['5'];	 // 5
$soll_grade_6  = $json['6'];	 // 6
$soll_grade_7  = $json['7'];	 // 7
$soll_grade_8  = $json['8'];	 // 8
$soll_grade_9  = $json['9'];	 // 9
$soll_grade_10 = $json['10']; // 10
$soll_grade_11 = $json['11']; // 11
$soll_grade_12 = $json['12']; // 12
$soll_grade_array = [$soll_grade_3,$soll_grade_4,$soll_grade_5,$soll_grade_6,$soll_grade_7,$soll_grade_8,$soll_grade_9,$soll_grade_10,$soll_grade_11,$soll_grade_12];



// Farben
$color_3  = '#a001f2'; // TODO CONFIG
$color_4  = '#ffc600';
$color_5  = '#a86301';
$color_6  = '#fa3a07';
$color_7  = '#98c920';
$color_8  = '#019abc';
$color_9  = '#a001f2';
$color_10 = '#2a82cd';
$color_11 = '#ff00ff';
$color_12 = '#ffc600';
$color_13 = '#f2f2f2';

// Label für Grad
$label_13 = 'undefiniert';
$label_3 = '3.Grad';  // TODO Sprache
$label_4 = '4.Grad';
$label_5 = '5.Grad';
$label_6 = '6.Grad';
$label_7 = '7.Grad';
$label_8 = '8.Grad';
$label_9 = '9.Grad';
$label_10 = '10.Grad';
$label_11 = '11.Grad';
$label_12 = '12.Grad';


// Ist Werte für Chart
$soll_label = '';
$soll_color = '';
$soll_data = ''; 

for ($i = 3; $i <= 13; $i++) {
 
  $soll_grade = "soll_grade_$i";
  $color = "color_$i";
  $label = "label_$i";

  if ($$soll_grade != 0) {
    $soll_data .= $$soll_grade . ',';
    $soll_color .= '"'.$$color.'",';
    $soll_label .= '"'.$$label.'",';
   } 

}

?>

<?php if ($soll_data != '') : ?>
  <canvas id="sollChart" width="" height="90"></canvas>

  <script>
  Chart.helpers.merge(Chart.defaults.global.plugins.datalabels, {
    align: 'end',
    anchor: 'end',
    color: '#555',
    offset: 0,
    margin: 30,
    font: {
      size: 14,
      weight: 'bold'
    },
  });


  var canvas = document.getElementById('sollChart');
  new Chart(canvas, {
    type: 'doughnut',    
    data: {
      labels: [<?php echo $soll_label; ?>],
      datasets: [{
        data: [<?php echo $soll_data; ?>],
        backgroundColor: [<?php echo $soll_color; ?> ]
      }]
    },

    // Abstand von Legend nach unten 3.Grade ...
    plugins: [{
      beforeInit: function(chart, options) {
        chart.legend.afterFit = function() {
          this.height = this.height + 30;
        };
      }
    }],

    options: {
      legend: {
        display: true,
        position: 'top',
        padding: 0,
        labels: {
        fontSize: 14,
        }
      },
      // Option animation time
      animation: {
        duration: 0 
      },
      // Semi
      rotation: -Math.PI,
      cutoutPercentage: 35,
      circumference: Math.PI,
      responsive: true,
      maintainAspectRatio: true,
      
      plugins: {
        labels: {
          fontColor: 'black',
          fontSize: 15,
          precision: 0
        },
      },
    }

  });
  </script>

<?php else : ?>
  <p>Keine Sollwerte erfasst.</p>
<?php endif; ?>