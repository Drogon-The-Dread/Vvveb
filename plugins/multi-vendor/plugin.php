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
Name: Multi vendor
Slug: multi-vendor
Category: content
Url: https://www.vvveb.com
Description: Adds multi vendor signup page on frontend.
Author: givanz
Version: 0.1
Thumb: multi-vendor.svg
Author url: https://www.vvveb.com
*/

use function Vvveb\__;
use function Vvveb\array_insert_after;
use Vvveb\System\Event;
use Vvveb\System\Routes;

if (! defined('V_VERSION')) {
	die('Invalid request!');
}

class MultiVendorPlugin {
	function admin() {
		//add admin menu items
		$admin_path = \Vvveb\adminPath();
		Event::on('Vvveb\Controller\Base', 'init-menu', __CLASS__, function ($menu) use ($admin_path) {
			// plugin settings page
			$menu['plugins']['items']['multi-vendor'] = [
				'name'   => __('Multi vendor'),
				'url'    => $admin_path . '?module=plugins/multi-vendor/settings',
				'module' => 'plugins/multi-vendor/settings',
				'action' => 'index',
				'icon'   => 'icon-storefront-outline',
			];

			// vendors list page
			$menu = array_insert_after('ecommerce', $menu, 'multi-vendor', [
				'name'   => __('Vendors'),
				'url'    => $admin_path . '?module=product/vendors',
				'icon'   => 'icon-storefront-outline',
				'module' => 'product/vendors',
				'action' => 'index',
				'items'  => ['settings' => [
					'name'   => __('Settings'),
					'url'    => $admin_path . '?module=plugins/multi-vendor/settings',
					'module' => 'plugins/multi-vendor/settings',
					'action' => 'index',
					'icon'   => 'icon-cog-outline',
				]],
			]);

			return [$menu];
		});
	}

	function app() {
		//add new route for vendor signup page
		Routes::addRoute('/vendor-signup',  ['module' => 'plugins/multi-vendor/index/signup']);
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

$portfolioMarketPlugin = new MultiVendorPlugin();
