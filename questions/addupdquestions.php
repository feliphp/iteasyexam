<?php
  /**
   * Fecha:  2020-01-30 - Update: 2020-01-30
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
require_once dirname(__FILE__).'/iteasyexam_question_form.php';
require_once $CFG->libdir.'/adminlib.php';

$contextid = optional_param('contextid', 0, PARAM_INT);
$openlink = optional_param('openlink', 0, PARAM_INT); 
$user = optional_param('user', 0, PARAM_INT); 
$id = optional_param('id', 0, PARAM_INT); 
$id_examen = optional_param('id_examen', 0, PARAM_INT); 
$name = optional_param('name', '', PARAM_TEXT);  
$answer_one = optional_param('answer_one', '', PARAM_TEXT);  
$correct_answer_one = optional_param('correct_answer_one', 0, PARAM_INT);   
$answer_two = optional_param('answer_two', '', PARAM_TEXT);  
$correct_answer_two = optional_param('correct_answer_two', 0, PARAM_INT);  
$answer_three = optional_param('answer_three', '', PARAM_TEXT);  
$correct_answer_three = optional_param('correct_answer_three', 0, PARAM_INT);  
$answer_four = optional_param('answer_four', '', PARAM_TEXT);  
$correct_answer_four = optional_param('correct_answer_four', 0, PARAM_INT);  
$enabled = optional_param('enabled', 0, PARAM_INT); 

$page = optional_param('page', 0, PARAM_INT);
$err_valida = optional_param('err_valida', 0, PARAM_INT); 
$returnurl = optional_param('returnurl', '', PARAM_LOCALURL);
$strname = get_string('iteasyexam_questions', 'iteasyexam');
$site = get_site();
$params = array('page' => $page); 
$baseurl = new moodle_url('/mod/iteasyexam/questions/addupdquestions.php', $params);

if ($contextid) {
    $context = context_system::instance();
} else {
    $context = context_system::instance();
}
global $SESSION;

$PAGE->set_url($CFG->wwwroot.'/mod/iteasyexam/questions/addupdquestions.php');
$cancelurl = new moodle_url('/mod/iteasyexam/questions/index.php', null);

if (isloggedin()) {
    $PAGE->navbar->add($strname);
    $PAGE->set_context($context);
    $PAGE->set_pagelayout('admin');
    $PAGE->set_heading($site->fullname);
    echo $PAGE->set_title(get_string('iteasyexam_questions', 'iteasyexam'));  
    echo $OUTPUT->header();  
    echo $OUTPUT->heading($strname);  

    if ($id != 0) {
         $question_to_update = iteasyexam_By_Id_form($id);
         $customdata = array(
            'id_question' => $question_to_update->id,
            'name' => $question_to_update->name,
            'id_examen' => $question_to_update->id_examen,
            'answer_one' => $question_to_update->answer_one,
            'correct_answer_one' => $question_to_update->correct_answer_one,
            'answer_two' => $question_to_update->answer_two,
            'correct_answer_two' => $question_to_update->correct_answer_two,
            'answer_three' => $question_to_update->answer_three,
            'correct_answer_three' => $question_to_update->correct_answer_three,
            'answer_four' => $question_to_update->answer_four,
            'correct_answer_four' => $question_to_update->correct_answer_four,
            'enabled' => $question_to_update->enabled,
        );
    } else {
        $customdata = array(
            'id_delegation' => 0,
            'name' => $name,
            'id_examen' => $id_examen,
            'answer_one' => $answer_one,
            'correct_answer_one' => $correct_answer_one,
            'answer_two' => $answer_two,
            'correct_answer_two' => $correct_answer_two,
            'answer_three' => $answer_three,
            'correct_answer_three' => $correct_answer_three,
            'answer_four' => $answer_four,
            'correct_answer_four' => $correct_answer_four,
            'enabled' => $enabled,
        );
    }

        $mformst = new iteasyexam_Question_Form(
            null,
            $customdata
        );

        if ($mformst->is_cancelled()) {
            redirect($cancelurl);
        } else if ($data = $mformst->get_data()) {
            if (is_null($data->enabled)) {
                $data->enabled = 0;
            }
            if (is_null($data->correct_answer_one)) {
                $data->correct_answer_one = 0;
            }
            if (is_null($data->correct_answer_two)) {
                $data->correct_answer_two = 0;
            }
            if (is_null($data->correct_answer_three)) {
                $data->correct_answer_three = 0;
            }
            if (is_null($data->correct_answer_four)) {
                $data->correct_answer_four = 0;
            }


            $data->id_examen = $id_examen;

            $data->datecreated = date("Y-m-d"); 
            $data->datemodified = date("Y-m-d"); 
            $baseurl_return = new moodle_url('/mod/iteasyexam/questions/index.php', null);

            //validación respuestas correctas
            $respuestas_correctas = $data->correct_answer_one + $data->correct_answer_two
            + $data->correct_answer_three + $data->correct_answer_four;

            if($respuestas_correctas != 1){
                $data->enabled = 0;
                echo "<br><strong>".get_string(
                    'error_answer_correct_message',
                    'iteasyexam'
                )."</strong><br><br>";
                echo "<a href='".$baseurl_return."' class='btn btn-success'>".
                get_string(
                    'link_return',
                    'iteasyexam'
                )."</a><br>";
            } else {
                echo "<br><strong>".get_string(
                    'successful_message',
                    'iteasyexam'
                )."</strong><br><br>";
                echo "<a href='".$baseurl_return."' class='btn btn-success'>".
                get_string(
                    'link_return',
                    'iteasyexam'
                )."</a><br>";
            }

            //save or update
           if ($id != 0) {
                $save_eval = iteasyexam_Questions_update(
                    $data
                );
            } else {
                        $save_eval = iteasyexam_Questions_save(
                            $data
                        );
            }


        } else {

            if ($validate_index != 0) {
                $baseurl_return = new moodle_url(
                    '/mod/iteasyexam/questions/index.php',
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