<?php

return [
    'ffmpeg' => [
        'binaries' => '/path/to/ffmpeg',
        'threads'  => 12,
    ],
    'ffprobe' => [
        'binaries' => '/path/to/ffprobe',
    ],

    'timeout' => 3600,

    'log_channel' => env('LOG_CHANNEL', 'stack'),   // set to false to completely disable logging

    'temporary_files_root' => env('FFMPEG_TEMPORARY_FILES_ROOT', sys_get_temp_dir()),

    'temporary_files_encrypted_hls' => env('FFMPEG_TEMPORARY_ENCRYPTED_HLS', env('FFMPEG_TEMPORARY_FILES_ROOT', sys_get_temp_dir())),
];
