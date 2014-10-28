<?php
/**
 * Created by PhpStorm.
 * User: jari-hermann.ernst
 * Date: 08.08.14
 * Time: 12:28
 */

class Tx_IrfaqCatmenu_ViewHelpers_UlViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

    protected $configurationManager;

    public function injectConfigurationManager(Tx_Extbase_Configuration_ConfigurationManagerInterface $configurationManager) {
        $this->configurationManager = $configurationManager;
    }

	/**
	 * Reverses the string
	 *
	 * @param object $catItems
	 * @return
	 */
	public function render($catItems) {

		$firstLevelArr = NULL;
		$categoryMenuArr = NULL;
		$htmlOutput = NULL;
        $entryPoint = intval(0);

        $settings = $this->configurationManager->getConfiguration('Settings');
        $entryPoint = $settings['catSelection'];

		//get first level of categories
        if($entryPoint){
            $firstLevelArr = $this->getFirstLevelCategoryItems($catItems, $entryPoint);
        } else {
            $firstLevelArr = $this->getChildCategoryItems($catItems, $entryPoint);
        }

		//create arr of category items with all sub levels
		$categoryMenuArr = $this->createCategoryItemArray($catItems, $firstLevelArr);

		$htmlOutput = $this->generateHtmlOutput($categoryMenuArr, $settings);

		return $htmlOutput;
	}

	public function createLinkWithCategoryParam($title, $uid, $settings){

		$this->cObj = t3lib_div::makeInstance('tslib_cObj');

 		$link = $this->cObj->getTypoLink($title, $settings['listViewPage'], array('tx_irfaq_pi1[cat]' => $uid));

		return $link;
	}

	public function generateHtmlOutput($categoryMenuArr, $settings){

		$cat = NULL;

		if($_GET['tx_irfaq_pi1']['cat']){
			$cat = $_GET['tx_irfaq_pi1']['cat'];
		}

		$htmlOutput = '<ul>';

		foreach($categoryMenuArr as $key => $categoryMenu){

			if($key == $cat){
				$htmlOutput .= '<li class="active">' . $this->createLinkWithCategoryParam($categoryMenu['title'], $key, $settings )  . '</li>';
			} else {
				$htmlOutput .= '<li>' . $this->createLinkWithCategoryParam($categoryMenu['title'], $key, $settings )  . '</li>';
			}

			if($categoryMenu['subLevel']){
				$htmlOutput .= $this->generateHtmlOutput($categoryMenu['subLevel'], $settings);
			}
		}

		$htmlOutput .= '</ul>';

		return $htmlOutput;
	}

    /**
     * @param $catItems
     * @param null $pid
     * @return array
     */
    public function getFirstLevelCategoryItems($catItems, $pid = NULL){
        $categoryItemsArr = array();

        foreach($catItems as $categoryItem){
            if($categoryItem->getUid() == $pid){
                $categoryItemsArr[$categoryItem->getUid()] = array(
                    'title' => $categoryItem->getTitle(),
                    'subLevel' => ''
                );
            }
        }

        return $categoryItemsArr;
    }

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

	public function createCategoryItemArray($catItems, $categoryItemArr){

		foreach($categoryItemArr as $uid => $categoryItemFirstLevel){
			$childCategoryItemArr = $this->getChildCategoryItems($catItems, $uid);

			if($childCategoryItemArr){
				$categoryItemArr[$uid]['subLevel'] = $childCategoryItemArr;

				$categoryItemArr[$uid]['subLevel'] = $this->createCategoryItemArray($catItems, $childCategoryItemArr);

			} else {
				$categoryItemArr[$uid]['subLevel'] = NULL;
			}
		}

		return $categoryItemArr;
	}
}