<?php

/** @noinspection PhpUnhandledExceptionInspection */

/** @noinspection LaravelFunctionsInspection */

use DefStudio\Telegraph\DTO\Photo;
use DefStudio\Telegraph\Facades\Telegraph;
use Illuminate\Support\Facades\Storage;

beforeEach(fn () => sandbox_bot());

it('can return bot info', function () {
    $response = Telegraph::botInfo()->send();
    expect($response->json('result'))->toMatchSnapshot();
})->skip(fn () => empty(env('SANDOBOX_TELEGRAM_BOT_TOKEN')) || env('SANDOBOX_TELEGRAM_BOT_TOKEN') === ':fake_bot_token:', 'Sandbox telegram bot token missing');

it('can store chat files', function () {
    Storage::fake();

    $photo = Photo::fromArray([
        "file_id" => "AgACAgQAAxkBAAMtYnZXPgRqZddLGQG6LSvtxQ0cQg4AApi5MRtoC7hTdvog5WT4h4QBAAMCAANzAAMkBA",
        "file_size" => 1514,
        "width" => 90,
        "height" => 84,
    ]);

    Telegraph::store($photo, Storage::path('images/bot'), 'my_file.jpg');

    expect(Storage::exists('images/bot/my_file.jpg'))->toBeTrue();
})->skip(fn () => empty(env('SANDOBOX_TELEGRAM_BOT_TOKEN')) || env('SANDOBOX_TELEGRAM_BOT_TOKEN') === ':fake_bot_token:', 'Sandbox telegram bot token missing');


it('can send an invoice', function () {

    $results = Telegraph::invoice('Test Invoice')
         ->description('A test invoice sent from Telegraph')
         ->currency('EUR')
         ->addItem('line 1', 1000)
         ->addItem('line 2', 1500)
         ->addItem('line 3', 5000)
         ->providerToken(env('SANDOBOX_TELEGRAM_PAYMENT_PROVIDER_TOKEN'))
         ->link()
         ->send();

    expect($results['ok'])->toBeTrue()
        ->and($results['result'])->toBeString();

})->skip(fn () => empty(env('SANDOBOX_TELEGRAM_PAYMENT_PROVIDER_TOKEN')) || empty(env('SANDOBOX_TELEGRAM_BOT_TOKEN')) || env('SANDOBOX_TELEGRAM_BOT_TOKEN') === ':fake_bot_token:', 'Sandbox telegram bot token missing');
