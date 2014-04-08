<?php 

namespace User\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use User\Model\User;
 use User\Form\UserForm;

class UserController extends AbstractActionController
{

	protected $userTable;

	public function getUserTable()
    {
       if (!$this->userTable) {
            $sm = $this->getServiceLocator();
            $this->userTable = $sm->get('User\Model\UserTable');
        }
        return $this->userTable;
     }

	public function addAction()
	{
		$form = new UserForm();
		$form->get('submit')->setValue('Zaregistrovať sa');

		$request = $this->getRequest();

		if($request->isPost())
		{
			$user = new User();
			$form->setInputFilter($user->getInputFilter());
			$form->setData($request->getPost());

			if($form->isValid())
			{
				$user->exchangeArray($form->getData());
				$this->getUserTable()->saveUser($user);

				return $this->redirect()->toRoute('product');
			}	
		}

	return array('form' => $form);

	}

	public function editAction()
	{

	}

	public function deleteAction()
	{

	}

	public function showAction()
	{

	}
}