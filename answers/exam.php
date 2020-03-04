<?php
  /**
   * Fecha:  2020-01-29 - Update: 2020-02-21
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
require_once dirname(__FILE__).'/iteasyexam_exam_form.php';
require_once $CFG->libdir.'/adminlib.php';

$contextid = optional_param('contextid', 0, PARAM_INT);
$openlink = optional_param('openlink', 0, PARAM_INT); 
$user = optional_param('user', 0, PARAM_INT); 
$id_examen = optional_param('id_examen', 0, PARAM_INT); 
$name = optional_param('name', '', PARAM_TEXT);  
$number_employee = optional_param('number_employee', '', PARAM_TEXT);
$unit_hospital = optional_param('unit_hospital', '', PARAM_TEXT);
$charge = optional_param('charge', '', PARAM_TEXT);
$institutional_email = optional_param('institutional_email', '', PARAM_TEXT);
$personal_email = optional_param('personal_email', '', PARAM_TEXT);
$delegation = optional_param('delegation', 0, PARAM_INT);
$ip = optional_param('ip', '', PARAM_TEXT);
$answers = optional_param('answers', '', PARAM_TEXT);

$page = optional_param('page', 0, PARAM_INT);
$err_valida = optional_param('err_valida', 0, PARAM_INT); 
$returnurl = optional_param('returnurl', '', PARAM_LOCALURL);
$strname = get_string('iteasyexam_exam', 'iteasyexam');
$site = get_site();
$params = array('page' => $page); 
$baseurl = new moodle_url('/mod/iteasyexam/answers/exam.php', $params);

if ($contextid) {
    $context = context_system::instance();
} else {
    $context = context_system::instance();
}
global $SESSION;

$PAGE->set_url($CFG->wwwroot.'/mod/iteasyexam/answers/exam.php');
$cancelurl = new moodle_url('/mod/iteasyexam/answers/index.php', null);

if ($id_examen != 0) {
    $name_exam = iteasyexam_Get_Exam_name($id_examen);
    $PAGE->navbar->add($strname.' '.$name_exam->name);
    $PAGE->set_context($context);
    $PAGE->set_pagelayout('admin');
    $PAGE->set_heading($site->fullname);
    echo $PAGE->set_title(get_string('iteasyexam_exam', 'iteasyexam').' '.$name_exam->name);  
    echo $OUTPUT->header();  
    echo $OUTPUT->heading($strname.' '.$name_exam->name);  

    $validate_index = iteasyexam_Answers_exist(
        $id_examen,
        $number_employee
    );

    $customdata = array(
        'id' => 0,
        'id_examen' => $id_examen,
        'name' => $name,
        'number_employee' => $number_employee,
        'unit_hospital' => $unit_hospital,
        'charge' => $charge,
        'institutional_email' => $institutional_email,
        'personal_email' => $personal_email,
        'delegation' => $delegation
    );

        $mformst = new iteasyexam_Exam_Form(
            null,
            $customdata
        );

        if ($mformst->is_cancelled()) {
            redirect($cancelurl);
        } else if ($data = $mformst->get_data()) {
            $preguntas = iteasyexam_Get_Total_Quest($id_examen);
            $respuestas = '{';
                $points = 0;
            for ($i=1; $i <= $preguntas; $i++ ){
                $respuesta_recibida = optional_param('radio_quest'.$i, 0, PARAM_INT);
                $id_pregunta = optional_param('id_pregunta'.$i, 0, PARAM_INT);
                $respuesta_correcta = iteasyexam_Validar_respuesta($respuesta_recibida, $id_pregunta);
                
                if ($respuesta_correcta > 0) {
                    $points = $points + 1;
                } 
                $respuestas = $respuestas . 'p'.$i.' : '. $respuesta_recibida.',';
            }
            $data->answers = $respuestas . '}';
            //falta calif
            $calif = floatval(0);
            $rule_3_1_part = floatval($points) * 10;
            $calif = floatval($rule_3_1_part) / floatval($preguntas);
            $calif = number_format($calif, 2, '.', '');
            $data->emam_grade = $calif;

            if(is_null($data->delegation)){
                $data->delegation = $delegation;
            }

            $data->ip = $_SERVER['REMOTE_ADDR'];
            $data->datecreated = date("Y-m-d"); 
            $data->datemodified = date("Y-m-d"); 

            //save

                if ($validate_index == 0) {
                        $save_eval = iteasyexam_Exam_Answers_save(
                            $data
                        );
                } 
            

            $baseurl_return = new moodle_url('/index.php', null);
            echo "".get_string('calif','iteasyexam')." ".$calif."<br>";
            echo "<br><strong>".get_string(
                'successful_exam_message',
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
                    '/index.php',
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
?>
 <script>
 
$(document).ready(function(){
  $(".radio").prop("checked", false);
  $("#id_institutional_email").change(function(){
      var inpmail = $("#id_institutional_email").val();
      var validamail = validarEmail(inpmail);
      if(validamail == false) { 
        alert("La dirección de email institucional es incorrecta.");
        return false;
      } else {
        return true;
      }
  });

  $("#id_personal_email").change(function(){
      var inpmail = $("#id_personal_email").val();
      var validamail = validarEmail(inpmail);
      if(validamail == false) { 
        alert("La dirección de email personal es incorrecta.");
        return false;
      } else {
        return true;
      }
  });

  $('#mform1').submit(function (evt) {
    var inpmail_1 = $("#id_institutional_email").val();
    var inpmail_2 = $("#id_personal_email").val();
    if(inpmail_1 == '' && inpmail_2 == ''){
        evt.preventDefault();
        alert("Debe proporcionar un correo electrónico.");
        return false;
      } else {
        return true;
    }

});
});

function validarEmail(valor) {
    var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(valor) ? true : false;
}

</script> 
<?php
} else {
    $PAGE->navbar->add($strname);
    $PAGE->set_context($context);
    $PAGE->set_pagelayout('admin');
    $PAGE->set_heading($site->fullname);
    echo $PAGE->set_title(get_string('iteasyexam_exam', 'iteasyexam'));  

    echo $OUTPUT->header();  
    $baseurl_return = new moodle_url(
        '/mod/iteasyexam/answers/index.php',
        null
    );
    echo "<br><strong>".get_string(
        'error_id_exam',
        'iteasyexam'
    )."</strong><br><br>";
    echo "<a href='".$baseurl_return."' class='btn btn-success'>".
    get_string(
        'link_return',
        'iteasyexam'
    )."</a><br>";

}

echo $OUTPUT->footer();