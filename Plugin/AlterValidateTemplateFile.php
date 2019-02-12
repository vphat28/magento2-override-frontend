<?php

namespace PhatNguyen\OverFrontend\Plugin;

class AlterValidateTemplateFile
{
    public function aroundIsValid($subject, $callable, $filename)
    {
        $basePath = BP . '/app/design/frontend';

        if (strpos($filename, $basePath) === 0) {
            return true;
        } else {
            return $callable($filename);
        }
    }
}
