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
 * QR code profile field.
 *
 * @package    profilefield_afaqr
 * @copyright  2014 Sam Battat
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Class profile_field_afaqr
 *
 * @copyright  2014 Sam Battat
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class profile_field_afaqr extends profile_field_base {

    /**
     * Overwrite the base class to display the data for this field
     */
    public function display_data() {
        // Default formatting.
        $data = parent::display_data();
	$urlencoded = urlencode('otpauth://totp/A2FA-Moodle?secret='.$data.'');
        $src = 'https://chart.googleapis.com/chart?chs=200x200&chld=M|0&cht=qr&chl='.$urlencoded.'';

        return '<img src="'.$src.'"/>';
    }

    /**
     * Add fields for editing a QR code profile field.
     * @param moodleform $mform
     */
    public function edit_field_add($mform) {
	global $CFG, $PAGE;
	$PAGE->requires->jquery();
	$PAGE->requires->js('/user/profile/field/afaqr/js/newsecret.js');
	$size = 50;
        $maxlength = 255;
        $fieldtype = 'text';

        // Create the form field.
        $mform->addElement($fieldtype, $this->inputname, format_string($this->field->name), 'maxlength="'.$maxlength.'" size="'.$size.'" ');
        $mform->setType($this->inputname, PARAM_TEXT);
	$mform->addElement('hidden', 'a2fa_baseurl', $CFG->wwwroot);
	$mform->setType('a2fa_baseurl', PARAM_TEXT);
	$mform->addElement('button', 'newsecret', get_string('newsecret', 'profilefield_afaqr'));
	$mform->setType('newsecret', PARAM_TEXT);
    }

}


