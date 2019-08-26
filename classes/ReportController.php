<?php

namespace Parser\Classes;

use Parser\Classes\Url;
use Parser\Classes\Report;

class ReportController
{

  public function show($domain)
  {
    $homeUrl = Url::getUrlDomain(Url::prepareDomain($domain));
    $url = Url::getUrl($homeUrl);
    Report::showDomain($homeUrl);
    Report::showPagesQuantitiy(Page::countPagesByUrlId($url['id']));
    Report::showImagesQuantitiy(Image::getCountImagesByUrl($url['id']));
    Report::showPeportFile($url['csv']);
  }

}
