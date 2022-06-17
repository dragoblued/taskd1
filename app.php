<?php
    function countNumberInFile($files, $path) {
        $count = 0;
        foreach ($files as $file) {
            $pathFile = $path . '/' . $file;
            if (is_dir($pathFile)) {
                $new_files = array_diff(scandir($pathFile), ['..', '.']);
                $count += countNumberInFile($new_files, $pathFile);
            } else if (is_file($pathFile) && $file == 'count') {
                $fp = @fopen($pathFile, "r");
                if ($fp) {
                    while (($buffer = fgets($fp, 4096)) !== false) {
                        $count = $count + (int)$buffer;
                    }
                    fclose($fp);
                }
            }
        }
        return $count;
    }

    function getPath($path) {
        $mas = [];
        $fp = @fopen($path, "r");
            if ($fp) {
                while (($buffer = fgets($fp, 4096)) !== false) {
                    $mas[] = trim((string)$buffer);
                }
                if (!feof($fp)) {
                    echo "Ошибка: fgets() неожиданно потерпел неудачу\n";
                }
            fclose($fp);
        }
        return $mas;
    }

    $listOfFolders = 'folders.txt';
    $result = 'result.txt';
    $paths = getPath($listOfFolders);
    $count = 0;
    foreach ($paths as $path) {
	    $files = array_diff(scandir($path), ['..', '.']);
        $count += countNumberInFile($files, $path);
    }
    file_put_contents($result, 'count = ' . $count);
?>