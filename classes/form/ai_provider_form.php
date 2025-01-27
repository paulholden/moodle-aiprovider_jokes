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

declare(strict_types=1);

namespace aiprovider_jokes\form;

use core_ai\hook\after_ai_provider_form_hook;

/**
 * AI provider form
 *
 * @package    aiprovider_jokes
 * @copyright  2025 Paul Holden <paulh@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class ai_provider_form {

    /**
     * Define form
     *
     * @param after_ai_provider_form_hook $hook
     */
    public static function set_form_definition(after_ai_provider_form_hook $hook): void {
        if ($hook->plugin !== 'aiprovider_jokes') {
            return;
        }

        $mform = $hook->mform;

        $mform->addElement('passwordunmask', 'apikey', get_string('apikey', 'aiprovider_jokes'));
        $mform->addRule('apikey', get_string('required'), 'required', null, 'client');
    }
}
