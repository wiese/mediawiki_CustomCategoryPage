<?php

require_once 'lib/CustomCategoryPage.php';

$wgExtensionCredits['parserhook'][] = array(
	'name' => 'CustomCategoryPage',
	'author' =>'wiese',
	'url' => 'https://github.com/wiese/mediawiki_CustomCategoryPage',
	'description' => 
		'Allows customizing category pages. Magic word __CUSTOM_CATEGORY_PAGE__ ' .
		'disables the native list of pages. The rest is DIY.',
	'descriptionmsg' => '',
	'version' => '0.1',
	'path' => __FILE__,
);

$wgHooks['CategoryPageView'][] = 'CustomCategoryPage::view';
$wgHooks['MagicWordMagicWords'][] = 'CustomCategoryPage::addMagicWord';
$wgHooks['MagicWordwgVariableIDs'][] = 'CustomCategoryPage::addMagicWordId';
$wgHooks['LanguageGetMagic'][] = 'CustomCategoryPage::addMagicWordLanguage';
$wgHooks['ParserBeforeTidy'][] = 'CustomCategoryPage::checkForMagicWord';
