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

namespace Vvveb\Controller\Settings;

use Vvveb\Controller\Base;
use Vvveb\Sql\SiteSQL;
use Vvveb\System\Sites as SitesList;
use Vvveb\System\User\Admin;

class Sites extends Base {
	//check for other modules permission like post and editor to enable links like save/delete etc
	protected $additionalPermissionCheck = ['settings/site/add'];

	function add() {
	}

	function index() {
		$view  = $this->view;
		$sites = new SiteSQL();

		$options = [];

		if (Admin::hasCapability('view_other_sites')) {
			unset($options['site_id']);
		} else {
			$options['site_id'] = Admin :: siteAccess();
		}

		$page    = $this->request->get['page'] ?? 1;
		$limit   = $this->request->get['limit'] ?? 10;

		$results = $sites->getAll(
			$options + [
				'start'        => ($page - 1) * $limit,
				'limit'        => $limit,
			]
		);

		foreach ($results['sites'] as &$site) {
			$site['url'] = SitesList::url($site['host']);
		}

		$view->sitesList = $results['sites'] ?? [];
		$view->count     = $results['count'] ?? 0;
	}
}
