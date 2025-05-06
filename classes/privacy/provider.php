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

namespace aiprovider_jokes\privacy;

use core_privacy\local\metadata\{collection, provider as metadata_provider};
use core_privacy\local\request\data_provider;

/**
 * Plugin privacy provider
 *
 * @package    aiprovider_jokes
 * @copyright  2025 Paul Holden <paulh@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class provider implements data_provider, metadata_provider {

    /**
     * Returns metadata about this system
     *
     * @param collection $collection
     * @return collection
     */
    public static function get_metadata(collection $collection): collection {
        $collection->add_external_location_link('aiprovider_jokes', [
            'apikey' => 'privacy:metadata:aiprovider_jokes:apikey',
        ], 'privacy:metadata:aiprovider_jokes:externallink');
        return $collection;
    }
}
