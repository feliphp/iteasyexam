<?php
/**
 * Fecha:  2020-01-30 - Update: 2020-02-10
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
 * iteasyexam Question Form Class
 * 
 * @category Class
 * @package  Moodle
 * @author   JFHR <felsul@hotmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://aulavirtual.issste.gob.mx
 */
class iteasyexam_Question_Form extends moodleform
{
    /**
     * Function from Form 
     * 
     * @return null
     */
    public function definition() 
    {
        global $CFG;

        $context = context_system::instance();

        $mform = $this->_form; 
        $id = $this->_customdata['id_question'];
        $name = $this->_customdata['name'];
        $id_examen = $this->_customdata['id_examen'];
        $answer_one = $this->_customdata['answer_one'];
        $correct_answer_one = $this->_customdata['correct_answer_one'];
        $answer_two = $this->_customdata['answer_two'];
        $correct_answer_two = $this->_customdata['correct_answer_two'];
        $answer_three = $this->_customdata['answer_three'];
        $correct_answer_three = $this->_customdata['correct_answer_three'];
        $answer_four = $this->_customdata['answer_four'];
        $correct_answer_four = $this->_customdata['correct_answer_four'];
        $enabled = $this->_customdata['enabled'];

        $mform->addElement(
            'text', 
            'name', 
            get_string('name_question', 'iteasyexam')
        );
        $mform->setType('name', PARAM_TEXT);
        $mform->setDefault('name', $name);
        $mform->addRule('name', get_string('required'), 'required');

        $examenes_array = array();
        $examenes_array = iteasyexam_Get_exams();

        $div_fitem ='<div id="fitem_id_type" class="fitem fitem_fselect">'.
        '<div class="fitemtitle"><label for="id_examen" >'
        .get_string('id_examen', 'iteasyexam').'</label></div>';
        $exam_name = iteasyexam_Get_Exam_name($id_examen);

        if ($id_examen == 0) {
            $div_felement ='<div class="felement fselect">'.
            '<select name="id_examen"'.
            ' id="id_examen" ><option value="0">'
            .get_string('option_default_id_examen', 'iteasyexam').'</option>';
        } else {
            $div_felement ='<div class="felement fselect">'.
            '<select name="id_examen"'.
            ' id="id_examen" ><option value="'.$id_examen.'">'
            .$exam_name->name.'</option><option value="0">'
            .get_string('option_default_id_examen', 'iteasyexam').'</option>';
        }

        $mform->addElement('html', ''.$div_fitem);
        $mform->addElement('html', ''.$div_felement);

        foreach ($examenes_array as $exa) {
            $html_exa = '<option value="'.$exa->id.'">'.$exa->name.'</option>';
            $mform->addElement('html', $html_exa);
        }
        $mform->addElement('html', '</select></div></div>'."\n");

        $mform->addElement(
            'text', 
            'answer_one', 
            get_string('answer_one', 'iteasyexam')
        );
        $mform->setType('answer_one', PARAM_TEXT);
        $mform->setDefault('answer_one', $answer_one);
        $mform->addRule('answer_one', get_string('required'), 'required');

        $mform->addElement('checkbox', 'correct_answer_one', get_string('correct_answer_one', 'iteasyexam'));
        $mform->setDefault('correct_answer_one', $correct_answer_one);

        $mform->addElement(
            'text', 
            'answer_two', 
            get_string('answer_two', 'iteasyexam')
        );
        $mform->setType('answer_two', PARAM_TEXT);
        $mform->setDefault('answer_two', $answer_two);
        $mform->addRule('answer_two', get_string('required'), 'required');

        $mform->addElement('checkbox', 'correct_answer_two', get_string('correct_answer_two', 'iteasyexam'));
        $mform->setDefault('correct_answer_two', $correct_answer_two); 

        $mform->addElement(
            'text', 
            'answer_three', 
            get_string('answer_three', 'iteasyexam')
        );
        $mform->setType('answer_three', PARAM_TEXT);
        $mform->setDefault('answer_three', $answer_three);
        $mform->addRule('answer_three', get_string('required'), 'required');

        $mform->addElement('checkbox', 'correct_answer_three', get_string('correct_answer_three', 'iteasyexam'));
        $mform->setDefault('correct_answer_three', $correct_answer_three);

        $mform->addElement(
            'text', 
            'answer_four', 
            get_string('answer_four', 'iteasyexam')
        );
        $mform->setType('answer_four', PARAM_TEXT);
        $mform->setDefault('answer_four', $answer_four);
        $mform->addRule('answer_four', get_string('required'), 'required');

        $mform->addElement('checkbox', 'correct_answer_four', get_string('correct_answer_four', 'iteasyexam'));
        $mform->setDefault('correct_answer_four', $correct_answer_four);

        $mform->addElement('checkbox', 'enabled', get_string('enabled_w', 'iteasyexam'));
        $mform->setDefault('enabled', $enabled);

        $mform->addElement('hidden', 'id', null);
        $mform->setType('id', PARAM_INT);
        $mform->setDefault('id', $id);

        $this->add_action_buttons(
            $cancel = true,
            $submitlabel = get_string('submit_value_add_questions', 'iteasyexam')
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