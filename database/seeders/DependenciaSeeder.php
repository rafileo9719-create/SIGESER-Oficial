<?php

namespace Database\Seeders;

use App\Models\Dependencia;
use Illuminate\Database\Seeder;

class DependenciaSeeder extends Seeder
{
    public function run(): void
    {
        $datos = [
            ['nombre' => 'INSTITUTO TECNOLOGICO SUPERIOR DE ATLIXCO', 'fecha_firma_convenio' => '2025-09-09', 'fecha_inicio' => '2025-09-09', 'fecha_termino' => 'INDEFINIDO', 'tipo_convenio_institucional' => 'Alianzas educativas', 'sector' => 'Público', 'giro' => 'Educativo', 'tamano' => 'Grande', 'actividad' => 'Científica', 'aplica_para' => 'AMBOS'],
            ['nombre' => 'CENTRO REGIONAL DE OPTIMIZACION Y DESARROLLO DE EQUIPO DE ORIZABA CRODE', 'fecha_firma_convenio' => '2025-04-25', 'fecha_inicio' => '2025-04-25', 'fecha_termino' => 'INDEFINIDO', 'tipo_convenio_institucional' => 'Alianzas educativas', 'sector' => 'Público', 'giro' => 'Educativo', 'tamano' => 'Grande', 'actividad' => 'Científica', 'aplica_para' => 'AMBOS'],
            ['nombre' => 'EMPRESA EMLCE S.A DE C.V. (Yerba Santa Merida)', 'fecha_firma_convenio' => '2025-06-06', 'fecha_inicio' => '2025-06-06', 'fecha_termino' => 'INDEFINIDO', 'tipo_convenio_institucional' => 'Convenio de colaboración Académica', 'sector' => 'Privado', 'giro' => 'Hotel / Restaurante', 'tamano' => 'Mediana', 'actividad' => 'Innovación', 'aplica_para' => 'AMBOS'],
            ['nombre' => 'GRAND FIESTA AMERICANA PUEBLA', 'fecha_firma_convenio' => '2026-02-02', 'fecha_inicio' => '2026-02-02', 'fecha_termino' => '2029-12-31', 'tipo_convenio_institucional' => 'Convenio de colaboración Académica', 'sector' => 'Privado', 'giro' => 'Hotel / Restaurante', 'tamano' => 'Grande', 'actividad' => 'Innovación', 'aplica_para' => 'AMBOS'],
            ['nombre' => 'CALERAS BELTRAN S.A DE C.V', 'fecha_firma_convenio' => '2022-08-18', 'fecha_inicio' => '2022-08-18', 'fecha_termino' => '2027-12-31', 'tipo_convenio_institucional' => 'Convenio de colaboración Académica', 'sector' => 'Privado', 'giro' => 'Producción de Cal', 'tamano' => 'Mediana', 'actividad' => 'Tecnológica', 'aplica_para' => 'AMBOS'],
            ['nombre' => 'SISTEMAS Y DISEÑOS MOVILES SA DE CV', 'fecha_firma_convenio' => '2024-04-24', 'fecha_inicio' => '2017-02-03', 'fecha_termino' => 'INDEFINIDO', 'tipo_convenio_institucional' => 'Convenio de colaboración Académica', 'sector' => 'Privado', 'giro' => 'Equipamiento Automotriz', 'tamano' => 'Mediana', 'actividad' => 'Innovación', 'aplica_para' => 'AMBOS'],
            ['nombre' => 'HOTEL CID MARINA', 'fecha_firma_convenio' => '2017-08-01', 'fecha_inicio' => '2017-08-01', 'fecha_termino' => 'INDEFINIDO', 'tipo_convenio_institucional' => 'Convenio de colaboración Académica', 'sector' => 'Privado', 'giro' => 'Hotel / Restaurante', 'tamano' => 'Grande', 'actividad' => 'Innovación', 'aplica_para' => 'AMBOS'],
            ['nombre' => 'ESCUELA PRIMARIA IGNACIO ZARAGOZA', 'fecha_firma_convenio' => '2017-10-23', 'fecha_inicio' => '2017-10-23', 'fecha_termino' => 'INDEFINIDO', 'tipo_convenio_institucional' => 'Proyecto Social', 'sector' => 'Público', 'giro' => 'Servicios educativos', 'tamano' => 'Mediana', 'actividad' => 'Tecnológica', 'aplica_para' => 'SS'],
            ['nombre' => 'CANACO TEPEACA', 'fecha_firma_convenio' => '2025-11-25', 'fecha_inicio' => '2025-11-25', 'fecha_termino' => 'INDEFINIDO', 'tipo_convenio_institucional' => 'Proyecto Social', 'sector' => 'Privado', 'giro' => 'Capacitación y asesoría en administración, contabilidad y fiscal', 'tamano' => 'Mediana', 'actividad' => 'Innovación', 'aplica_para' => 'SS'],
            ['nombre' => 'CEMEX OPERACIONES MEXICO, S.A. DE C.V.', 'fecha_firma_convenio' => '2018-08-17', 'fecha_inicio' => '2018-08-17', 'fecha_termino' => 'INDEFINIDO', 'tipo_convenio_institucional' => 'Convenio de colaboración Académica', 'sector' => 'Privado', 'giro' => 'Producción de Concreto', 'tamano' => 'Grande', 'actividad' => 'Tecnológica', 'aplica_para' => 'AMBOS'],
        ];

        foreach ($datos as $dato) {
            Dependencia::create($dato);
        }
    }
}