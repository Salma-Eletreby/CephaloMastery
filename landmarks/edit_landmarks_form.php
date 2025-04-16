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
 * Base class for editing form for the drag-and-drop images onto images question type.
 *
 * @package     qtype_landmarks
 * @copyright   23/24 SDP<group_31_CS_F>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

//this is a file that is open source that is used throughout moodle's questions
//we needed to modify some values so we could not use the base one
//modified or added code will be marked

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/question/type/landmarks/edit_landmarks_form_base.php');
require_once($CFG->dirroot . '/question/type/landmarks/shapes.php');





define('QTYPE_LANDMARKS_ALLOWED_TAGS_IN_MARKER', '<br><i><em><b><strong><sup><sub><u><span>');


/**
 * Drag-and-drop images onto images  editing form definition.
 *
 * @copyright 2009 The Open University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_landmarks_edit_form extends qtype_landmarks_edit_form_base
{
    public function qtype()
    {
        return 'landmarks';
    }

    protected function definition_inner($mform)
    {
        $mform->addElement('advcheckbox', 'showmisplaced', get_string('showmisplaced', 'qtype_landmarks'));
        $mform->setDefault('showmisplaced', $this->get_default_value('showmisplaced', 0));
        parent::definition_inner($mform);

        $mform->addHelpButton('drops[0]', 'dropzones', 'qtype_landmarks');
    }

    public function js_call()
    {
        global $PAGE;
        $PAGE->requires->js_call_amd('qtype_landmarks/form', 'init');
    }


    protected function definition_draggable_items($mform, $itemrepeatsatstart)
    {
        $mform->addElement(
            'header',
            'draggableitemheader',
            get_string('markers', 'qtype_landmarks')
        );
        $mform->addElement('advcheckbox', 'shuffleanswers', get_string('shuffleimages', 'qtype_' . $this->qtype()));
        $mform->setDefault('shuffleanswers', $this->get_default_value('shuffleanswers', 0));
        $this->repeat_elements(
            $this->draggable_item($mform),
            $itemrepeatsatstart,
            $this->draggable_items_repeated_options(),
            'noitems',
            'additems',
            self::ADD_NUM_ITEMS,
            get_string('addmoreitems', 'qtype_landmarks'),
            true
        );
    }

    //Added
    protected function definition_distance_items($mform, $itemrepeatsatstart, $imagerepeats)
    {
        $mform->addElement('header', 'distanceheaders', get_string('distanceTitle', 'qtype_landmarks'));
        //Aya number of comparisons
        $this->repeat_elements(
            $this->distance($mform, $imagerepeats),
            3,
            $this->distance_angle_repeated_options(),
            'nodistance',
            'adddistance',
            self::ADD_NUM_ITEMS,
            get_string('addmoredistance', 'qtype_landmarks'),
            true
        );
    }

    //Aya
    protected function definition_angle_items($mform, $itemrepeatsatstart, $imagerepeats)
    {
        $mform->addElement('header', 'angleheaders', get_string('angleTitle', 'qtype_landmarks'));

        $this->repeat_elements(
            $this->angle($mform, $imagerepeats),
            3,
            $this->distance_angle_repeated_options(),
            'noangle',
            'addangle',
            self::ADD_NUM_ITEMS,
            get_string('addmoreangle', 'qtype_landmarks'),
            true
        );
    }
    //Aya
    protected function angle($mform, $imagerepeats)
    {
        $markernos = array();
        $markernos[0] = '';
        for ($i = 1; $i <= $imagerepeats; $i += 1) {
            $markernos[$i] = $i;
        }
        $grouparray[] = $mform->createElement(
            'select',
            'point1',
            get_string('marker', 'qtype_landmarks'),
            $markernos
        );

        $grouparray[] = $mform->createElement(
            'select',
            'point2',
            get_string('marker', 'qtype_landmarks'),
            $markernos
        );

        $grouparray[] = $mform->createElement(
            'select',
            'point3',
            get_string('marker', 'qtype_landmarks'),
            $markernos
        );
        $grouparray[] = $mform->createElement(
            'text',
            'angle',
            get_string('angle', 'qtype_landmarks'),
            array('size' => 30, 'class' => 'tweakcss')
        );

        for ($i = 0; $i <= $imagerepeats; $i += 1) {
            $mform->setType("angles[$i][angle]", PARAM_RAW);
        }

        $angle = $mform->createElement(
            'group',
            'angles',
            get_string('anglecomparison', 'qtype_landmarks', '{no}'),
            $grouparray
        );

        return array($angle);
    }
    //Added
    protected function distance($mform, $imagerepeats)
    {
        $markernos = array();
        $markernos[0] = '';
        for ($i = 1; $i <= $imagerepeats; $i += 1) {
            $markernos[$i] = $i;
        }

        $grouparray[] = $mform->createElement(
            'select',
            'point1',
            get_string('marker', 'qtype_landmarks'),
            $markernos
        );

        $grouparray[] = $mform->createElement(
            'select',
            'point2',
            get_string('marker', 'qtype_landmarks'),
            $markernos
        );

        $grouparray[] = $mform->createElement(
            'text',
            'distance',
            get_string('distance', 'qtype_landmarks'),
            array('size' => 30, 'class' => 'tweakcss')
        );

        for ($i = 0; $i <= $imagerepeats; $i += 1) {
            $mform->setType("dd[$i][distance]", PARAM_RAW);
        }

        $distance = $mform->createElement(
            'group',
            'dd',
            get_string('comparison', 'qtype_landmarks', '{no}'),
            $grouparray
        );

        return array($distance);
    }

    //Added
    protected function distance_angle_repeated_options()
    {
        $repeatedoptions = array();
        $repeatedoptions['distance[label]']['type'] = PARAM_RAW;
        return $repeatedoptions;
    }

    protected function draggable_item($mform)
    {
        $draggableimageitem = array();

        $grouparray = array();
        $grouparray[] = $mform->createElement(
            'text',
            'label',
            '',
            array('size' => 30, 'class' => 'tweakcss')
        );
        $mform->setType('text', PARAM_RAW_TRIMMED);

        $noofdragoptions = array(0 => get_string('infinite', 'qtype_landmarks'));
        foreach (range(1, 6) as $option) {
            $noofdragoptions[$option] = $option;
        }
        $grouparray[] = $mform->createElement('select', 'noofdrags', get_string('noofdrags', 'qtype_landmarks'), $noofdragoptions);

        $draggableimageitem[] = $mform->createElement(
            'group',
            'drags',
            get_string('marker_n', 'qtype_landmarks'),
            $grouparray
        );
        return $draggableimageitem;
    }

    protected function draggable_items_repeated_options()
    {
        $repeatedoptions = array();
        $repeatedoptions['drags[label]']['type'] = PARAM_RAW;
        return $repeatedoptions;
    }

    protected function drop_zone($mform, $imagerepeats)
    {
        $grouparray = array();
        $shapearray = qtype_landmarks_shape::shape_options();
        $grouparray[] = $mform->createElement(
            'select',
            'shape',
            get_string('shape', 'qtype_landmarks'),
            $shapearray
        );
        $markernos = array();
        $markernos[0] = '';
        for ($i = 1; $i <= $imagerepeats; $i += 1) {
            $markernos[$i] = $i;
        }
        $grouparray[] = $mform->createElement(
            'select',
            'choice',
            get_string('marker', 'qtype_landmarks'),
            $markernos
        );
        $grouparray[] = $mform->createElement(
            'text',
            'coords',
            get_string('coords', 'qtype_landmarks'),
            array('size' => 30, 'class' => 'tweakcss')
        );
        $mform->setType('coords', PARAM_RAW); // These are validated manually.
        $dropzone = $mform->createElement(
            'group',
            'drops',
            get_string('dropzone', 'qtype_landmarks', '{no}'),
            $grouparray
        );
        return array($dropzone);
    }

    protected function drop_zones_repeated_options()
    {
        $repeatedoptions = array();
        $repeatedoptions['drops[coords]']['type'] = PARAM_RAW;
        return $repeatedoptions;
    }

    protected function get_hint_fields($withclearwrong = false, $withshownumpartscorrect = false)
    {
        $mform = $this->_form;

        $repeated = array();
        $repeated[] = $mform->createElement(
            'editor',
            'hint',
            get_string('hintn', 'question'),
            array('rows' => 5),
            $this->editoroptions
        );
        $repeatedoptions['hint']['type'] = PARAM_RAW;

        $repeated[] = $mform->createElement(
            'checkbox',
            'hintshownumcorrect',
            get_string('options', 'question'),
            get_string('shownumpartscorrect', 'question')
        );
        $repeated[] = $mform->createElement(
            'checkbox',
            'hintoptions',
            '',
            get_string('stateincorrectlyplaced', 'qtype_landmarks')
        );
        $repeated[] = $mform->createElement(
            'checkbox',
            'hintclearwrong',
            '',
            get_string('clearwrongparts', 'qtype_landmarks')
        );

        return array($repeated, $repeatedoptions);
    }

    public function data_preprocessing($question)
    {
        global $DB;
        $question = parent::data_preprocessing($question);
        $question = $this->data_preprocessing_combined_feedback($question, true);
        $question = $this->data_preprocessing_hints($question, true, true);

        //Aya
        $dragids = array(); // Drag no -> dragid.
        if (!empty($question->options)) {
            $question->shuffleanswers = $question->options->shuffleanswers;
            $question->showmisplaced = $question->options->showmisplaced;
            $question->drags = array();
            foreach ($question->options->drags as $drag) {
                $dragindex = $drag->no - 1;
                $question->drags[$dragindex] = array();
                $question->drags[$dragindex]['label'] = $drag->label;
                if ($drag->infinite == 1) {
                    $question->drags[$dragindex]['noofdrags'] = 0;
                } else {
                    $question->drags[$dragindex]['noofdrags'] = $drag->noofdrags;
                }
                $dragids[$dragindex] = $drag->id;
            }
            $question->drops = array();

            foreach ($question->options->drops as $drop) {
                $droparray = (array)$drop;
                unset($droparray['id']);
                unset($droparray['no']);
                unset($droparray['questionid']);
                $question->drops[$drop->no - 1] = $droparray;
            }
        }
        

        $distances = $DB->get_recordset_select('qtype_landmarks_points_relation', 'questionid = ?', array($question->id));
        $question->dd = array();
        $dindex = 0;

        foreach ($distances as $dpoint) {
            $question->dd[$dindex] = array(
                'point1' => $dpoint->point1,
                'point2' => $dpoint->point2,
                'distance' => $dpoint->distance,
            );
            $dindex++;
        }

        $distances->close();

        $angles = $DB->get_recordset_select('qtype_landmarks_angles', 'questionid = ?', array($question->id));
        $question->angles = array();
        $aindex = 0;

        foreach ($angles as $apoint) {
            $question->angles[$aindex] = array(
                'point1' => $apoint->point1,
                'point2' => $apoint->point2,
                'point3' => $apoint->point3,
                'angle' => $apoint->angle,
            );
            $aindex++;
        }

        $angles->close();


        // Initialise file picker for bgimage.
        $draftitemid = file_get_submitted_draft_itemid('bgimage');

        file_prepare_draft_area(
            $draftitemid,
            $this->context->id,
            'qtype_landmarks',
            'bgimage',
            !empty($question->id) ? (int) $question->id : null,
            self::file_picker_options()
        );
        $question->bgimage = $draftitemid;

        $this->js_call();

        return $question;
    }

    /**
     * Perform the necessary preprocessing for the hint fields.
     *
     * @param object $question The data being passed to the form.
     * @param bool $withclearwrong Clear wrong hints.
     * @param bool $withshownumpartscorrect Show number correct.
     * @return object The modified data.
     */
    protected function data_preprocessing_hints(
        $question,
        $withclearwrong = false,
        $withshownumpartscorrect = false
    ) {
        if (empty($question->hints)) {
            return $question;
        }
        parent::data_preprocessing_hints($question, $withclearwrong, $withshownumpartscorrect);

        $question->hintoptions = array();
        foreach ($question->hints as $hint) {
            $question->hintoptions[] = $hint->options;
        }

        return $question;
    }

    public function validation($data, $files)
    {
        $errors = parent::validation($data, $files);
        $bgimagesize = $this->get_image_size_in_draft_area($data['bgimage']);
        if ($bgimagesize === null) {
            $errors["bgimage"] = get_string('formerror_nobgimage', 'qtype_landmarks');
        }

        $dropfound = false;
        for ($i = 0; $i < $data['nodropzone']; $i++) {
            $choice = $data['drops'][$i]['choice'];
            $choicepresent = ($choice !== '0');

            if ($choicepresent) {
                $dropfound = true;
                // Test coords here.
                if ($bgimagesize !== null) {
                    $shape = $data['drops'][$i]['shape'];
                    $coordsstring = $data['drops'][$i]['coords'];
                    $shapeobj = qtype_landmarks_shape::create($shape, $coordsstring);
                    $interpretererror = $shapeobj->get_coords_interpreter_error();
                    if ($interpretererror !== false) {
                        $errors["drops[{$i}]"] = $interpretererror;
                    } else if (!$shapeobj->inside_width_height($bgimagesize)) {
                        $errorcode = 'shapeoutsideboundsofbgimage';
                        $errors["drops[{$i}]"] =
                            get_string('formerror_' . $errorcode, 'qtype_landmarks');
                    }
                }
            } else {
                if (trim($data['drops'][$i]['coords']) !== '') {
                    $dropfound = true;
                    $errorcode = 'noitemselected';
                    $errors["drops[{$i}]"] = get_string('formerror_' . $errorcode, 'qtype_landmarks');
                }
            }
        }
        if (!$dropfound) {
            $errors['drops[0]'] = get_string('formerror_droprequired', 'qtype_landmarks');
        }

        $markerfound = false;
        for ($dragindex = 0; $dragindex < $data['noitems']; $dragindex++) {
            $label = $data['drags'][$dragindex]['label'];
            if ($label !== '') {
                $markerfound = true;
            }
            if ($label != strip_tags($label, QTYPE_LANDMARKS_ALLOWED_TAGS_IN_MARKER)) {
                $errors["drags[{$dragindex}]"]
                    = get_string(
                        'formerror_onlysometagsallowed',
                        'qtype_landmarks',
                        s(QTYPE_LANDMARKS_ALLOWED_TAGS_IN_MARKER)
                    );
            }
        }
        if (!$markerfound) {
            $errors['drags[0]'] = get_string('formerror_dragrequired', 'qtype_landmarks');
        }

        return $errors;
    }

    /**
     * Gets the width and height of a draft image.
     *
     * @param int $draftitemid ID of the draft image
     * @return array Return array of the width and height of the draft image.
     */
    public function get_image_size_in_draft_area($draftitemid)
    {
        global $USER;
        $usercontext = context_user::instance($USER->id);
        $fs = get_file_storage();
        $draftfiles = $fs->get_area_files($usercontext->id, 'user', 'draft', $draftitemid, 'id');
        if ($draftfiles) {
            foreach ($draftfiles as $file) {
                if ($file->is_directory()) {
                    continue;
                }
                // Just return the data for the first good file, there should only be one.
                $imageinfo = $file->get_imageinfo();
                $width    = $imageinfo['width'];
                $height   = $imageinfo['height'];
                return array($width, $height);
            }
        }
        return null;
    }
}
