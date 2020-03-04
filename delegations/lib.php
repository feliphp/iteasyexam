<?php
/**
 * Fecha: 2020-01-27 - Update: 2020-01-28
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
 * Delegations Delete
 * 
 * @param int $id id 
 *  
 * @return bool
 */
function iteasyexam_Delegations_delete(
    $id
) {
    global $DB;
    $sql_delete = "DELETE FROM mdl_iteasyexam_delegations WHERE id = ".$id."";
    if ($DB->execute($sql_delete)) {
        return true;
    } else {
        return false;
    }
}

/**
 * Get total delegations
 * 
 * @return int
 */
function iteasyexam_Get_Total_delegations()
{
    global $DB;
    $sql = "SELECT count(*) as item FROM {iteasyexam_delegations}";
    $array_count = $DB->get_record_sql($sql, null);
    return $array_count->item;
}

/**
 * Get Delegations Content
 * 
 * @param String $order     value of order
 * @param String $dir       value of dir
 * @param String $page      value of page
 * @param String $limit     value of limit
 * 
 * @return array
 */
function iteasyexam_Delegations_content($order,$dir,$page,$limit)
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

    $sql = "SELECT * FROM mdl_iteasyexam_delegations WHERE id <> 0 $filter_query 
    $filtro_query_orden LIMIT $offset, $limit";
    
    return $DB->get_records_sql($sql, null);
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
    
    $sql = "SELECT count(*) as item FROM {iteasyexam_delegations} ".
    "WHERE name = '".$name."'";
    $array_count = $DB->get_record_sql($sql, null);
    return $array_count->item;
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

    $sql = "SELECT * FROM mdl_iteasyexam_delegations WHERE id = $id ";    
    return $DB->get_record_sql($sql, null);
}

/**
 * iteasyexam Delegation Save
 * 
 * @param array $data data
 *  
 * @return bool
 */
function iteasyexam_Delegation_save(
    $data
) {
    global $DB;

     $newautoenrolid = $DB->insert_record('iteasyexam_delegations', $data);

    if ($newautoenrolid) {
        return true;
    } else {
        return false;
    }
}

/**
 * iteasyexam Delegation Update
 * 
 * @param array $data data
 *  
 * @return bool
 */
function iteasyexam_Delegation_update(
    $data
) {
    global $DB;

    $contentid = $data->id;

    $DB->set_field(
        'iteasyexam_delegations', 
        'name', 
        $data->name, 
        array('id'=>$contentid)
    );

    $datemodified = date("Y-m-d"); 
    $DB->set_field(
        'iteasyexam_delegations', 
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
