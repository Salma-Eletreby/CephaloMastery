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
 * @package     qtype_landmarks
 * @category    upgrade
 * @copyright   23/24 SDP<group_31_CS_F>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__ . '/upgradelib.php');

/**
 * Execute qtype_landmarks upgrade from the given old version.
 *
 * @param int $oldversion
 * @return bool
 */
function xmldb_qtype_landmarks_upgrade($oldversion)
{
    global $CFG;
    global $DB;

    $dbman = $DB->get_manager();

    // For further information please read {@link https://docs.moodle.org/dev/Upgrade_API}.
    //
    // You will also have to create the db/install.xml file by using the XMLDB Editor.
    // Documentation for the XMLDB Editor can be found at {@link https://docs.moodle.org/dev/XMLDB_editor}.
    // Define table qtype_landmarks_points_relation to be dropped.
    //  $table = new xmldb_table('qtype_landmarks_points_relation');

    //  // Conditionally launch drop table for qtype_landmarks_points_relation.
    //  if ($dbman->table_exists($table)) {
    //      $dbman->drop_table($table);
    //  }



    //    // Define table qtype_landmarks_points_relation to be created.
    //    $table = new xmldb_table('qtype_landmarks_points_relation');

    //    // Adding fields to table qtype_landmarks_points_relation.
    //    $table->add_field('point1', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
    //    $table->add_field('point2', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
    //    $table->add_field('questionid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
    //    $table->add_field('distance', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
    //    $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);

    //    // Adding keys to table qtype_landmarks_points_relation.
    //    $table->add_key('questionid', XMLDB_KEY_FOREIGN, ['questionid'], 'question', ['id']);
    //    $table->add_key('id', XMLDB_KEY_PRIMARY, ['id']);
    //    $table->add_key('fk_point1', XMLDB_KEY_FOREIGN, ['point1'], 'qtype_landmarks_drops', ['id']);
    //    $table->add_key('fk_point2', XMLDB_KEY_FOREIGN, ['point2'], 'qtype_landmarks_drops', ['id']);

    //    // Conditionally launch create table for qtype_landmarks_points_relation.
    //    if (!$dbman->table_exists($table)) {
    //        $dbman->create_table($table);
    //    }
    // Landmarks savepoint reached.
    $table = new xmldb_table('qtype_landmarks_points_relation');
    $field = new xmldb_field('distance', XMLDB_TYPE_NUMBER, '10, 3', null, XMLDB_NOTNULL, null, null, 'questionid');

    // Launch change of type for field distance.
    $dbman->change_field_type($table, $field);

    $table = new xmldb_table('qtype_landmarks_angles');

    // Adding fields to table qtype_landmarks_angles.
    $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
    $table->add_field('point1', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
    $table->add_field('point2', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
    $table->add_field('point3', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
    $table->add_field('angle', XMLDB_TYPE_NUMBER, '10, 3', null, XMLDB_NOTNULL, null, null);
    $table->add_field('questionid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);

    // Adding keys to table qtype_landmarks_angles.
    $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
    $table->add_key('fk_point1', XMLDB_KEY_FOREIGN, ['point1'], 'qtype_landmarks_drops', ['id']);
    $table->add_key('fk_point2', XMLDB_KEY_FOREIGN, ['point2'], 'qtype_landmarks_drops', ['id']);
    $table->add_key('fk_point3', XMLDB_KEY_FOREIGN, ['point3'], 'qtype_landmarks_drops', ['id']);
    $table->add_key('fk_questionid', XMLDB_KEY_FOREIGN, ['questionid'], 'question', ['id']);

    // Conditionally launch create table for qtype_landmarks_angles.
    if (!$dbman->table_exists($table)) {
        $dbman->create_table($table);
    }
    upgrade_plugin_savepoint(true, 2023112006, 'qtype', 'landmarks');

    return true;
}
