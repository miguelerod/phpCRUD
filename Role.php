<?php
	class Role
	{
		protected $permissions;
	
		protected function __construct()
		{
			$this->permissions = array();
		}

		// return a role object with associated permissions
		public static function getRolePerms($role_id)
		{
			$role = new Role();
			
			$sql = "SELECT t2.perm_desc FROM role_perm as t1
					JOIN permissions as t2 ON t1.perm_id = t2.perm_id
					WHERE t1.role_id = '$role_id'";
			$query = $GLOBALS["DB"]->query($sql);

			while($row = $query->fetch_assoc()) 
			{
				$role->permissions[$row["perm_desc"]] = true;
			}
			
			return $role;
		}

		// check if a permission is set
		public function hasPerm($permission) {
			return isset($this->permissions[$permission]);
		}
	}

?>