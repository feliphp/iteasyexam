<?php
/**
 * Fecha: 2020-01-27 - Update: 2020-02-11
 * PHP Version 7
 * 
 * @category   Components
 * @package    Moodle
 * @subpackage Mod_iteasyexam
 * @author     JFHR <felsul@hotmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://aulavirtual.issste.gob.mx
 */

 /**
 * iteasyexam_Validar_respuesta
 * 
 * @param int $respuesta   respuesta 
 * @param int $id_pregunta id
 *  
 * @return int
 */
function iteasyexam_Validar_respuesta(
    $respuesta,
    $id_pregunta
) {
    global $DB;
    if ($respuesta == 0){
        $sql = "SELECT count(*) as item FROM {iteasyexam_quest} WHERE id = '".
        $id_pregunta."' AND correct_answer_one = 1";
    } else if ($respuesta == 1) {
        $sql = "SELECT count(*) as item FROM {iteasyexam_quest} WHERE id = '".
        $id_pregunta."' AND correct_answer_two = 1";
    } else if ($respuesta == 2) {
        $sql = "SELECT count(*) as item FROM {iteasyexam_quest} WHERE id = '".
        $id_pregunta."' AND correct_answer_three = 1";
    } else if ($respuesta == 3) {
        $sql = "SELECT count(*) as item FROM {iteasyexam_quest} WHERE id = '".
        $id_pregunta."' AND correct_answer_four = 1";
    }
    $array_count = $DB->get_record_sql($sql, null);
    return $array_count->item;
}

 /**
 * Answer Delete
 * 
 * @param int $id id 
 *  
 * @return bool
 */
function iteasyexam_Answer_delete(
    $id
) {
    global $DB;
    $sql_delete = "DELETE FROM {iteasyexam_answers} WHERE id = ".$id."";
    if ($DB->execute($sql_delete)) {
        return true;
    } else {
        return false;
    }
}


/**
 * Get total answers
 * 
 * @return int
 */
function iteasyexam_Get_Total_answers()
{
    global $DB;
    $sql = "SELECT count(*) as item FROM {iteasyexam_answers}";
    $array_count = $DB->get_record_sql($sql, null);
    return $array_count->item;
}

/**
 * Get Answers Content
 * 
 * @param String $order     value of order
 * @param String $dir       value of dir
 * @param String $page      value of page
 * @param String $limit     value of limit
 * 
 * @return array
 */
function iteasyexam_Answers_content($order,$dir,$page,$limit)
{
    global $DB;
    $filter_query = '';

    if (!$dir) {
         $dir = 'asc';
    }

    if ($order == '') {
        $filtro_query_orden="ORDER BY id ASC";
    } elseif ($order == 'id') {
        $filtro_query_orden="ORDER BY id $dir";
    } elseif ($order == 'name') {
        $filtro_query_orden="ORDER BY name $dir";
    } elseif ($order == 'id_examen') {
        $filtro_query_orden="ORDER BY id_examen $dir";
    } elseif ($order == 'emam_grade') {
        $filtro_query_orden="ORDER BY emam_grade $dir";
    }

    // página pedida
    $pag = (int) $page;
    if ($pag < 1) {
        $pag = 1;
    }
    $offset = ($pag-1) * $limit;

    $sql = "SELECT * FROM mdl_iteasyexam_answers WHERE id <> 0 $filter_query 
    $filtro_query_orden LIMIT $offset, $limit";
    
    return $DB->get_records_sql($sql, null);
}
/**
 * Get Exams
 * 
 * @return array
 */
function iteasyexam_Get_exams()
{
    global $DB;
    $sql = "SELECT * FROM {iteasyexam} WHERE enabled <> 0 ";
    
    return $DB->get_records_sql($sql, null);
}

/**
 * Get Exam name
 * 
 * @param int $id value of id exam
 * 
 * @return array
 */
function iteasyexam_Get_Exam_name($id) 
{
    global $DB;
    $query ="SELECT name FROM {iteasyexam} ".
            "WHERE id =".$id.";";
    return $DB->get_record_sql($query);
}

/**
 * Get Instructions name
 * 
 * @param int $id value of id exam
 * 
 * @return array
 */
function iteasyexam_Get_Instructons_name($id) 
{
    global $DB;
    $query ="SELECT instructions FROM {iteasyexam} ".
            "WHERE id =".$id.";";
    return $DB->get_record_sql($query);
}

/**
 * Get Delegation name
 * 
 * @param int $id value of id delegation
 * 
 * @return array
 */
function iteasyexam_Get_Delegation_name($id) 
{
    global $DB;
    $query ="SELECT name FROM {iteasyexam_delegations} ".
            "WHERE id =".$id.";";
    $result =$DB->get_record_sql($query);
    return $result->name;
}

/**
 * Get Delegations
 * 
 * @return array
 */
function iteasyexam_Get_delegations()
{
    global $DB;
    $sql = "SELECT * FROM {iteasyexam_delegations}";
    
    return $DB->get_records_sql($sql, null);
}

/**
 * Get Quest
 * 
 * @param int $id_examen value of id examen
 * 
 * @return array
 */
function iteasyexam_Get_quest($id_examen)
{
    global $DB;
    $sql = "SELECT id,name as pregunta, answer_one, answer_two, answer_three,".
    " answer_four FROM {iteasyexam_quest} WHERE id_examen = '".$id_examen.
    "' AND enabled <> 0";
    
    return $DB->get_records_sql($sql, null);
}

/**
 * Get total Quest
 * 
 * @param int $id_examen value of id examen
 * 
 * @return int
 */
function iteasyexam_Get_Total_Quest($id_examen)
{
    global $DB;
    $sql = "SELECT count(*) as item FROM {iteasyexam_quest} WHERE id_examen = '".$id_examen."'";
    $array_count = $DB->get_record_sql($sql, null);
    return $array_count->item;
}


/**
 * iteasyexam Exam Answers Save
 * 
 * @param array $data data
 *  
 * @return bool
 */
function iteasyexam_Exam_Answers_save(
    $data
) {
    global $DB;

     $newautoenrolid = $DB->insert_record('iteasyexam_answers', $data);

    if ($newautoenrolid) {
        return true;
    } else {
        return false;
    }
}

/**
 * Exist
 * 
 * @param String $id_examen        id examen
 * @param String $number_employee  number employee
 * 
 * @return int
 */
function iteasyexam_Answers_exist($id_examen, $number_employee)
{
    global $DB;
    
    $sql = "SELECT count(*) as item FROM {iteasyexam_answers} ".
    "WHERE id_examen = '".$id_examen."' AND number_employee = '".$number_employee."'";
    $array_count = $DB->get_record_sql($sql, null);
    return $array_count->item;
}