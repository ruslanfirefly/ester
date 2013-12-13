<?php

class Finrisk extends Phalcon\Mvc\Model{

    public $id;
    public $familia;
    public $imya;
    public $otchestvo;
    public $dateB;
    public $tel;
    public $seria_pass;
    public $nomer_pass;
    public $vidan_pass;
    public $propiska;
    public $tarif;
    public $summa;
    public $summa_pro;
    public $premiya;
    public $premiya_pro;
    public $insur_from;
    public $insur_to;
    public $user;
    public $dogovor;
    public $time;
	public $cooperative;
	public $performer;
	public $deposit_type;

	public static function getTariffRates()
	{
		return array(
			'2' => '2%',
			'2.5' => '2.5%',
		);
	}

    public function saveDogovorFinRisk(){

        $dog = $this->getDI()->get('db')->fetchOne("select dogovor from ester_dogovors_finrisk order by cast(substring_index(dogovor, '№', -1) AS INT) limit 1", Phalcon\Db::FETCH_ASSOC);
        $this->dogovor = $dog["dogovor"];
		$dogtime2 = DateTime::createFromFormat('d/m/Y', $this->time);

		$connection = $this->getDI()->get('db');
		$connection->begin();
		$status = $connection->insert('ester_finriski',
			array($this->familia, $this->imya, $this->otchestvo, $this->dateB, $this->tel,
				$this->seria_pass, $this->nomer_pass, $this->vidan_pass, $this->propiska,
				$this->tarif, $this->summa, $this->summa_pro, $this->premiya, $this->premiya_pro,
				$this->insur_from, $this->insur_to, $this->user, $this->dogovor , $this->time,
				$dogtime2->format('Y-m-d'), $this->cooperative, $this->performer, $this->deposit_type,
			),
			array(
				'familia', 'imya', 'otchestvo', 'dateb', 'tel',
				'seria_pass', 'nomer_pass', 'vidan_pass', 'propiska',
				'tarif', 'summa', 'summa_pro', 'premiya', 'premiya_pro',
				'insur_from', 'insur_to', 'userid', 'dogovor', 'dog_time',
				'dog_time2', 'cooperative', 'performer', 'deposit_type',
			)
		);

		if ($status)
		{
			$this->id = $connection->lastInsertId();
			$connection->commit();
		}
		else
		{
			$connection->rollback();
		}

		return $this->id;
    }

	public function getAllDogovors($filter = array())
	{
		$role = $this->getDI()->get('session')->get("role");
		$sql = 'SELECT ef.id,
                ef.familia,
				ef.imya,
				ef.otchestvo,
				ef.dogovor,
				ef.dog_time
				FROM ester_finriski as ef
			{{WHERE}}
			ORDER BY id DESC';
		$sql = preg_replace("/[ \t\n]+/", ' ', $sql);

		if (is_array($filter['date']['from']))
		{
			$date = $filter['date']['from'];
			$filter['date']['from'] = $date['Y'] . '-' . $date['m'] . '-' . $date['d'];
		}
		if (is_array($filter['date']['until']))
		{
			$date = $filter['date']['until'];
			$filter['date']['until'] = $date['Y'] . '-' . $date['m'] . '-' . $date['d'];
		}

		$condition = array();
		if (!empty($filter))
		{
			if (isset($filter['date']['from']) && (!empty($filter['date']['from'])))
			{
				$condition[] = 'ef.dog_time2 >= \'' . mysql_escape_string($filter['date']['from']) . '\'';
			}
			if (isset($filter['date']['until']) && (!empty($filter['date']['until'])))
			{
				$condition[] = 'ef.dog_time2 <= \'' . mysql_escape_string($filter['date']['until']) . '\'';
			}

			if (isset($filter['orderno']['from']) && (!empty($filter['orderno']['from'])))
			{
				$condition[] = 'TRIM(SUBSTRING_INDEX(dogovor, \'№\', -1)) >= ' . mysql_escape_string($filter['orderno']['from']);
			}
			if (isset($filter['orderno']['until']) && (!empty($filter['orderno']['until'])))
			{
				$condition[] = 'TRIM(SUBSTRING_INDEX(dogovor, \'№\', -1)) <= ' . mysql_escape_string($filter['orderno']['until']);
			}
		}

		if (in_array($role, array(Roles::ROLE_SUPERADMIN, Roles::ROLE_ADMIN)))
		{
			$condition = (empty($condition) ? '' : 'WHERE (' . implode(') AND (', $condition) . ')');
			$sql = strtr($sql, array('{{WHERE}}' => $condition));
		}
		else
		{
			$user = new Users();
			$user->getUserById($this->getDI()->get('session')->get('userid'));
			if ($user->id != NULL)
			{
				var_dump($this->getDI()->get('session')->get('userid'), $user);

				$userIds = Users::extractUserIds($user->getSubordinateUsers());
				$userIds[] = $user->id;

				if (!empty($userIds))
				{
					$condition[] = 'userid IN (' . implode(',', $userIds) . ')';
				}
			}
			if (!empty($condition))
			{
				$condition = 'WHERE (' . implode(') AND (', $condition) . ')';
			}
			else
			{
				$condition = 'WHERE 1=0';
			}

			$sql = strtr($sql, array('{{WHERE}}' => $condition));
		}
		//var_dump($sql);
		//die(__METHOD__);

		return $this->getDI()->get('db')->fetchAll($sql, Phalcon\Db::FETCH_ASSOC);
    }

