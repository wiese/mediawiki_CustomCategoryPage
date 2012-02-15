<?php

$wgExtensionCredits['parserhook'][] = array(
	'name' => 'CustomCategoryPage',
	'author' =>'wiese',
	'url' => '',
	'description' => 
		'Allows for customizing of category pages. Magic word '.
		'__CUSTOM_CATEGORY_PAGE__ disables list of pages. The rest is DIY.',
	'descriptionmsg' => '',
	'version' => '0.1',
	'path' => __FILE__,
);

class CustomCategoryPage {

	const MAGIC_WORD_ID = 'MAG_CUSTOMCATEGORYPAGE';
	const MAGIC_WORD_EN = '__CUSTOM_CATEGORY_PAGE__';

	public static function view($categorypage) {
		global $wgOut;
		if (isset($categorypage) and $categorypage)	{
			$wikisyntax = $categorypage->getContent();
			$mw = MagicWord::get(self::MAGIC_WORD_ID);
			if ($mw->match($wikisyntax)) {
				$article = Article::newFromID($categorypage->mTitle->mArticleID);
				$wgOut->addHTML($article->view());
				return false;
			}
		}
		return true;
	}

	public static function addMagicWord(&$magicWords) {
		$magicWords[] = self::MAGIC_WORD_ID;
		return true;
	}

	public static function addMagicWordId(&$magicWords) {
		$magicWords[] = self::MAGIC_WORD_ID;
		return true;
	}

	public static function addMagicWordLanguage(&$magicWords, $langCode) {
		switch($langCode) {
			default:
				$magicWords[self::MAGIC_WORD_ID] = array(0, self::MAGIC_WORD_EN);
		}
		return true;
	}

	public static function checkForMagicWord(&$parser, &$text) {
		global $wgOut, $wgAction;
		$mw = MagicWord::get(self::MAGIC_WORD_ID);

		if (!in_array($wgAction, array('submit','edit'))) {
			$mw->matchAndRemove($text);
		}

		return true;
	}
}

$wgHooks['CategoryPageView'][] = 'CustomCategoryPage::view';
$wgHooks['MagicWordMagicWords'][] = 'CustomCategoryPage::addMagicWord';
$wgHooks['MagicWordwgVariableIDs'][] = 'CustomCategoryPage::addMagicWordId';
$wgHooks['LanguageGetMagic'][] = 'CustomCategoryPage::addMagicWordLanguage';
$wgHooks['ParserBeforeTidy'][] = 'CustomCategoryPage::checkForMagicWord';
