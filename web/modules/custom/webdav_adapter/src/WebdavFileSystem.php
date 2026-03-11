<?php

namespace Drupal\webdav_adapter;

use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\StreamWrapper\StreamWrapperManagerInterface;
use Drupal\Core\File\FileSystem;
use Drupal\Core\Site\Settings;

class WebdavFileSystem extends \Drupal\Core\File\FileSystem {

  protected FileSystemInterface $inner;

  public function __construct(FileSystemInterface $inner, StreamWrapperManagerInterface $streamWrapperManager, Settings $settings) {
    $this->inner = $inner;
    parent::__construct($streamWrapperManager, $settings);
  }

  public function chmod($uri, $mode = NULL) {
    $scheme = $this->streamWrapperManager->getScheme($uri);

    if ($scheme === 'webdav') {
      return TRUE;
    }

    return $this->inner->chmod($uri, $mode);
  }

  public function __call($method, $args) {
    return $this->inner->{$method}(...$args);
  }
}
