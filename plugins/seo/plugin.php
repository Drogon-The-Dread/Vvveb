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

/**
 * @package SEO Plugin
 * @version 0.1
 */
/*
Name: SEO Optimization
Slug: seo
Url: https://www.vvveb.com
Description: Add SEO capabilities like meta for content.
Author: givanz
Version: 0.1
Thumb: seo.svg
Author url: https://www.vvveb.com
Settings: /admin/?module=plugins/seo/settings
*/

use function Vvveb\__;
use Vvveb\System\Core\View;
use Vvveb\System\Event;

if (! defined('V_VERSION')) {
	die('Invalid request!');
}

class SeoPlugin {
	private $view;

	function post($content, $language, $slug) {
		$post                               = $content[$language] ?? [];
		$this->view->seo                    = ['json-schema-graph' => $post['name'] ?? ''];
		$this->view->seo['meta']['og']      = ['json-schema-graph' => $post['name'] ?? '', 'vasile' => 'asds'];
		$this->view->seo['meta']['article'] = ['json-schema-graph' => $post['name'] ?? '', 'vasile' => 'asds'];
		$this->view->seo['meta']['twitter'] = ['json-schema-graph' => $post['name'] ?? '', 'vasile' => 'asds'];

		return [$content, $language, $slug];
	}

	function save($post, $post_id, $type) {
		//var_dump($post);
		return [$post, $post_id, $type];
	}

	function addSeoTabs() {
		//add script on compile
		Event::on('Vvveb\System\Core\View', 'compile', __CLASS__, function ($template, $htmlFile, $tplFile, $vTpl, $view) {
			//insert js and css on post and product page
			if ($template == 'content/post.html' || $template == 'product/product.html') {
				//insert script
				$vTpl->loadTemplateFile(__DIR__ . '/admin/template/seotab.tpl', true);
				//$vTpl->addCommand('body|append', $script);
			}
		
			return [$template, $htmlFile, $tplFile];			
		});
	}

	function admin() {
		$this->addSeoTabs();

		//add admin menu item
		$admin_path = \Vvveb\adminPath();
		Event::on('Vvveb\Controller\Base', 'init-menu', __CLASS__, function ($menu) use ($admin_path) {
			$menu['plugins']['items']['seo-plugin'] = [
				'name'     => __('Seo optimization'),
				'url'      => $admin_path . '?module=plugins/seo/settings',
				'module'   => 'plugins/seo/settings',
				'icon-img' => PUBLIC_PATH . 'plugins/seo/seo.svg',
			];

			return [$menu];
		});

		Event::on('Vvveb\Controller\Content\Edit', 'save', __CLASS__, [$this, 'save']);
	}

	function app() {
		$template = $this->view->getTemplateEngineInstance();
		$template->loadTemplateFile(__DIR__ . '/app/template/common.tpl');

		//Event::on('Vvveb\Component\Post', 'results', __CLASS__, [$this,'post']);
		Event::on('Vvveb\Controller\Content\Post', 'index', __CLASS__, [$this, 'post']);
	}

	function __construct() {
		$this->view     = View::getInstance();

		if (APP == 'admin') {
			$this->admin();
		} else {
			if (APP == 'app') {
				$this->app();
			}
		}
	}
}

$seoPlugin = new SeoPlugin();
