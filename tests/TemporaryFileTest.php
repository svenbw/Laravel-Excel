<?php

namespace Maatwebsite\Excel\Tests;

use Maatwebsite\Excel\Files\TemporaryFileFactory;
use Maatwebsite\Excel\Tests\Helpers\FileHelper;

class TemporaryFileTest extends TestCase
{
    /**
     * @test
     */
    public function can_use_default_rights()
    {
        $path = FileHelper::absolutePath('rights-test', 'local');
        FileHelper::recursiveDelete($path);

        config()->set('excel.temporary_files.local_path', $path);

        $temporaryFileFactory = app(TemporaryFileFactory::class);

        $temporaryFile = $temporaryFileFactory->makeLocal(null, 'txt');
        $temporaryFile->put('data-set');

        $this->assertFileExists($temporaryFile->getLocalPath());
        $this->assertEquals('0770', substr(sprintf('%o', fileperms(dirname($temporaryFile->getLocalPath()))), -4));
        $this->assertEquals('0640', substr(sprintf('%o', fileperms($temporaryFile->getLocalPath())), -4));
    }

    /**
     * @test
     */
    public function can_use_dir_rights()
    {
        $path = FileHelper::absolutePath('rights-test', 'local');
        FileHelper::recursiveDelete($path);

        config()->set('excel.temporary_files.local_path', $path);
        config()->set('excel.temporary_files.local_permissions.dir', 0700);

        $temporaryFileFactory = app(TemporaryFileFactory::class);

        $temporaryFile = $temporaryFileFactory->makeLocal(null, 'txt');
        $temporaryFile->put('data-set');

        $this->assertFileExists($temporaryFile->getLocalPath());
        $this->assertEquals('0700', substr(sprintf('%o', fileperms(dirname($temporaryFile->getLocalPath()))), -4));
        $this->assertEquals('0640', substr(sprintf('%o', fileperms($temporaryFile->getLocalPath())), -4));
    }

    /**
     * @test
     */
    public function can_use_file_rights()
    {
        $path = FileHelper::absolutePath('rights-test', 'local');
        FileHelper::recursiveDelete($path);

        config()->set('excel.temporary_files.local_path', $path);
        config()->set('excel.temporary_files.local_permissions.file', 0600);

        $temporaryFileFactory = app(TemporaryFileFactory::class);

        $temporaryFile = $temporaryFileFactory->makeLocal(null, 'txt');
        $temporaryFile->put('data-set');

        $this->assertFileExists($temporaryFile->getLocalPath());
        $this->assertEquals('0770', substr(sprintf('%o', fileperms(dirname($temporaryFile->getLocalPath()))), -4));
        $this->assertEquals('0600', substr(sprintf('%o', fileperms($temporaryFile->getLocalPath())), -4));
    }
}
