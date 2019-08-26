<?php

namespace Parser\Classes;

class Csv
{

  private $filename;
  private $file;

  public function __construct($domain)
  {
    $this->filename = $domain . date('-y-m-d-H-i-s') . '.csv';
    $this->file = STORAGE . $this->filename;
  }

  public function getFileName()
  {
    return $this->filename;
  }

  public function getFile()
  {
    return $this->file;
  }

  public function createFile()
  {
    if (!file_exists($this->file)) {
      if ($fp = fopen($this->file, "w")) {
        fclose($fp);
      } else {
        die("\n Can\'t create file. Please check permissions on '/files' dir. \n");
      }
    }
  }

  public function writeHeader()
  {
    if (file_exists($this->file)) {
      $fp = fopen($this->file, "w");
      fwrite($fp, 'domain, parent_page, image' . "\n");
      fclose($fp);
    } else {
      die("\n Can\'t create file. Please check permissions on '/files' dir. \n");
    }
  }

  /**
   * Writes data in file. 
   * @param string $file
   * @param array $data
   * @param string $domain
   * @param string $parent_page
   */
  public static function write(string $file, array $data, string $domain, string $parent_page)
  {
    if (file_exists($file)) {

      $fp = fopen($file, "a");
      foreach ($data as $single) {
        fwrite($fp, "{$domain}, {$parent_page}, {$single}\r\n");
      }
      fclose($fp);
    }
  }

}
