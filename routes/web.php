<?php

use App\Models\User;
use Illuminate\Support\Collection;
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

    $faker = Faker\Factory::create();

    $user = \Papalardo\Laform\Tests\Models\User::create([
        'name' => $faker->name,
        'email' => $faker->email,
        'country' => $faker->randomElement(['us', 'cn', 'in'])
    ]);
    

    $musics = collect([]);
    foreach(range(1, 5) as $n) {
        $musics->push(\Papalardo\Laform\Tests\Models\Music::create([ 'name' => $faker->name, 'album' => $faker->name ]));
    }
    

    $user->playlist()->sync($musics->pluck('id'));

    $user->avatar()->save(new \Papalardo\Laform\Tests\Models\Media(['link' => 'https://ui-avatars.com/api/?name=John+Doe', 'ref' => 'avatar']));

    $user->photos()->saveMany([
        new \Papalardo\Laform\Tests\Models\Media(['link' => 'https://ui-avatars.com/api/?name=John+Doe', 'ref' => 'photos']),
        new \Papalardo\Laform\Tests\Models\Media(['link' => 'https://ui-avatars.com/api/?name=John+Doe', 'ref' => 'photos']),
        new \Papalardo\Laform\Tests\Models\Media(['link' => 'https://ui-avatars.com/api/?name=John+Doe', 'ref' => 'photos']),
    ]);

    $user->carDocument()->save(new \Papalardo\Laform\Tests\Models\Media(['link' => 'https://ui-avatars.com/api/?name=John+Doe', 'ref' => 'car_document']));

    $user->documents()->saveMany([
        new \Papalardo\Laform\Tests\Models\Media(['link' => 'https://ui-avatars.com/api/?name=John+Doe', 'ref' => 'documents']),
        new \Papalardo\Laform\Tests\Models\Media(['link' => 'https://ui-avatars.com/api/?name=John+Doe', 'ref' => 'documents']),
        new \Papalardo\Laform\Tests\Models\Media(['link' => 'https://ui-avatars.com/api/?name=John+Doe', 'ref' => 'documents']),
    ]);
        
    $user->nested_fields = [
        [ 'name2' => 'name2', 'name3' => 'name3', 'playlist' => $user->playlist, 'deep_nested_fields' => [['name' => 'Pablo', 'phone' => '61']] ],
        [ 'name2' => 'name2123', 'name3' => 'name365', 'playlist' => $user->playlist ],
        [ 'name2' => 'name2123', 'name3' => 'name365654', 'playlist' => $user->playlist ],
        [ 'name2' => 'name2445464', 'playlist' => $user->playlist ],
    ];
    
    $form = \Papalardo\Laform\Forms\FormBuilder::init($user)
        // ->addField(\Papalardo\Laform\Fields\HiddenField::make('_token', csrf_token()))
        ->addField(InputField::make('nome', 'name'))
        // ->addField(InputField::make('Email', 'email')->help('This is help 2'))
        ->addField(
            \Papalardo\Laform\Fields\RichMultiSelectField::make('Gostos musicais', 'playlist', \Papalardo\Laform\Tests\Models\Music::limit(2)->get())
                ->trackBy('name', 'id')
        )
        ->addField(
            SelectField::make('País', 'country', \App\Models\Music::all()->toArray())
                ->trackByLabel('name')
                // ->addSlot(new \Papalardo\Laform\FieldSlots\SelectField\SelectFieldOptionSlot('<option :value="option.name">Custom {{ option.name }}</option>'))
        )
        ->addField(
            SelectField::make('País', 'country', [
                    ['code' => 'us', 'name' => 'United States', 'flag' => 'https://lipis.github.io/flag-icon-css/flags/4x3/um.svg'],
                    ['code' => 'cn', 'name' => 'China', 'flag' => 'https://lipis.github.io/flag-icon-css/flags/4x3/cn.svg'],
                    ['code' => 'in', 'name' => 'India', 'flag' => 'https://lipis.github.io/flag-icon-css/flags/4x3/in.svg']
                ])
                ->trackBy('name', 'code')
                // ->addSlot(new \Papalardo\Laform\FieldSlots\SelectField\SelectFieldOptionSlot('<option :value="option.name">Custom {{ option.name }}</option>'))
        )
        ->addField(
            \Papalardo\Laform\Fields\RichSelectField::make('Country From', 'country')
                ->options([
                    ['code' => 'us', 'name' => 'United States', 'flag' => 'https://lipis.github.io/flag-icon-css/flags/4x3/um.svg' ],
                    ['code' => 'cn', 'name' => 'China', 'flag' => 'https://lipis.github.io/flag-icon-css/flags/4x3/cn.svg' ],
                    ['code' => 'in', 'name' => 'India', 'flag' => 'https://lipis.github.io/flag-icon-css/flags/4x3/in.svg' ]
                ])
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
                ->trackByValue('code')
                // ->trackBy('name', 'code')
        )
        ->addField(
            \Papalardo\Laform\Fields\FileField::make('Documento do carro', 'car_document')
                ->setUploadConfig(\Papalardo\Laform\Config\Upload\FileUploadConfig::make()
                    ->setDirectory('documents')))
        ->addField(\Papalardo\Laform\Fields\MultiFileField::make('Documentos', 'documents'))
        ->addField(\Papalardo\Laform\Fields\ImageField::make('Avatar'))
        ->addField(\Papalardo\Laform\Fields\MultiImageField::make('Photos'))
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
                    InputField::make('Teste nome 2', 'name2'),
                    InputField::make('Teste nome 3', 'name3'),
                    \Papalardo\Laform\Fields\RichMultiSelectField::make('Gostos musicais', 'playlist', \Papalardo\Laform\Tests\Models\Music::limit(2)->get())
                        ->trackBy('name', 'id'),
                    RepeatedField::make(
                        'Nested Field',
                        'deep_nested_fields',
                        FieldsBuilder::make([
                            InputField::make('Teste nome 2', 'name')
                                ->valueResolve(function($value) {
                                    return $value . ' <= Local Deep Value Resolved';
                                }),
                            InputField::make('Teste nome 3', 'phone'),
                        ]),
                    )
                ]),
            )
        )
        ->getForm();
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
    
    // $user = \App\Models\User::updateOrCreate(['email' => 'pablopapalardo2@gmail.com'], [
    //     'name' => 'Pablo Papalardo',
    //     'password' => '@admin123',
    // ]);

    // $user->musics()->saveMany([
    //     new \App\Models\Music(['name' => 'Samba']),
    //     new \App\Models\Music(['name' => 'Rap']),
    //     new \App\Models\Music(['name' => 'Hip Hop'])
    // ]);

    // $form->fill($user);
    // return response()->json($form);

    return view('forms.user-edit', ['form' => $form]);
});
