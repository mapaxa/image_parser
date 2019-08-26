<?php

namespace Parser\Classes;

class Parse
{

  /**
   * 
   * @param string $url
   * @return string
   */
  public static function getPageContent(string $url): string
  {
    return @file_get_contents($url);
  }

}
