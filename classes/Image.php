<?php

namespace Parser\Classes;

use Parser\Classes\Tag;
use Parser\Components\Db;

class Image implements Tag
{

  private static $pattern = '%<img.*?src=["\'](.*?)["\'].*?>%i';

  /**
   * 
   * @param type $str
   * @return type
   */
  public function getData($domain)
  {
    preg_match_all(self::$pattern, $domain, $res, PREG_PATTERN_ORDER);
    return $res[1];
  }

  /**
   * Returns image url according to pattern
   * @param string $url
   * @param string $preparedDomain
   * @return string
   */
  public static function prepareImagePath(string $url, string $preparedDomain): string
  {
    if (!empty($url)) {
      $url = trim($url);
      if (substr($url, 0, 2) == '//') {
        $url = 'http:' . $url;
      }
      if ($url{0} == '/' && substr_count($url, '/') == 1) {
        $url = $preparedDomain . $url;
      }
    }
    return $url;
  }

  /**
   * Saves images to DB
   * @param array $images
   * @param int $page_id
   */
  public static function saveImagesPerPage(array $images, int $page_id): void
  {
    $result = array();
    if ($images > 0) {
      for ($x = 0; $x < count($images); $x++) {
        if (!empty($images[$x])) {
          $result[] = '( \'' . $images[$x] . '\', ' . $page_id . ' )';
        }
      }
    }
    $imploded_string = implode(', ', $result);
    $db = Db::getConnection();
    $sql = "INSERT INTO images (name , page_id) VALUES {$imploded_string}";
    $stmt = $db->prepare($sql);
    $stmt->execute($result);
  }

  /**
   * Returns quantity of pages which belong to url
   * @param int $urlId
   * @return type string
   */
  public static function getCountImagesByUrl(int $urlId): string
  {
    $db = Db::getConnection();
    $result = $db->prepare("SELECT count(`images`.`id`) FROM `images` INNER JOIN `pages` ON `images`.`page_id`=`pages`.`id` WHERE `pages`.`url_id`={$urlId}");
    $result->execute();
    return $result->fetchColumn();
  }

  public static function getUniqueImagesByUrl(int $urlId)
  {
    $db = Db::getConnection();
    $result = $db->prepare("SELECT DISTINCT `images`.`name` FROM `images` INNER JOIN `pages` ON `images`.`page_id`=`pages`.`id` WHERE `pages`.`url_id`={$urlId}");
    $result->execute();
    return $result->fetchAll(\PDO::FETCH_NUM);
  }

}
