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
Name: Sun Editor
Slug: sun-editor
Category: content
Url: https://www.vvveb.com
Description: Replace tinymce with sun editor in post/page and product edit page
Author: givanz
Version: 0.1
Thumb: sun-editor.svg
Author url: https://www.vvveb.com
*/

use Vvveb\System\Event;

if (! defined('V_VERSION')) {
	die('Invalid request!');
}

class SunEditorPlugin {
	private $parsedown;

	function addSunEditor() {
		//add script on compile
		Event::on('Vvveb\System\Core\View', 'compile', __CLASS__, function ($template, $htmlFile, $tplFile, $vTpl, $view) {
			//insert js and css on post and product page
			if ($template == 'content/post.html' || $template == 'product/product.html') {
				//insert script
				$vTpl->loadTemplateFile(__DIR__ . '/admin/template/editor.tpl');
				//$vTpl->addCommand('body|append', $script);
			}

			return [$template, $htmlFile, $tplFile, $vTpl, $view];
		});
	}

	function admin() {
		$this->addSunEditor();
	}

	function app() {
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

$sunPlugin = new SunEditorPlugin();
