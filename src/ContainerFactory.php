<?php declare(strict_types = 1);

namespace FrolKr\PhpFramework;

use Psr\Container\ContainerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection;

class ContainerFactory
{
    /**
     * @param string $root
     * @param bool $isDebug
     * @return ContainerInterface
     * @throws \Exception
     */
    public static function create(string $root, bool $isDebug): ContainerInterface
    {
        $cachedContainerFile = implode(DIRECTORY_SEPARATOR, [$root, 'var', 'cache', 'container.php']);
        $containerConfigCache = new \Symfony\Component\Config\ConfigCache($cachedContainerFile, $isDebug);
        if ($isDebug || (!$containerConfigCache->isFresh() && $isDebug)) {
            $container = new ContainerBuilder();
            $loader = new YamlFileLoader(
                $container,
                new FileLocator($root . DIRECTORY_SEPARATOR . 'etc')
            );
            $loader->load('services.yml', 'yml');
            try {
                $container->compile();
            } catch (\Exception $e) {
                exit($e->getMessage());
            }

            $containerConfigCache->write(
                (new DependencyInjection\Dumper\PhpDumper($container))->dump([
                    'class' => 'CachedContainer',
                    'debug' => $isDebug
                ])
            );
        }

        if (!file_exists($cachedContainerFile)) {
            exit(sprintf('Container [%s] not generated', $cachedContainerFile));
        }
        require_once $cachedContainerFile;
        return new \CachedContainer();
    }
}