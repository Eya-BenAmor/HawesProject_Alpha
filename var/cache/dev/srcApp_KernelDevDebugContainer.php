<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerXywDzRf\srcApp_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerXywDzRf/srcApp_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerXywDzRf.legacy');

    return;
}

if (!\class_exists(srcApp_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerXywDzRf\srcApp_KernelDevDebugContainer::class, srcApp_KernelDevDebugContainer::class, false);
}

return new \ContainerXywDzRf\srcApp_KernelDevDebugContainer([
    'container.build_hash' => 'XywDzRf',
    'container.build_id' => 'c77c6758',
    'container.build_time' => 1645219236,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerXywDzRf');
