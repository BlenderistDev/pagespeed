<?php

namespace App\Components\Audits\PageSpeed;

use Database\Factories\AuditsFactoryPrototype;
use Database\Factories\AuditResultFactoryPrototype;

class AuditSaver
{
    private $existingAuditNames;

    private $auditsData;

    private $auditsToSave = [];

    private AuditsFactoryPrototype $auditFactory;

    public static function makeGooglePageSpeedAudits(array $auditsData, AuditsFactoryPrototype $auditFactory, AuditResultFactoryPrototype $auditResultFactory)
    {
        $auditSaver = new self($auditsData, $auditFactory);
        $auditSaver->addScoreAudit();
        $auditSaver->addAudits();
        $auditSaver->saveAudits($auditResultFactory);
    }

    private function __construct(array $auditsData, AuditsFactoryPrototype $auditFactory)
    {
        $this->auditsData = $auditsData;
        $this->auditFactory = $auditFactory;
        $this->setExistingAuditsNames();
    }

    private function addScoreAudit(): void
    {
        $auditName = 'score';
        $auditId = $this->getAuditIdByName($auditName);
        $this->auditsToSave[$auditId] = $this->auditsData['lighthouseResult']['categories']['performance']['score'];
    }

    private function saveAudits(AuditResultFactoryPrototype $auditResultFactory)
    {
        foreach ($this->auditsToSave as $iAuditId => $aAudit) {
            $auditResultFactory->create([
                'audits_id' => $iAuditId,
                'value' => $aAudit,
            ]);
        }
    }

    private function addAudits()
    {
        foreach ($this->auditsData['lighthouseResult']['audits'] as $auditName => $audit) {
            if (!empty($audit['numericValue'])) {
                $auditId = $this->getAuditIdByName($auditName, $audit);
                $this->auditsToSave[$auditId] = $audit['numericValue'];                
            }
        }
    }

    private function setExistingAuditsNames()
    {
        $this->existingAuditNames = $this->auditFactory->modelName()::all()->pluck('name', 'id');
    }

    private function getAuditIdByName($auditName, $auditData = [])
    {
        $auditId = $this->existingAuditNames->search($auditName);
        if (!$auditId) {
            $audit = $this->auditFactory->create([
                'name' => $auditName,
                'description' => $auditsData['description'] ?? '',
            ]);
            $auditId = $audit->id;
        }
        return $auditId;
    }
}