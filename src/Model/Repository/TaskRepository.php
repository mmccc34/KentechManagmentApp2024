<?php

namespace Sthom\App\Model\Repository;

use Sthom\App\Model\task;
use Sthom\Kernel\Utils\Repository;

class TaskRepository extends Repository
{

    public function __construct()
    {
        parent::__construct(task::class);
    }

    public function getFullTaskById(int $id)
    {
        $query = "SELECT 
    t.id AS taskId, 
    t.name AS taskName, 
    t.description AS taskDescription, 
    t.startDate AS taskStartDate, 
    t.endDate AS taskEndDate, 
    t.effort AS taskEffort, 
    u.name AS devName, 
    u.firstname AS devFirstname, 
    u.email AS devEmail, 
    p.id AS projectId, 
    p.name AS projectName, 
    p.description AS projectDescription,
    p.idManager AS projectIdManager, 
    p.idState AS projectIdState, 
    p.idClient AS projectIdClient, 
    s.name AS stateName, 
    s.id AS stateId
FROM task t
JOIN users u ON u.id = t.idDev
JOIN project p ON p.id = t.idProject
JOIN state s ON s.id = t.idState
        WHERE t.id=:id ";
        return $this->customQuery($query, [":id" => $id])[0];
    }

    public function getTaskByUser(int $id, array $dates)
    {
        $query = "SELECT * FROM task t
        WHERE t.idDev = :idDev AND 
        t.startDate <= :date2 AND 
        t.endDate >= :date1"
        ;
return $this->customQuery($query,["idDev"=>$id,"date1"=>$dates[0],"date2"=>$dates[1]]);
    }
}
