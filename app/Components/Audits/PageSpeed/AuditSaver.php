<?php

namespace App\Components\Audits\PageSpeed;

use Database\Factories\AuditsFactoryPrototype;
use Database\Factories\AuditResultFactoryPrototype;

class AuditSaver
{
    private $existingAuditNames;

    private $auditsToSave = [];

    public static function makeGooglePageSpeedAudits(array $auditsData, AuditsFactoryPrototype $auditFactory, AuditResultFactoryPrototype $auditResultFactory): void
    {
        $auditSaver = new self($auditsData, $auditFactory);
        $auditSaver->addScoreAudit();
        $auditSaver->addAudits();
        $auditSaver->saveAudits($auditResultFactory);
    }

    private function __construct(private array $auditsData, private AuditsFactoryPrototype $auditFactory)
    {
        $this->setExistingAuditsNames();
    }

    private function addScoreAudit(): void
    {
        $auditName = 'score';
        $auditId = $this->getAuditIdByName($auditName, [
            'title' => 'Общие очки',
        ]);
        $this->auditsToSave[$auditId] = $this->auditsData['lighthouseResult']['categories']['performance']['score'];
    }

    private function saveAudits(AuditResultFactoryPrototype $auditResultFactory): void
    {
        foreach ($this->auditsToSave as $iAuditId => $aAudit) {
            $auditResultFactory->create([
                'audits_id' => $iAuditId,
                'value' => $aAudit,
            ]);
        }
    }

    private function addAudits(): void
    {
        foreach ($this->auditsData['lighthouseResult']['audits'] as $auditName => $audit) {
            if (!empty($audit['numericValue'])) {
                $auditId = $this->getAuditIdByName($auditName, $audit);
                $this->auditsToSave[$auditId] = $audit['numericValue'];
            }
        }
    }

    private function setExistingAuditsNames(): void
    {
        $this->existingAuditNames = $this->auditFactory->modelName()::all()->pluck('name', 'id');
    }

    private function getAuditIdByName($auditName, $auditData = []): int
    {
        $auditId = $this->existingAuditNames->search($auditName);
        if (!$auditId) {
            $audit = $this->auditFactory->create([
                'name' => $auditName,
                'title' => $auditData['title'] ?? '',
                'description' => $auditData['description'] ?? '',
            ]);
            $auditId = $audit->id;
        }
        return $auditId;
    }
}
