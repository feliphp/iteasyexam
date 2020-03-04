<?php
  /**
   * Fecha:  2020-01-14 - Update: 2020-02-21
   * PHP Version 7
   * 
   * @category   Components
   * @package    Moodle
   * @subpackage Mod_Itpreregister
   * @author     JFHR <felsul@hotmail.com>
   * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
   * @link       https://aulavirtual.issste.gob.mx
   */
require_once dirname(dirname(dirname(__FILE__))).'/config.php';
require_once dirname(__FILE__).'/vendor/xlsxwriter/xlsxwriter.class.php';
require_once dirname(__FILE__).'/lib.php';

/**
 * To Excell 
 * 
 * @param int $course_id id course
 * 
 * @return null
 */
function To_excell()
{
    $filename = "Respuestasiteasyexam_AulaVirtual.xlsx";
    header(
        'Content-disposition: attachment; filename="'.
        XLSXWriter::sanitize_filename($filename).'"'
    );
    header(
        "Content-Type: application/vnd.openxmlformats-officedocument".
        ".spreadsheetml.sheet"
    );
    header(
        'Content-Transfer-Encoding: binary'
    ); 
    header(
        'Cache-Control: must-revalidate'
    );
    global $DB;

    if ($course_id == 0) {
        $queryadd = '';
    } 

    $header = array( 
        'Id'=>'string',
        'Id Examen'=>'string',
        'Nombre'=>'string',
        'Calificación'=>'string',
        'Número de Empleado'=>'string',
        'Unidad Hospitalaria'=>'string',
        'Cargo'=>'string',
        'Correo Institucional'=>'string',
        'Correo Personal'=>'string',
        'Delegación'=>'string',
        'Dirección IP'=>'string',
        'Respuestas'=>'string',
        'Fecha Creación'=>'string',
        'Fecha Modificación'=>'string'
    );
    
    $styleHeader = array(
        'fill'=>'#80CAF9',
        'font-style'=>'bold',
        'border'=>'left,right,top,bottom'
    );

    $writer = new XLSXWriter(); 
    $writer->writeSheetHeader('Sheet1', $header, $styleHeader);
    $array = array();
    $query = 'SELECT * FROM {iteasyexam_answers} '.$queryadd.'';
    $resultu = $DB->get_recordset_sql($query);

    foreach ($resultu as $ans) {
        for ($i=0; $i< count(resultu); $i++ ) {
            $array['A'.$i] = $ans->id; 
            $array['B'.$i] = $ans->id_examen; 
            $array['C'.$i] = $ans->name;
            $array['D'.$i] = $ans->emam_grade; 
            $array['E'.$i] = $ans->number_employee; 
            $array['F'.$i] = $ans->unit_hospital; 
            $array['G'.$i] = $ans->charge; 
            $array['H'.$i] = $ans->institutional_email; 
            $array['I'.$i] = $ans->personal_email; 
            $delegation = iteasyexam_Get_Delegation_name_xls($ans->delegation);
            $array['J'.$i] = $delegation; 
            $array['K'.$i] = $ans->ip; 
            $array['L'.$i] = $ans->answers; 
            $array['M'.$i] = $ans->datecreated;
            $array['N'.$i] = $ans->datemodified;
        
        }
        $writer->writeSheetRow('Sheet1', $array);
    }   
    $writer->writeToStdOut();
    
}

$number_report=$_GET['nr'];

if ($number_report == '1') {
    To_excell();
} 
exit(0);
