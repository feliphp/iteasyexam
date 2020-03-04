<?php
/**
 * Fecha: 2020-01-24 - Update: 2020-02-10
 * PHP Version 7
 * 
 * @category   Components
 * @package    Moodle
 * @subpackage Mod_iteasyexam
 * @author     JFHR <felsul@hotmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://aulavirtual.issste.gob.mx
 */
require_once dirname(dirname(dirname(__FILE__))).'/config.php';

defined('MOODLE_INTERNAL') || die();

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
 * Get Courses
 * 
 * @return array
 */
function iteasyexam_Get_courses() 
{
    global $DB;
    $query ="SELECT DISTINCT course FROM {iteasyexam}";
    return $DB->get_records_sql($query);
}

/**
 * Get Course name
 * 
 * @param int $id id course
 * 
 * @return array
 */
function iteasyexam_Get_Course_name($id) 
{
    global $DB;
    $query ="SELECT fullname FROM {course} WHERE id = ".$id."";
    $result_string = $DB->get_record_sql($query);
    return $result_string->fullname;
}

/**
 * Get username
 * 
 * @param int $id id user
 * 
 * @return string
 */
function iteasyexam_Get_username($id)
{
    global $DB;
    $query ="SELECT username FROM {user} WHERE id = ".$id."";
    $result_string = $DB->get_record_sql($query);
    return $result_string->username;
}

/**
 * Exist
 * 
 * @param String $name  exam name
 * 
 * @return int
 */
function iteasyexam_exist($name)
{
    global $DB;
    
    $sql = "SELECT count(*) as item FROM {iteasyexam} ".
    "WHERE name = '".$name."'";
    $array_count = $DB->get_record_sql($sql, null);
    return $array_count->item;
}

/**
 * iteasyexam Exam Save
 * 
 * @param array $data data
 *  
 * @return bool
 */
function iteasyexam_Exam_save(
    $data
) {
    global $DB;

     $newautoenrolid = $DB->insert_record('iteasyexam', $data);

    if ($newautoenrolid) {
        return true;
    } else {
        return false;
    }
}

/**
 * iteasyexam Exam Update
 * 
 * @param array $data data
 *  
 * @return bool
 */
function iteasyexam_Exam_update(
    $data
) {
    global $DB;

    $contentid = $data->id;

    $DB->set_field(
        'iteasyexam', 
        'name', 
        $data->name, 
        array('id'=>$contentid)
    );

    $DB->set_field(
        'iteasyexam', 
        'instructions', 
        $data->instructions, 
        array('id'=>$contentid)
    );

    $DB->set_field(
        'iteasyexam', 
        'enabled', 
        $data->enabled, 
        array('id'=>$contentid)
    );

    $datemodified = date("Y-m-d"); 
    $DB->set_field(
        'iteasyexam', 
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


/**
 * Exam Delete
 * 
 * @param int $id id 
 *  
 * @return bool
 */
function iteasyexam_Exam_delete(
    $id
) {
    global $DB;
    $sql_delete = "DELETE FROM mdl_iteasyexam WHERE id = ".$id."";
    if ($DB->execute($sql_delete)) {
        return true;
    } else {
        return false;
    }
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

    $sql = "SELECT * FROM mdl_iteasyexam WHERE id = $id ";    
    return $DB->get_record_sql($sql, null);
}



/**
 * iteasyexam Get Full name
 * 
 * @param int $userid user id
 *  
 * @return string
 */
function iteasyexam_Get_Full_name($userid)
{
    global $DB;

    $sql = "SELECT firstname, lastname FROM mdl_user WHERE id = $userid ";  
    $ret = $DB->get_record_sql($sql);
    $fullname = $ret->firstname . " " . $ret->lastname;
    return $fullname;
}

/**
 * iteasyexam Get Email
 * 
 * @param int $userid user id
 *  
 * @return string
 */
function iteasyexam_Get_email($userid)
{
    global $DB;

    $sql = "SELECT email FROM mdl_user WHERE id = $userid ";  
    $ret = $DB->get_record_sql($sql);
    $email = $ret->email;
    return $email;
}

/**
 * Get total exams
 * 
 * @return int
 */
function iteasyexam_Get_Total_exams()
{
    global $DB;
    $sql = "SELECT count(*) as item FROM {iteasyexam}";
    $array_count = $DB->get_record_sql($sql, null);
    return $array_count->item;
}

/**
 * Get Content
 * 
 * @param String $order     value of order
 * @param String $dir       value of dir
 * @param String $page      value of page
 * @param String $limit     value of limit 
 * 
 * @return array
 */
function iteasyexam_content($order,$dir,$page,$limit)
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
    }

    // página pedida
    $pag = (int) $page;
    if ($pag < 1) {
        $pag = 1;
    }
    $offset = ($pag-1) * $limit;

    $sql = "SELECT * FROM mdl_iteasyexam WHERE id <> 0 $filter_query 
    $filtro_query_orden LIMIT $offset, $limit";
    
    return $DB->get_records_sql($sql, null);
}

/**
 * Get Delegation name
 * 
 * @param int $id value of id delegation
 * 
 * @return array
 */
function iteasyexam_Get_Delegation_name_xls($id) 
{
    global $DB;
    $query ="SELECT name FROM {iteasyexam_delegations} ".
            "WHERE id =".$id.";";
    $result =$DB->get_record_sql($query);
    return $result->name;
}
