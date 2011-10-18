<?php

/**
 * Backstretch
 *
 * @author Eugene I. Nezhuta [Seotoaster Dev Team] <eugene@seotoaster.com>
 */
class Backstretch extends Tools_Plugins_Abstract {

	private $_websiteHelper = null;

	public function  __construct($options, $seotoasterData) {
		parent::__construct($options, $seotoasterData);
		$this->_websiteHelper = Zend_Controller_Action_HelperBroker::getStaticHelper('website');
		$this->_view->setScriptPath(dirname(__FILE__) . '/views/');
	}

	public function run($requestedParams = array()) {
		$path                = $this->_websiteHelper->getPath() . 'media/' . $this->_options[0] . '/original/';
		$this->_view->images = array_map(array($this, '_beckstretchCallback'), Tools_Filesystem_Tools::scanDirectory($path, true));
		return $this->_view->render('backstretch.phtml');
	}

//	public static function getWidgetMakerContent() {
//		$data = array(
//			'title'   => 'Forms',
//			'content' => '<h2>Some pre-defined forms</2>'
//		);
//		return $data;
//	}


	private function _beckstretchCallback($item) {
		return str_replace($this->_websiteHelper->getPath(), $this->_websiteHelper->getUrl(), $item);
	}
}

