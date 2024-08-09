<?php

return [
  'binary' => env('PDFTOTEXT_BINARY', 'C:\Program Files\Xpdf\bin64\pdftotext.exe'),
  'options' => [
      'layout',
      'enc UTF-8',
  ],
  // ... other configurations
];