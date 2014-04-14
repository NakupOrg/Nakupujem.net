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

				return $this->redirect()->toRoute('user');
			}	
		}

	return array('form' => $form);

	}

	public function editAction()
	{

	}

	public function deleteAction()
	{
		 $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id)
        {
            return $this->redirect()->toRoute('user');
        }
        // ......
        $request = $this->getRequest();
        
        if ($request->isPost())
        {
            $del = $request->getPost('del', 'No');
        if ($del == 'Yes')
            {
            $id = (int) $request->getPost('id');
            $this->getProductTable()->deleteProduct($id);
            }

        return $this->redirect()->toRoute('user');
        }
        return array(
             'id' => $id,
             'user' => $this->getUserTable()->getUser($id)
         );
	}

	public function showAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
             return $this->redirect()->toRoute('user', array(
                 'action' => 'add'
             ));
        }

        try {
             $user = $this->getUserTable()->getUser($id);
         }
         catch (\Exception $ex) {
             
             return $this->redirect()->toRoute('user', array(
                 'action' => 'add'
             ));
         }


       return new ViewModel(array(
             'user' => $user,
             ));
     }

	public function loginAction()
	{

	}
}