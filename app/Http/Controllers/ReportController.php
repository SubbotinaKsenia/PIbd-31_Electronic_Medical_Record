<?php

namespace App\Http\Controllers;

use App\DoctorReport;
use App\PatientReport;
use App\Record;
use App\ServiceReport;
use App\User;
use App\Service;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\SimpleType\Jc;

class ReportController extends Controller
{
    public function getReportTopDoctors()
    {
        $phpWord = new  \PhpOffice\PhpWord\PhpWord();
        $phpWord->addFontStyle('FontHeader', array('name' => 'Times New Roman', 'size' => 16, 'bold' => true));
        $phpWord->addFontStyle('Font', array('name' => 'Times New Roman', 'size' => 14, 'bold' => true));
        $phpWord->addFontStyle('FontCell', array('name' => 'Times New Roman', 'size' => 14, 'bold' => false));
        $phpWord->addParagraphStyle('Paragraph', array('alignment' => Jc::CENTER));

        $section = $phpWord->addSection();

        $docs = \App::call('App\Http\Controllers\ReportController@ReportTopDoctors');

        $section->addText(htmlspecialchars('Рейтинг врачей за период'), 'FontHeader', 'Paragraph');

        $styleTable = array('borderSize' => 6, 'borderColor' => '006699', 'cellMargin' => 100);
        $styleFirstRow = array('borderBottomSize' => 15);

        $phpWord->addTableStyle('Рейтинг врачей за период', $styleTable, $styleFirstRow);
        $table = $section->addTable('Рейтинг врачей за период');

        $table->addRow();
        $table->addCell(750)->addText(htmlspecialchars('№'), 'Font', 'Paragraph');
        $table->addCell(5000)->addText(htmlspecialchars('Доктор'), 'Font', 'Paragraph');
        $table->addCell(5000)->addText(htmlspecialchars('Кол-во записей'), 'Font', 'Paragraph');
        $i = 1;
        foreach ($docs as $doc) {
            $table->addRow();
            $table->addCell(750)->addText(htmlspecialchars("{$i}."), 'FontCell', 'Paragraph');
            $table->addCell(5000)->addText(htmlspecialchars("{$doc->fio}"), 'FontCell');
            $table->addCell(5000)->addText(htmlspecialchars("{$doc->count}"), 'FontCell');
            $i++;
        }

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('Рейтинг врачей за период.docx');

        return response()->download(public_path('Рейтинг врачей за период.docx'));
    }


    public function getReportTopServices()
    {
        $phpWord = new  \PhpOffice\PhpWord\PhpWord();
        $phpWord->addFontStyle('FontHeader', array('name' => 'Times New Roman', 'size' => 16, 'bold' => true));
        $phpWord->addFontStyle('Font', array('name' => 'Times New Roman', 'size' => 14, 'bold' => true));
        $phpWord->addFontStyle('FontCell', array('name' => 'Times New Roman', 'size' => 14, 'bold' => false));
        $phpWord->addParagraphStyle('Paragraph', array('alignment' => Jc::CENTER));

        $section = $phpWord->addSection();

        $top_services = \App::call('App\Http\Controllers\ReportController@ReportTopServices');

        $section->addText(htmlspecialchars('Рейтинг услуг за период'), 'FontHeader', 'Paragraph');

        $styleTable = array('borderSize' => 6, 'borderColor' => '006699', 'cellMargin' => 100);
        $styleFirstRow = array('borderBottomSize' => 15);

        $phpWord->addTableStyle('Рейтинг услуг за период', $styleTable, $styleFirstRow);
        $table = $section->addTable('Рейтинг услуг за период');

        $table->addRow();
        $table->addCell(750)->addText(htmlspecialchars('№'), 'Font', 'Paragraph');
        $table->addCell(5000)->addText(htmlspecialchars('Услуга'), 'Font', 'Paragraph');
        $table->addCell(5000)->addText(htmlspecialchars('Кол-во записей'), 'Font', 'Paragraph');
        $i = 1;
        foreach ($top_services as $top_service) {
            $table->addRow();
            $table->addCell(750)->addText(htmlspecialchars("{$i}."), 'FontCell', 'Paragraph');
            $table->addCell(5000)->addText(htmlspecialchars("{$top_service->title}"), 'FontCell');
            $table->addCell(5000)->addText(htmlspecialchars("{$top_service->count}"), 'FontCell');
            $i++;
        }

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('Рейтинг услуг за период.docx');

        return response()->download(public_path('Рейтинг услуг за период.docx'));
    }

