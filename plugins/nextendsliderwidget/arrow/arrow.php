<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

class plgNextendSliderWidgetArrow extends NextendPluginBase {

    var $_group = 'arrow';

    function onNextendSliderWidgetList(&$list) {
        $list[$this->_group] = array(NextendText::_('Arrows'), $this->getPath(), 1);
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . 'arrow' . DIRECTORY_SEPARATOR;
    }
}
NextendPlugin::addPlugin('nextendsliderwidget', 'plgNextendSliderWidgetArrow');