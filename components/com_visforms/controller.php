<?php
/**
 * Visforms default controller
 *
 * @author       Aicha Vack
 * @see           visforms is extended and rivised adaptation of ckforms from cookex (http://www.cookex.eu) for Joomla 2.5
 * @package      Joomla.Site
 * @subpackage   com_visforms
 * @link         http://www.vi-solutions.de 
 * @license      GNU General Public License version 2 or later; see license.txt
 * @copyright    2012 vi-solutions
 * @since        Joomla 1.6 
 */
 
// no direct access
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');

/**
 * Visforms Controller Class
 *
 * @package		Joomla.Site
 * @subpackage	com_visforms
 * @since		1.6
 */
class VisformsController extends JController
{
	/**
	 * Method to display the captcha to validate the form
	 *
	 * @access	public
	 */
	function captcha()
	{
		include("components/com_visforms/captcha/securimage.php");
		
		$img = new Securimage();
		$img->ttf_file = "components/com_visforms/captcha/elephant.ttf";
		$img->show();
	}

	/**
	 * Method to display a data view.
	 *
	 * @param   boolean  $cachable   If true, the view output will be cached
	 * @param   array    $urlparams  An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController          This object to support chaining.
	 *
	 * @since	1.5
	 */
	function  display($cachable = false, $urlparams = false)
	{
		$model = $this->getModel('visforms');
		$model->addHits();
		
		$_SESSION['vis_send_once'.JRequest::getCmd('id')] = "1";
		$_SESSION['vis_cache_page_'.JRequest::getCmd('id')] = md5(JRequest::getURI());
		
		parent::display($cachable = false, $urlparams = false);
	}

	/**
	 * save a record (and redirect to main page)
	 * and send emails
	 * @return void
	 */
	function send()
	{		
		$model = $this->getModel('visforms');
		$visform = $model->getData();	
		$post = JRequest::get('post', JREQUEST_ALLOWHTML);
		
		//Check that data is ok, in case that javascript may not work properly
		
		if($model->validatePostData($post, $visform->fields) === false) {
			// Get the validation messages.
			$errors	= $model->getErrors();
			$app=JFactory::getApplication();

			// Push up the validation messages
			for ($i = 0, $n = count($errors); $i < $n; $i++) {
				if ($errors[$i] instanceof Exception) {
					$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
				} else {
					$app->enqueueMessage($errors[$i], 'warning');
				}
			}
			
			//Show form again, keep values already typed in
			$this->display();
			return false;
		}
		
		
		// Captcha ok?	
		if ($visform->captcha == 1){
			include("components/com_visforms/captcha/securimage.php");
			
			$img = new Securimage();
			
			$valid = $img->check($_POST['vis_captcha_code']);			
			
			if($valid == false) {
				JError::raiseWarning( 0, JText::_( "COM_VISFORMS_CODE_INVALID" ));
				//Show form again, keep values already typed in
				$this->display();
				return false;
			}
		}
		
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		
		if (isset( $_SESSION['vis_send_once'.$visform->id])) {
			unset($_SESSION['vis_send_once'.$visform->id]);			
		} else {
			JError::raiseWarning( 0, JText::_( "COM_VISFORMS_CAN_SENT_ONLY_ONCE" ));
			return false;		
		}
		
		$securimage_code_value = 'securimage_code_value';
		unset($securimage_code_value);	
		
		//save data to db
		//$model->saveData($post);
		if($model->saveData($post) === false) {
			// Get the validation messages.
			$errors	= $model->getErrors();
			$app=JFactory::getApplication();

			// Push up the validation messages
			for ($i = 0, $n = count($errors); $i < $n; $i++) {
				if ($errors[$i] instanceof Exception) {
					$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
				} else {
					$app->enqueueMessage($errors[$i], 'warning');
				}
			}
			
			//Show form again, keep values already typed in
			$this->display();
			return false;
		}		

		if (isset($_SESSION['vis_cache_page_'.$visform->id])) {
			$cacheid = $_SESSION['vis_cache_page_'.$visform->id];
			$cache = JFactory::getCache();
			$cacheresult = $cache->remove($cacheid, 'page'); 
		}
		
		$msg = JText::sprintf('Form successfully sent', 1);
		
		if ( isset($visform->redirecturl) && $visform->redirecturl != "") {
			
			$this->setRedirect($visform->redirecturl);
			
			
		} else if ((isset($visform->redirecturl) == false || $visform->redirecturl == "")
			&& ((isset($visform->textresult) == false || $visform->textresult == ""))) {
			$this->setRedirect(JURI::base(), $msg);
		}
		
		JRequest::setVar( 'view', 'visforms' );
		JRequest::setVar( 'layout', 'message'  );
		
		parent::display();

	}
}
?>
