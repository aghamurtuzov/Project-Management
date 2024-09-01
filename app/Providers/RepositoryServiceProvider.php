<?php

namespace App\Providers;

use App\Repository\Project\Interface\ProjectInterface;
use App\Repository\Project\ProjectRepository;
use App\Repository\Task\Interface\TaskInterface;
use App\Repository\Task\TaskRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ProjectInterface::class, ProjectRepository::class);
        $this->app->bind(TaskInterface::class, TaskRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