    public function getReportTopPatients()
    {
        $phpWord = new  \PhpOffice\PhpWord\PhpWord();
        $phpWord->addFontStyle('FontHeader', array('name' => 'Times New Roman', 'size' => 16, 'bold' => true));
        $phpWord->addFontStyle('Font', array('name' => 'Times New Roman', 'size' => 14, 'bold' => true));
        $phpWord->addFontStyle('FontCell', array('name' => 'Times New Roman', 'size' => 14, 'bold' => false));
        $phpWord->addParagraphStyle('Paragraph', array('alignment' => Jc::CENTER));

        $section = $phpWord->addSection();

        $top_patients = \App::call('App\Http\Controllers\ReportController@ReportTopPatients');

        $section->addText(htmlspecialchars('Рейтинг пациентов за период'), 'FontHeader', 'Paragraph');

        $styleTable = array('borderSize' => 6, 'borderColor' => '006699', 'cellMargin' => 100);
        $styleFirstRow = array('borderBottomSize' => 15);

        $phpWord->addTableStyle('Рейтинг пациентов за период', $styleTable, $styleFirstRow);
        $table = $section->addTable('Рейтинг пациентов за период');

        $table->addRow();
        $table->addCell(750)->addText(htmlspecialchars('№'), 'Font', 'Paragraph');
        $table->addCell(5000)->addText(htmlspecialchars('Пациент'), 'Font', 'Paragraph');
        $table->addCell(5000)->addText(htmlspecialchars('Кол-во записей'), 'Font', 'Paragraph');
        $i = 1;
        foreach ($top_patients as $top_patient) {
            $table->addRow();
            $table->addCell(750)->addText(htmlspecialchars("{$i}."), 'FontCell', 'Paragraph');
            $table->addCell(5000)->addText(htmlspecialchars("{$top_patient->fio}"), 'FontCell');
            $table->addCell(5000)->addText(htmlspecialchars("{$top_patient->count}"), 'FontCell');
            $i++;
        }

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('Рейтинг пациентов за период.docx');

        return response()->download(public_path('Рейтинг пациентов за период.docx'));
    }


    public function ReportTopDoctors()
    {
        $sheets = Record::where('is_reserved', 1)->get();

        $doctors = array();
        $top_doctors = array();

        foreach ($sheets as $sheet) {
            $doctor = User::findOrFail($sheet->doctor_id);
            if (!in_array($doctor, $doctors)) {
                array_push($top_doctors, new DoctorReport([
                    'fio' => $doctor->fio,
                    'count' => 1,
                    'doctor_id' => $doctor->id,
                ]));
                array_push($doctors, $doctor);
            } else {
                foreach ($top_doctors as $doc) {
                    if ($doc->doctor_id == $doctor->id) {
                        $doc->fill([
                            'count' => intval($doc->count) + 1,
                        ]);
                    }
                }
            }
        }

        usort($top_doctors, function ($a, $b) {
            return ($b->count - $a->count);
        });

        return $top_doctors;
    }

    public function ReportTopServices()
    {
        $records = Record::all();

        $services = array();
        $top_services = array();

        foreach ($records as $rec) {
            $service = Service::findOrFail($rec->service_id);
            if (!in_array($service, $services)) {
                array_push($top_services, new ServiceReport([
                    'title' => $service->title,
                    'count' => 1,
                    'service_id' => $service->id,
                ]));
                array_push($services, $service);
            } else {
                foreach ($top_services as $top_service) {
                    if ($top_service->service_id == $service->id) {
                        $top_service->fill([
                            'count' => intval($top_service->count) + 1
                        ]);
                    }
                }
            }
        }

        usort($top_services, function ($a, $b) {
            return ($b->count - $a->count);
        });

        return $top_services;
    }

    public function ReportTopPatients()
    {
        $records = Record::where('is_reserved', 1)->get();

        $patients = array();
        $top_patients = array();

        foreach ($records as $rec) {
            $patient = User::findOrFail($rec->patient_id);
            if (!in_array($patient, $patients)) {
                array_push($top_patients, new PatientReport([
                    'fio' => $patient->fio,
                    'count' => 1,
                    'patient_id' => $patient->id,
                ]));
                array_push($patients, $patient);
            } else {
                foreach ($top_patients as $top_patient) {
                    if ($top_patient->patient_id == $patient->id) {
                        $top_patient->fill([
                            'count' => intval($top_patient->count) + 1
                        ]);
                    }
                }
            }
        }

        usort($top_patients, function ($a, $b) {
            return ($b->count - $a->count);
        });

        return $top_patients;
    }
}
