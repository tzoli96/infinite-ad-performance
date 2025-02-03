<?php

namespace Domains\FileScanner\Application\Actions;

use Domains\FileScanner\Application\Dto\ScanResultDto;
use Shared\Application\AbstractAction;
use Illuminate\Support\Facades\File;
use InvalidArgumentException;

class ScanDomainFilesAction extends AbstractAction
{
    public function __invoke(
        array $foldersToScan,
        string $basePath = 'src/Domains',
        string $extension = 'php'
    ): ScanResultDto {
        return $this->executeWithLogging(function () use ($foldersToScan, $basePath, $extension) {
            $domainsPath = base_path($basePath);

            if (!File::exists($domainsPath)) {
                throw new InvalidArgumentException("Base path does not exist: {$basePath}");
            }

            $files = $this->scanDirectories($domainsPath, $foldersToScan, $extension);

            return ScanResultDto::fromFiles($files);
        }, 'ScanDomainFilesAction');
    }

    private function scanDirectories(string $domainsPath, array $foldersToScan, string $extension): array
    {
        $files = [];

        foreach (File::directories($domainsPath) as $domain) {
            foreach ($foldersToScan as $folder) {
                $fullPath = "{$domain}/{$folder}";

                if (!File::exists($fullPath)) {
                    continue;
                }

                $scannedFiles = File::glob("{$fullPath}/*.{$extension}");
                $files = array_merge($files, $scannedFiles);
            }
        }

        return $files;
    }
}
