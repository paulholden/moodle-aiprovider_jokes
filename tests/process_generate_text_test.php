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

use advanced_testcase;
use core_ai\aiactions\generate_text;
use core_ai\manager;
use core\context\system;
use core\di;
use GuzzleHttp\Psr7\Response;
use ReflectionMethod;

/**
 * AI provider text generation test
 *
 * @package    aiprovider_jokes
 * @covers     \aiprovider_jokes\process_generate_text
 * @copyright  2025 Paul Holden <paulh@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class process_generate_text_test extends advanced_testcase {

    /** @var manager $manager */
    private readonly manager $manager;

    /** @var provider $provider */
    private readonly provider $provider;

    /** @var generate_text $action */
    private readonly generate_text $action;

    protected function setUp(): void {
        global $USER;

        parent::setUp();

        $this->setAdminUser();
        $this->resetAfterTest();

        $this->manager = di::get(manager::class);
        $this->provider = $this->manager->create_provider_instance(
            classname: provider::class,
            name: 'Test',
            config: ['apikey' => 'foo'],
        );
        $this->action = new generate_text(
            contextid: system::instance()->id,
            userid: (int) $USER->id,
            prompttext: 'Hello',
        );
    }

    public function test_query_ai_api(): void {
        $fixture = file_get_contents(self::get_fixture_path('aiprovider_jokes', 'process_generate_text.json'));
        $response = new Response(200, ['Content-Type' => 'application/json'], $fixture);
        $this->get_mocked_http_client()['mock']->append($response);

        $processor = new process_generate_text($this->provider, $this->action);
        $method = new ReflectionMethod($processor, 'query_ai_api');
        $this->assertEquals([
            'success' => true,
            'generatedcontent' => 'Man walks into a bar.',
        ], $method->invoke($processor));
    }
}
