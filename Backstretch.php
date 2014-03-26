<?php

/**
 * Backstretch
 *
 * @author Eugene I. Nezhuta <eugene.nezhuta@gmail.com>
 */
class Backstretch extends Tools_Plugins_Abstract {

	/**
	 * Default value in seconds for the images fade animation
	 *
	 */
	const DEFAULT_FADE_INTERVAL     = '750';
    const DEFAULT_DURATION_INTERVAL = '3000';

    protected function _init() {
        $this->_view->setScriptPath(dirname(__FILE__) . '/views/');
    }

	public function run($requestedParams = array()) {
		$path                  = $this->_websiteHelper->getPath() . 'media/' . $this->_options[0] . '/original/';
		$this->_view->time     = (isset($this->_options[1]) && intval($this->_options[1])) ? $this->_options[1] : false;
        $this->_view->duration = (isset($this->_options[2]) && intval($this->_options[2])) ? $this->_options[2] : false;
		$this->_view->images   = array_map(array($this, '_beckstretchCallback'), Tools_Filesystem_Tools::scanDirectory($path, true));
		return $this->_view->render('backstretch.phtml');
	}

	public static function getWidgetMakerContent() {
		$translator = Zend_Registry::get('Zend_Translate');
		$view       = new Zend_View(array(
			'scriptPath' => dirname(__FILE__) . '/views'
		));
		$data = array(
			'title'   => $translator->translate('Backstretch'),
			'content' => $view->render('wmcontent.phtml')
		);
		unset($view);
		unset($translator);
		return $data;
	}

	private function _beckstretchCallback($item) {
		return str_replace($this->_websiteHelper->getPath(), $this->_websiteHelper->getUrl(), $item);
	}
}

