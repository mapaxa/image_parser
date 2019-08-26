<?php

namespace Parser\Classes;

class Report
{

  public static function showDomain($domain)
  {
    echo "_____________________________________________________________\n"
    . "\nРезультаты парсинга по домену \033[31m{$domain}\033[0m\n";
  }

  public static function showPagesQuantitiy($count)
  {
    echo "\nДомену принадлежат \033[31m{$count}\033[0m страниц. \n";
  }

  public static function showImagesQuantitiy($count)
  {
    echo "\nНа домене находится \033[31m{$count}\033[0m изображений. \n";
  }

  public static function showPeportFile($filename)
  {
    echo "\nФайл с отчётом лежит здесь: \n" . HOST . 'files/' . $filename . "\n\n"
    . "_____________________________________________________________\n";
  }

}
