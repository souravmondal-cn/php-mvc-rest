<?php

class QuickGit {

    private $version;

    function __construct() {
        exec('git describe --always', $version_mini_hash);
        exec('git rev-list HEAD | wc -l', $version_number);
        exec('git log -1', $line);
        $this->version['full'] = trim(str_replace('commit ', '', $line[0]));
        $this->version['mini'] = trim($version_mini_hash[0]);
    }

    public function getBuildVersion() {
        return $this->version;
    }

}
