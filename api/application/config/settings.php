<?php
declare(strict_types=1);

return [
    'httpVersion' => '1.1',
    'responseChunkSize' => 4096,
    'outputBuffering' => 'append',
    'determineRouteBeforeAppMiddleware' => false,
    'displayErrorDetails' => DEBUG,
    'addContentLengthHeader' => true,
    'routerCacheFile' => false,
];
