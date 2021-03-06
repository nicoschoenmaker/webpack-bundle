<?php
/**
 * @copyright 2017 Hostnet B.V.
 */
declare(strict_types = 1);
namespace Hostnet\Component\Webpack\Configuration\Config;

use Hostnet\Component\Webpack\Configuration\CodeBlock;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * @covers \Hostnet\Component\Webpack\Configuration\Config\ResolveLoaderConfig
 */
class ResolveLoaderConfigTest extends TestCase
{
    public function testConfigTreeBuilder()
    {
        $tree = new TreeBuilder();
        $node = $tree->root('webpack')->children();

        ResolveLoaderConfig::applyConfiguration($node);
        $node->end();

        $config = $tree->buildTree()->finalize([]);
        self::assertArrayHasKey('resolve_loader', $config);
    }

    public function testGetCodeBlock()
    {
        $config = new ResolveLoaderConfig([
            'node' => [
                'node_modules_path' => '/foo/bar'
            ],
            'resolve_loader' => [
                'root' => ['/tmp']
            ]
        ]);

        self::assertTrue($config->getCodeBlocks()[0]->has(CodeBlock::RESOLVE_LOADER));
        self::assertArrayHasKey('root', $config->getCodeBlocks()[0]->get(CodeBlock::RESOLVE_LOADER));
    }
}
