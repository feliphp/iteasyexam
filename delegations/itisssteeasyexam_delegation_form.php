<?php
/**
 * Fecha:  2020-01-29 - Update: 2020-01-30
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
class iteasyexam_delegation_Form extends moodleform
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
        $id = $this->_customdata['id_delegation'];
        $name = $this->_customdata['name'];

        $mform->addElement(
            'text', 
            'name', 
            get_string('name_delegation', 'iteasyexam')
        );
        $mform->setType('name', PARAM_TEXT);
        $mform->setDefault('name', $name);
        $mform->addRule('name', get_string('required'), 'required');

        $mform->addElement('hidden', 'id', null);
        $mform->setType('id', PARAM_INT);
        $mform->setDefault('id', $id);

        $this->add_action_buttons(
            $cancel = true,
            $submitlabel = get_string('submit_value_add_delegations', 'iteasyexam')
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