<?php
/**
 * PHP-DI
 *
 * @link      http://mnapoli.github.com/PHP-DI/
 * @copyright Matthieu Napoli (http://mnapoli.fr/)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace DI\Definition\Resolver;

use DI\Definition\DecoratorDefinition;
use DI\Definition\Exception\DefinitionException;
use DI\Definition\Definition;
use Interop\Container\ContainerInterface;

/**
 * Resolves a decorator definition to a value.
 *
 * @since 5.0
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class DecoratorResolver implements DefinitionResolver
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var DefinitionResolver
     */
    private $definitionResolver;

    /**
     * The resolver needs a container. This container will be passed to the factory as a parameter
     * so that the factory can access other entries of the container.
     *
     * @param ContainerInterface $container
     * @param DefinitionResolver $definitionResolver Used to resolve nested definitions.
     */
    public function __construct(ContainerInterface $container, DefinitionResolver $definitionResolver)
    {
        $this->container = $container;
        $this->definitionResolver = $definitionResolver;
    }

    /**
     * Resolve a decorator definition to a value.
     *
     * This will call the callable of the definition and pass it the decorated entry.
     *
     * @param DecoratorDefinition $definition
     *
     * {@inheritdoc}
     */
    public function resolve(Definition $definition, array $parameters = [])
    {
        $this->assertIsDecoratorDefinition($definition);

        $callable = $definition->getCallable();

        if (! is_callable($callable)) {
            throw new DefinitionException(sprintf(
                'The decorator "%s" is not callable',
                $definition->getName()
            ));
        }

        $decoratedDefinition = $definition->getDecoratedDefinition();

        if (! $decoratedDefinition instanceof Definition) {
            if (! $definition->getSubDefinitionName()) {
                throw new DefinitionException('Decorators cannot be nested in another definition');
            }

            throw new DefinitionException(sprintf(
                'Entry "%s" decorates nothing: no previous definition with the same name was found',
                $definition->getName()
            ));
        }

        $decorated = $this->definitionResolver->resolve($decoratedDefinition);

        return call_user_func($callable, $decorated, $this->container);
    }

    /**
     * {@inheritdoc}
     */
    public function isResolvable(Definition $definition, array $parameters = [])
    {
        $this->assertIsDecoratorDefinition($definition);

        return true;
    }

    private function assertIsDecoratorDefinition(Definition $definition)
    {
        if (!$definition instanceof DecoratorDefinition) {
            throw new \InvalidArgumentException(sprintf(
                'This definition resolver is only compatible with DecoratorDefinition objects, %s given',
                get_class($definition)
            ));
        }
    }
}
