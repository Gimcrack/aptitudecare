<?php

class MenuController extends DietaryController {

	// protected $template = "dietary";
	public $module = "Dietary";
	protected $navigation = 'dietary';
	protected $searchBar = 'dietary';


	public function edit() {
		smarty()->assign('title', "Edit Menu");
		$menuMod = false;

		if (input()->id == "") {
			session()->setFlash("Could not find the menu item you were looking for.", 'error');
			$this->redirect();
		}

		if (isset (input()->date)) {
			$date = input()->date;
		} else {
			$date = null;
		}

		if ($date == null) {
			$corpEdit = true;
			smarty()->assign('corporateEdit', $corpEdit);
		} else {
			$corpEdit = false;
			smarty()->assign('corporateEdit', $corpEdit);
		}

		// Need to fetch the menu item
		if (input()->type == "MenuMod") {
			// fetch the menu modification
			$menuItem = $this->loadModel("MenuMod", input()->id);
			$menuMod = true;

		} elseif (input()->type == "MenuChange") {
			// fetch the changed menu
			$menuItem = $this->loadModel("MenuChange", input()->id);
		} else {
			// fetch the menu item
			$menuItem = $this->loadModel("MenuItem", input()->id);
		}


		// remove tags from the menu
		// if (strstr($menuItem->content, "<p>")) {
		// 	$menuItem->content = explode("<p>", $menuItem->content);
		// 	$menuItem->content = str_replace("</p>", "", $menuItem->content);
		// } else {
		// 	$menuItem->content = explode("<br />", $menuItem->content);
		// }


		if (isset (input()->location)) {
			$location = $this->loadModel('Location', input()->location);

			// if location is set and corporateEdit is true, then we are on the edit facility
			// page. We need to get a list of all the facilities
			if ($corpEdit) {
				$allLocations = $this->loadModel('Location')->fetchFacilities();
			} else {
				$allLocations = false;
			}
		} else {
			$location = false;
		}


		if ($corpEdit) {
			$allLocations = $this->loadModel('Location')->fetchFacilities();
		} else {
			$allLocations = false;
		}
		

		smarty()->assign('location', $location);
		smarty()->assign('allLocations', $allLocations);
		smarty()->assign('menuItem', $menuItem);
		smarty()->assign('menuType', input()->type);
		smarty()->assign('date', $date);
		smarty()->assign('menuMod', $menuMod);
	}


	public function submit_edit() {

		// check if this is being submitted from a facility or corporate edit page
		// corporate edit pages are the facility menus page as well as the corporate
		// menus page, access to these page should be limited by user group

		if (input()->date == null) {
			// if the date is null then it is a corporate page
			$this->corporateInfo();
		} else {
			// if there is a date set then it is a facility page
			$this->facilityInfo();
		}

	}


	public function meal_order_form() {
		$this->template = "blank";
		smarty()->assign('title', "Meal Order Form");

		// // get location
		// $location = $this->loadModel("Location", input()->location);

		if (isset (input()->start_date)) {
			$start_date = date("Y-m-d", strtotime(input()->start_date));
		} else {
			$start_date = date("Y-m-d", strtotime("now"));
		}

		if (isset (input()->end_date)) {
			$end_date = date("Y-m-d", strtotime(input()->end_date));
		} else {
			$end_date = date("Y-m-d", strtotime("now"));
		}


		smarty()->assign('startDate', $start_date);


		$urlDate = date('m/d/Y', strtotime($start_date));
		$printDate = date("l, F j, Y", strtotime($start_date));
		smarty()->assign('urlDate', $urlDate);


		// Get the selected facility. If no facility has been selected return the users' default location
		$location = $this->getLocation();

		// Get the menu id the facility is currently using
		$menu = $this->loadModel('Menu')->fetchMenu($location->id, $start_date);
		smarty()->assign('menu', $menu);

		// Get the menu day for today
		$numDays = $this->loadModel('MenuItem')->fetchMenuDay($menu->menu_id);
		$startDay = round($this->dateDiff($menu->date_start, $start_date) % $numDays->count + 1);

		// Get the menu items for the week
		$menuItems = $this->loadModel('MenuItem')->fetchMenuItems($location->id, $start_date, $end_date, $startDay, $startDay, $menu->menu_id);
		$this->normalizeMenuItems($menuItems);

		smarty()->assignByRef('menuItems', $menuItems);

		// get alternates
		$alternates = $this->loadModel("Alternate")->fetchOne(null, array("location_id" => $location->id));

		// put alternates in an array to display similar to the meal menu
		$alternatesArray = explode("; ", $alternates->content);
		smarty()->assignByRef("alternates", $alternatesArray);

	}





	/*
	 * -------------------------------------------------------------------------
	 *  Validate info submitted from menu edit pages
	 * -------------------------------------------------------------------------
	 */


