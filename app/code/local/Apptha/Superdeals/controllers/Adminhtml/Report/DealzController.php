<?php
/**
 * Apptha
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.apptha.com/LICENSE.txt
 *
 * ==============================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * ==============================================================
 * This package designed for Magento COMMUNITY edition
 * Apptha does not guarantee correct work of this extension
 * on any other Magento edition except Magento COMMUNITY edition.
 * Apptha does not provide extension support in case of
 * incorrect edition usage.
 * ==============================================================
 *
 * @category    Apptha
 * @package     Apptha_SuperDeals
 * @version    0.1.2
 * @author      Apptha Team <developers@contus.in>
 * @copyright   Copyright (c) 2014 Apptha. (http://www.apptha.com)
 * @license     http://www.apptha.com/LICENSE.txt
 *
 */

class Apptha_Superdeals_Adminhtml_Report_DealzController extends Mage_Adminhtml_Controller_Action
{

	/**
	 * fucntion to view deals order details
	 */
	public function indexAction()
	{
		$this->_title($this->__('Reports'))
		->_title($this->__('Super Deal Orders'));

		$this->loadLayout()
		->_setActiveMenu('superdeals/dealz')
		->_addBreadcrumb(Mage::helper('reports')->__('Super Deal Orders'), Mage::helper('reports')->__('Super Deal Orders'))
		->_addContent($this->getLayout()->createBlock('superdeals/adminhtml_report_dealz'))
		->renderLayout();
	}
	/**
	 * fucntion to export records as csv file
	 */
	public function exportDealzCsvAction()
	{
		$fileName = 'superdeals_order.csv';
		$content  = $this->getLayout()->createBlock('superdeals/adminhtml_report_dealz_grid')
		->getCsv();
		$this->_prepareDownloadResponse($fileName, $content);
	}
	/**
	 * fucntion to export records as Excel file
	 */
	public function exportDealzExcelAction()
	{
		$fileName = 'superdeals_order.xml';
		$content  = $this->getLayout()->createBlock('superdeals/adminhtml_report_dealz_grid')
		->getExcel($fileName);
		$this->_prepareDownloadResponse($fileName, $content);
	}
	/**
	 * fucntion to delete deals order details
	 */
	public function massDeleteAction()
	{
		$serialIds = $this->getRequest()->getParam('superdeals');
		if (!is_array($serialIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
		} else {
			try {
				foreach ($serialIds as $serialRequestIds)
				{
					$sRequest = Mage::getModel('superdeals/dealz')->load($serialRequestIds);
					$sRequest->delete();
				}
				Mage::getSingleton('adminhtml/session')->addSuccess(
				Mage::helper('adminhtml')->__(
                                'Total of %d record(s) were successfully deleted', count($serialIds)
				)
				);
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
		}
		$this->_redirect('*/*/index');
	}

}

