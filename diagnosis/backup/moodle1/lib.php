<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package    qtype
 * @subpackage diagnosis
 * @copyright  2011 David Mudrak <david@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * diagnosis question type conversion handler
 */
class moodle1_qtype_diagnosis_handler extends moodle1_qtype_handler {

    /**
     * @return array
     */
    public function get_question_subpaths() {
        return array(
            'ANSWERS/ANSWER',
            'diagnosis',
        );
    }

    /**
     * Appends the diagnosis specific information to the question
     */
    public function process_question(array $data, array $raw) {

        // Convert and write the answers first.
        if (isset($data['answers'])) {
            $this->write_answers($data['answers'], $this->pluginname);
        }

        // Convert and write the diagnosis.
        if (!isset($data['diagnosis'])) {
            // This should never happen, but it can do if the 1.9 site contained
            // corrupt data.
            $data['diagnosis'] = array(array(
                'single'                         => 1,
                'shuffleanswers'                 => 1,
                'correctfeedback'                => '',
                'correctfeedbackformat'          => FORMAT_HTML,
                'partiallycorrectfeedback'       => '',
                'partiallycorrectfeedbackformat' => FORMAT_HTML,
                'incorrectfeedback'              => '',
                'incorrectfeedbackformat'        => FORMAT_HTML,
                'answernumbering'                => 'abc',
                'showstandardinstruction'        => 0
            ));
        }
        $this->write_diagnosis($data['diagnosis'], $data['oldquestiontextformat'], $data['id']);
    }

    /**
     * Converts the diagnosis info and writes it into the question.xml
     *
     * @param array $diagnosiss the grouped structure
     * @param int $oldquestiontextformat - {@see moodle1_question_bank_handler::process_question()}
     * @param int $questionid question id
     */
    protected function write_diagnosis(array $diagnosiss, $oldquestiontextformat, $questionid) {
        global $CFG;

        // The grouped array is supposed to have just one element - let us use foreach anyway
        // just to be sure we do not loose anything.
        foreach ($diagnosiss as $diagnosis) {
            // Append an artificial 'id' attribute (is not included in moodle.xml).
            $diagnosis['id'] = $this->converter->get_nextid();

            // Replay the upgrade step 2009021801.
            $diagnosis['correctfeedbackformat']               = 0;
            $diagnosis['partiallycorrectfeedbackformat']      = 0;
            $diagnosis['incorrectfeedbackformat']             = 0;

            if ($CFG->texteditors !== 'textarea' and $oldquestiontextformat == FORMAT_MOODLE) {
                $diagnosis['correctfeedback']                 = text_to_html($diagnosis['correctfeedback'], false, false, true);
                $diagnosis['correctfeedbackformat']           = FORMAT_HTML;
                $diagnosis['partiallycorrectfeedback']        = text_to_html($diagnosis['partiallycorrectfeedback'], false, false, true);
                $diagnosis['partiallycorrectfeedbackformat']  = FORMAT_HTML;
                $diagnosis['incorrectfeedback']               = text_to_html($diagnosis['incorrectfeedback'], false, false, true);
                $diagnosis['incorrectfeedbackformat']         = FORMAT_HTML;
            } else {
                $diagnosis['correctfeedbackformat']           = $oldquestiontextformat;
                $diagnosis['partiallycorrectfeedbackformat']  = $oldquestiontextformat;
                $diagnosis['incorrectfeedbackformat']         = $oldquestiontextformat;
            }

            $diagnosis['correctfeedback'] = $this->migrate_files(
                    $diagnosis['correctfeedback'], 'question', 'correctfeedback', $questionid);
            $diagnosis['partiallycorrectfeedback'] = $this->migrate_files(
                    $diagnosis['partiallycorrectfeedback'], 'question', 'partiallycorrectfeedback', $questionid);
            $diagnosis['incorrectfeedback'] = $this->migrate_files(
                    $diagnosis['incorrectfeedback'], 'question', 'incorrectfeedback', $questionid);

            $this->write_xml('diagnosis', $diagnosis, array('/diagnosis/id'));
        }
    }
}
