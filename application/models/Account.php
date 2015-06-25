<?php
/**
* Class Model for accounts table
*/
class Model_Account extends Zend_Db_Table_Abstract
{
	protected $_name = 'accounts';		
		
	/**
	 * [createAccount description]
	 * @param  [type] $username [description]
	 * @param  [type] $email    [description]
	 * @param  [type] $password [description]
	 * @param  [type] $recovery [description]
	 * @return [type] $id       [description]
	 */
	public function createAccount($username, $email, $password, $recovery)
	{
		// create a new row in the accounts table
		$row = $this->createRow();

		if($row) {
			try {
				// set the row data
				$row->username = $username;
				$row->email = $email;
				$row->password = md5($password);
				// set confimed to false
				$row->confirmed = 0;
				// set the confirmation key
				$row->recovery = $recovery;
				// set creation date
				$date = new Zend_Date();			
				$row->created = $date->toString('YYYY-MM-dd HH:mm:ss');						
				// save the new row
				$row->save();
				// now fetch the id of the row you just created and return it
				$id = $this->_db->lastInsertId();
				// return the id of the inserted row
				return $id;			
			} catch(Zend_Exception $e) {
				throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido guardar el usuario!'));	
			}
		} else {
			throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido crear el usuario.'));
		}
	}
		
	/**
	 * [updatePasswordAccount description]
	 * @param  [type] $id       [description]
	 * @param  [type] $password [description]
	 * @return [boolean] true   [description]
	 */
	public function updatePasswordAccount($id, $password)
	{
		// find the row that matches the id
		$row = $this->find($id)->current();

		if($row) {
			try {				
				// apply md5 algorythm to the password
				$row->password = md5($password);
				// save the updated row
				$row->save();			
				
				return true;

			} catch (Zend_Exception $e) {
				throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido actualizar la clave.'));	
			}
		} else {
			throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido actualizar la clave. No se ha encontradoo el usuario.'));	
		}
	}
		
	/**
	 * [findOneByUsernameOrEmail description]
	 * @param  [type] $username [description]
	 * @param  [type] $email    [description]
	 * @return [type]           [description]
	 */
	public function findOneByUsernameOrEmail($username, $email)
	{
		$query = $this->select();		
		$query->where('username = ?', $username);
		if($email)
			$query->orWhere('email = ?', $email);

		$result = $this->fetchRow($query);
					
		return $result;
	}
		
	/**
	 * [findOneByEmail description]
	 * @param  [type] $email [description]
	 * @return [type]        [description]
	 */
	public function findOneByEmail($email)
	{
		$query = $this->select();		
		$query->where('email = ?', $email);			
		$result = $this->fetchRow($query);
					
		return $result;
	}
		
	/**
	 * [findOneByRecovery description]
	 * @param  [type] $key [description]
	 * @return [type]      [description]
	 */
	public function findOneByRecovery($key)
	{
		$query = $this->select();						
		$query->where('recovery = ?', $key);			
		$result = $this->fetchRow($query);
				
		return $result;
	}

	/**
	 * [getUsers description]
	 * @return [type] [description]
	 */
	public static function getAccounts()
	{
		$userModel = new self();
		$query = $userModel->select()->setIntegrityCheck(false);
		$query->distinct();
		$query->from('accounts');
		$query->joinLeft('projects', 'accounts.id = projects.account_id', array('total_projects' => 'COUNT(projects.account_id)', 'public_projects' => 'SUM(if(projects.public = 1, 1, 0))', 'private_projects' => 'SUM(if(projects.public = 0, 1, 0))'));
		$query->group(array("accounts.id"));

		// create a new instance of the paginator adapter and return it
		$adapter = new Zend_Paginator_Adapter_DbTableSelect($query);
		
		// return variable $adapter
		return $adapter;		
	}

	/**
	 * [updateAccount description]
	 * @param  [type] $id        [description]
	 * @param  [type] $email     [description]
	 * @param  [type] $firstName [description]
	 * @param  [type] $lastName  [description]
	 * @param  [type] $company   [description]
	 * @param  [type] $city      [description]
	 * @param  [type] $province  [description]
	 * @param  [type] $country   [description]
	 * @param  [type] $web       [description]
	 * @param  [type] $photo     [description]
	 * @return [type]            [description]
	 */
	public function updateAccount($id, $firstName, $lastName, $company, $city, $province, $country, $web, $role, $photo)
	{
		// fetch the user's row
		$rowUser = $this->find($id)->current();

		if($rowUser) {
			try {
				// update the row values
				$rowUser->firstname = $firstName;
				$rowUser->lastname = $lastName;
				$rowUser->company = $company;
				$rowUser->city = $city;
				$rowUser->province = $province;
				$rowUser->country = $country;
				$rowUser->web = $web;
				$rowUser->role = $role;
				
				if(!empty($photo))
					$rowUser->photo = $photo;

				//$rowUser->role = $role;
				// set update date
				$date = new Zend_Date();			
				$rowUser->updated = $date->toString('YYYY-MM-dd HH:mm:ss');

				$rowUser->save();

				// return the updated user
				return $rowUser;
			} catch (Zend_Exception $e) {
				throw new Exception('Hemos encontrado un problema al actualizar su cuenta.');	
			}
		} else {
			throw new Exception('Hemos encontrado un problema al actualizar su cuenta.');			
		}
	}

	/**
	 * [checkUniqueEmailAccount description]
	 * @param  [type] $id    [description]
	 * @param  [type] $email [description]
	 * @return [type]        [description]
	 */
	public function checkUniqueEmailAccount($id, $email)
	{
		$query = $this->select();		
		$query->where('email = ?', $email);			
		$query->where('id != ?', $id);
		$result = $this->fetchRow($query);
					
		return $result;
	}

	/**
	 * [updateEmailAccount description]
	 * @param  [type] $id       [description]
	 * @param  [type] $password [description]
	 * @return [type]           [description]
	 */
	public function updateEmailAccount($id, $email)
	{
		// find the row that matches the id
		$row = $this->find($id)->current();

		if($row) {
			try {	
				// apply md5 algorythm to the email
				$row->email = $email;
				// save the updated row
				$row->save();

				// return boolean true
				return true;
			} catch (Zend_Exception $e) {
				throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido actualizar el correo.'));	
			}
		} else {
			throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido actualizar el correo. No se ha encontrado el usuario.'));
		}	
	}

	/**
	 * [deleteAccount description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function deleteAccount($id)
	{
		// fetch the user's row
		$rowUser = $this->find($id)->current();
		if($rowUser) {
			$rowUser->delete();
		} else {			
			throw new Zend_Exception('No se ha podido borrar el usuario.');
		}
	}
}