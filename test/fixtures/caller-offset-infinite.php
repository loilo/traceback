<?php
require_once __DIR__ . '/traceback.php';

// Indirect traceback() call with infinite files offset
return traceback_offset_infinite();
