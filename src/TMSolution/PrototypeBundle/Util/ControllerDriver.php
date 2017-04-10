<?php

namespace TMSolution\PrototypeBundle\Util;

use TMSolution\ConfigurationBundle\Util\ConfigurationInterface;
use TMSolution\PrototypeBundle\Util\ControllerDriverInterface;

class ControllerDriver implements ControllerDriverInterface {

    protected $configuration;

    public function __construct(ConfigurationInterface $configuration) {
        $this->configuration = $configuration;
    }

    public function isActionAllowed() {
        return $this->configuration->get('allowed');
    }

    public function getEntityClass() {

        return $this->configuration->get('request_analyze.entity_class');
    }

    public function getApplicationPath() {

        return $this->configuration->get('request_analyze.application_path');
    }

    public function getEntitiesPath() {

        return $this->configuration->get('request_analyze.entities_path');
    }

    public function returnResultToView($modelName) {

        $returnToViewParameter = sprintf('models.%s.return_result_to_view', $modelName);

        if ($this->configuration->has($returnToViewParameter)) {
            return $this->configuration->get($returnToViewParameter);
        } else {
            return false;
        }
    }

    public function getResultParameter($modelName) {

        $resultParameter = sprintf('models.%s.result_parameter', $modelName);
        if ($this->configuration->has($resultParameter)) {
            return $this->configuration->get($resultParameter);
        } else {
            throw new \Exception(sprintf('No result_parameter for %s', $modelName));
        }
    }

    public function shouldRedirect() {
        if ($this->configuration->has('redirection') && $this->configuration->get('redirection') != null) {
            return true;
        }
    }

    public function getRedirectionRoute() {

        if ($this->configuration->has('redirection')) {
            $redirection = $this->configuration->get('redirection');

            if (array_key_exists('route_name', $redirection)) {
                return $redirection['route_name'];
            } else {
                throw new \Exception('No route_name in redirection');
            }
        } else {
            throw new \Exception('No redirection parameter');
        }
    }

    public function getRedirectionRouteParameters() {


        if ($this->configuration->has('redirection')) {
            $redirection = $this->configuration->get('redirection');

            if (array_key_exists('parameters', $redirection)) {
                return $redirection['parameters'];
            } else {
                return [];
            }
        }
    }

    public function getModel($name) {

        $modelName = sprintf('models.%s', $name);

        if ($this->configuration->has('models')) {

            $model = $this->configuration->get($modelName);

            if (!array_key_exists('name', $model)) {
                throw new \Exception('Model must have defined name in configuration');
            }

            if (!array_key_exists('method', $model)) {
                throw new \Exception('Model must have defined method in configuration');
            }

            if (!array_key_exists('type', $model)) {
                $model['type'] = 'service';
            }


            return $model;
        } else {

            throw new \Exception('Model %s doesn\'t exists in configuration');
        }
    }

    public function hasModelDataParameter($name) {

        $dataParameterPath = sprintf('models.%s.data_parameter', $name);

        if ($this->configuration->has($dataParameterPath)) {
            return true;
        }
    }

    public function getModelDataParameter($name) {

        $dataParameterPath = sprintf('models.%s.data_parameter', $name);

        return $this->configuration->get($dataParameterPath);
    }

    public function hasModel($name) {

        $modelName = sprintf('models.%s', $name);

        if ($this->configuration->has($modelName)) {
            return true;
        }
    }

    public function getFormTypeClass() {

        $formTypeClass = $this->configuration->get('form.form_type');
        return $formTypeClass;
    }

    public function hasFormTypeClass() {

        if ($this->configuration->has('form.form_type')) {
            return true;
        }
    }

    public function hasFormMethod() {

        if ($this->configuration->has('form.method')) {

            return true;
        }
    }

    public function getFormMethod() {

        return $this->configuration->get('form.method');
    }

    public function getFormAction() {

        $formTypeClass = $this->configuration->get('form.action');

        return $formTypeClass;
    }

    public function getTemplate() {

        $template = $this->configuration->get('templates.widget');

        return $template;
    }

}
