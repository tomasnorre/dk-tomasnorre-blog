<?php

namespace App\Listeners;

use samdark\sitemap\Sitemap;
use TightenCo\Jigsaw\Jigsaw;
use Illuminate\Support\Str;

class GenerateSitemap
{
    protected $exclude = [
        '/assets/*',
        '*/favicon.ico',
        '*/404*'
    ];

    public function handle(Jigsaw $jigsaw)
    {
        $baseUrl = $jigsaw->getConfig('baseUrl');

        if (! $baseUrl) {
            echo("\nTo generate a sitemap.xml file, please specify a 'baseUrl' in config.php.\n\n");

            return;
        }

        $sitemap = new Sitemap($jigsaw->getDestinationPath() . '/sitemap.xml');
        $sourcePath = $jigsaw->getSourcePath();
        collect($jigsaw->getOutputPaths())
            ->reject(function ($path) {
                return $this->isExcluded($path);
            })->each(function ($path) use ($baseUrl, $sitemap, $sourcePath ) {
                if(!str_contains($path, 'feed.atom')) {
                    $path .= '/';
                }
                $time = $this->getModifiedTime($path, $sourcePath);
                $changeFrequency = $this->isMainOrCategoryPage($path) ? Sitemap::DAILY : Sitemap::MONTHLY;
                $sitemap->addItem(rtrim($baseUrl, '/') . $path, $time, $changeFrequency) ;
        });

        $sitemap->write();
    }

    public function isExcluded($path)
    {
        return Str::is($this->exclude, $path);
    }

    private function getModifiedTime(string $path, string $sourcePath): int
    {
        date_default_timezone_set('Europe/Copenhagen');
        if($this->isMainOrCategoryPage($path)) {
            return time();
        }

        $file = $this->getFilenameAndPath($path, $sourcePath);
        $lastModified = false;
        if (file_exists($file)) {
            $lastModified = filemtime($file);
        }

        if (is_int($lastModified)) {
            return $lastModified;
        }

        return 0;
    }

    private function isMainOrCategoryPage(string $path): bool
    {
        if ($this->isCategoryIndex($path)) {
            return true;
        }

        if(in_array($path,  ['/blog/', '/about/', '/privacy/'])) {
            return true;
        }

        return false;
    }

    private function isCategoryIndex(string $path): bool
    {
        // Path is categories index
        if(str_contains($path, '/categories/')) {
            return true;
        }

        // Path is categories index number based.
        if (preg_match('#^/blog(/([0-9]+)/)?$#', $path)) {
            return true;
        }

        return false;
    }

    /**
     * @param string $path
     * @param string $sourcePath
     * @return string
     */
    private function getFilenameAndPath(string $path, string $sourcePath): string
    {
        $filename = basename(trim($path, '/')) . '.md';
        $sourceDirectory = $sourcePath . '/_posts/';

        return $sourceDirectory . $filename;
    }

}
