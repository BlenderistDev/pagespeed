<?php

namespace App\Services;

class AuditSaver
{
    private $existingAuditNames;

    private $auditsData;

    public array $auditsToSave = [];

    private $Audits;

    public function __construct(array $auditsData, $Audits)
    {
        $this->auditsData = $auditsData;
        $this->Audits = $Audits;
        $this->setExistingAuditsNames($Audits);
    }

    public static function makeGooglePageSpeedAudits(array $auditsData, int $measureId, $Audits, $ResultModel)
    {
        $auditSaver = new self($auditsData, $Audits);
        $auditSaver->addScoreAudit();
        $auditSaver->addAudits();
        $auditSaver->saveAudits($measureId, $ResultModel);
    }

    public function addScoreAudit(): void
    {
        $auditName = 'score';
        $auditId = $this->getAuditIdByName($auditName);
        $this->auditsToSave[$auditId] = $this->auditsData['lighthouseResult']['categories']['performance']['score'];
    }

    public function saveAudits($iMeasureId, $ResultModel)
    {
        foreach ($this->auditsToSave as $iAuditId => $aAudit) {
            $oAudit = new $ResultModel([
                'audits_id' => $iAuditId,
                'value' => $aAudit,
                'measurements_id' => $iMeasureId,
            ]);
            $oAudit->save();
        }
    }

    public function addAudits()
    {
        foreach ($this->auditsData['lighthouseResult']['audits'] as $auditName => $audit) {
            if (!empty($audit['numericValue'])) {
                $auditId = $this->getAuditIdByName($auditName, $audit);
                $this->auditsToSave[$auditId] = $audit['numericValue'];                
            }
        }
    }

    private function setExistingAuditsNames($Audits)
    {
        $this->existingAuditNames = $Audits::all(['id', 'name'])->pluck('name', 'id');
    }

    private function getAuditIdByName($auditName, $auditData = [])
    {
        $auditId = $this->existingAuditNames->search($auditName);
        if (!$auditId) {
            $Audits = $this->Audits;
            $auditData['name'] = $auditName;
            $audit = new $Audits();
            $audit->fill($auditData)->save();
            $auditId = $audit->id;
        }
        return $auditId;
    }
}