<?php
/**
 * Fecha:  2020-01-24 - Update: 2020-01-27
 * PHP Version 7
 * 
 * @category   Components
 * @package    Moodle
 * @subpackage Mod_iteasyexam
 * @author     JFHR <felsul@hotmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://aulavirtual.issste.gob.mx
 */
namespace mod_iteasyexam\event;
defined('MOODLE_INTERNAL') || die();
/**
 * Course_module_viewed Class
 * 
 * @category Class
 * @package  Moodle
 * @author   JFHR <felsul@hotmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://aulavirtual.issste.gob.mx
 */
class Course_Module_Viewed extends \core\event\course_module_viewed
{
    /**
     * Function init 
     * 
     * @return null
     */
    protected function init() 
    {
        $this->data['objecttable'] = 'iteasyexam';
        parent::init();
    }
}
