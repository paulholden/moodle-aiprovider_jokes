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
use core\di;
use GuzzleHttp\Psr7\Request;

/**
 * AI provider tests
 *
 * @package    aiprovider_jokes
 * @covers     \aiprovider_jokes\provider
 * @copyright  2025 Paul Holden <paulh@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class provider_test extends advanced_testcase {

    /** @var manager $manager */
    private readonly manager $manager;

    /** @var provider $provider */
    private readonly provider $provider;

    protected function setUp(): void {
        parent::setUp();

        $this->resetAfterTest();

        $this->manager = di::get(manager::class);
        $this->provider = $this->manager->create_provider_instance(
            classname: provider::class,
            name: 'Test',
            config: ['apikey' => 'foo'],
        );
    }

    public function test_get_action_list(): void {
        $this->assertEquals([
            generate_text::class,
        ], $this->provider::get_action_list());
    }

    public function test_is_provider_configured(): void {
        $this->assertTrue($this->provider->is_provider_configured());

        /** @var provider $provider */
        $provider = $this->manager->update_provider_instance($this->provider, []);
        $this->assertFalse($provider->is_provider_configured());
    }

    public function test_add_authentication_headers(): void {
        $request = $this->provider->add_authentication_headers(new Request('GET', ''));
        $this->assertTrue($request->hasHeader('X-Api-Key'));
        $this->assertEquals(['foo'], $request->getHeader('X-Api-Key'));
    }
}
