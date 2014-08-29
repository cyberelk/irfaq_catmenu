<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Jari-Hermann Ernst <jari-hermann.ernst@bad-gmbh.de>, B·A·D GmbH
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package irfaq_catmenu
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_IrfaqCatmenu_Controller_CatMenuController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * catMenuRepository
	 *
	 * @var Tx_IrfaqCatmenu_Domain_Repository_CatMenuRepository
	 */
	protected $catMenuRepository = NULL;

	/**
	 * injectCatMenuRepository
	 *
	 * @param Tx_IrfaqCatmenu_Domain_Repository_CatMenuRepository $catMenuRepository
	 * @return void
	 */
	public function injectCatMenuRepository(Tx_IrfaqCatmenu_Domain_Repository_CatMenuRepository $catMenuRepository) {
		$this->catMenuRepository = $catMenuRepository;
	}

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {

		$GLOBALS['TSFE']->reqCHash();

        $cat = NULL;


        if($_GET['tx_irfaq_pi1']['cat']){
            $noCat = 0;
            $cat = $_GET['tx_irfaq_pi1']['cat'];
            $catTitle = $this->catMenuRepository->findByUid($cat);

            $this->view->assign('catTitle', ' :: ' . $catTitle->getTitle());
        } else {
            $noCat = 1;
        }

		$catMenus = $this->catMenuRepository->findAll();
		$this->view->assign('catMenus', $catMenus);
        $this->view->assign('noCat',$noCat);

	}

}
?>