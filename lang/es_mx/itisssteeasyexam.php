<?php
  /**
   * Fecha:  2020-01-24 - Update: 2020-02-21
   * PHP Version 7
   * 
   * @category   Components
   * @package    Moodle
   * @subpackage Mod_iteasyexam
   * @author     JFHR <felsul@hotmail.com>
   * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
   * @link       https://aulavirtual.issste.gob.mx
   */
defined('MOODLE_INTERNAL') || die();

$string['modulename'] = 'Examen Fácil para el ISSSTE';
$string['modulenameplural'] = 'Examen Fácil para el ISSSTE';
$string['parentorg'] = 'Parent';
$string['iteasyexam_help'] = 'Este es el contenido de la ayuda contextual.';
$string['iteasyexam'] = 'Examen Fácil para el ISSSTE';
$string['iteasyexam_questions'] = 'Examen Fácil para el ISSSTE - Preguntas';
$string['iteasyexam_answers'] = 'Examen Fácil para el ISSSTE - Respuestas y Calificaciones';
$string['iteasyexam_delegations'] = 'Examen Fácil para el ISSSTE - Catálogo Delegaciones';
$string['iteasyexam_exam'] = 'Examen :';
$string['pluginadministration'] = 'Examen Fácil para el ISSSTE '.
' Administración';
$string['pluginname'] = 'Examen Fácil para el ISSSTE Plugin ';
$string['link_return_update'] = 'Regresar a Actualización de Datos';
$string['link_update_form'] = 'Ir al Formulario de Actualización de Datos para el '.
'ISSSTE';
$string['pages'] = 'Páginas';
$string['label_table_content_id'] = 'Id';
$string['label_table_name_exam'] = 'Nombre del Examen';
$string['label_table_id_examen'] = 'Examen';
$string['label_table_content_function'] = 'Funciones';
$string['label_table_delete'] = 'Borrar';
$string['label_table_name_question'] = 'Pregunta';
$string['label_table_name_answer'] = 'Usuario';
$string['label_table_name_delegation'] = 'Delegación';
$string['label_table_answer_one'] = 'Respuesta 1';
$string['label_table_answer_two'] = 'Respuesta 2';
$string['label_table_answer_three'] = 'Respuesta 3';
$string['label_table_answer_four'] = 'Respuesta 4';
$string['label_table_correct_answer'] = 'Respuesta Correcta';
$string['label_table_emam_grade'] = 'Calificación';
$string['label_table_number_employee'] = 'Numero de Empleado';
$string['label_table_unit_hospital'] = 'Unidad Hospitalaria';
$string['label_table_charge'] = 'Chargo';
$string['label_table_institutional_email'] = 'Correo Electrónico Institucional';
$string['label_table_personal_email'] = 'Correo Electrónico Personal';
$string['label_table_delegation'] = 'Delegación';
$string['label_table_ip'] = 'IP';
$string['label_table_answers'] = 'Respuestas';
$string['label_table_date_created'] = 'Fecha';
$string['label_table_enabled'] = 'Habilitado';
$string['label_table_enabled_w'] = 'Habilitada';
$string['label_table_edit'] = 'Editar';
$string['label_table_instructions'] = 'Instrucciones';
$string['add_exam_form'] = 'Agregar Examen';
$string['add_question_form'] = 'Agregar Pregunta';
$string['add_delegation_form'] = 'Agregar Delegación';
$string['view_questions'] = 'Ir a la sección de preguntas';
$string['view_answers'] = 'Ir a la sección de respuesta';
$string['view_delegations'] = 'Ir al Catálogo de Delegaciones';
$string['return_to_exams'] = 'Regresar a la lista de exámenes';
$string['go_to_quiz'] = 'Ir al Examen';
$string['successful_message'] = 'Gracias, los datos se guardaron exitosamente ';
$string['successful_exam_message'] = 'Gracias, las respuestas se guardaron exitosamente ';
$string['link_return'] = 'Regresar';
$string['duplicate_message'] = ' !!! Su información ya se encuentra registrada';
$string['duplicate_message_exam'] = ' !!! Usted no puede volver a realizar el examen, '.
'existen respuestas con su número de empleado, por favor contacte a su instructor';
$string['requireloginerror'] = 'Necesitas acceder y tener permisos administrativos';
$string['name_exam'] = 'Examen';
$string['name_delegation'] = 'Delegación';
$string['name_question'] = 'Pregunta';
$string['enabled'] = 'Habilitado';
$string['enabled_w'] = 'Habilitada';
$string['id_examen'] = 'Id Examen';
$string['submit_value_add'] = 'Guardar Examen ';
$string['submit_value_add_delegations'] = 'Guardar Delegación ';
$string['submit_value_add_questions'] = 'Guardar Pregunta ';
$string['answer_one'] = 'Respuesta Uno ';
$string['answer_two'] = 'Respuesta Dos ';
$string['answer_three'] = 'Respuesta Tres ';
$string['answer_four'] = 'Respuesta Cuatro ';
$string['correct_answer_one'] = 'La Respuesta Correcta es la Primera ';
$string['correct_answer_two'] = 'La Respuesta Correcta es la Segunda ';
$string['correct_answer_three'] = 'La Respuesta Correcta es la Tercera ';
$string['correct_answer_four'] = 'La Respuesta Correcta es la Cuarta ';
$string['option_default_id_examen'] = 'Selecciona el Examen';
$string['option_default_id_delegation'] = 'Selecciona la Delegación';
$string['error_answer_correct_message'] = 'Los datos se guardaron PERO ... <br>'.
'No es posible habilitar la pregunta, existe más de una respuesta correcta';
$string['title_table_answers'] = 'Tabla de Respuestas de los Usuarios';
$string['finish_exam'] = 'Terminar examen y enviar las respuestas';
$string['error_id_exam'] = 'Es necesario el parámetro del identificador del Examen, '.
'no debe de estar vacio.';
$string['name'] = 'Nombre Completo';
$string['number_employee'] = 'Número de Empleado';
$string['unit_hospital'] = 'Unidad Hospitalaria';
$string['charge'] = 'Cargo';
$string['institutional_email'] = 'Correo Electrónico Institucional';
$string['personal_email'] = 'Correo Electrónico Personal';
$string['question_section'] = 'Preguntas:';
$string['question_instructions'] = 'Selecciona la Respuesta Correcta';
$string['calif'] = 'Tu Calificación Fue de :';