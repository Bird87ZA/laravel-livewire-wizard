<?php

namespace Spatie\LivewireWizard\Components\Concerns;

use Livewire\Livewire;

trait WizardQueryString
{
    public string|null $currentStepQueryString = null;
    public string $queryStringStepName = 'step';
    private array $queryStringSteps = [];

    public function queryStringWizardQueryString()
    {
        return [
            'currentStepQueryString' => ['as' => $this->queryStringStepName],
        ];
    }

    public function initializeWizardQueryString()
    {
        $this->queryStringSteps = array_flip(
            collect(array_flip($this->queryStringSteps()))
                ->map(function ($array) {
                    return Livewire::getAlias($array);
                })
                ->toArray()
        );
        if ($step = collect($this->queryStringSteps)->search(request()->query($this->queryStringStepName))) {
            $this->currentStepName = $step;
        }
    }

    public function showStep($toStepName, array $currentStepState = [])
    {
        parent::showStep($toStepName, $currentStepState);

        if ($parameter = $this->queryStringSteps[$toStepName] ?? null) {
            $this->currentStepQueryString = $parameter;
        }
    }

    protected function queryStringSteps(): array
    {
        return $this->queryStringSteps;
    }
}
