<?php

/*
 * This file is part of the Doctrine Bundle
 *
 * The code was originally distributed inside the Symfony framework.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 * (c) Doctrine Project, Benjamin Eberlei <kontakt@beberlei.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Saxulum\DoctrineOrmCommands\Command;

use Symfony\Component\Console\Command\Command;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\EntityGenerator;

/**
 * Base class for Doctrine console commands to extend from.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
abstract class DoctrineCommand extends Command
{
    /**
     * @var ManagerRegistry
     */
    protected $managerRegistry;

    /**
     * @param null            $name
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct($name = null, ManagerRegistry $managerRegistry)
    {
        parent::__construct($name);

        $this->managerRegistry = $managerRegistry;
    }

    /**
     * get a doctrine entity generator
     *
     * @return EntityGenerator
     */
    protected function getEntityGenerator()
    {
        $entityGenerator = new EntityGenerator();
        $entityGenerator->setGenerateAnnotations(false);
        $entityGenerator->setGenerateStubMethods(true);
        $entityGenerator->setRegenerateEntityIfExists(false);
        $entityGenerator->setUpdateEntityIfExists(true);
        $entityGenerator->setNumSpaces(4);
        $entityGenerator->setAnnotationPrefix('ORM\\');

        return $entityGenerator;
    }

    /**
     * Get a doctrine entity manager by symfony name.
     *
     * @param string $name
     *
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager($name)
    {
        return $this->managerRegistry->getManager($name);
    }

    /**
     * Get a doctrine dbal connection by symfony name.
     *
     * @param string $name
     *
     * @return \Doctrine\DBAL\Connection
     */
    protected function getDoctrineConnection($name)
    {
        return $this->managerRegistry->getConnection($name);
    }
}