    public function getDogById() {
		$role = $this->getDI()->get('session')->get("role");
		$sql = 'Select * from ester_finriski where {{CONDITION}} limit 1';
		if (in_array($role, array(Roles::ROLE_SUPERADMIN, Roles::ROLE_ADMIN)))
		{
			$sql = strtr($sql, array('{{CONDITION}}'=>' id = :id'));
		}
		else
		{
			$user = new Users();
			$user->getUserById($this->getDI()->get('session')->get("userid"));

			$userIds = Users::extractUserIds($user->getSubordinateUsers());
			if (empty($userIds))
			{
				$sql = strtr($sql, array('{{CONDITION}}'=>' id = :id'));
			}
			else
			{
				$sql = strtr($sql, array('{{CONDITION}}'=>' id = :id AND userid IN (' . implode(',', $userIds) . ')'));
			}
		}

		$dog = $this->getDI()->get('db')->fetchOne($sql, Phalcon\Db::FETCH_ASSOC, array('id' => $this->id));

        if($dog){
            $this->familia = $dog["familia"];
            $this->imya =  $dog["imya"];
            $this->otchestvo = $dog["otchestvo"];
            $this->dateB = $dog["dateb"];
            $this->tel = $dog["tel"];
            $this->seria_pass = $dog["seria_pass"];
            $this->nomer_pass = $dog["nomer_pass"];
            $this->vidan_pass = $dog["vidan_pass"];
            $this->propiska = $dog["propiska"];
            $this->tarif = $dog["tarif"];
            $this->summa = $dog["summa"];
            $this->summa_pro = $dog["summa_pro"];
            $this->insur_from = $dog["insur_from"];
            $this->insur_to = $dog["insur_to"];
            $this->premiya = $dog["premiya"];
            $this->premiya_pro =$dog["premiya_pro"];
            $this->time = $dog["dog_time"];
            $this->user =$dog["userid"];
            $this->dogovor = $dog["dogovor"];
			$this->cooperative = $dog["cooperative"];
			$this->performer   = $dog['performer'];
			$this->deposit_type = $dog['deposit_type'];
            return true;
        }else{
            return false;
        }

    }
    public function updateDogovorFinRisk(){

       return $this->getDI()->get("db")->update("ester_finriski",
            array("familia","imya","otchestvo","dateb","tel","seria_pass","nomer_pass","vidan_pass","propiska",
                "tarif","summa","summa_pro","premiya","premiya_pro","insur_from","insur_to","cooperative","performer",'deposit_type'),
            array($this->familia,$this->imya,$this->otchestvo,$this->dateB,$this->tel,$this->seria_pass,$this->nomer_pass,$this->vidan_pass,$this->propiska,
                $this->tarif,$this->summa,$this->summa_pro,$this->premiya,$this->premiya_pro,$this->insur_from,$this->insur_to,$this->cooperative,$this->performer,$this->deposit_type),
           "id = ".$this->id
        );

    }
}
