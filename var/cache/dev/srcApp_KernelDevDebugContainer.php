<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerF46obYy\srcApp_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerF46obYy/srcApp_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerF46obYy.legacy');

    return;
}

if (!\class_exists(srcApp_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerF46obYy\srcApp_KernelDevDebugContainer::class, srcApp_KernelDevDebugContainer::class, false);
}

return new \ContainerF46obYy\srcApp_KernelDevDebugContainer([
    'container.build_hash' => 'F46obYy',
    'container.build_id' => 'b205cce2',
    'container.build_time' => 1645370466,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerF46obYy');
