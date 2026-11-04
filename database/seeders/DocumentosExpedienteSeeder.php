<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Expediente;
use App\Models\DocumentoExpediente;

class DocumentosExpedienteSeeder extends Seeder
{
    public function run(): void
    {
        // Buscamos el expediente de William (ID 1)
        $expediente = Expediente::find(1);

        if ($expediente) {
            $documentosSS = [
                'Solicitud de Servicio Social', 'Carta Compromiso', 'Carta de Presentación',
                'Plan de Trabajo', 'Boleta de Actividades', 'Reporte Bimestral 1', 'Evaluación Cualitativa 1',
                'Autoevaluación 1', 'Evaluación Actividades 1', 'Reporte Bimestral 2', 'Evaluación Cualitativa 2',
                'Autoevaluación 2', 'Evaluación Actividades 2', 'Reporte Bimestral 3', 'Evaluación Cualitativa 3',
                'Autoevaluación 3', 'Evaluación Actividades 3', 'Reporte Final', 'Evaluación Cualitativa Final',
                'Autoevaluación Final', 'Evaluación Actividades Final', 'Carta de Terminación'
            ];

            foreach ($documentosSS as $nombreDoc) {
                DocumentoExpediente::create([
                    'expediente_id' => $expediente->id,
                    'nombre_documento' => $nombreDoc,
                    'estado' => 'Pendiente'
                ]);
            }
        }
    }
}