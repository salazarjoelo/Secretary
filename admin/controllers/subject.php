<?php
/**
 * @version     3.0.0
 * @package     com_secretary
 *
 * @author       Fjodor Schaefer (schefa.com)
 * @copyright    Copyright (C) 2015-2017 Fjodor Schaefer. All rights reserved.
 * @license      MIT License
 */
 
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

class SecretaryControllerSubject extends JControllerForm
{
	
    protected $app;
    protected $fileId;
    protected $catid;
    
    public function __construct() {
        $this->app          = JFactory::getApplication();
        $this->fileId		= $this->app->input->getInt('secf');
        $this->catid		= $this->app->input->getInt('catid',0);
        parent::__construct();
    }
	
	public function getModel($name = 'Subject', $prefix = 'SecretaryModel', $config = array('ignore_request' => true))
	{
	    return Secretary\Model::create($name,$prefix,$config);
	}
	
	protected function allowEdit($data = array(), $key = 'id')
	{
	    $return = \Secretary\Helpers\Access::allowEdit('subject',$data, $key);
		return $return;
	}

	protected function getRedirectToItemAppend($recordId = null, $urlVar = 'id')
	{
		$append = parent::getRedirectToItemAppend($recordId);
		$append .= '&catid=' . $this->catid;
		if(!empty($this->fileId)) $append .= '&secf=' . $this->fileId;
		return $append;
	}
	
	protected function getRedirectToListAppend()
	{
		$append = parent::getRedirectToListAppend();
		$append .= '&catid=' . $this->catid;
		return $append;
	}
	
	public function batch($model = null)
	{
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		$model = $this->getModel('Subject');
		$this->setRedirect(JRoute::_('index.php?option=com_secretary&view='. $this->view_list . $this->getRedirectToListAppend(), false));
		return parent::batch($model);
	}
	
}