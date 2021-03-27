<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Act_building
 * @author     Birgit Gebhard <info@routes-manager.de>
 * @copyright  2021 Birgit Gebhard
 * @license    GNU General Public License Version 2 oder später; siehe LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

use \Joomla\CMS\HTML\HTMLHelper;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Uri\Uri;
use \Joomla\CMS\Router\Route;
use \Joomla\CMS\Language\Text;

// Add Script 
$doc = Factory::getDocument();
$doc->addScript('components/com_act_building/views/buildingform/tmpl/prozent.min.js', true, true); // Nicht absenden wenn Enter 
$doc->addScript('components/com_act/views/sectorform/tmpl/enternotsend.js'); // Nicht absenden wenn Enter 

$user    = Factory::getUser();
$canEdit = Act_buildingHelpersAct_building::canUserEdit($this->item, $user);

// PARAMS TODO
$grade_start = 5; 
$grade_end = 10; 

if(!empty($this->item->id)) {
	$total_lines = Act_buildingHelpersAct_building::getTotalLinesFromBuilding($this->item->id);	
} else {
	$total_lines = '';
}
if(!empty($this->item->percentsoll)) {
	$json = json_decode($this->item->percentsoll, true); // Hole die Were aus DB um die Inputfelder vorab zu füllen
}
?>
<style>
.sw_soll  {text-align: center; font-weight: bold;}
.sw_soll .form-control {text-align: center; padding-left: 25px!important;}
#gradetable input {padding: 0; width: 100%; min-height: 1.5rem; text-align: center;}
#gradetable .table td {padding: 4px;}
.card-body {padding: 0; margin-left: -5px;}
label {width: 100%; margin-bottom: 0;}
.lblg {border-bottom: 5px solid;!important;}
.grade3  {border-color: #a001f2}
.grade4  {border-color: #ffc600}
.grade5  {border-color: #a86301}
.grade6  {border-color: #fa3a07}
.grade7  {border-color: #98c920}
.grade8  {border-color: #019abc}
.grade9  {border-color: #a001f2}
.grade10 {border-color: #2a82cd}
.grade11 {border-color: #ff00ff}
.grade12 {border-color: #444444}
.progress {height: 1.3rem; font-size: 120%; font-weight: bold; margin: .3rem 0;}
</style>			

		<h3 class="mt-5">Soll-Verteilung SW</h3>
		<div>Gesamtzahl Linie: <span id="total_lines"><?php echo $total_lines ; ?></span></div>
		<div>Routendichte: <span id="density"> </span> </div>

		<div class="row">
            <div class="col-sm-6"><?php echo $this->form->renderField('routestotal'); ?></div>
        </div>
        
          
    <div id="gradetable" class="table-responsive mt-4">
        <table class="table table-bordered text-center" id="datatable">
            <thead>
                <tr>
				<td>Grad</td>
					<?php for ($i = $grade_start; $i <= $grade_end; $i++) : ?>
						<td class="grade">
							<label class="lblg grade<?php echo $i; ?>"><?php echo $i; ?></label>
						</td>
					<?php endfor; ?>
                </tr>
            </thead>
            <tbody>
			<tr id="percent_val"> 
                    <td>Prozent</td>   
					<?php for ($i = $grade_start; $i <=$grade_end; $i++) : ?>
						<td class="grade">
							<input type="number" id="percent<?php echo $i; ?>" class="form-control" min="0" max="100" step="1" value="<?php echo $json[$i]; ?>">
						</td>
					<?php endfor; ?>
                </tr>
				<tr id="allroutes">
                    <td  width="110px">Anzahl Routen</td>
                    <?php for($i = $grade_start; $i <= $grade_end; $i++) : ?>
                        <td>
						<input type="text" id="routes_grade<?php echo $i; ?>" class="form-control" name="routes_grade<?php echo $i; ?>" value="" readonly>
						</td>
                    <?php endfor; ?>
                </tr>
				<tr>
                    <td>Erfüllung</td>
                    <td colspan="11">
                        <div class="progress">
                            <span class="sr-only"><input type="number" name="jform[percent]" id="jform_percent" value="" max="100" step="1"></span>
                            <div id="progress" class="progress-bar progress-bar-striped" role="progressbar" style=""></div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
	<input type="hidden" id="percentsoll" name="jform[percentsoll]" value="" />
	<input type="hidden" id="routessoll" name="jform[routessoll]" value="" />
