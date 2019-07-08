<?php

class ztm_Update
{
    public function act_Default()
    {
        lib_Git::pull(ZTM_ROOT, $log);
        
        return dump($log);
    }
}