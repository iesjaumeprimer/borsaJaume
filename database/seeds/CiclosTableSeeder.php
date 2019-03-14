<?php

use Illuminate\Database\Seeder;
use App\Entities\Ciclo;

class CiclosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ciclo::create( [
            'id'=>2,
            'codigo'=>'CFMX',
            'ciclo'=>'CFM  FCT ESTÈTICA (LOGSE)',
            'Dept'=>3,
            'cDept'=>'IMAGEN PERSONAL',
            'vDept'=>'IMATGE PERSONAL',
            'responsable'=>NULL,
            'vCiclo'=>NULL,
            'cCiclo'=>NULL
        ] );



        Ciclo::create( [
            'id'=>3,
            'codigo'=>'CFMJ',
            'ciclo'=>'CFM APD (LOE)',
            'Dept'=>2,
            'cDept'=>'SERVICIOS A LA COMUNIDAD',
            'vDept'=>'SEVEIS A LA COMUNITAT',
            'responsable'=>NULL,
            'vCiclo'=>'Atenció a persones en situació de dependència',
            'cCiclo'=>'Atención a personas en situación de dependencia'
        ] );



        Ciclo::create( [
            'id'=>4,
            'codigo'=>'CFMD',
            'ciclo'=>'CFM FARMACIA (LOE)',
            'Dept'=>6,
            'cDept'=>'DEPARTAMENTO SANITARIO',
            'vDept'=>'DEPARTAMENT SANITARI',
            'responsable'=>1,
            'vCiclo'=>'Farmàcia i parafarmàcia',
            'cCiclo'=>'Farmacia y parafarmacia'
        ] );



        Ciclo::create( [
            'id'=>8,
            'codigo'=>'CFMA',
            'ciclo'=>'CFM CAE (LOGSE)',
            'Dept'=>6,
            'cDept'=>'DEPARTAMENTO SANITARIO',
            'vDept'=>'DEPARTAMENT SANITARI',
            'responsable'=>1,
            'vCiclo'=>'Cures auxiliares d\'infermeria',
            'cCiclo'=>'Curas auxiliares de enfermería'
        ] );



        Ciclo::create( [
            'id'=>12,
            'codigo'=>'CFMN',
            'ciclo'=>'CFM CUINA (LOE)',
            'Dept'=>10,
            'cDept'=>'HOSTELERIA Y TURISMO',
            'vDept'=>'HOSTELERIA I TURISME',
            'responsable'=>NULL,
            'vCiclo'=>'Cuina i gastronomia',
            'cCiclo'=>'Cocina y gastronomía'
        ] );



        Ciclo::create( [
            'id'=>16,
            'codigo'=>'CFMF',
            'ciclo'=>'CFM ESTÈTICA I BELL. (LOE)',
            'Dept'=>3,
            'cDept'=>'IMAGEN PERSONAL',
            'vDept'=>'IMATGE PERSONAL',
            'responsable'=>1,
            'vCiclo'=>'Estètica i bellesa',
            'cCiclo'=>'Estética y belleza'
        ] );



        Ciclo::create( [
            'id'=>18,
            'codigo'=>'CFMB',
            'ciclo'=>'CFM GESTIÓ ADMVA. (LOE)',
            'Dept'=>5,
            'cDept'=>'DEPARTAMENTO ADMINISTRATIVO',
            'vDept'=>'DEPARTAMENT ADMINISTRACIÓ',
            'responsable'=>NULL,
            'vCiclo'=>'Gestió administrativa',
            'cCiclo'=>'Gestión administrativa'
        ] );



        Ciclo::create( [
            'id'=>20,
            'codigo'=>'CFMG',
            'ciclo'=>'CFM PERRUQUERIA (LOE)',
            'Dept'=>3,
            'cDept'=>'IMAGEN PERSONAL',
            'vDept'=>'IMATGE PERSONAL',
            'responsable'=>1,
            'vCiclo'=>'Perruqueria i cosmètica capilar',
            'cCiclo'=>'Peluquería y cosmética capilar'
        ] );



        Ciclo::create( [
            'id'=>22,
            'codigo'=>'CFMP',
            'ciclo'=>'CFM SERV. RESTAURACIÓ (LOE)',
            'Dept'=>10,
            'cDept'=>'HOSTELERIA Y TURISMO',
            'vDept'=>'HOSTELERIA I TURISME',
            'responsable'=>NULL,
            'vCiclo'=>'Servicis en restauració',
            'cCiclo'=>'Servicios en restauración'
        ] );



        Ciclo::create( [
            'id'=>24,
            'codigo'=>'CFMH',
            'ciclo'=>'CFM SMX  (LOE)',
            'Dept'=>24,
            'cDept'=>'DEPARTAMENTO INFORMATICA',
            'vDept'=>'DEPARTAMENT INFORMÀTICA',
            'responsable'=>NULL,
            'vCiclo'=>'Sistemes microinformàtics i xarxes',
            'cCiclo'=>'Sistemas microinformáticos y redes'
        ] );



        Ciclo::create( [
            'id'=>28,
            'codigo'=>'CFSB',
            'ciclo'=>'CFS ADM. I FINANC. (LOE)',
            'Dept'=>5,
            'cDept'=>'DEPARTAMENTO ADMINISTRATIVO',
            'vDept'=>'DEPARTAMENT ADMINISTRACIÓ',
            'responsable'=>NULL,
            'vCiclo'=>'Administració i finances',
            'cCiclo'=>'Administración y finanzas'
        ] );



        Ciclo::create( [
            'id'=>30,
            'codigo'=>'CFSC',
            'ciclo'=>'CFS ASIX (LOE)',
            'Dept'=>24,
            'cDept'=>'DEPARTAMENTO INFORMATICA',
            'vDept'=>'DEPARTAMENT INFORMÀTICA',
            'responsable'=>NULL,
            'vCiclo'=>'Administració de sistemes informàtics en xarxa',
            'cCiclo'=>'Administración de sistemas informáticos en red'
        ] );



        Ciclo::create( [
            'id'=>32,
            'codigo'=>'CFSL',
            'ciclo'=>'CFS DAM (LOE)',
            'Dept'=>24,
            'cDept'=>'DEPARTAMENTO INFORMATICA',
            'vDept'=>'DEPARTAMENT INFORMÀTICA',
            'responsable'=>NULL,
            'vCiclo'=>'Desenrotllament d\'aplicacions multiplataforma',
            'cCiclo'=>'Desarrollo de aplicaciones multiplataforma'
        ] );



        Ciclo::create( [
            'id'=>35,
            'codigo'=>'CFSW',
            'ciclo'=>'CFS DAW (LOE)',
            'Dept'=>24,
            'cDept'=>'DEPARTAMENTO INFORMATICA',
            'vDept'=>'DEPARTAMENT INFORMÀTICA',
            'responsable'=>NULL,
            'vCiclo'=>'Desenrotllament d\'aplicacions web',
            'cCiclo'=>'Desarrollo de aplicaciones  web'
        ] );



        Ciclo::create( [
            'id'=>36,
            'codigo'=>'CFSP',
            'ciclo'=>'CFS DIREC. CUINA (LOE)',
            'Dept'=>10,
            'cDept'=>'HOSTELERIA Y TURISMO',
            'vDept'=>'HOSTELERIA I TURISME',
            'responsable'=>NULL,
            'vCiclo'=>'Direcció de cuina',
            'cCiclo'=>'Dirección de cocina'
        ] );



        Ciclo::create( [
            'id'=>38,
            'codigo'=>'CFSR',
            'ciclo'=>'CFS DIREC.RESTAURACIÓ (LOE)',
            'Dept'=>10,
            'cDept'=>'HOSTELERIA Y TURISMO',
            'vDept'=>'HOSTELERIA I TURISME',
            'responsable'=>NULL,
            'vCiclo'=>'Direcció en servicis de restauració',
            'cCiclo'=>'Dirección en servicios de restauración'
        ] );



        Ciclo::create( [
            'id'=>39,
            'codigo'=>'CFSP',
            'ciclo'=>'CFS EDUC.INFANTIL (LOE)',
            'Dept'=>2,
            'cDept'=>'SERVICIOS A LA COMUNIDAD',
            'vDept'=>'SEVEIS A LA COMUNITAT',
            'responsable'=>NULL,
            'vCiclo'=>'Educació infantil',
            'cCiclo'=>'Educación infantil'
        ] );



        Ciclo::create( [
            'id'=>42,
            'codigo'=>'CFSN',
            'ciclo'=>'CFS ESTET.INTEG. (LOE)',
            'Dept'=>3,
            'cDept'=>'IMAGEN PERSONAL',
            'vDept'=>'IMATGE PERSONAL',
            'responsable'=>NULL,
            'vCiclo'=>'Estètica integral i benestar',
            'cCiclo'=>'Estética integral y bienestar'
        ] );



        Ciclo::create( [
            'id'=>44,
            'codigo'=>'CFSS',
            'ciclo'=>'CFS INTEGR.SOCIAL (LOE)',
            'Dept'=>2,
            'cDept'=>'SERVICIOS A LA COMUNIDAD',
            'vDept'=>'SEVEIS A LA COMUNITAT',
            'responsable'=>NULL,
            'vCiclo'=>'Integració Social',
            'cCiclo'=>'Integración Social'
        ] );



        Ciclo::create( [
            'id'=>45,
            'codigo'=>'CFSJ',
            'ciclo'=>'CFS LABORATORI (LOE)',
            'Dept'=>6,
            'cDept'=>'DEPARTAMENTO SANITARIO',
            'vDept'=>'DEPARTAMENT SANITARI',
            'responsable'=>NULL,
            'vCiclo'=>'Laboratori clínic i biomèdic',
            'cCiclo'=>'Laboratorio clinico y biomédico'
        ] );



        Ciclo::create( [
            'id'=>46,
            'codigo'=>'CFST',
            'ciclo'=>'CFS LABORATORI (LOGSE)',
            'Dept'=>6,
            'cDept'=>'DEPARTAMENTO SANITARIO',
            'vDept'=>'DEPARTAMENT SANITARI',
            'responsable'=>NULL,
            'vCiclo'=>'Laboratori de diagnòstic clínic',
            'cCiclo'=>'Laboratorio de diagnostico clínico'
        ] );



        Ciclo::create( [
            'id'=>47,
            'codigo'=>'CFSM',
            'ciclo'=>'CFS RX  (LOGSE)',
            'Dept'=>6,
            'cDept'=>'DEPARTAMENTO SANITARIO',
            'vDept'=>'DEPARTAMENT SANITARI',
            'responsable'=>NULL,
            'vCiclo'=>'Imatge per al diagnòstic',
            'cCiclo'=>'Imagen para el diagnóstico'
        ] );



        Ciclo::create( [
            'id'=>51,
            'codigo'=>'CFSH',
            'ciclo'=>'CFS RXMN (LOE)',
            'Dept'=>6,
            'cDept'=>'DEPARTAMENTO SANITARIO',
            'vDept'=>'DEPARTAMENT SANITARI',
            'responsable'=>NULL,
            'vCiclo'=>'Imatge per al diagnòtic i medicina nuclear',
            'cCiclo'=>'Imagen para el diagnóstico y medicina nuclear'
        ] );



        Ciclo::create( [
            'id'=>54,
            'codigo'=>'CFSE',
            'ciclo'=>'CFS SALUT AMBIENTAL (LOGSE)',
            'Dept'=>6,
            'cDept'=>'DEPARTAMENTO SANITARIO',
            'vDept'=>'DEPARTAMENT SANITARI',
            'responsable'=>NULL,
            'vCiclo'=>'Salut ambiental',
            'cCiclo'=>'Salud ambiental'
        ] );



        Ciclo::create( [
            'id'=>55,
            'codigo'=>'CFSX',
            'ciclo'=>'CFS TASOC (LOGSE)',
            'Dept'=>2,
            'cDept'=>'SERVICIOS A LA COMUNIDAD',
            'vDept'=>'SEVEIS A LA COMUNITAT',
            'responsable'=>NULL,
            'vCiclo'=>'Animació Sociocultural',
            'cCiclo'=>'Animación Sociocultural'
        ] );



        Ciclo::create( [
            'id'=>56,
            'codigo'=>'CFSM',
            'ciclo'=>'CFS TASOCIT (LOE)',
            'Dept'=>2,
            'cDept'=>'SERVICIOS A LA COMUNIDAD',
            'vDept'=>'SEVEIS A LA COMUNITAT',
            'responsable'=>NULL,
            'vCiclo'=>'Animació Sociocultural i turística',
            'cCiclo'=>'Animación Sociocultural y turística'
        ] );
    }
}
