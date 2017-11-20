<?php

namespace EditeurBundle\Services;
class Logs
{
    private $insertLogName;
    private $rejectLogName;
    private $errorLogName;
    private $warningLogName;
    private $techLogName;


    public function setAttribute($dir, $filename)
    {
        $this->warningLogName = $dir . '/' . $filename.'.log';
    }

    public function error($line)
    {
        file_put_contents($this->errorLogName, $line."\n", FILE_APPEND);
    }

    public function reject($line)
    {
        file_put_contents($this->rejectLogName, $line."\n", FILE_APPEND);
    }

    public function insert($line)
    {
        file_put_contents($this->insertLogName, $line."\n", FILE_APPEND);
    }

    public function warning($line)
    {
        file_put_contents($this->warningLogName, $line."\n", FILE_APPEND);
    }

    public function tech($line)
    {
        file_put_contents($this->techLogName, $line."\n", FILE_APPEND);
    }


}