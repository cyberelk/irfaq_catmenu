<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Pi1',
	'Modern FAQ Cat Menu'
);

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Modern FAQ Cat Menu');

$tmp_irfaq_catmenu_columns = array(

	'parentcategory' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:irfaq_catmenu/Resources/Private/Language/locallang_db.xml:tx_irfaqcatmenu_domain_model_catmenu.parentcategory',
		'config' => array(
			'type' => 'select',
			'renderMode' => 'tree',
			'treeConfig' => array(
				'parentField' => 'parentcategory',
				'appearance' => array(
					'expandAll' => 'true',
					'showHeader' => 'true',
				),
			),
			'foreign_table' => 'tx_irfaq_cat',
			'foreign_table_where' => 'AND tx_irfaq_cat.pid=2140 ORDER BY tx_irfaq_cat.uid',
			'size' => 30,
			'minitems' => 0,
			'maxitems' => 999,
		),
	),
);

t3lib_div::loadTCA('tx_irfaq_cat');
t3lib_extMgm::addTCAcolumns('tx_irfaq_cat',$tmp_irfaq_catmenu_columns,1);
t3lib_extMgm::addToAllTCAtypes('tx_irfaq_cat','parentcategory;;;;1-1-1');

$TCA['tx_irfaq_cat']['columns'][$TCA['tx_irfaq_cat']['ctrl']['type']]['config']['items'][] = array('LLL:EXT:irfaq_catmenu/Resources/Private/Language/locallang_db.xml:tx_irfaq_cat.tx_extbase_type.Tx_IrfaqCatmenu_CatMenu','Tx_IrfaqCatmenu_CatMenu');

$TCA['tx_irfaq_cat']['types']['Tx_IrfaqCatmenu_CatMenu']['showitem'] = $TCA['tx_irfaq_cat']['types']['1']['showitem'];
$TCA['tx_irfaq_cat']['types']['Tx_IrfaqCatmenu_CatMenu']['showitem'] .= ',--div--;LLL:EXT:irfaq_catmenu/Resources/Private/Language/locallang_db.xml:tx_irfaqcatmenu_domain_model_catmenu,';
$TCA['tx_irfaq_cat']['types']['Tx_IrfaqCatmenu_CatMenu']['showitem'] .= 'parentcategory';

//
t3lib_div::loadTCA('tx_irfaq_q');

$TCA['tx_irfaq_q']['columns']['cat']['config']['type'] = 'select';
$TCA['tx_irfaq_q']['columns']['cat']['config']['renderMode'] = 'tree';
$TCA['tx_irfaq_q']['columns']['cat']['config']['treeConfig']['parentField'] = 'parentcategory';
$TCA['tx_irfaq_q']['columns']['cat']['config']['treeConfig']['appearance']['expandAll'] = 'true';
$TCA['tx_irfaq_q']['columns']['cat']['config']['treeConfig']['appearance']['showHeader'] = 'true';
$TCA['tx_irfaq_q']['columns']['cat']['config']['foreign_table'] = 'tx_irfaq_cat';
$TCA['tx_irfaq_q']['columns']['cat']['config']['foreign_table_where'] = 'AND tx_irfaq_cat.pid=2140 ORDER BY tx_irfaq_cat.uid';
$TCA['tx_irfaq_q']['columns']['cat']['config']['size'] = 30;
$TCA['tx_irfaq_q']['columns']['cat']['config']['minitems'] = 0;
$TCA['tx_irfaq_q']['columns']['cat']['config']['maxitems'] = 999;

?>