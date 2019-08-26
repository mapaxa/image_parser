<?php

namespace Parser\Classes;

use Parser\Components\Db;

class Url
{

  /**
   * Returns domain
   * @param string $url
   * @return string
   */
  public static function getUrlDomain(string $url): string
  {
    return parse_url(trim($url), PHP_URL_HOST);
  }

  /**
   * Returns processed domain.
   * @param string $sitename
   * @return string
   */
  public static function prepareDomain(string $sitename): string
  {
    $sitename = trim($sitename);
    $protocol = parse_url($sitename, PHP_URL_SCHEME);
    $search = "/";
    $pos = strrpos($sitename, $search);
    if ($pos !== false) {
      if ($sitename{strlen($sitename) - 1} == $search) {
        $sitename = substr_replace($sitename, '', $pos, strlen($search));
      }
    }

    return (!is_null($protocol)) ? $sitename : "http://" . $sitename;
  }

  /**
   * Check if url has domain
   * @param string $url
   * @return bool
   */
  public static function checkHasHost(string $url): bool
  {
    if (parse_url($url, PHP_URL_HOST) !== null) {
      return true;
    } else {
      return false;
    }
  }

  public static function saveUrlDomain($url, $filename)
  {
    $db = Db::getConnection();
    $result = $db->prepare("INSERT INTO urls (domain, csv) VALUES (:domain, :csv)");
    $result->bindParam(':domain', $url, \PDO::PARAM_STR);
    $result->bindParam(':csv', $filename, \PDO::PARAM_STR);
    if ($result->execute()) {
      return $result;
    }
    echo "\nPDO::errorInfo():\n";
    print_r($result->errorInfo());
    die();
  }

  public static function getLastId()
  {
    $db = Db::getConnection();
    $result = $db->query('SELECT MAX(id) FROM urls');
    $result->execute();
    return intval($result->fetch()[0]);
  }

  public static function getUrl($url)
  {
    $db = Db::getConnection();
    $result = $db->prepare("SELECT id, domain, csv FROM urls WHERE domain=:domain ORDER BY id DESC LIMIT 1");
    $result->execute(array('domain' => $url));
    return $result->fetch(\PDO::FETCH_ASSOC);
  }

}
