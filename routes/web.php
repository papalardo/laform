<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('img/{path}', function (League\Glide\Server $server, Illuminate\Http\Request $request, $path) {
    try {
        return $server->getImageResponse($path, $request->all());
    } catch(\League\Glide\Filesystem\FileNotFoundException $exception) {
        $server->setSource(new \League\Flysystem\Filesystem(new \League\Flysystem\Adapter\Local(public_path('images'))));
        return $server->getImageResponse('image-not-found.png', array_merge($request->all(), ['fit' => 'fill', 'bg' => 'ececec']));
    }
})->where('path', '.*')->name('image.get');

Route::post('/post', function () {
    dd(request()->all());
});

use Papalardo\Laform\Builder\FieldsBuilder;
use Papalardo\Laform\Fields\RepeatedField;
use Papalardo\Laform\Fields\InputField;
use Papalardo\Laform\Fields\SelectField;

Route::get('/', function () {
    // $contactForm = (new \Papalardo\Laform\Forms\FormBuilder)
    //     ->add('123', \Papalardo\Laform\Fields\InputField::class, [
    //         'widthSpan' => 6,
    //         'appendAddon' => '.00'
    //     ])
    //     ->addField(new \Papalardo\Laform\Fields\InputField('Teste nome'))
    //     ->add('options', \Papalardo\Laform\Fields\SelectField::class, [
    //         'widthSpan' => 6,
    //         'options' => [
    //             'teste' => 'Teste123',
    //             'teste2' => 'Teste1234',
    //             'teste3' => 'Teste12345',
    //         ]
    //     ])
    //     ->add('deep_field', \Papalardo\Laform\Fields\NestedField::class, [
    //         'label' => 'Deep Field',
    //         'fields' => (new \Papalardo\Laform\Forms\FormBuilder)
    //             ->add('123', \Papalardo\Laform\Fields\InputField::class)
    //             ->getFields()
    //     ]);

    $form = (new \Papalardo\Laform\Forms\FormBuilder)
        ->addField(\Papalardo\Laform\Fields\HiddenField::make('_token', csrf_token()))
        ->addField(InputField::make('Teste nome')->value('TESTE'))
        ->addField(InputField::make('Teste nome')->help('This is help 2'))
        ->addField(
            SelectField::make('Teste nome')
                ->help('This is help')
                ->options([
                    'us' => ['name' => 'United States', 'flag' => 'https://lipis.github.io/flag-icon-css/flags/4x3/um.svg' ],
                    'cn' => ['name' => 'China', 'flag' => 'https://lipis.github.io/flag-icon-css/flags/4x3/cn.svg' ],
                    'in' => ['name' => 'India', 'flag' => 'https://lipis.github.io/flag-icon-css/flags/4x3/in.svg' ]
                ])
                // ->valueAttribute('name')
                ->textAttribute('name')
                // ->addSlot(new \Papalardo\Laform\FieldSlots\SelectField\SelectFieldOptionSlot('<option :value="option.name">Custom {{ option.name }}</option>'))
        )
        ->addField(
            \Papalardo\Laform\Fields\RichSelectField::make('Teste nome')
                ->help('This is help')
                ->options([
                    'us' => ['name' => 'United States', 'flag' => 'https://lipis.github.io/flag-icon-css/flags/4x3/um.svg' ],
                    'cn' => ['name' => 'China', 'flag' => 'https://lipis.github.io/flag-icon-css/flags/4x3/cn.svg' ],
                    'in' => ['name' => 'India', 'flag' => 'https://lipis.github.io/flag-icon-css/flags/4x3/in.svg' ]
                ])
                ->textAttribute('name')
                ->setSlots([
                    new \Papalardo\Laform\FieldSlots\SelectField\SelectFieldOptionSlot('
                        <span class="flex items-center"><img class="w-4 h-4 mr-2" :src="option.flag" />{{ option.name }}</span>
                    '),
                    new \Papalardo\Laform\FieldSlots\RichSelectFieldSlots\RichSelectFieldNoResultsSlot('
                        <span class="block text-center text-xs text-gray-600">
                            Nenhum resultado encotrado para <strong>{{ keyword }}</strong>.
                        </span>
                    ')
                ])
        )
        ->addField(
            \Papalardo\Laform\Fields\FileField::make('CPF')
                ->setUploadConfig(\Papalardo\Laform\Config\Upload\FileUploadConfig::make()
                    ->setDirectory('documents')))
        ->addField(\Papalardo\Laform\Fields\MultiFileField::make('Processos'))
        ->addField(\Papalardo\Laform\Fields\ImageField::make('Avatar'))
        ->addField(\Papalardo\Laform\Fields\MultiImageField::make('Gallery'))
        // ->addField(
        //     \Papalardo\Laform\Fields\RichSelectField::make('Estado')
        //         ->help('This is help')
        //         ->options([
        //             ['name' => 'United States', 'flag' => 'https://lipis.github.io/flag-icon-css/flags/4x3/um.svg' ],
        //             ['name' => 'China', 'flag' => 'https://lipis.github.io/flag-icon-css/flags/4x3/cn.svg' ],
        //             ['name' => 'India', 'flag' => 'https://lipis.github.io/flag-icon-css/flags/4x3/in.svg' ]
        //         ])
        //         ->textAttribute('name')
        //         ->valueAttribute('name')
        //         ->multiple()
        // )
        ->addField(
            RepeatedField::make(
                'Nested Field',
                'nested_fields',
                FieldsBuilder::make([
                    InputField::make('Teste nome 2'),
                    InputField::make('Teste nome 3'),
                ]),
            )
        )
        ;
    // ->add('dateeee', \Papalardo\Laform\Fields\DateTimePickerField::class, [
    //     'placeholder' => 'Selecione uma data',
    //     'label' => 'Date inicial',
    //     'widthSpan' => 12
    // ])
    // ->add('name', \Papalardo\Laform\Fields\InputField::class, [
    //     'prependAddon' => 'Melhor nome',
    //     'placeholder' => 'Digite o nome'
    // ])
    // ->add('name2', \Papalardo\Laform\Fields\InputField::class)
    // ->add('name3', \Papalardo\Laform\Fields\InputField::class)
    // ->add('nested_field', \Papalardo\Laform\Fields\NestedField::class, [
    //     'label' => 'Nested Field',
    //     'fields' => $contactForm->getFields()
    // ]);

    return view('forms.user-edit', ['form' => $form]);
});
