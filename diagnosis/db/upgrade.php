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
 * Plugin upgrade steps are defined here.
 *
 * @package     qtype_diagnosis
 * @category    upgrade
 * @copyright   23/24 SDP<group_31_CS_F>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__.'/upgradelib.php');

/**
 * Execute qtype_diagnosis upgrade from the given old version.
 *
 * @param int $oldversion
 * @return bool
 */
function xmldb_qtype_diagnosis_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager();

    // Define field questiontype to be added to qtype_diagnosis_options.
    $table = new xmldb_table('qtype_diagnosis_options');
    $field = new xmldb_field('questiontype', XMLDB_TYPE_TEXT, null, null, null, null, null, 'showstandardinstruction');

    // Conditionally launch add field questiontype.
    if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

    upgrade_plugin_savepoint(true, 2024020601, 'qtype', 'diagnosis');

    return true;
}
