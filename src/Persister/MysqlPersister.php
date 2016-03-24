<?php
namespace App\Persister;

use AuditStash\PersisterInterface;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

class MysqlPersister implements PersisterInterface
{
    /**
     * Persists all of the audit log event objects that are provided
     *
     * @param array $auditLogs An array of EventInterfacfe objects
     * @return void
     */
    public function logEvents(array $auditLogs)
    {
        foreach ($auditLogs as $log) {
            $eventType = $log->getEventType();
            $data = [
                'timestamp' => $log->getTimestamp(),
                'transaction' => $log->getTransactionId(),
                'type' => $log->getEventType(),
                'primary_key' => $log->getId(),
                'source' => $log->getSourceName(),
                'parent_source' => $log->getParentSourceName(),
                'changed' => 'delete' === $eventType ? null : json_encode($log->getChanged()),
                'meta' => json_encode($log->getMetaInfo())
            ];
            // save audit log
            TableRegistry::get('LogAudit')->save(new Entity($data));
        }
    }
}
