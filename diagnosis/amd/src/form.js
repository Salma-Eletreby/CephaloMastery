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
 * Handles events related to the multiple-choice question type answers.
 *
 * @module     qtype_diagnosis/answers
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define(['exports'], function(exports) {
    const init = () => {        
        // Define the function to handle the file picker change event
        const handleFilePickerChange = () => {
            var filePicker = document.getElementById("fitem_id_image");
            var filepickerFilename = document.getElementsByClassName("filepicker-filename")[0];
            var token = document.getElementById("id_token").value
            var generateButton = document.getElementById("id_generate");
            
            if (filepickerFilename !== undefined && filepickerFilename.querySelector("a") !== null && token !=="") {
                generateButton.disabled = false;
            } else {
                generateButton.disabled = true;
            }
        };
        
        // Attach the handleFilePickerChange function to the onchange event of the file picker
        document.getElementById("fitem_id_image").addEventListener("change", handleFilePickerChange);
        document.getElementById("id_token").addEventListener("input", handleFilePickerChange);
    };
    exports.init = init;
});

