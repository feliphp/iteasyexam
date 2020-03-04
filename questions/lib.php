<?php
/**
 * Fecha: 2020-01-27 - Update: 2020-02-10
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
 * Has permissions
 * 
 * @return boolean
 */
function iteasyexam_Has_permissions()
{
    global $USER;
    $permission = false;
    $context = get_context_instance(CONTEXT_SYSTEM);

    if (is_siteadmin()) {
        $permission = true;
    } else {
        $roles = get_user_roles($context, $USER->id, false);
        $role = key($roles);
        $roleid = $roles[$role]->roleid;
        if ($roleid == 1) {
            $permission = true;
        }
    }
    return $permission;
}

/**
 * Quest Delete
 * 
 * @param int $id id 
 *  
 * @return bool
 */
function iteasyexam_Quest_delete(
    $id
) {
    global $DB;
    $sql_delete = "DELETE FROM mdl_iteasyexam_quest WHERE id = ".$id."";
    if ($DB->execute($sql_delete)) {
        return true;
    } else {
        return false;
    }
}

/**
 * Get total questions
 * 
 * @return int
 */
function iteasyexam_Get_Total_questions()
{
    global $DB;
    $sql = "SELECT count(*) as item FROM {iteasyexam_quest}";
    $array_count = $DB->get_record_sql($sql, null);
    return $array_count->item;
}

/**
 * Get Questions Content
 * 
 * @param String $order     value of order
 * @param String $dir       value of dir
 * @param String $page      value of page
 * @param String $limit     value of limit
 * 
 * @return array
 */
function iteasyexam_Questions_content($order,$dir,$page,$limit)
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
    }

    // página pedida
    $pag = (int) $page;
    if ($pag < 1) {
        $pag = 1;
    }
    $offset = ($pag-1) * $limit;

    $sql = "SELECT * FROM mdl_iteasyexam_quest WHERE id <> 0 $filter_query 
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
 * @param int $id value of id course
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
 * Get iteasyexam by id
 * 
 * @param int $id id
 * 
 * @return array
 */
function iteasyexam_By_Id_form($id)
{
    global $DB;

    $sql = "SELECT * FROM mdl_iteasyexam_quest WHERE id = $id ";    
    return $DB->get_record_sql($sql, null);
}

/**
 * iteasyexam Questions_save
 * 
 * @param array $data data
 *  
 * @return bool
 */
function iteasyexam_Questions_save(
    $data
) {
    global $DB;

     $newautoenrolid = $DB->insert_record('iteasyexam_quest', $data);

    if ($newautoenrolid) {
        return true;
    } else {
        return false;
    }
}

/**
 * iteasyexam Questions Update
 * 
 * @param array $data data
 *  
 * @return bool
 */
function iteasyexam_Questions_update(
    $data
) {
    global $DB;

    $contentid = $data->id;

    $DB->set_field(
        'iteasyexam_quest', 
        'name', 
        $data->name, 
        array('id'=>$contentid)
    );

    $DB->set_field(
        'iteasyexam_quest', 
        'id_examen', 
        $data->id_examen, 
        array('id'=>$contentid)
    );

    $DB->set_field(
        'iteasyexam_quest', 
        'answer_one', 
        $data->answer_one, 
        array('id'=>$contentid)
    );

    $DB->set_field(
        'iteasyexam_quest', 
        'correct_answer_one', 
        $data->correct_answer_one, 
        array('id'=>$contentid)
    );

    $DB->set_field(
        'iteasyexam_quest', 
        'answer_two', 
        $data->answer_two, 
        array('id'=>$contentid)
    );

    $DB->set_field(
        'iteasyexam_quest', 
        'correct_answer_two', 
        $data->correct_answer_two, 
        array('id'=>$contentid)
    );

    $DB->set_field(
        'iteasyexam_quest', 
        'answer_three', 
        $data->answer_three, 
        array('id'=>$contentid)
    );

    $DB->set_field(
        'iteasyexam_quest', 
        'correct_answer_three', 
        $data->correct_answer_three, 
        array('id'=>$contentid)
    );

    $DB->set_field(
        'iteasyexam_quest', 
        'answer_four', 
        $data->answer_four, 
        array('id'=>$contentid)
    );

    $DB->set_field(
        'iteasyexam_quest', 
        'correct_answer_four', 
        $data->correct_answer_four, 
        array('id'=>$contentid)
    );

    $DB->set_field(
        'iteasyexam_quest', 
        'enabled', 
        $data->enabled, 
        array('id'=>$contentid)
    );

    $datemodified = date("Y-m-d"); 
    $DB->set_field(
        'iteasyexam_quest', 
        'datemodified', 
        $data->datemodified, 
        array('id'=>$contentid)
    );

    if ($newautoenrolid) {
        return true;
    } else {
        return false;
    }
}

