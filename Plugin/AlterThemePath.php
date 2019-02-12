<?php

namespace PhatNguyen\OverFrontend\Plugin;

class AlterThemePath
{
    public function aroundGetPatternDirs($subject, $callable, ...$args)
    {
        $params = @$args[0];

        if (
            isset($params['area']) &&
            $params['area'] === 'frontend' &&
            isset($params['theme'])
        ) {
            /** @var \Magento\Theme\Model\Theme $theme */
            $theme = $params['theme'];
            $path = $theme->getArea() . '/' . $theme->getThemePath();
          $fileInfo = pathinfo($params['file']);

            if (isset($params['module_name'])) {
                $path .= '/' . $params['module_name'];
            }

            if ($fileInfo['extension'] === 'phtml') {
                $path .= '/templates';
            } else if ($fileInfo['extension'] === 'html') {
                $path .= '/web';
            }

            //$path .= '/' . $params['file'];

            if (is_file(BP . '/app/design/' . $path . '/' . $params['file'])) {
                $result = BP . '/app/design/' . $path;
            }
        }

        if (isset($result) && !empty($result)) {
            return [$result];
        }

        $result = $callable(...$args);

        return $result;
    }
}
