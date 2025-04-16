<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * The editing form for diagnosis question type is defined here.
 *
 * @package     qtype_diagnosis
 * @copyright   23/24 SDP<group_31_CS_F>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Diagnosis question editing form definition.
 *
 * @copyright  2007 Jamie Pratt
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_diagnosis_edit_form extends question_edit_form {

    public static function file_picker_options() {
        $filepickeroptions = array();
        $filepickeroptions['accepted_types'] = array('web_image');
        $filepickeroptions['maxbytes'] = 0;
        $filepickeroptions['maxfiles'] = 1;
        $filepickeroptions['subdirs'] = 0;
        return $filepickeroptions;
    }

    public function js_call() {
        global $PAGE;
        $PAGE->requires->js_call_amd('qtype_diagnosis/form', 'init');
    }

    /**
     * Add question-type specific form fields.
     *
     * @param object $mform the form being built.
     */
    protected function definition_inner($mform) {
        parent::definition_inner($mform);
        $menu = array(
            get_string('answersingleno', 'qtype_diagnosis'),
            get_string('answersingleyes', 'qtype_diagnosis'),
        );
        $mform->addElement('select', 'single',
                get_string('answerhowmany', 'qtype_diagnosis'), $menu);
        $mform->setDefault('single', $this->get_default_value('single',
            get_config('qtype_diagnosis', 'answerhowmany')));

        $mform->addElement('advcheckbox', 'shuffleanswers',
                get_string('shuffleanswers', 'qtype_diagnosis'), null, null, array(0, 1));
        $mform->addHelpButton('shuffleanswers', 'shuffleanswers', 'qtype_diagnosis');
        $mform->setDefault('shuffleanswers', $this->get_default_value('shuffleanswers',
            get_config('qtype_diagnosis', 'shuffleanswers')));

        $mform->addElement('select', 'answernumbering',
                get_string('answernumbering', 'qtype_diagnosis'),
                qtype_diagnosis::get_numbering_styles());
        $mform->setDefault('answernumbering', $this->get_default_value('answernumbering',
            get_config('qtype_diagnosis', 'answernumbering')));

        $mform->addElement('selectyesno', 'showstandardinstruction',
            get_string('showstandardinstruction', 'qtype_diagnosis'), null, null, [0, 1]);
        $mform->addHelpButton('showstandardinstruction', 'showstandardinstruction', 'qtype_diagnosis');
        $mform->setDefault('showstandardinstruction', $this->get_default_value('showstandardinstruction',
                get_config('qtype_diagnosis', 'showstandardinstruction')));

        //Added ~ Salma Eletreby
        $this->js_call();
        $questionTypeLogic = '
        var qtype = document.getElementById(\'id_questionType\');
        var question = "";

        function FillQuestionName(q) {
            document.getElementById(\'id_name\').value = q
            document.getElementById(\'id_questiontext_ifr\').contentDocument.querySelector(\'body[data-id="id_questiontext"]\').innerHTML = `<p>${q}</p>`;
        }

        switch(qtype.value){
            case "EOFS":
            case "EOFSOC":
                if(qtype.value == "EOFS"){
                    question = "Is the face symmetrical?"
                }

                if(qtype.value == "EOFSOC"){
                    question = "Is the Upper Occlusal Plane canted?"
                }

                FillQuestionName(question)

                document.getElementById(\'id_answer_0_ifr\').contentDocument.querySelector(\'body[data-id="id_answer_0"]\').innerHTML = \'<p>Yes</p>\';
                document.getElementById(\'id_answer_1_ifr\').contentDocument.querySelector(\'body[data-id="id_answer_1"]\').innerHTML = \'<p>No</p>\';
                break;
            case "EOFAS":
                question = "Describe the severity of asymmetry"
                FillQuestionName(question)

                document.getElementById(\'id_answer_0_ifr\').contentDocument.querySelector(\'body[data-id="id_answer_0"]\').innerHTML = \'<p>No Asymmetry</p>\';
                document.getElementById(\'id_answer_1_ifr\').contentDocument.querySelector(\'body[data-id="id_answer_1"]\').innerHTML = \'<p>Moderate</p>\';
                document.getElementById(\'id_answer_2_ifr\').contentDocument.querySelector(\'body[data-id="id_answer_2"]\').innerHTML = \'<p>Mild</p>\';
                document.getElementById(\'id_answer_3_ifr\').contentDocument.querySelector(\'body[data-id="id_answer_3"]\').innerHTML = \'<p>Severe</p>\';
                break;
            case "EOFLVH":
            case "PNA":
            case "PMPA":
            case "PLFH":
                if(qtype.value == "EOFLVH"){
                    question = "Describe the Lower Vertical Height"
                }

                if(qtype.value == "PNA"){
                    question = "Describe the Nasolabial angle"
                }

                if(qtype.value == "PMPA"){
                    question = "Describe the mandibular plane angle"
                }
            
                if(qtype.value == "PLFH"){
                    question = "Describe the Lower Face Height"
                }
                
                FillQuestionName(question)

                document.getElementById(\'id_answer_0_ifr\').contentDocument.querySelector(\'body[data-id="id_answer_0"]\').innerHTML = \'<p>Reduced</p>\';
                document.getElementById(\'id_answer_1_ifr\').contentDocument.querySelector(\'body[data-id="id_answer_1"]\').innerHTML = \'<p>Normal</p>\';
                document.getElementById(\'id_answer_2_ifr\').contentDocument.querySelector(\'body[data-id="id_answer_2"]\').innerHTML = \'<p>Increased</p>\';
                break;
            case "EOFLC":
                question = "Describe Lip competence"
                FillQuestionName(question)

                document.getElementById(\'id_answer_0_ifr\').contentDocument.querySelector(\'body[data-id="id_answer_0"]\').innerHTML = \'<p>Compoetent</p>\';
                document.getElementById(\'id_answer_1_ifr\').contentDocument.querySelector(\'body[data-id="id_answer_1"]\').innerHTML = \'<p>Incompetent</p>\';
                document.getElementById(\'id_answer_2_ifr\').contentDocument.querySelector(\'body[data-id="id_answer_2"]\').innerHTML = \'<p>Potentially competent</p>\';
                break;
            case "EOFSSL":
                question = "Describe Smile line"
                FillQuestionName(question)

                document.getElementById(\'id_answer_0_ifr\').contentDocument.querySelector(\'body[data-id="id_answer_0"]\').innerHTML = \'<p>Normal</p>\';
                document.getElementById(\'id_answer_1_ifr\').contentDocument.querySelector(\'body[data-id="id_answer_1"]\').innerHTML = \'<p>High</p>\';
                document.getElementById(\'id_answer_2_ifr\').contentDocument.querySelector(\'body[data-id="id_answer_2"]\').innerHTML = \'<p>Low</p>\';
                break;
            case "EOFSSA":
                question ="Describe Smile arc"
                FillQuestionName(question)

                document.getElementById(\'id_answer_0_ifr\').contentDocument.querySelector(\'body[data-id="id_answer_0"]\').innerHTML = \'<p>Consonant</p>\';
                document.getElementById(\'id_answer_1_ifr\').contentDocument.querySelector(\'body[data-id="id_answer_1"]\').innerHTML = \'<p>Non Consonant</p>\';
                document.getElementById(\'id_answer_2_ifr\').contentDocument.querySelector(\'body[data-id="id_answer_2"]\').innerHTML = \'<p>Flat</p>\';
                document.getElementById(\'id_answer_3_ifr\').contentDocument.querySelector(\'body[data-id="id_answer_3"]\').innerHTML = \'<p>Reversed</p>\';
                break;
            case "EOFSDM":
                question = "Describe upper dental midline to the midline of the face"
                FillQuestionName(question)

                document.getElementById(\'id_answer_0_ifr\').contentDocument.querySelector(\'body[data-id="id_answer_0"]\').innerHTML = \'<p>Coincident</p>\';
                document.getElementById(\'id_answer_1_ifr\').contentDocument.querySelector(\'body[data-id="id_answer_1"]\').innerHTML = \'<p>Shifted</p>\';
                break;
            case "EOFSDMSD":
                question = "Describe upper dental midline shift direction"
                FillQuestionName(question)

                document.getElementById(\'id_answer_0_ifr\').contentDocument.querySelector(\'body[data-id="id_answer_0"]\').innerHTML = \'<p>Right</p>\';
                document.getElementById(\'id_answer_1_ifr\').contentDocument.querySelector(\'body[data-id="id_answer_1"]\').innerHTML = \'<p>Left</p>\';
                document.getElementById(\'id_answer_2_ifr\').contentDocument.querySelector(\'body[data-id="id_answer_2"]\').innerHTML = \'<p>No shift</p>\';
                break;
            case "EOFSDMSDD":
                question = "Describe upper dental midline shift distance"
                FillQuestionName(question)

                document.getElementById(\'id_answer_0_ifr\').contentDocument.querySelector(\'body[data-id="id_answer_0"]\').innerHTML = \'<p>2</p>\';
                document.getElementById(\'id_answer_1_ifr\').contentDocument.querySelector(\'body[data-id="id_answer_1"]\').innerHTML = \'<p>3</p>\';
                document.getElementById(\'id_answer_2_ifr\').contentDocument.querySelector(\'body[data-id="id_answer_2"]\').innerHTML = \'<p>4</p>\';
                break;
            case "PD":
                question = "Describe the Profile"
                FillQuestionName(question)

                document.getElementById(\'id_answer_0_ifr\').contentDocument.querySelector(\'body[data-id="id_answer_0"]\').innerHTML = \'<p>Convex</p>\';
                document.getElementById(\'id_answer_1_ifr\').contentDocument.querySelector(\'body[data-id="id_answer_1"]\').innerHTML = \'<p>Straight</p>\';
                document.getElementById(\'id_answer_2_ifr\').contentDocument.querySelector(\'body[data-id="id_answer_2"]\').innerHTML = \'<p>Concave</p>\';
                break;
        }
        ';

        //Added ~ Salma Eletreby
        $customElement = $mform->createElement('select', 'questionType',
                get_string('questionType', 'qtype_diagnosis'),
                qtype_diagnosis::get_questionMode(),array('onchange' => $questionTypeLogic) );


        $mform->insertElementBefore($customElement, 'name');


        $mform->addElement('button', 'ML', get_string('ML', 'qtype_'.$this->qtype()));
        $mform->addElement('filepicker', 'image', get_string('MLImage', 'qtype_'.$this->qtype()),
                                                               null, self::file_picker_options());

        $mform->addHelpButton('image', 'image', 'qtype_diagnosis');

        $mform ->addElement('text','token','Token');
        $mform->addHelpButton('token', 'token', 'qtype_diagnosis');
        $mform->addElement('button', 'generate', get_string('generate', 'qtype_'.$this->qtype()));
        $mform->getElement('generate')->updateAttributes(array('disabled' => 'disabled'));


        $mform->getElement('ML')->updateAttributes(array('onclick' => '
        var filePicker = document.getElementById(\'fitem_id_image\');
        if (window.getComputedStyle(filePicker).display == \'none\') {
            document.getElementById(\'id_generate\').style.display = \'block\';
            document.getElementById(\'fitem_id_token\').style.display = \'block\';
            document.getElementById(\'id_token\').style.marginLeft = \'18rem\';
            document.getElementById(\'id_token\').style.marginTop = \'-3rem\';
            filePicker.style.display = \'block\';
            document.querySelector(\'.felement[data-fieldtype="filepicker"]\').style.marginLeft = \'18rem\';
            document.querySelector(\'.felement[data-fieldtype="filepicker"]\').style.marginTop = \'-3rem\';
        } else {
            document.getElementById(\'id_generate\').style.display = \'none\';
            document.getElementById(\'fitem_id_token\').style.display = \'none\';
            filePicker.style.display = \'none\'; // Hide the file picker
        }
        '));   
        
        

        $mform->getElement('generate')->updateAttributes(array('onclick' => '
        var qtype = document.getElementById(\'id_questionType\');
        var userToken = document.getElementById(\'id_token\').value

        var btn = document.getElementById(\'id_generate\');
        btn.innerHTML = \'<div class="loader" style="border: 4px solid rgba(0, 0, 0, 0.1); border-left-color: #3498db; border-radius: 50%; width: 40px; height: 40px; animation: spin 1s linear infinite;">&nbsp;</div>\';

        const endpointUrl = "https://aitech.net.au/cephalo-mastery/ai/diagnosis/predict";
        const imageURL = document.getElementsByClassName("filepicker-filename")[0].querySelector(\'a\').getAttribute(\'href\');

        const APIUrl = imageURL.replace("/draftfile.php/", "/webservice/draftfile.php/") + "?token=" + userToken;
        var answer = "Yes";
        var numAnswers = 2;

        switch(qtype.value){
            case "EOFS":
            case "EOFSOC":
            case "EOFSDM":
                numAnswers = 2
                break; 
            case "EOFAS":
            case "EOFSSA":
                numAnswers = 4
                break;
            case "EOFLVH":
            case "PNA":
            case "PMPA":
            case "PLFH":
            case "EOFLC":
            case "EOFSSL":
            case "EOFSDMSD":
            case "EOFSDMSDD":
            case "PD":
                numAnswers = 3
                break;
        }

        fetch(endpointUrl, {
            method: "POST",
            headers: {
              "Access-Control-Allow-Origin": "*",
              "Content-Type": "application/json"
            },
            body: JSON.stringify({imageURL:APIUrl,model:qtype.value}),
          })
            .then((response) => {
              if (!response.ok) {
                throw new Error("Error occurred while fetching data");
              }
              // Parse the JSON response
              return response.json();
            })
            .then((data) => {
              console.log(data)
              answer = data

            for (var i = 0; i < numAnswers; i++) {
                var elementId = \'id_answer_\' + i + \'_ifr\';
                
                var paragraphElement = document.getElementById(elementId).contentDocument.querySelector(\'body[data-id="id_answer_\' + i + \'"] p\');
                if (paragraphElement && paragraphElement.innerHTML.trim() === answer) {
                    document.getElementById(elementId.replace("_ifr", "").replace("answer","fraction")).value = "1.0"
                    console.log("reached the answer")
                } else {
                    document.getElementById(elementId.replace("_ifr", "").replace("answer","fraction")).value = "0.0"
                }
            }

            btn.innerHTML = \'Answer Retrieved Succesfully\';
            })
            .catch((error) => {
              console.error(error.message);
              btn.innerHTML = \'Connection failed.Check the token or image or type of question\';
              document.getElementById(\'id_token\').value =""
            });




        '));

        $this->add_per_answer_fields($mform, get_string('choiceno', 'qtype_diagnosis', '{no}'),
                question_bank::fraction_options_full(), max(5, QUESTION_NUMANS_START));

        $this->add_combined_feedback_fields(true);
        $mform->disabledIf('shownumcorrect', 'single', 'eq', 1);

        $this->add_interactive_settings(true, true);
    }

    protected function get_per_answer_fields($mform, $label, $gradeoptions,
            &$repeatedoptions, &$answersoption) {
        $repeated = array();
        $repeated[] = $mform->createElement('editor', 'answer',
            $label, ['rows' => 2], $this->editoroptions);
        $repeated[] = $mform->createElement('select', 'fraction',
                get_string('gradenoun'), $gradeoptions);
        $repeated[] = $mform->createElement('editor', 'feedback',
            get_string('feedback', 'question'), ['rows' => 2], $this->editoroptions);
        $repeatedoptions['answer']['type'] = PARAM_RAW;
        $repeatedoptions['fraction']['default'] = 0;
        $answersoption = 'answers';
        return $repeated;
    }

    protected function get_hint_fields($withclearwrong = false, $withshownumpartscorrect = false) {
        list($repeated, $repeatedoptions) = parent::get_hint_fields($withclearwrong, $withshownumpartscorrect);
        $repeatedoptions['hintclearwrong']['disabledif'] = array('single', 'eq', 1);
        $repeatedoptions['hintshownumcorrect']['disabledif'] = array('single', 'eq', 1);
        return array($repeated, $repeatedoptions);
    }

    protected function data_preprocessing($question) {
        $question = parent::data_preprocessing($question);
        $question = $this->data_preprocessing_answers($question, true);
        $question = $this->data_preprocessing_combined_feedback($question, true);
        $question = $this->data_preprocessing_hints($question, true, true);

        if (!empty($question->options)) {
            $question->single = $question->options->single;
            $question->shuffleanswers = $question->options->shuffleanswers;
            $question->answernumbering = $question->options->answernumbering;
            $question->showstandardinstruction = $question->options->showstandardinstruction;
            $question->questionType = $question->options->questiontype;
        }

        return $question;
    }

    public function validation($data, $files) {
        $errors = parent::validation($data, $files);
        $answers = $data['answer'];
        $answercount = 0;

        $totalfraction = 0;
        $maxfraction = -1;

        foreach ($answers as $key => $answer) {
            // Check no of choices.
            $trimmedanswer = trim($answer['text']);
            $fraction = (float) $data['fraction'][$key];
            if ($trimmedanswer === '' && empty($fraction)) {
                continue;
            }
            if ($trimmedanswer === '') {
                $errors['fraction['.$key.']'] = get_string('errgradesetanswerblank', 'qtype_diagnosis');
            }

            $answercount++;

            // Check grades.
            if ($data['fraction'][$key] > 0) {
                $totalfraction += $data['fraction'][$key];
            }
            if ($data['fraction'][$key] > $maxfraction) {
                $maxfraction = $data['fraction'][$key];
            }
        }

        if ($answercount == 0) {
            $errors['answer[0]'] = get_string('notenoughanswers', 'qtype_diagnosis', 2);
            $errors['answer[1]'] = get_string('notenoughanswers', 'qtype_diagnosis', 2);
        } else if ($answercount == 1) {
            $errors['answer[1]'] = get_string('notenoughanswers', 'qtype_diagnosis', 2);

        }

        // Perform sanity checks on fractional grades.
        if ($data['single']) {
            if ($maxfraction != 1) {
                $errors['fraction[0]'] = get_string('errfractionsnomax', 'qtype_diagnosis',
                        $maxfraction * 100);
            }
        } else {
            $totalfraction = round($totalfraction, 2);
            if ($totalfraction != 1) {
                $errors['fraction[0]'] = get_string('errfractionsaddwrong', 'qtype_diagnosis',
                        $totalfraction * 100);
            }
        }
        return $errors;
    }

    public function qtype() {
        return 'diagnosis';
    }
}
