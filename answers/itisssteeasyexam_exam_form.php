<?php
/**
 * Fecha:  2020-01-31 - Update: 2020-02-21
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
require_once $CFG->libdir.'/adminlib.php';
require_once $CFG->libdir.'/formslib.php';

/**
 * isssteeasyexam_Form Class
 * 
 * @category Class
 * @package  Moodle
 * @author   JFHR <felsul@hotmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://aulavirtual.issste.gob.mx
 */
class iteasyexam_Exam_Form extends moodleform
{
    /**
     * Function from Form 
     * 
     * @return null
     */
    public function definition() 
    {
        global $CFG, $DB, $USER;

        $context = context_system::instance();

        $mform = $this->_form; 
        $id = $this->_customdata['id'];
        $id_examen = $this->_customdata['id_examen'];
        $name = $this->_customdata['name'];
        $number_employee = $this->_customdata['number_employee'];
        $unit_hospital = $this->_customdata['unit_hospital'];
        $charge = $this->_customdata['charge'];
        $institutional_email = $this->_customdata['institutional_email'];
        $personal_email = $this->_customdata['personal_email'];
        $delegation = $this->_customdata['delegation'];


        if($USER->id > 0){
            $name = $USER->firstname . '' . $USER->lastname;
            $institutional_email = $USER->email;
        }

        $quest_array = array();
        $quest_array = iteasyexam_Get_quest($id_examen);
        $instructions = iteasyexam_Get_Instructons_name($id_examen);
        if ($instructions == '') {
            $mform->addElement('html', '<br>');
        } else {
            $mform->addElement('html', '<font color="red">'.$instructions->instructions.'</font><br><br>');
        }

        $mform->addElement(
            'text', 
            'name', 
            get_string('name', 'iteasyexam')
        );
        $mform->setType('name', PARAM_TEXT);
        $mform->setDefault('name', $name);
        $mform->addRule('name', get_string('required'), 'required');

        $mform->addElement(
            'text', 
            'number_employee', 
            get_string('number_employee', 'iteasyexam')
        );
        $mform->setType('number_employee', PARAM_TEXT);
        $mform->setDefault('number_employee', $number_employee);
        $mform->addRule('number_employee', get_string('required'), 'required');

        $mform->addElement(
            'text', 
            'unit_hospital', 
            get_string('unit_hospital', 'iteasyexam')
        );
        $mform->setType('unit_hospital', PARAM_TEXT);
        $mform->setDefault('unit_hospital', $unit_hospital);
        $mform->addRule('unit_hospital', get_string('required'), 'required');

        $mform->addElement(
            'text', 
            'charge', 
            get_string('charge', 'iteasyexam')
        );
        $mform->setType('charge', PARAM_TEXT);
        $mform->setDefault('charge', $charge);
        $mform->addRule('charge', get_string('required'), 'required');

        $attributes=array('placeholder'=>'username@issste.gob.mx');

        $mform->addElement(
            'text', 
            'institutional_email', 
            get_string('institutional_email', 'iteasyexam'),
            $attributes
        );
        $mform->setType('institutional_email', PARAM_TEXT);
        $mform->setDefault('institutional_email', $institutional_email);

        $attributes=array('placeholder'=>'username@correo.com');

        $mform->addElement(
            'text', 
            'personal_email', 
            get_string('personal_email', 'iteasyexam'),
            $attributes
        );
        $mform->setType('personal_email', PARAM_TEXT);
        $mform->setDefault('personal_email', $personal_email);

       
        $delegations_array = array();
        $delegations_array = iteasyexam_Get_delegations();

        $div_fitem_exam ='<div id="fitem_id_delegation" class="fitem fitem_fselect">'.
        '<div class="fitemtitle"><label for="delegation" >'
        .get_string('name_delegation', 'iteasyexam').'</label></div>';

        $div_felement_exam ='<div class="felement fselect">'.
        '<select name="delegation" id="delegation" ><option value="0">'
        .get_string('option_default_id_delegation', 'iteasyexam').'</option>';

        $mform->addElement('html', ''.$div_fitem_exam);
        $mform->addElement('html', ''.$div_felement_exam);

        foreach ($delegations_array as $deleg) {
            $html_deleg = '<option value="'.$deleg->id.'">'.$deleg->name.'</option>';
            $mform->addElement('html', $html_deleg);
        }
        $mform->addElement('html', '</select></div></div>'."\n");

        $label_preguntas = get_string('question_section', 'iteasyexam');
        $label_instrucciones = get_string('question_instructions', 'iteasyexam');
        $mform->addElement('html', '<br><strong>'.$label_preguntas.'</strong><br>'.$label_instrucciones.'<hr><div class="preguntas">');

        $attributes_r=array('class'=>'radio');

        $i = 1;
        foreach ($quest_array as $quest) {
            $radioarray=array();
            $radioarray[] = $mform->createElement('radio', 'radio_quest'.$i , '', $quest->answer_one, 0, $attributes_r);
            $radioarray[] = $mform->createElement('radio', 'radio_quest'.$i, '', $quest->answer_two, 1, $attributes_r);
            $radioarray[] = $mform->createElement('radio', 'radio_quest'.$i, '', $quest->answer_three, 2, $attributes_r);
            $radioarray[] = $mform->createElement('radio', 'radio_quest'.$i, '', $quest->answer_four, 3, $attributes_r);
            $mform->addGroup($radioarray, 'radio_quest'.$i, $quest->pregunta, array(' '), false);

            $mform->addElement('hidden', 'id_pregunta'.$i, null);
            $mform->setType('id_pregunta'.$i, PARAM_INT);
            $mform->setDefault('id_pregunta'.$i, $quest->id);
            $i++;
        }
        $mform->addElement('html', '</div>');

        $mform->addElement('hidden', 'id_examen', null);
        $mform->setType('id_examen', PARAM_INT);
        $mform->setDefault('id_examen', $id_examen);

        $this->add_action_buttons(
            $cancel = false,
            $submitlabel = get_string('finish_exam', 'iteasyexam')
        ); 

    }

    /**
     * Function from Validation Form 
     * 
     * @param array $data  comment about this variable
     * @param array $files comment about this variable
     * 
     * @return array
     */
    function validation($data, $files) 
    {
        return array();
    }

    
}