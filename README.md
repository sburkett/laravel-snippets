# laravel-snippets
Various tidbits from my adventures with Laravel.

## DomainWhitelist.php
A simple, but functional, domain whitelister for Laravel 5.x

## extractTranslationTokens.php
A command-line PHP script that uses regex to extract all of your language translation tokens from your views. Handy if you want to get a list of them in order to feed them into a localisation tool, spreadsheet, etc. Just toss the script into your `resources/views` folder, make executable (or run via `php extractTranslationTokens.php`) and everything is sent to `stdout`.
