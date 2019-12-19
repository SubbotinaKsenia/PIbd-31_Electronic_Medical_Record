<?php

namespace App\Http\Controllers;

use App\Disease;
use App\DiseaseReport;
use App\DoctorReport;
use App\PatientReport;
use App\ReceivingSheet;
use App\Record;
use App\ServiceReport;
use App\User;
use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\SimpleType\Jc;

class ReportController extends Controller
{
    public function getReportTopDoctors($dateFrom, $dateTo)
    {
        $phpWord = new  \PhpOffice\PhpWord\PhpWord();
        $phpWord->addFontStyle('FontHeader', array('name' => 'Times New Roman', 'size' => 16, 'bold' => true));
        $phpWord->addFontStyle('Font', array('name' => 'Times New Roman', 'size' => 14, 'bold' => true));
        $phpWord->addFontStyle('FontCell', array('name' => 'Times New Roman', 'size' => 14, 'bold' => false));
        $phpWord->addParagraphStyle('Paragraph', array('alignment' => Jc::CENTER));

        $section = $phpWord->addSection();

        $top_doctors = \App::call('App\Http\Controllers\ReportController@ReportTopDoctors', ['dateFrom' => $dateFrom, 'dateTo' => $dateTo]);

        $section->addText(htmlspecialchars('Рейтинг врачей за период c ' . strval(date('d.m.Y', strtotime($dateFrom))) . ' по ' . strval(date('d.m.Y', strtotime($dateTo)))), 'FontHeader', 'Paragraph');

        $styleTable = array('borderSize' => 6, 'borderColor' => '006699', 'cellMargin' => 100);
        $styleFirstRow = array('borderBottomSize' => 15);

        $phpWord->addTableStyle('Рейтинг врачей за период', $styleTable, $styleFirstRow);
        $table = $section->addTable('Рейтинг врачей за период');

        $table->addRow();
        $table->addCell(750)->addText(htmlspecialchars('№'), 'Font', 'Paragraph');
        $table->addCell(5000)->addText(htmlspecialchars('Доктор'), 'Font', 'Paragraph');
        $table->addCell(5000)->addText(htmlspecialchars('Кол-во записей'), 'Font', 'Paragraph');
        $i = 1;
        foreach ($top_doctors as $doc) {
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


    public function getReportTopServices($dateFrom, $dateTo)
    {
        $phpWord = new  \PhpOffice\PhpWord\PhpWord();
        $phpWord->addFontStyle('FontHeader', array('name' => 'Times New Roman', 'size' => 16, 'bold' => true));
        $phpWord->addFontStyle('Font', array('name' => 'Times New Roman', 'size' => 14, 'bold' => true));
        $phpWord->addFontStyle('FontCell', array('name' => 'Times New Roman', 'size' => 14, 'bold' => false));
        $phpWord->addParagraphStyle('Paragraph', array('alignment' => Jc::CENTER));

        $section = $phpWord->addSection();

        $top_services = \App::call('App\Http\Controllers\ReportController@ReportTopServices', ['dateFrom' => $dateFrom, 'dateTo' => $dateTo]);

        $section->addText(htmlspecialchars('Рейтинг услуг за период c ' . strval(date('d.m.Y', strtotime($dateFrom))) . ' по ' . strval(date('d.m.Y', strtotime($dateTo)))), 'FontHeader', 'Paragraph');

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

    public function getReportTopPatients($dateFrom, $dateTo)
    {
        $phpWord = new  \PhpOffice\PhpWord\PhpWord();
        $phpWord->addFontStyle('FontHeader', array('name' => 'Times New Roman', 'size' => 16, 'bold' => true));
        $phpWord->addFontStyle('Font', array('name' => 'Times New Roman', 'size' => 14, 'bold' => true));
        $phpWord->addFontStyle('FontCell', array('name' => 'Times New Roman', 'size' => 14, 'bold' => false));
        $phpWord->addParagraphStyle('Paragraph', array('alignment' => Jc::CENTER));

        $section = $phpWord->addSection();

        $top_patients = \App::call('App\Http\Controllers\ReportController@ReportTopPatients', ['dateFrom' => $dateFrom, 'dateTo' => $dateTo]);

        $section->addText(htmlspecialchars('Рейтинг пациентов за период c ' . strval(date('d.m.Y', strtotime($dateFrom))) . ' по ' . strval(date('d.m.Y', strtotime($dateTo)))), 'FontHeader', 'Paragraph');

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

    public function getReportTopDiseases($dateFrom, $dateTo)
    {
        $phpWord = new  \PhpOffice\PhpWord\PhpWord();
        $phpWord->addFontStyle('FontHeader', array('name' => 'Times New Roman', 'size' => 16, 'bold' => true));
        $phpWord->addFontStyle('Font', array('name' => 'Times New Roman', 'size' => 14, 'bold' => true));
        $phpWord->addFontStyle('FontCell', array('name' => 'Times New Roman', 'size' => 14, 'bold' => false));
        $phpWord->addParagraphStyle('Paragraph', array('alignment' => Jc::CENTER));

        $section = $phpWord->addSection();

        $top_diseases = \App::call('App\Http\Controllers\ReportController@ReportTopDiseases', ['dateFrom' => $dateFrom, 'dateTo' => $dateTo]);

        $section->addText(htmlspecialchars('Заболевания за период c ' . strval(date('d.m.Y', strtotime($dateFrom))) . ' по ' . strval(date('d.m.Y', strtotime($dateTo)))), 'FontHeader', 'Paragraph');

        $styleTable = array('borderSize' => 6, 'borderColor' => '006699', 'cellMargin' => 100);
        $styleFirstRow = array('borderBottomSize' => 15);

        $phpWord->addTableStyle('Заболевания за период', $styleTable, $styleFirstRow);
        $table = $section->addTable('Заболевания за период');

        $table->addRow();
        $table->addCell(750)->addText(htmlspecialchars('№'), 'Font', 'Paragraph');
        $table->addCell(5000)->addText(htmlspecialchars('Болезнь'), 'Font', 'Paragraph');
        $table->addCell(5000)->addText(htmlspecialchars('Кол-во обращений'), 'Font', 'Paragraph');
        $i = 1;
        foreach ($top_diseases as $top_disease) {
            $table->addRow();
            $table->addCell(750)->addText(htmlspecialchars("{$i}."), 'FontCell', 'Paragraph');
            $table->addCell(5000)->addText(htmlspecialchars("{$top_disease->title}"), 'FontCell');
            $table->addCell(5000)->addText(htmlspecialchars("{$top_disease->count}"), 'FontCell');
            $i++;
        }

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('Заболевания за период.docx');

        return response()->download(public_path('Заболевания за период.docx'));
    }


    public function ReportTopDoctors($dateFrom, $dateTo)
    {
        $sheets = Record::where('is_reserved', 1)->get();

        $doctors = array();
        $top_doctors = array();

        foreach ($sheets as $sheet) {
            $doctor = User::findOrFail($sheet->doctor_id);
            if ($sheet->date >= $dateFrom && $sheet->date <= $dateTo) {
                if (!in_array($doctor, $doctors)) {
                    array_push($top_doctors, new DoctorReport([
                        'fio' => $doctor->fio,
                        'count' => 1,
                        'doctor_id' => $doctor->id,
                    ]));
                    array_push($doctors, $doctor);
                } else {
                    foreach ($top_doctors as $d) {
                        if ($d->doctor_id == $doctor->id) {
                            $d->fill([
                                'count' => intval($d->count) + 1,
                            ]);
                        }
                    }
                }
            }
        }

        usort($top_doctors, function ($a, $b) {
            return ($b->count - $a->count);
        });

        return $top_doctors;
    }

    public function ReportTopServices($dateFrom, $dateTo)
    {
        $records = Record::all();

        $services = array();
        $top_services = array();

        foreach ($records as $rec) {
            $service = Service::findOrFail($rec->service_id);
            if ($rec->date >= $dateFrom && $rec->date <= $dateTo) {
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
        }

        usort($top_services, function ($a, $b) {
            return ($b->count - $a->count);
        });

        return $top_services;
    }

    public function ReportTopPatients($dateFrom, $dateTo)
    {
        $records = Record::where('is_reserved', 1)->get();

        $patients = array();
        $top_patients = array();

        foreach ($records as $rec) {
            $patient = User::findOrFail($rec->patient_id);
            if ($rec->date >= $dateFrom && $rec->date <= $dateTo) {
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
        }

        usort($top_patients, function ($a, $b) {
            return ($b->count - $a->count);
        });

        return $top_patients;
    }

    public function ReportTopDiseases($dateFrom, $dateTo)
    {
        $sheet_diseases = DB::table('disease_receiving_sheet')->get();

        $top_diseases = array();
        $diseases = array();

        foreach ($sheet_diseases as $sheet_disease) {
            $receiving_sheet = ReceivingSheet::findOrFail($sheet_disease->receiving_sheet_id);
            if ($receiving_sheet->date >= $dateFrom && $receiving_sheet->date <= $dateTo) {
                $disease = Disease::findOrFail($sheet_disease->disease_id);
                if (!in_array($disease, $diseases)) {
                    array_push($top_diseases, new DiseaseReport([
                        'title' => $disease->title,
                        'count' => 1,
                        'disease_id' => $disease->id,
                    ]));
                    array_push($diseases, $disease);
                } else {
                    foreach ($top_diseases as $top_disease) {
                        if ($top_disease->disease_id == $disease->id) {
                            $top_disease->fill([
                                'count' => intval($top_disease->count) + 1
                            ]);
                        }
                    }
                }
            }
        }

        usort($top_diseases, function ($a, $b) {
            return ($b->count - $a->count);
        });

        return $top_diseases;
    }
}