<?php
  /**
   * Fecha:  2020-01-27 - Update: 2020-02-21
   * 
   * @category   Components
   * @package    Moodle
   * @subpackage Mod_iteasyexam
   * @author     JFHR <felsul@hotmail.com>
   * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
   * @link       https://aulavirtual.issste.gob.mx
   */

require_once dirname(dirname(dirname(dirname(__FILE__)))).'/config.php';
require_once dirname(dirname(__FILE__)).'/lib.php';
require_once dirname(__FILE__).'/lib.php';
require_once dirname(__FILE__).'/exam_form.php';
//
require_once $CFG->libdir.'/adminlib.php';
$contextid = optional_param('contextid', 0, PARAM_INT);
$openlink = optional_param('openlink', 0, PARAM_INT); 
$id = optional_param('id', 0, PARAM_INT); 
$id_examen = optional_param('id_examen', 0, PARAM_INT); 
$course_id = optional_param('course_id', 0, PARAM_INT); 
$user = optional_param('user', 0, PARAM_INT); 
$returnurl = optional_param('returnurl', '', PARAM_LOCALURL);
$page = optional_param('page', 0, PARAM_INT);
$order = optional_param('order', 'name', PARAM_TEXT); 
$dir = optional_param('dir', 'asc', PARAM_TEXT); 
$edit = optional_param('edit', '', PARAM_INT); 
$del = optional_param('del', '', PARAM_INT); 

$strname = get_string('iteasyexam_answers', 'iteasyexam');

if ($del != '') {
    iteasyexam_Answer_delete($del);
}

$baseurl = new moodle_url('/mod/iteasyexam/answers/index.php', null);
if ($contextid) {
    $context = context_system::instance();
} else {
    $context = context_system::instance();
}

$PAGE->set_url($CFG->wwwroot.'/mod/iteasyexam/answers/index.php');
$PAGE->navbar->add($strname);

