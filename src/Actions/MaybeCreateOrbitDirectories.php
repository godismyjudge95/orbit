<?php

namespace Orbit\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Filesystem;
use Orbit\Contracts\Orbit;

class MaybeCreateOrbitDirectories
{
    public function execute((Orbit & Model)|null $model = null)
    {
        $fs = new Filesystem();

        $fs->ensureDirectoryExists(config('orbit.paths.content'));
        $fs->ensureDirectoryExists(dirname(config('orbit.paths.database')));

        if (! $fs->exists(config('orbit.paths.database'))) {
            $fs->put(config('orbit.paths.database'), '');
        }

        if ($model !== null) {
            $modelDirectory = config('orbit.paths.content') . DIRECTORY_SEPARATOR . $model->getTable();

            $fs->ensureDirectoryExists($modelDirectory);
        }
    }
}
