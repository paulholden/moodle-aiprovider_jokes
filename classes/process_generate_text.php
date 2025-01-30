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

use core\{di, http_client};
use core_ai\process_base;
use GuzzleHttp\Psr7\{Request, Uri};

/**
 * AI provider text generation
 *
 * @package    aiprovider_jokes
 * @copyright  2025 Paul Holden <paulh@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class process_generate_text extends process_base {

    /**
     * Query the AI provider endpoint
     *
     * @return array
     */
    protected function query_ai_api(): array {
        $request = $this->provider->add_authentication_headers(new Request('GET', '', ['Content-Type' => 'application/json']));

        try {
            $response = di::get(http_client::class)->send($request, [
                'base_uri' => new Uri('https://api.api-ninjas.com/v1/jokes'),
            ]);
        } catch (\Exception $e) {
            return [
                'success' => false,
                'errorcode' => $e->getCode(),
                'errormessage' => $e->getMessage(),
            ];
        }

        $contents = json_decode($response->getBody()->getContents(), true);

        return [
            'success' => true,
            'generatedcontent' => $contents[0]['joke'] ?? '',
        ];
    }
}
