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

namespace Vvveb\Plugins\MenuHidePerRole\Controller;

use function Vvveb\__;
use Vvveb\Controller\Base;
use Vvveb\System\CacheManager;
use Vvveb\System\Validator;

class Settings extends Base {
	function save() {
		//$validator = new Validator(['plugins.insert-scripts.settings']);
		$settings  = $this->request->post['settings'] ?? false;
		$errors    = [];

		if ($settings /*&&
			($errors = $validator->validate($settings)) === true*/) {
			//$settings              = $validator->filter($settings);
			$results               = \Vvveb\set_settings('menu-hide-per-role', $settings);
			$this->view->success[] = __('Settings saved!');
			CacheManager::delete();
		} else {
			$this->view->errors = $errors;
		}

		return $this->index();
	}

	function index() {
		$settings = \Vvveb\get_setting('menu-hide-per-role') ?? ['roles' => []];

		$roleSql    = new \Vvveb\Sql\RoleSQL();

		$options    =  [
			'type'         => 'admin', //$this->type,
		] + $this->global;

		$results = $roleSql->getAll($options) ?? ['role' => []];

		foreach ($results['role'] as $role) {
			$roles[$role['name']] = $role['role_id'];
		}

		$settings['roles'] += $roles;
		$this->view->roles = $settings['roles'];
	}
}
