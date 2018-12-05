<?php

namespace app\extensions;

use base\constants\ShellConstant;
use base\utils\LogUtils;
use yii\base\BaseObject;
use yii\base\Exception;
use Yii;

/**
 * Convert XLSX to XML format
 */
class handleFile extends BaseObject
{
    /**
     * @var string
     */
    protected $error;

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param  string $src xlsx path
     * @param  string $dst xml
     * @return bool
     */
    public function handle($src, $dst)
    {
        if (!file_exists($src)) {
            throw new Exception('Excel file not existed.');
        }

        $DirFile = __DIR__.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'uploadFile.py';
      
        $shell = sprintf('py %s %s %s 2>&1', $DirFile, $src, $dst);
     
        $console = shell_exec($shell);

        Yii::info('Execute: '. $shell, __METHOD__);
        Yii::info('Result: '. $console, __METHOD__);
        
        // check process log
        if (mb_strpos($console, 'Conversion complete!') !== false) {
            return true;
        }

        // console is null, so we should check form xml
        if (file_exists($dst) && filesize($dst) > 0) {
            return true;
        }

        $this->error = $console;
        return false;
    }
}
