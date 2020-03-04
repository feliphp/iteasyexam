<?php
  /**
   * Fecha:  2020-01-29 - Update: 2020-01-29
   * PHP Version 7
   * 
   * @category   Components
   * @package    Moodle
   * @subpackage Mod_iteasyexam
   * @author     JFHR <felsul@hotmail.com>
   * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
   * @link       https://aulavirtual.issste.gob.mx
   */

require_once dirname(dirname(dirname(dirname(__FILE__)))).'/config.php';
require_once dirname(__FILE__).'/lib.php';
require_once dirname(__FILE__).'/iteasyexam_delegation_form.php';
require_once $CFG->libdir.'/adminlib.php';

$contextid = optional_param('contextid', 0, PARAM_INT);
$openlink = optional_param('openlink', 0, PARAM_INT); 
$user = optional_param('user', 0, PARAM_INT); 
$id = optional_param('id', 0, PARAM_INT); 
$name = optional_param('name', '', PARAM_TEXT);  

$page = optional_param('page', 0, PARAM_INT);
$err_valida = optional_param('err_valida', 0, PARAM_INT); 
$returnurl = optional_param('returnurl', '', PARAM_LOCALURL);
$strname = get_string('iteasyexam_delegations', 'iteasyexam');
$site = get_site();
$params = array('page' => $page); 
$baseurl = new moodle_url('/mod/iteasyexam/delegations/addupddelegation.php', $params);

if ($contextid) {
    $context = context_system::instance();
} else {
    $context = context_system::instance();
}
global $SESSION;

$PAGE->set_url($CFG->wwwroot.'/mod/iteasyexam/delegations/addupddelegation.php');
$cancelurl = new moodle_url('/mod/iteasyexam/delegations/index.php', null);

if (isloggedin()) {
    $PAGE->navbar->add($strname);
    $PAGE->set_context($context);
    $PAGE->set_pagelayout('admin');
    $PAGE->set_heading($site->fullname);
    echo $PAGE->set_title(get_string('iteasyexam_delegations', 'iteasyexam'));  
    echo $OUTPUT->header();  
    echo $OUTPUT->heading($strname);  

    $validate_index = iteasyexam_exist(
        $name
    );
    if ($id != 0) {
         $delegation_to_update = iteasyexam_By_Id_form($id);
         $customdata = array(
            'id_delegation' => $delegation_to_update->id,
            'name' => $delegation_to_update->name
        );
    } else {
        $customdata = array(
            'id_delegation' => 0,
            'name' => $name
        );
    }

        $mformst = new iteasyexam_delegation_Form(
            null,
            $customdata
        );

        if ($mformst->is_cancelled()) {
            redirect($cancelurl);
        } else if ($data = $mformst->get_data()) {

            $data->datecreated = date("Y-m-d"); 
            $data->datemodified = date("Y-m-d"); 

            //save or update
            if ($id != 0) {
                $save_eval = iteasyexam_Delegation_update(
                    $data
                );
            } else {
                if ($validate_index == 0) {
                        $save_eval = iteasyexam_Delegation_save(
                            $data
                        );
                }
            }

            $baseurl_return = new moodle_url('/mod/iteasyexam/delegations/index.php', null);

            echo "<br><strong>".get_string(
                'successful_message',
                'iteasyexam'
            )."</strong><br><br>";
            echo "<a href='".$baseurl_return."' class='btn btn-success'>".
            get_string(
                'link_return',
                'iteasyexam'
            )."</a><br>";


        } else {

            if ($validate_index != 0) {
                $baseurl_return = new moodle_url(
                    '/mod/iteasyexam/delegations/index.php',
                    null
                );
                echo "<br><strong>".get_string(
                    'duplicate_message',
                    'iteasyexam'
                )."</strong><br><br>";
                echo "<a href='".$baseurl_return."' class='btn btn-success'>".
                get_string(
                    'link_return',
                    'iteasyexam'
                )."</a><br>";
            } else {
                $mformst->set_data($toform);
                $mformst->display();
            }
        }
    
    
} else {
    $login_url = new moodle_url(
        '/login/index.php', 
        null
    );
    redirect($login_url);

    $PAGE->navbar->add($strname);
    $PAGE->set_context($context);
    $PAGE->set_pagelayout('admin');
    $PAGE->set_heading($site->fullname);
    echo $PAGE->set_title(get_string('iteasyexam', 'iteasyexam'));  
    echo $OUTPUT->header();  
    echo $OUTPUT->heading(get_string('requireloginerror', 'iteasyexam'));  

}

echo $OUTPUT->footer();