	private function facilityInfo() {
				// If this is already a menu mod load the current changes...
		if (input()->menu_type == "MenuMod") {
			$menuItem = $this->loadModel('MenuMod', input()->public_id);
		} else {
			$menuItem = $this->loadModel('MenuMod');
		}


		// get the location
		if (input()->location == "") {
			session()->setFlash("No facility menu was selected. Please try again.", 'error');
			$this->redirect();
		} else {
			$location = $this->loadModel('Location', input()->location);
		}

		// if reset is not empty then delete the menu mod item
		if (isset (input()->reset)) {
			if ($menuItem->delete()) {
				session()->setFlash("The menu changes have been deleted and the menu has been reset to the original menu items.", 'success');
				$this->redirect(array('module' => 'Dietary', 'page' => 'info', 'action' => 'current', 'location' => $location->public_id));
			} else {
				session()->setFlash("Could not reset the menu changes. Please try again", 'error');
				$this->redirect(input()->path);
			}
		}


		// get the original menu item
		if (input()->menu_type == "MenuChange") {
			$menuChange = true;
			$origMenuItem = $this->loadModel('MenuChange', input()->public_id);
		} else {
			$menuChange = false;
			$origMenuItem = $this->loadModel('MenuItem', input()->public_id);
		}
		
		
		// if there was no reason for a menu change entered throw an error
		if (input()->reason == "") {
			session()->setFlash("You must enter the reason for the menu change.", 'error');
			$this->redirect(input()->path);
		} else {
			$menuItem->reason = input()->reason;
		}

		// set the menu item id
		if ($menuChange) {
			$menuItem->menu_item_id = $origMenuItem->menu_item_id;
		} else {
			$menuItem->menu_item_id = $origMenuItem->id;
		}

		// set the location
		$menuItem->location_id = $location->id;

		// set the date
		$menuItem->date = input()->date;

		// set the menu content to be saved...
		$menuItem->content = input()->menu_content;

		// set the user info who made the change
		$menuItem->user_id = auth()->getRecord()->id;

		if ($menuItem->save()) {
			session()->setFlash("The menu for " . display_date(input()->date) . " has been saved.", 'success');
			$this->redirect(array('module' => 'Dietary', 'page' => 'info', 'action' => 'current', 'location' => $location->public_id));
		} else {
			session()->setFlash("Could not save the menu information. Please try again.", 'error');
			$this->redirect(input()->path);
		}

	}

	private function corporateInfo() {

		$menuItem = $this->loadModel('MenuItem', input()->public_id);
		
		// determine if this edit is for all locations or only those selected
		if (input()->edit_type == "corp_menu") {
			// this edit is for all locations
			// set the menu item variables	
			$menuItem->content = $this->validateMenuContent();

			if ($menuItem->save()) {
				session()->setFlash("The menu was successfully changed for all locations.", 'success');
				$this->corpPageRedirect();
			} else {
				session()->setFlash("Could not save the menu. Please try again.", 'error');
				$this->redirect(input()->path);
			}


		} elseif (input()->edit_type == "select_locations") {
			// this edit is only for those locations selected

			// verify that location(s) were selected
			$location = array();
			foreach (input() as $key => $test) {
				$facility = preg_replace("/\d+$/", "", $key);
				if ($facility == "facility") {
					$location[] = $test;
				}
			}
			// if selected locations is false then throw and error and redirect.
			if (empty ($location)) {
				session()->setFlash("You must select the location(s) for which you want to make the change", 'error');
				$this->redirect(input()->path);
			} 


			$flash_message = array();
			foreach ($location as $l) {
				$location = $this->loadModel('Location', $l);
				// load the menuChange model and make sure there is not an existing menuChange item
				$menuChange = $this->loadModel('MenuChange')->fetchExisting($menuItem->id, $location->id);
				$menuChange->content = $this->validateMenuContent();
				$menuChange->menu_item_id = $menuItem->id;
				$menuChange->location_id = $location->id;
				$menuChange->user_id = auth()->getRecord()->id;
				if ($menuChange->save()) {
					$flash_message[]['success'] = "The menu was changed for {$location->name}";
				} else {
					$flash_message[]['error'] = "Could not change the menu for {$location->name}";
				}
			}

			foreach ($flash_message as $message) {
				foreach ($message as $k => $m) {
					if ($k == "success") {
						session()->setFlash($m, 'success');
					} elseif ($k == "error") {
						session()->setFlash($m, 'error');
					}
				}
			}

			$this->corpPageRedirect();

		}
	}



	private function validateMenuContent() {
		// change the menu content to the newly entered info
		if (input()->menu_content == "") {
			session()->setFlash("Enter the new menu content", 'error');
			$this->redirect(input()->path);
		} else {
			return trim(input()->menu_content);
		}
	}


	private function corpPageRedirect() {
		// if the location is set we came from the facility menu page, redirect there
		if (isset (input()->location)) {
			$this->redirect(array('module' => "Dietary", 'page' => "info", 'action' => "facility_menus"));
		} else {
			// redirect to the corporate menu page
			$this->redirect(array('module' => "Dietary", 'page' => "info", 'action' => "corporate_menus"));
		}

	}


}