<?php
/**
 * Created by PhpStorm.
 * User: jari-hermann.ernst
 * Date: 08.08.14
 * Time: 12:28
 */

class Tx_IrfaqCatmenu_ViewHelpers_UlViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * @param $catItems
	 * @param null $pid
	 * @return array
	 */
	public function getChildCategoryItems($catItems, $pid = NULL){
		$categoryItemsArr = array();

		foreach($catItems as $categoryItem){
			if($categoryItem->getParentcategory() == $pid){
				$categoryItemsArr[$categoryItem->getUid()] = array(
					'title' => $categoryItem->getTitle(),
					'subLevel' => ''
				);
			}
		}

		return $categoryItemsArr;
	}

	public function checkForChildCategories($catItems, $uid){

		$i = 0;

		foreach($catItems as $categoryItem){
			if($categoryItem->getParentcategory() == $uid){
				$i++;
			}
		}

		if($i > 0){
			$check = TRUE;
		} else {
			$check = FALSE;
		}

		return $check;
	}

	public function checkIfCategoryItemHasSubItems($catItems, $categoryItemArr){

		foreach ($categoryItemArr as $key => $value){

			$subCategoriesArr = NULL;
			$subCategoriesArr = $this->getChildCategoryItems($catItems, $key);

			$categoryMenuArr[$key] = $value;

			if($subCategoriesArr){
				$categoryMenuArr[$key]['subLevel'] = $subCategoriesArr;

				$this->getChildCategoryItems($catItems, $categoryMenuArr[$key]);
			}

		}

		return $categoryMenuArr;
	}

	/**
	 * Reverses the string
	 *
	 * @param object $catItems
	 * @return
	 */
	public function render($catItems) {

		$output = NULL;
		$childCategories = NULL;
		$firstLevelArr = NULL;

		$categoryMenuArr = NULL;

		//get first level of categories
		$firstLevelArr = $this->getChildCategoryItems($catItems);

		//create arr of category items with all sub levels
		$categoryMenu = $this->createCategoryItemArray($catItems, $firstLevelArr);

		//$categoryMenuArr = $this->checkIfCategoryItemHasSubItems($catItems, $firstLevelArr);

		//var_dump($categoryMenu);

		return NULL;

	}

	public function createCategoryItemArray($catItems, $firstLevelArr){

		foreach($firstLevelArr as $uid => $categoryItemFirstLevel){
			$childCategoryItemArr = $this->getChildCategoryItems($catItems, $uid);
			//var_dump($childCategoryItemArr);

			if($childCategoryItemArr){
				$firstLevelArr[$uid]['subLevel'] = $childCategoryItemArr;

				foreach($childCategoryItemArr as $key => $value){
					$subChildCategoryItemsArr = $this->getChildCategoryItems($catItems, $key);
					//var_dump($subChildCategoryItemsArr);

					if($subChildCategoryItemsArr){
						$firstLevelArr[$uid]['subLevel'][$key]['subLevel'] = $subChildCategoryItemsArr;
					} else {
						$firstLevelArr[$uid]['subLevel'][$key]['subLevel'] = NULL;
					}
				}

			} else {
				$firstLevelArr[$uid]['subLevel'] = NULL;
			}
		}

		var_dump($firstLevelArr);

		//var_dump($childCategoryItemArr);

		/*foreach ($categoryItemArr as $key => $value){

			$subCategoriesArr = NULL;
			$subCategoriesArr = $this->getChildCategoryItems($catItems, $key);

			$categoryMenuArr[$key] = $value;

			if($subCategoriesArr){
				$categoryMenuArr[$key]['subLevel'] = $subCategoriesArr;

				$this->getChildCategoryItems($catItems, $categoryMenuArr[$key]);
			}

		}*/







		return NULL;
	}

}