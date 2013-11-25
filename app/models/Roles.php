<?php


class Roles extends Phalcon\Mvc\Model {
	const ROLE_SUPERADMIN = 1;
	const ROLE_ADMIN      = 2;
	const ROLE_MANAGER    = 3;
	const ROLE_BROKER     = 4;
	const ROLE_FINBROKER  = 5;
	const ROLE_AGENT      = 6;

	public $role;

	static public function getRoleSubroles($roleId)
	{
		$roles = array(
			self::ROLE_SUPERADMIN => array(
				//self::ROLE_SUPERADMIN,
				self::ROLE_ADMIN,
				self::ROLE_MANAGER,
				self::ROLE_BROKER,
				self::ROLE_FINBROKER,
				self::ROLE_AGENT,
			),
			self::ROLE_ADMIN => array(
				//self::ROLE_ADMIN,
				self::ROLE_MANAGER,
				self::ROLE_BROKER,
				self::ROLE_FINBROKER,
				self::ROLE_AGENT,
			),
			self::ROLE_MANAGER => array(
				self::ROLE_BROKER,
				self::ROLE_FINBROKER,
				self::ROLE_AGENT,
			),
			self::ROLE_FINBROKER => array(
				self::ROLE_AGENT,
			),
			self::ROLE_BROKER => array(
				self::ROLE_AGENT,
			),
		);

		return (isset($roles[$roleId]) ? $roles[$roleId] : array());
	}

	static public function getPrivilegedRoles($roleId)
	{
		$roles = self::getRoleSubroles($roleId);
		$roles[] = $roleId;
		$roles = array_diff(array(
			self::ROLE_AGENT,
			self::ROLE_BROKER,
			self::ROLE_FINBROKER,
			self::ROLE_MANAGER,
			self::ROLE_ADMIN,
			self::ROLE_SUPERADMIN
		), $roles);
		$roles = array_flip($roles);
		if (($roleId == Roles::ROLE_BROKER) && isset($roles[Roles::ROLE_FINBROKER]))
		{
			unset($roles[Roles::ROLE_FINBROKER]);
		}
		if (($roleId == Roles::ROLE_FINBROKER) && isset($roles[Roles::ROLE_BROKER]))
		{
			unset($roles[Roles::ROLE_BROKER]);
		}
		$roles = array_values(array_flip($roles));

		return $roles;
	}

	public function getSubordinateRoleUsers($roleIds)
	{
		$subRoles = array();
		if (!is_array($roleIds))
		{
			$roleIds = array($roleIds);
		}

		$subRoles = array();		
		foreach($roleIds as $roleId)
		{
			foreach(self::getRoleSubroles($roleId) as $role)
			{
				$subRoles[$role] = $role;
			}
		}

		if (empty($subRoles))
		{
			return array();
		}
		$sql = 'SELECT eu.id,
                                  eu.username,
                                  eu.firstname,
                                  eu.secondname,
								  er.id as role_id,
                                  er.rolename as role,
                                  ec.city,
                                  eu.dogovor,
                                  eu.email,
								  eu.active FROM ester_users as eu, ester_city as ec, ester_rolename as er
			WHERE eu.role = er.id AND eu.city = ec.id AND eu.role IN (' . implode(',', $subRoles) . ')';
		return $this->getDI()->get('db')->fetchAll($sql); 
	}

	public function getRoleById($roleId)
	{
		$data = $this->getDI()->get('db')->fetchOne('SELECT id, rolename FROM ester_rolename WHERE id = :id', Phalcon\Db::FETCH_ASSOC, array('id' => $roleId));

		$this->id       = $data['id'];
		$this->rolename = $data['rolename'];

		return $this;
	}

	public function getAllRoles()
	{
		$role    = isset($this->id) ? $this->id : $this->getDI()->get('session')->get('role');
		$roleIds = self::getRoleSubroles($role);
		if (in_array($role, array(Roles::ROLE_SUPERADMIN, Roles::ROLE_ADMIN, Roles::ROLE_MANAGER)))
		{
			$roleIds[] = $role;
		}
		if (empty($roleIds))
		{
			return array();
		}

        return $this->getDI()->get('db')->fetchAll('SELECT id, rolename FROM ester_rolename WHERE id IN (' . implode(',', $roleIds) . ') ORDER BY id');
    }
}
