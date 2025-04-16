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
 * Plugin strings are defined here.
 *
 * @package     qtype_diagnosis
 * @category    string
 * @copyright   23/24 SDP<group_31_CS_F>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Diagnosis';
$string['answerhowmany'] = 'One or multiple answers?';
$string['answerhowmany_desc'] = 'Whether the default should be one response (i.e. radio buttons) or multiple responses (i.e. checkboxes).';
$string['answernumbering'] = 'Number the choices?';
$string['answernumbering123'] = '1., 2., 3., ...';
$string['answernumberingabc'] = 'a., b., c., ...';
$string['answernumberingABCD'] = 'A., B., C., ...';
$string['answernumberingiii'] = 'i., ii., iii., ...';
$string['answernumberingIIII'] = 'I., II., III., ...';
$string['answernumberingnone'] = 'No numbering';
$string['answernumbering_desc'] = 'The default numbering style.';
$string['answersingleno'] = 'Multiple answers allowed';
$string['answersingleyes'] = 'One answer only';
$string['choiceno'] = 'Choice {$a}';
$string['choices'] = 'Available choices';
$string['clearchoice'] = 'Clear my choice';
$string['clozeaid'] = 'Enter missing word';
$string['correctansweris'] = 'The correct answer is: {$a}';
$string['correctanswersare'] = 'The correct answers are: {$a}';
$string['correctfeedback'] = 'For any correct response';
$string['deletedchoice'] = 'This choice was deleted after the attempt was started.';
$string['errgradesetanswerblank'] = 'Grade set, but the Answer is blank';
$string['errfractionsaddwrong'] = 'The positive grades you have chosen do not add up to 100%<br />Instead, they add up to {$a}%';
$string['errfractionsnomax'] = 'One of the choices should be 100%, so that it is<br />possible to get a full grade for this question.';
$string['feedback'] = 'Feedback';
$string['fillouttwochoices'] = 'You must fill out at least two choices. Choices left blank will not be used.';
$string['fractionsaddwrong'] = 'The positive grades you have chosen do not add up to 100%<br />Instead, they add up to {$a}%<br />Do you want to go back and fix this question?';
$string['fractionsnomax'] = 'One of the choices should be 100%, so that it is<br />possible to get a full grade for this question.<br />Do you want to go back and fix this question?';
$string['incorrectfeedback'] = 'For any incorrect response';
$string['notenoughanswers'] = 'This type of question requires at least {$a} choices';
$string['overallcorrectfeedback'] = 'Feedback for any correct response';
$string['overallfeedback'] = 'Overall feedback';
$string['overallincorrectfeedback'] = 'Feedback for any incorrect response';
$string['overallpartiallycorrectfeedback'] = 'Feedback for any partially correct response';
$string['partiallycorrectfeedback'] = 'For any partially correct response';
$string['pleaseselectananswer'] = 'Please select an answer.';
$string['pleaseselectatleastoneanswer'] = 'Please select at least one answer.';
$string['pluginname_help'] = 'In response to a question (that may include an image) the respondent chooses from multiple answers. A diagnosis question may have one or multiple correct answers.';
$string['pluginname_link'] = 'question/type/diagnosis';
$string['pluginnameadding'] = 'Adding a diagnosis question';
$string['pluginnameediting'] = 'Editing a Diagnosis question';
$string['pluginnamesummary'] = 'Allows the creation of an orthodontic analysis and diagnosis question with the option to fill the form using ML.';
$string['privacy:metadata'] = 'Diagnosis question type plugin allows question authors to set default options as user preferences.';
$string['privacy:preference:defaultmark'] = 'The default mark set for a given question.';
$string['privacy:preference:penalty'] = 'The penalty for each incorrect try when questions are run using the \'Interactive with multiple tries\' or \'Adaptive mode\' behaviour.';
$string['privacy:preference:single'] = 'Whether the answer is single with radio buttons or multiple with checkboxes.';
$string['privacy:preference:shuffleanswers'] = 'Whether the answers should be automatically shuffled.';
$string['privacy:preference:answernumbering'] = 'Which numbering style should be used (\'1, 2, 3, ...\', \'a, b, c, ...\' etc.).';
$string['privacy:preference:showstandardinstruction'] = 'Whether standard instructions are shown.';
$string['regradeissuenumchoiceschanged'] = 'The number of choices in the question has changed.';
$string['selectmulti'] = 'Select one or more:';
$string['selectone'] = 'Select one:';
$string['shuffleanswers'] = 'Shuffle the choices?';
$string['shuffleanswers_desc'] = 'Whether options should be randomly shuffled for each attempt by default.';
$string['shuffleanswers_help'] = 'If enabled, the order of the answers is randomly shuffled for each attempt, provided that "Shuffle within questions" in the activity settings is also enabled.';
$string['singleanswer'] = 'Choose one answer.';
$string['showstandardinstruction'] = 'Show standard instructions';
$string['showstandardinstruction_desc'] = 'Whether to show the instructions "Select one:" or "Select one or more:" before Diagnosis answers.';
$string['showstandardinstruction_help'] = 'Whether to show the instructions \'Select one:\' or \'Select one or more:\' before Diagnosis answers. Alternatively, you can include instructions in the question text.';
$string['toomanyselected'] = 'You have selected too many options.';

//added
$string['ML'] = 'Use Machine Learning to fill details';
$string['MLImage'] = 'Image to send to the Machine Learning Model';
$string['image'] = 'uploading the image';
$string['image_help'] = 'Please note the image uploaded here will not be displayed to the student. Please upload the image in question text for it to be displayed to student';
$string['generate'] = 'Generate Answer using ML';
$string['questionType'] = 'What type of Question?';
$string['questionTypeNone'] = 'None';
$string['questionTypeEOFS'] = 'Extra Oral Frontal - Symmetry';
$string['questionTypeEOFAS'] = 'Extra Oral Frontal - Severity of Asymetry';
$string['questionTypeEOFLVH'] = 'Extra Oral Frontal - Lower Vertical Height';
$string['questionTypeEOFLC'] = 'Extra Oral Frontal - Lip Competence';
$string['questionTypeEOFSSL'] = 'Extra Oral Frontal Smiling - Smile Line';
$string['questionTypeEOFSSA'] = 'Extra Oral Frontal Smiling - Smile Arc';
$string['questionTypeEOFSDM'] = 'Extra Oral Frontal Smiling - Dental Midline';
$string['questionTypeEOFSDMSD'] = 'Extra Oral Frontal Smiling - Dental Midline Shift Direction';
$string['questionTypeEOFSDMSDD'] = 'Extra Oral Frontal Smiling - Dental Midline Shift Distance';
$string['questionTypeEOFSOC'] = 'Extra Oral Frontal Smiling - Upper Occlusal Plane';
$string['questionTypePD'] = 'Profile - Describe Profile';
$string['questionTypePNA'] = 'Profile - Nasolabial Angle';
$string['questionTypePMPA'] = 'Profile - Mandibular Plane Angle';
$string['questionTypePLFH'] = 'Profile - Lower Face Height';
$string['token'] = 'token';
$string['token_help'] = 'You should put here the token provided by admins.If you lost it or forgot it contact admins for a new one';