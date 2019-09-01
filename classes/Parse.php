<?php

namespace Parser\Classes;

class Parse
{

  /**
   * 
   * @param string $url
   * @return string
   */
  public static function getPageContent(string $url, $message): string
  {
    if (!function_exists('curl_init')) {
      try {
        $result = @file_get_contents($url);
        if ($result == '') {
          throw new \Exception("{$message} {$url}\n");
        } else {
          return $result;
        }
      } catch (\Exception $e) {
        die($e->getMessage());
      }
    } else {
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

      $result = curl_exec($curl);
      
      if ($result === false) {
        echo "Ошибка CURL: " . curl_error($curl);
        return false;
      } else {
        return $result;
      }
    }
  }

}
