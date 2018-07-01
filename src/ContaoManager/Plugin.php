<?php

namespace Webteam\PizzaBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Webteam\PizzaBundle\WebteamPizzaBundle;

class Plugin implements BundlePluginInterface
{

  /**
  * {@inheritdoc}
  */
  public function getBundles(ParserInterface $parser)
  {
    return [
      BundleConfig::create(WebteamPizzaBundle::class)
        ->setLoadAfter([ContaoCoreBundle::class])
        ->setReplace(['pizza']),
    ];
  }
}
