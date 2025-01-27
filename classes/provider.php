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

namespace aiprovider_jokes;

use core_ai\aiactions\generate_text;
use Psr\Http\Message\RequestInterface;

/**
 * AI provider implementation
 *
 * @package    aiprovider_jokes
 * @copyright  2025 Paul Holden <paulh@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class provider extends \core_ai\provider {

    /**
     * Actions supported by this provider
     *
     * @return string[]
     */
    public static function get_action_list(): array {
        return [
            generate_text::class,
        ];
    }

    /**
     * Determine whether provider is configured
     *
     * @return bool
     */
    public function is_provider_configured(): bool {
        return !empty($this->config['apikey']);
    }


    /**
     * Provider request authentication (API key)
     *
     * @param RequestInterface $request
     * @return RequestInterface
     */
    public function add_authentication_headers(RequestInterface $request): RequestInterface {
        return $request->withAddedHeader('X-Api-Key', $this->config['apikey']);
    }
}
