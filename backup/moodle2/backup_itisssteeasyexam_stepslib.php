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
defined('MOODLE_INTERNAL') || die;
/**
 * Backup_iteasyexam_activity_structure_step Class
 * 
 * @category Class
 * @package  Moodle
 * @author   JFHR <felsul@hotmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://aulavirtual.issste.gob.mx
 */
class Backup_iteasyexam_Activity_Structure_Step extends 
backup_activity_structure_step
{
    /**
     * Defines the backup structure of the module
     *
     * @return backup_nested_element
     */
    protected function defineStructure()
    {
        $userinfo = $this->get_setting_value('userinfo');
        $iteasyexam = new backup_nested_element(
            'iteasyexam', array('id'),
            array('name', 'intro', 'introformat', 'grade')
        );
        $iteasyexam->set_source_table(
            'iteasyexam',
            array('id' => backup::VAR_ACTIVITYID)
        );
        $iteasyexam->annotate_files('mod_iteasyexam', 'intro', null);
        return $this->prepare_activity_structure($iteasyexam);
    }
}