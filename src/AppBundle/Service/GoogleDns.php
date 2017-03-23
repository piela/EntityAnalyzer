<?php

namespace AppBundle\Service;

/**
 * Simple class to adding and finding google dns records, using creditionals key file
 *
 * @author Mariusz Piela
 */
class GoogleDns {

    protected $creditionalsKeyPath;
    protected $project;
    protected $managedZone;

    /**
     * 
     * @param string $creditionalsKeyPath
     * @param string $project
     * @param string $managedZone
     */
    public function __construct($creditionalsKeyPath, $project, $managedZone) {
        $this->creditionalsKeyPath = $creditionalsKeyPath;
        $this->project = $project;
        $this->managedZone = $managedZone;
    }

    /**
     * 
     * @return string
     */
    protected function getProject() {
        return $this->project;
    }

    /**
     * 
     * @return string
     */
    protected function getManagedZone() {
        return $this->managedZone;
    }

    /**
     * 
     * @return \Google_Client
     */
    protected function getClient() {
        putenv(sprintf('GOOGLE_APPLICATION_CREDENTIALS=%s', $this->creditionalsKeyPath));
        $client = new \Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->addScope('https://www.googleapis.com/auth/cloud-platform');
        return $client;
    }

    /**
     * 
     * @param type $name
     * @return boolean
     */
    public function findRecord($name) {
        $service = new \Google_Service_Dns($this->getClient());
        $project = 'callcenteronline-dns';
        $managedZone = 'call-center-online';
        $response = $service->resourceRecordSets->listResourceRecordSets($this->getProject(), $this->getManagedZone());
        foreach ($response->getRrsets() as $rrset) {
            if ($rrset->name == $name) {
                return true;
            }
        }
        return false;
    }

    /**
     *  
     * @param string $name
     * @param string $type
     * @param string $ttl
     * @param array $rrdatas
     * @throws \Exception
     */
    public function addDnsRecord($name, $type, $ttl, $rrdatas = []) {
        $service = new \Google_Service_Dns($this->getClient());
        $record = new \StdClass();
        $record->kind = "dns#resourceRecordSet";
        $record->name = $name;
        $record->type = $type;
        $record->ttl = $ttl;
        $record->rrdatas = $rrdatas;
        $additions[] = $record;
        $postBody = new \Google_Service_Dns_Change($this->getClient());
        $postBody->setAdditions($additions);
        try {
            $response = $service->changes->create($this->getProject(), $this->getManagedZone(), $postBody);
        } catch (\Exception $e) {
            $response = json_decode($e->getMessage());
            throw new \Exception($response->error->message, $response->error->code);
        }
    }

}
