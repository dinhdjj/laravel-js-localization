<?php

use Dinhdjj\JsLocalization\Facades\JsLocalization;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;

it('has jslocalization blade directive', function (): void {
    expect(Blade::getCustomDirectives())->toHaveKey('jslocalization');
});

test('jslocalization blade directive', function (): void {
    $result = Blade::getCustomDirectives()['jslocalization']();
    $langs = json_encode(JsLocalization::getLangs());
    $mainJs = File::get(__DIR__.'/../dist/main.js');
    expect(str_contains($result, "locale:'<?php echo app()->getLocale() ?>'"))->toBe(true);
    expect(str_contains($result, "fallbackLocale:'<?php echo app()->getFallbackLocale() ?>'"))->toBe(true);
    expect(str_contains($result, '<script type="text/javascript">'))->toBe(true);
    expect(str_contains($result, '</script>'))->toBe(true);
    expect(str_contains($result, $langs))->toBe(true);
    expect(str_contains($result, $mainJs))->toBe(true);
});
