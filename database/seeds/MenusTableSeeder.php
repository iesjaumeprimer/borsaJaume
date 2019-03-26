<?php

use Illuminate\Database\Seeder;
use App\Entities\Menu;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Menu::create( [
            'id'=>1,
            'order'=>5,
            'icon'=>'people',
            'text'=>'Alumnes',
            'path'=>'/alumnos',
            'rol'=>42,
            'parent'=>NULL,
            'model'=>0,
            'active'=>1,
            'comments'=>NULL,
            'icon_alt'=>NULL
        ] );



        Menu::create( [
            'id'=>2,
            'order'=>10,
            'icon'=>'school',
            'text'=>'Cicles',
            'path'=>'/ciclos',
            'rol'=>30,
            'parent'=>NULL,
            'model'=>0,
            'active'=>1,
            'comments'=>NULL,
            'icon_alt'=>NULL
        ] );



        Menu::create( [
            'id'=>3,
            'order'=>15,
            'icon'=>'keyboard_arrow_down',
            'text'=>'Administrar',
            'path'=>NULL,
            'rol'=>6,
            'parent'=>NULL,
            'model'=>1,
            'active'=>1,
            'comments'=>NULL,
            'icon_alt'=>'keyboard_arrow_up'
        ] );



        Menu::create( [
            'id'=>4,
            'order'=>17,
            'icon'=>'list_alt',
            'text'=>'Menú',
            'path'=>'/menu',
            'rol'=>2,
            'parent'=>3,
            'model'=>0,
            'active'=>0,
            'comments'=>NULL,
            'icon_alt'=>NULL
        ] );



        Menu::create( [
            'id'=>6,
            'order'=>2,
            'icon'=>'account_box',
            'text'=>'Perfil',
            'path'=>'/perfil',
            'rol'=>35,
            'parent'=>NULL,
            'model'=>0,
            'active'=>1,
            'comments'=>NULL,
            'icon_alt'=>NULL
        ] );



        Menu::create( [
            'id'=>7,
            'order'=>25,
            'icon'=>'business',
            'text'=>'Empreses',
            'path'=>'/empresas',
            'rol'=>30,
            'parent'=>NULL,
            'model'=>0,
            'active'=>1,
            'comments'=>NULL,
            'icon_alt'=>NULL
        ] );



        Menu::create( [
            'id'=>8,
            'order'=>30,
            'icon'=>'event_note',
            'text'=>'Ofertes',
            'path'=>'/ofertas',
            'rol'=>210,
            'parent'=>NULL,
            'model'=>0,
            'active'=>1,
            'comments'=>NULL,
            'icon_alt'=>NULL
        ] );



        Menu::create( [
            'id'=>9,
            'order'=>99,
            'icon'=>'power_settings_new',
            'text'=>'Eixir',
            'path'=>'/logout',
            'rol'=>210,
            'parent'=>NULL,
            'model'=>0,
            'active'=>1,
            'comments'=>NULL,
            'icon_alt'=>NULL
        ] );



        Menu::create( [
            'id'=>10,
            'order'=>67,
            'icon'=>'how_to_reg',
            'text'=>'Validar cicles alumnes',
            'path'=>'/alumnos',
            'rol'=>6,
            'parent'=>NULL,
            'model'=>NULL,
            'active'=>1,
            'comments'=>NULL,
            'icon_alt'=>NULL
        ] );



        Menu::create( [
            'id'=>12,
            'order'=>32,
            'icon'=>'event_busy',
            'text'=>'Ofertes arxivades',
            'path'=>'/ofertas-arxiu',
            'rol'=>6,
            'parent'=>NULL,
            'model'=>NULL,
            'active'=>1,
            'comments'=>NULL,
            'icon_alt'=>NULL
        ] );



        Menu::create( [
            'id'=>13,
            'order'=>69,
            'icon'=>'event_available',
            'text'=>'Validar ofertes',
            'path'=>'/ofertas',
            'rol'=>6,
            'parent'=>NULL,
            'model'=>NULL,
            'active'=>1,
            'comments'=>NULL,
            'icon_alt'=>NULL
        ] );



        Menu::create( [
            'id'=>14,
            'order'=>75,
            'icon'=>'security',
            'text'=>'Usuaris',
            'path'=>'/users',
            'rol'=>2,
            'parent'=>NULL,
            'model'=>NULL,
            'active'=>1,
            'comments'=>NULL,
            'icon_alt'=>NULL
        ] );
    }
}
