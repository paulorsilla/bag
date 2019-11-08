<?php

namespace Bag\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Factory genérico para instanciar os Controllers que necessitam do entityManager
 */

class FileUploadFactory implements FactoryInterface
{
	public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
	{
                $entityManager = $container->get('doctrine.entitymanager.orm_default');
		return new \Bag\Service\FileUpload($entityManager);
	}
}