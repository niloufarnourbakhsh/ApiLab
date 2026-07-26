<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;

#[Signature('make:apiRequest {name}')]
#[Description('create new Api requestClass')]
class ApiRequestMakeCommand extends GeneratorCommand
{
    /**
     * Execute the console command.
     */
//    public function handle()
//    {
//        //
//    }

    protected function getStub()
    {
        // TODO: Implement getStub() method.
        return __DIR__.'/stubs/ApiRequest.stub';
    }

    public function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace. '/Http/ApiRequests';
    }
}
