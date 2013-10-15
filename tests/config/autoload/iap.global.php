<?php

return array(
    'idAuth' => array(
        'storage' => 'IdAuth\Session',
        'tryProviders' => array(
            'IdAuth\Provider\DbTable',
        ),
    ),
);
