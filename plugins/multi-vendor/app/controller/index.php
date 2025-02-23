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

namespace Vvveb\Plugins\MultiVendor\Controller;

use function Vvveb\__;
use Vvveb\Controller\Base;
use function Vvveb\email;
use function Vvveb\siteSettings;
use Vvveb\System\Event;
use Vvveb\System\User\Admin;
use Vvveb\System\Validator;

class Index extends Base {
	function index() {
	}

	function signup() {
		$validator = new Validator(['signup']);

		if ($this->request->post &&
			($this->view->errors['login'] = $validator->validate($this->request->post)) === true) {
			//allow only fields that are in the validator list and remove the rest
			$userInfo                 = $validator->filter($this->request->post);
			$userInfo['display_name'] = $userInfo['first_name'] . ' ' . $userInfo['last_name'];
			$userInfo['username']     = $userInfo['first_name'] . $userInfo['last_name'];
			$userInfo['role_id']      = 8; //vendor role_id todo:get from settings
			$userInfo['status']       = 0; //defalt inactive wait for admin activation todo:get from settings

			list($userInfo) = Event :: trigger(__CLASS__, __FUNCTION__ , $userInfo);

			if ($userInfo) {
				$result                   = Admin::add($userInfo);

				$this->view->errors['login'] = [];

				if ($result) {
					if (is_array($result)) {
						$message = __('User created! It will be activated by the admin soon. <a href="/admin">Go to login</a>');
						//$this->session->set('success',  ['login' => $message]);
						$this->view->success['login'][]     = $message;
						$user_id                            = $result['admin'];
						$this->request->request['user_id']  = $user_id;

						$site = siteSettings();

						try {
							$error =  __('Error sending account creation mail!');

							if (! email([$userInfo['email'], $site['admin-email']], __('Your account has been created!'), 'user/signup', $userInfo)) {
								//$this->session->set('errors', ['login' => $error]);
								$this->view->errors[] = $error;
							}
						} catch (\Exception $e) {
							if (DEBUG) {
								$error .= "\n" . $e->getMessage();
							}
							//$this->session->set('errors', ['login' => $error]);
							$this->view->errors['login'] = $error;
						}

						//reset form fields
						$this->request->post = [];

					//return $this->redirect('/admin');
					} else {
						$this->view->errors['login'] = __('This email is already in use. Please use another one.');
					}
				} else {
					$this->view->errors['login'] = __('Error creating user!');
				}
			}
		}

		return $this->index();
	}
}
