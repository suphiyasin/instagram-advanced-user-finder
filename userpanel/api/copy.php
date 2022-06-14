<?php
if (!function_exists('copy_dir'))
{
    /**
     * Copy directory
     *
     * @param string $src
     * @param string $dst
     */
    function copy_dir($src, $dst)
    {
        if (is_dir($src)) {
            if (!is_dir($dst)) mkdir($dst);
            $files = scandir($src);
            foreach ($files as $file)
            {
                if ($file != "." and $file != "..")
                {
                    copy_dir("$src/$file", "$dst/$file");
                }
            }
        } else if (file_exists($src)) {
             copy($src, $dst);
        }
    }
}
copy_dir('../../scripts/kurucugecen', '../../teslimat/site');