$permissions = iteasyexam_Has_permissions();
if (isloggedin() && $permissions ) {

    global $SESSION;
    $SESSION->ccourses = null;
    $PAGE->set_context($context);
    $PAGE->set_pagelayout('admin');
    $PAGE->set_heading($site->fullname);
    $strorg = get_string('iteasyexam', 'iteasyexam');

    echo $PAGE->set_title($strorg);  
    echo $OUTPUT->header();  
    echo $OUTPUT->heading($strname);  

    $imagen_dir_id = $OUTPUT->image_url('menos', 'iteasyexam');
    if ($order=='id') {
        if ($dir == 'asc') {
            $imagen_dir_id = $OUTPUT->image_url('asc', 'iteasyexam');
            $link_dir = 'desc';
        } else {
            $imagen_dir_id = $OUTPUT->image_url('desc', 'iteasyexam');
            $link_dir = 'asc';
        }
    }
    $imagen_dir_nombre = $OUTPUT->image_url('menos', 'iteasyexam');
    if ($order=='name') {
        if ($dir == 'asc') {
            $imagen_dir_nombre = $OUTPUT->image_url('asc', 'iteasyexam');
            $link_dir = 'desc';
        } else {
            $imagen_dir_nombre = $OUTPUT->image_url('desc', 'iteasyexam');
            $link_dir = 'asc';
        }
    }
    $imagen_dir_id_examen = $OUTPUT->image_url('menos', 'iteasyexam');
    if ($order=='id_examen') {
        if ($dir == 'asc') {
            $imagen_dir_id_examen = $OUTPUT->image_url('asc', 'iteasyexam');
            $link_dir = 'desc';
        } else {
            $imagen_dir_id_examen = $OUTPUT->image_url('desc', 'iteasyexam');
            $link_dir = 'asc';
        }
    }
    $imagen_dir_calif = $OUTPUT->image_url('menos', 'iteasyexam');
    if ($order=='emam_grade') {
        if ($dir == 'asc') {
            $imagen_dir_calif = $OUTPUT->image_url('asc', 'iteasyexam');
            $link_dir = 'desc';
        } else {
            $imagen_dir_calif = $OUTPUT->image_url('desc', 'iteasyexam');
            $link_dir = 'asc';
        }
    }

    $mformst = new Exam_Form(
        null
    );
    if ($mformst->is_cancelled()) {
        redirect($cancelurl);
    } else if ($data = $mformst->get_data()) {
        $customdata = array(
            'id_examen' => $data->id_examen
        );
        $id_examen_b = $data->id_examen;
        $exam_url = new moodle_url(
            '/mod/iteasyexam/answers/exam.php', 
            null
        );
        redirect($exam_url.'?id_examen='.$id_examen);
    } else {
        $mformst->set_data($toform);
        $mformst->display();
    }

    echo "<br><strong>".get_string('title_table_answers', 'iteasyexam').
    "</strong><br><br>";
    /** pagination */
    $items_by_page_content = 20;
    $all_items = iteasyexam_Get_Total_answers();
    $totalPag = ceil($all_items/$items_by_page_content);
    $baseurl = new moodle_url('/mod/iteasyexam/answers/index.php', $params);
    echo get_string('pages', 'iteasyexam');
    for ($i=1; $i<=$totalPag ; $i++) {
        if ($page_st == $i) {
            $links[] = "<a href='".$baseurl."?page=$i'>".
            "<strong>$i</strong></a>"; 
        } else {
            $links[] = "<a href='".$baseurl."?page=$i'>$i</a>"; 
        }
    }
    echo implode(" - ", $links);
    $links = array();
    // end pagination

    echo "<table class='flexible reportlog generaltable generalbox'
    cellspacing='0'>";
    echo "<thead>";
    echo "<tr>";
        echo "<th class='header c0' scope='col'>";
        echo "<a href ='".$baseurl."?order=id&dir=$link_dir&page=$page'>".
        get_string(
            'label_table_content_id',
            'iteasyexam'
        )."<img src='".$imagen_dir_id."' 
        width='15px' height='15px'></a>";
        echo "</th>";

        echo "<th class='header c0' scope='col'>";
        echo "<a href ='".$baseurl."?order=name&dir=$link_dir&page=$page'>".
        get_string(
            'label_table_name_answer',
            'iteasyexam'
        )."<img src='".$imagen_dir_nombre."' 
        width='15px' height='15px'></a>";
        echo "</th>";

        echo "<th class='header c0' scope='col'>";
        echo "<a href ='".$baseurl."?order=id_examen&dir=$link_dir&page=$page'>".
        get_string(
            'label_table_id_examen',
            'iteasyexam'
        )."<img src='".$imagen_dir_id_examen."' 
        width='15px' height='15px'></a>";
        echo "</th>";

        echo "<th class='header c0' scope='col'>";
        echo "<a href ='".$baseurl."?order=emam_grade&dir=$link_dir&page=$page'>".
        get_string(
            'label_table_emam_grade',
            'iteasyexam'
        )."<img src='".$imagen_dir_calif."' 
        width='15px' height='15px'></a>";
        echo "</th>";

        echo "<th class='header c0' scope='col'>";
        echo "".get_string(
            'label_table_number_employee',
            'iteasyexam'
        )."";
        echo "</th>";

        echo "<th class='header c0' scope='col'>";
        echo "".get_string(
            'label_table_unit_hospital',
            'iteasyexam'
        )."";
        echo "</th>";

        echo "<th class='header c0' scope='col'>";
        echo "".get_string(
            'label_table_charge',
            'iteasyexam'
        )."";
        echo "</th>";

        echo "<th class='header c0' scope='col'>";
        echo "".get_string(
            'label_table_institutional_email',
            'iteasyexam'
        )."";
        echo "</th>";

        echo "<th class='header c0' scope='col'>";
        echo "".get_string(
            'label_table_personal_email',
            'iteasyexam'
        )."";
        echo "</th>";

        echo "<th class='header c0' scope='col'>";
        echo "".get_string(
            'label_table_delegation',
            'iteasyexam'
        )."";
        echo "</th>";

        echo "<th class='header c0' scope='col'>";
        echo "".get_string(
            'label_table_ip',
            'iteasyexam'
        )."";
        echo "</th>";

        echo "<th class='header c0' scope='col'>";
        echo "".get_string(
            'label_table_answers',
            'iteasyexam'
        )."";
        echo "</th>";

        echo "<th class='header c0' scope='col'>";
        echo "".get_string(
            'label_table_date_created',
            'iteasyexam'
        )."";
        echo "</th>";

        echo "<th class='header c3' scope='col'>";
        echo  get_string(
            'label_table_delete', 
            'iteasyexam'
        )."</a>";
        echo "</th>";
        
        echo "<th class='header c3' scope='col'>";
        echo "</tr>";
       echo "</thead>";

       $registered_data_answers = iteasyexam_Answers_content(
            $order,
            $dir,
            $page,
            $items_by_page_content
        );

        $baseurlb = new moodle_url('/mod/iteasyexam/answers/index.php', null);
        echo "<tbody>";
        foreach ($registered_data_answers as $data) {
            echo "<tr>";
            echo "<td>";
            $id=$data->id;
            echo $data->id;
            echo "</td>";
            echo "<td>";
            echo $data->name;
            echo "</td>";
            echo "<td>";
            echo $data->id_examen;
            echo "</td>";
            echo "<td>";
            echo $data->emam_grade;
            echo "</td>";
            echo "<td>";
            echo $data->number_employee;
            echo "</td>";
            echo "<td>";
            echo $data->unit_hospital;
            echo "</td>";
            echo "<td>";
            echo $data->charge;
            echo "</td>";
            echo "<td>";
            echo $data->institutional_email;
            echo "</td>";
            echo "<td>";
            echo $data->personal_email;
            echo "</td>";
            echo "<td>";
            $delegation_name = iteasyexam_Get_Delegation_name($data->delegation);
            echo $delegation_name;
            echo "</td>";
            echo "<td>";
            echo $data->ip;
            echo "</td>";
            echo "<td>";
            echo $data->answers;
            echo "</td>";
            echo "<td>";
            echo $data->datecreated;
            echo "</td>";
            echo "<td>";
            echo "<a href ='".$baseurlb."?del=".$id."' 
            onclick='return confirmar()'>".get_string(
                'label_table_delete', 
                'iteasyexam'
            )."</a>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
       echo "</table>";

       $img_down = $OUTPUT->image_url('download_data', 'itisssteupdate');
       echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="./../locallib.php?nr=1">'.
       '<img src="'.$img_down.'"".
       " height="35px" width="35px"><br>Descargar</a><br><br>';

    echo "<a href='./../index.php' class='btn btn-success'>&nbsp;&nbsp;".
    get_string(
        'return_to_exams',
        'iteasyexam'
    )." &nbsp;</a><br>";

    ?>
    <script type="text/javascript">
    function confirmar()
        {
            if(confirm('¿Estas seguro?'))
                return true;
            else
                return false;
        }
    </script>
    <?php


} else {
    $session_url = new moodle_url(
        '/mod/iteasyexam/', 
        null
    );
    $SESSION->wantsurl = $session_url;

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

