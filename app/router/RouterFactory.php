<?php

namespace App;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;


class RouterFactory
{

	/**
	 * @return Nette\Application\IRouter
	 */
	public static function createRouter()
	{
		$router = new RouteList;
		$router[] = new Route('admin', 'Sign:in');
		$router[] = new Route('[<locale=cs cs|de|pl|sk>/]<presenter>/<action>[/<id>]', 'Homepage:default');
		return $router;
	}

}
