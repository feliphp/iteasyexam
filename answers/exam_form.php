<?php
/**
 * Fecha:  2020-01-31 - Update: 2020-01-31
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
class Exam_Form extends moodleform
{
    /**
     * Function from Form 
     * 
     * @return null
     */
    public function definition() 
    {
        global $CFG, $DB;

        $context = context_system::instance();

        $mform = $this->_form; 

        $examenes_array = array();
        $examenes_array = iteasyexam_Get_exams();

        $div_fitem ='<div id="fitem_id_type" class="fitem fitem_fselect">'.
        '<div class="fitemtitle"><label for="id_examen" >'
        .get_string('id_examen', 'iteasyexam').'</label></div>';

        if ($id_examen == 0) {
            $div_felement ='<div class="felement fselect">'.
            '<select name="id_examen"'.
            ' id="id_examen" ><option value="0">'
            .get_string('option_default_id_examen', 'iteasyexam').'</option>';
         }

        $mform->addElement('html', ''.$div_fitem);
        $mform->addElement('html', ''.$div_felement);

        foreach ($examenes_array as $exa) {
            $html_exa = '<option value="'.$exa->id.'">'.$exa->name.'</option>';
            $mform->addElement('html', $html_exa);
        }
        $mform->addElement('html', '</select></div></div>'."\n");

        $this->add_action_buttons(
            $cancel = false,
            $submitlabel = get_string('go_to_quiz', 'iteasyexam')
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