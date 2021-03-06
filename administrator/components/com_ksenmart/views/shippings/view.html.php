<?php
/**
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

KSSystem::import('views.viewksadmin');

class KsenMartViewShippings extends JViewKSAdmin {

	function display($tpl = null) {
		$this->path->addItem(JText::_('ksm_trade'), 'index.php?option=com_ksen&widget_type=trade&extension=com_ksenmart');
		$this->path->addItem(JText::_('ksm_shippings'));

		switch ($this->getLayout()) {
			case 'shipping_params':
				$this->shipping   = $this->get('Shipping');
				$this->paramsform = $this->get('ShippingParamsForm');
				break;
			case 'shipping':
				$this->document->addScript(JUri::base() . 'components/com_ksenmart/js/shipping.js');
				$this->document->addScript(JUri::base() . 'components/com_ksenmart/js/jquery.custom.min.js');
				$this->document->addScript(JUri::base() . 'components/com_ksenmart/js/jquery.ui.datepicker-ru.js');
				$model          = $this->getModel();
				$this->shipping = $model->getShipping();
				$disabled = KSSystem::checkExtension('shipping', $this->shipping->type);
				if ($disabled) {
					$this->setLayout('disabled');
				}
				$model->form = 'shipping';
				$form        = $model->getForm();
				if ($form) $form->bind($this->shipping);
				$this->title      = JText::_('ksm_shippings_shipping_editor');
				$this->form       = $form;
				$this->paramsform = $this->get('ShippingParamsForm');
				break;
			default:
				$this->items = $this->get('ListItems');
				$this->total = $this->get('Total');
		}
		parent::display($tpl);
	}
}