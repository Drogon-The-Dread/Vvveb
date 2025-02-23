<?php

/**
 * Vvveb
 *
 * Copyright (C) 2022  Ziadin Givan
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 */

/*
Name: Hide language selector
Slug: hide-language-selector
Category: tools
Url: https://www.vvveb.com
Description: Hides top header language selector from frontend
Author: givanz
Version: 0.1
Thumb: hide-language-selector.svg
Author url: https://www.vvveb.com
*/

use \Vvveb\System\Event as Event;

if (! defined('V_VERSION')) {
	die('Invalid request!');
}

class HideLanguageSelectorPlugin {
	function admin() {
	}

	function app() {
		Event::on('Vvveb\System\Core\View', 'compile:after', __CLASS__, function ($template, $htmlFile, $tplFile, $vTpl, $view) {
			//remove ecommerce components from html
			$vTpl->addCommand('[data-v-component-language]|delete');

			return [$template, $htmlFile, $tplFile, $vTpl, $view];
		});		
	}

	function __construct() {
		if (APP == 'admin') {
			$this->admin();
		} else {
			if (APP == 'app') {
				$this->app();
			}
		}
	}
}

$hideLanguageSelectorPlugin = new HideLanguageSelectorPlugin();
