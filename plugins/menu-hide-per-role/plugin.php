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
Name: Menu hide items per role
Slug: menu-hide-per-role
Category: tools
Url: https://www.vvveb.com
Description: Hide certain admin sidebar menu items for a specified role
Author: givanz
Version: 0.1
Thumb: menu-hide-per-role.svg
Author url: https://www.vvveb.com
Settings: /admin/?module=plugins/menu-hide-per-role/settings
*/

use \Vvveb\System\Event as Event;

if (! defined('V_VERSION')) {
	die('Invalid request!');
}

class MenuHidePerRolePlugin {
	function admin() {
		// add admin menu item
		$admin_path = \Vvveb\adminPath();
		Event::on('Vvveb\Controller\Base', 'init-menu', __CLASS__, function ($menu) use ($admin_path) {
			$menu['plugins']['items']['menuHidePerRole'] = [
				'name'     => 'ChatGPT',
				'url'      => $admin_path . '?module=plugins/menuHidePerRole/settings',
				'icon-img' => PUBLIC_PATH . 'plugins/menuHidePerRole/menuHidePerRole.svg',
			];

			return [$menu];
		});
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

$menuHidePerRolePlugin = new MenuHidePerRolePlugin();
