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
 * Plugin administration pages are defined here.
 *
 * @package     qtype_diagnosis
 * @category    admin
 * @copyright   23/24 SDP<group_31_CS_F>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    $menu = [
        new lang_string('answersingleno', 'qtype_diagnosis'),
        new lang_string('answersingleyes', 'qtype_diagnosis')
    ];
    $settings->add(new admin_setting_configselect('qtype_diagnosis/answerhowmany',
    new lang_string('answerhowmany', 'qtype_diagnosis'),
    new lang_string('answerhowmany_desc', 'qtype_diagnosis'), '1', $menu));

    $settings->add(new admin_setting_configcheckbox('qtype_diagnosis/shuffleanswers',
    new lang_string('shuffleanswers', 'qtype_diagnosis'),
    new lang_string('shuffleanswers_desc', 'qtype_diagnosis'), '1'));

    $settings->add(new qtype_diagnosis_admin_setting_answernumbering('qtype_diagnosis/answernumbering',
    new lang_string('answernumbering', 'qtype_diagnosis'),
    new lang_string('answernumbering_desc', 'qtype_diagnosis'), 'abc', null));

    $settings->add(new admin_setting_configcheckbox('qtype_diagnosis/showstandardinstruction',
            new lang_string('showstandardinstruction', 'qtype_diagnosis'),
            new lang_string('showstandardinstruction_desc', 'qtype_diagnosis'), 0));

}
