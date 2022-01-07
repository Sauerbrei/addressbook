<?php
declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploadService
{
    public function __construct(
        private string $targetDirectory,
        private SluggerInterface $slugger
    ) {}

    public function storeUpload(UploadedFile $file): File
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $newFilename = sprintf(
            '%s-%s.%s',
            $safeFilename,
            uniqid(),
            $file->guessExtension()
        );

        return $file->move($this->getTargetDirectory(), $newFilename);
    }

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }
}
