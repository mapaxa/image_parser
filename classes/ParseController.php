<?php

namespace Parser\Classes;

use Parser\Classes\Parse;
use Parser\Classes\Url;
use Parser\Classes\Csv;

Class ParseController
{

  private $tag;

  public function __construct(Tag $tag)
  {
    $this->tag = $tag;
  }

  function recursiveParseAndSave($preparedDomain, $lastUrlId, $csv, $n, $max_iterations = MAX_ITERATIONS_DEFAULT)
  {
    if ($n == Page::countPagesByUrlId($lastUrlId) || $n == $max_iterations) {
      echo "\n" . HOST . 'files/' . $csv->getFileName() . "\n\n";
    } else {
      $page = Page::getUncheckedPageByUrlId($lastUrlId);
      if (!$str = Parse::getPageContent($preparedDomain . $page['path'], " Could not resolve host: ")) {
        die;
      }
        $links = Page::getLinks($str);

      $imgSrcs = $this->tag->getData($str);

      $domainNoProtocol = Url::getUrlDomain($preparedDomain);

      foreach ($links as $num => $link) {
        if (!Url::checkHasHost($link)) {
          continue;
        } elseif ($domainNoProtocol == Url::getUrlDomain($link)) {
          $links[$num] = str_replace($preparedDomain, '', $link);
          continue;
        } else {
          unset($links[$num]);
        }
      }
      $links = Page::excludeArray($links);
      $links = Page::removeDuplicates($links);
      $links = Page::preparePaths($links);


      $links = Page::removeExistingPages($links, $lastUrlId);
      foreach ($links as $link) {
        if (!empty($links)) {
          Page::savePage($link, $lastUrlId);

          foreach ($imgSrcs as $num => $imgSrc) {
            $imgSrcs[$num] = Image::prepareImagePath($imgSrcs[$num], $preparedDomain);
          }
          Image::saveImagesPerPage($imgSrcs, $page['id']);
          Csv::write($csv->getFile(), $imgSrcs, $preparedDomain, $link);
        }
      }
      Page::setPageChecked($page['id']);

      unset($links);
      unset($imgSrcs);
      usleep(2000);
      echo $n;
      $this->recursiveParseAndSave($preparedDomain, $lastUrlId, $csv, $n + 1, MAX_ITERATIONS_DEFAULT);
    }
  }

  public function parse($domain)
  {
    $start = time();
    $preparedDomain = Url::prepareDomain($domain);
    $homeDomain = Url::getUrlDomain($preparedDomain);

    $csv = new Csv($homeDomain);
    Url::saveUrlDomain($homeDomain, $csv->getFileName());
    $lastUrlId = Url::getLastId();
    Page::savePage('/', $lastUrlId);
    $csv->createFile();
    $csv->writeHeader($csv);
    $this->recursiveParseAndSave($preparedDomain, $lastUrlId, $csv, 0, MAX_ITERATIONS_DEFAULT);
    $seconds = time() - $start;
    echo 'Выполнение заняло ' . $seconds . " секунд.\n";
  }

}
