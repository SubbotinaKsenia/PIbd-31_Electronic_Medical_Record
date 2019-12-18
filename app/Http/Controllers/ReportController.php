<?php

namespace App\Http\Controllers;

use App\DoctorReport;
use App\PatientReport;
use App\Record;
use App\ServiceReport;
use App\User;
use App\Service;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function report()
    {
        $phpWord = new  \PhpOffice\PhpWord\PhpWord();
        $phpWord->setDefaultFontSize(14);
//        $properties = $phpWord->getDocInfo();
//        $properties->setCreator('Name');
//        $properties->setCompany('Company');
//        $properties->setTitle('Title');
//        $properties->setDescription('Description');
//        $properties->setCategory('My category');
//        $properties->setLastModifiedBy('My name');
//        $properties->setCreated(mktime(0, 0, 0, 3, 12, 2015));
//        $properties->setModified(mktime(0, 0, 0, 3, 14, 2015));
//        $properties->setSubject('My subject');
//        $properties->setKeywords('my, key, word');
        $section = $phpWord->addSection();
        //$text = $section->addTable()
        $text = $section->addText("dfsfsfsfs");
        //$text = $section->addText($request->get('emp_salary'));
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('testik.docx');
        return response()->download(public_path('testik.docx'));
    }

    public function getReportTopDoctors()
    {
        $phpWord = new  \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        $header = array(
            'size' => 14,
            'bold' => true,
            'align' => 'center',
        );

        $docs = \App::call('App\Http\Controllers\ReportController@ReportTopDoctors');

        $section->addTextBreak(1);
        $section->addText(htmlspecialchars('Рейтинг врачей за период'), $header);
        $styleTable = array('borderSize' => 6, 'borderColor' => '006699', 'cellMargin' => 100);
        $styleFirstRow = array('borderBottomSize' => 18);
        $styleCell = array('align' => 'center');
        $fontStyle = array('bold' => true, 'align' => 'center');
        $phpWord->addTableStyle('Рейтинг врачей за период', $styleTable, $styleFirstRow);
        $table = $section->addTable('Рейтинг врачей за период');
        $table->addRow(500);
        $table->addCell(2000, $styleCell)->addText(htmlspecialchars('№'), $fontStyle);
        $table->addCell(2000, $styleCell)->addText(htmlspecialchars('Доктор'), $fontStyle);
        $table->addCell(2000, $styleCell)->addText(htmlspecialchars('Кол-во записей к врачу'), $fontStyle);
        $i = 1;
        foreach ($docs as $doc) {
            $table->addRow();
            $table->addCell(2000)->addText(htmlspecialchars("{$i}."));
            $table->addCell(2000)->addText(htmlspecialchars("{$doc->fio}"));
            $table->addCell(2000)->addText(htmlspecialchars("{$doc->count}"));
            $i++;
        }
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('Рейтинг врачей за период.docx');
        return response()->download(public_path('Рейтинг врачей за период.docx'));
    }


    public function getReportTopServices()
    {
        $phpWord = new  \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        $header = array(
            'size' => 14,
            'bold' => true,
            'align' => 'center',
        );

        $top_services = \App::call('App\Http\Controllers\ReportController@ReportTopServices');
        $section->addTextBreak(1);
        $section->addText(htmlspecialchars('Рейтинг услуг за период'), $header);
        $styleTable = array('borderSize' => 6, 'borderColor' => '006699', 'cellMargin' => 100);
        $styleFirstRow = array('borderBottomSize' => 18);
        $styleCell = array('align' => 'center');
        $fontStyle = array('bold' => true, 'align' => 'center');
        $phpWord->addTableStyle('Рейтинг услуг за период', $styleTable, $styleFirstRow);
        $table = $section->addTable('Рейтинг услуг за период');
        $table->addRow(500);
        $table->addCell(2000, $styleCell)->addText(htmlspecialchars('№'), $fontStyle);
        $table->addCell(2000, $styleCell)->addText(htmlspecialchars('Услуга'), $fontStyle);
        $table->addCell(2000, $styleCell)->addText(htmlspecialchars('Кол-во записей на услугу'), $fontStyle);
        $i = 1;
        foreach ($top_services as $top_service) {
            $table->addRow();
            $table->addCell(2000)->addText(htmlspecialchars("{$i}."));
            $table->addCell(2000)->addText(htmlspecialchars("{$top_service->title}"));
            $table->addCell(2000)->addText(htmlspecialchars("{$top_service->count}"));
            $i++;
        }


        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('Рейтинг услуг за период.docx');
        return response()->download(public_path('Рейтинг услуг за период.docx'));
    }

    public function getReportTopPatients()
    {
        $phpWord = new  \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        $header = array(
            'size' => 14,
            'bold' => true,
            'align' => 'center',
        );

        $top_patients = \App::call('App\Http\Controllers\ReportController@ReportTopPatients');

        $section->addTextBreak(1);
        $section->addText(htmlspecialchars(' '), $header);
        $styleTable = array('borderSize' => 6, 'borderColor' => '006699', 'cellMargin' => 100);
        $styleFirstRow = array('borderBottomSize' => 18);
        $styleCell = array('align' => 'center');
        $fontStyle = array('bold' => true, 'align' => 'center');
        $phpWord->addTableStyle('Рейтинг пациентов за период', $styleTable, $styleFirstRow);
        $table = $section->addTable('Рейтинг пациентов за период');
        $table->addRow(500);
        $table->addCell(2000, $styleCell)->addText(htmlspecialchars('№'), $fontStyle);
        $table->addCell(2000, $styleCell)->addText(htmlspecialchars('Пациент'), $fontStyle);
        $table->addCell(2000, $styleCell)->addText(htmlspecialchars('Кол-во записей на прием'), $fontStyle);
        $i = 1;
        foreach ($top_patients as $top_patient) {
            $table->addRow();
            $table->addCell(2000)->addText(htmlspecialchars("{$i}."));
            $table->addCell(2000)->addText(htmlspecialchars("{$top_patient->fio}"));
            $table->addCell(2000)->addText(htmlspecialchars("{$top_patient->count}"));
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
