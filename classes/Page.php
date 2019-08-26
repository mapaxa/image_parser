<?php

namespace Parser\Classes;

use Parser\Components\Db;

class Page
{

  private static $pattern = "/<a[\s]+[^>]*?href[\s]?=[\s\"\']+" . "(.*?)[\"\']+.*?>" . "([^<]+|.*?)?<\/a>/";
  private static $excludeElements = array('#', '/', ' ', '', '/wp-admin');

  /**
   * Make: trim, add '/', deletes elems with spaces
   * @param array $array
   * @return array
   */
  public static function preparePaths(array $array): array
  {

    foreach ($array as $num => $link) {
      $array = array_map('trim', $array);
      if (!empty($link) && $link{0} != '/') {
        $array[$num] = '/' . $link;
      }
      if (stristr($link, ' ') == true) {
        unset($array[$num]);
      }
    }
    return $array;
  }

  /**
   * 
   * @param string $str
   * @return array
   */
  public static function getLinks(string $str): array
  {
    preg_match_all(self::$pattern, $str, $res, PREG_PATTERN_ORDER);
    return $res[1];
  }

  public static function getPageByUrlId(int $id)
  {
    $db = Db::getConnection();
    $result = $db->query("SELECT path FROM pages WHERE url_id={$id} LIMIT 1");
    $result->execute();
    return $result->fetch(\PDO::FETCH_NUM)[0];
  }

  public static function getUncheckedPageByUrlId($id)
  {
    $db = Db::getConnection();
    $result = $db->query("SELECT id, path, url_id, is_checked FROM pages WHERE url_id={$id} AND is_checked=0 LIMIT 1");
    $result->execute();
    return $result->fetch(\PDO::FETCH_ASSOC);
  }

  public static function getPagesByUrlId($urlId)
  {
    $db = Db::getConnection();
    $result = $db->query("SELECT id, url_id, path FROM pages WHERE url_id={$urlId}");
    $result->execute();
    return $result->fetchAll(\PDO::FETCH_COLUMN);
  }

  /**
   * Returns array without existing in DB pages 
   * @param array $array
   * @param int $urlId
   * @return array
   */
  public static function removeExistingPages($array, $urlId)
  {
    return array_diff($array, self::getPagesByUrlId($urlId));
  }

  public static function setPageChecked(int $id)
  {
    $db = Db::getConnection();
    $result = $db->prepare("UPDATE pages SET is_checked=1 WHERE id=:id");
    $result->bindParam(':id', $id, \PDO::PARAM_STR);
    if ($result->execute()) {
      return $result;
    }
    echo "\nPDO::errorInfo!!():\n";
    print_r($result->errorInfo());
    die();
  }

  public static function countPagesByUrlId($urlId)
  {
    $db = Db::getConnection();
    $sql = "SELECT COUNT(id) FROM pages WHERE url_id = {$urlId}";
    $result = $db->query($sql);
    return intval($result->fetchColumn());
  }

  public static function getPagesDataByUrlId($urlId)
  {
    $db = Db::getConnection();
    $result = $db->query("SELECT id, url_id, path FROM pages WHERE url_id={$urlId}");
    $result->execute();
    return $result->fetchAll(\PDO::FETCH_ASSOC);
  }

  public static function excludeArray(array $array): array
  {
    return array_diff($array, self::$excludeElements);
  }

  public static function removeDuplicates($array)
  {
    return array_unique($array);
  }

  public static function savePage($page_path, $url_id)
  {
    $db = Db::getConnection();
    $sql = "INSERT INTO pages (path, url_id) VALUES (:path, :url_id)";
    $result = $db->prepare($sql);
    $result->bindParam(':path', $page_path, \PDO::PARAM_STR);
    $result->bindParam(':url_id', $url_id, \PDO::PARAM_STR);
    if ($result->execute()) {
      return $result;
    }
    echo "\n PDO::errorInfo!():\n";
    print_r($result->errorInfo());
  }

}
