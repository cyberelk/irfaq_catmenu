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
		'label' => 'LLL:EXT:irfaq_catmenu/Resources/Private/Language/locallang_db.xml:tx_irfaqcatmenu_domain_model_modernfaqcatmenu.parentcategory',
		'config' => array(
			'type' => 'input',
			'size' => 4,
			'eval' => 'int'
		),
	),
);

t3lib_extMgm::addTCAcolumns('tx_irfaq_cat',$tmp_irfaq_catmenu_columns);

$TCA['tx_irfaq_cat']['columns'][$TCA['tx_irfaq_cat']['ctrl']['type']]['config']['items'][] = array('LLL:EXT:irfaq_catmenu/Resources/Private/Language/locallang_db.xml:tx_irfaq_cat.tx_extbase_type.Tx_IrfaqCatmenu_ModernFaqCatMenu','Tx_IrfaqCatmenu_ModernFaqCatMenu');

$TCA['tx_irfaq_cat']['types']['Tx_IrfaqCatmenu_ModernFaqCatMenu']['showitem'] = $TCA['tx_irfaq_cat']['types']['1']['showitem'];
$TCA['tx_irfaq_cat']['types']['Tx_IrfaqCatmenu_ModernFaqCatMenu']['showitem'] .= ',--div--;LLL:EXT:irfaq_catmenu/Resources/Private/Language/locallang_db.xml:tx_irfaqcatmenu_domain_model_modernfaqcatmenu,';
$TCA['tx_irfaq_cat']['types']['Tx_IrfaqCatmenu_ModernFaqCatMenu']['showitem'] .= 'parentcategory';

?>