<?php

namespace App\Imports;

use App\Models\Activity;
use App\Models\ActivitySection;
use App\Models\Permission;
use App\Models\Input;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Illuminate\Support\Str;
use Carbon\Carbon;

class ProjectImport implements ToModel, WithHeadingRow
{
    use Importable;

    public function __construct($id)
    {
    	$this->id = $id;
    }

    public function model(array $row)
    {
    	$activity_sections = ActivitySection::where('permission_id',$this->id)->get();

    	foreach ($activity_sections as $key => $value) {

	        $activities = Activity::where('activity_section_id',$value->id)->get();

	        foreach ($activities as $key => $a) {
	        	
	        	if (Str::slug($a->name,'-') == Str::slug($row[""],'-')) {
	        		
			    	if (isset($row['start']) && gettype($row['start']) == 'integer') {
			    		$a->start_date = Date::excelToDateTimeObject($row['start'])->format('Y-m-d');
			    	}
			    	if (isset($row['end']) && gettype($row['end']) == 'integer') {
				        $a->end_date = Date::excelToDateTimeObject($row['end'])->format('Y-m-d');
			    	}
			    	/**/
	        		if ($row['start_date'] && $row['start_date'] != "Start Date" && $row['start_date'] != 'N/A' && $row['start_date'] != 'Pending') {
			        	$a->start_date = Date::excelToDateTimeObject($row['start_date'])->format('Y-m-d');
			    	}else{
			    		$a->start_date = null;
			    	}
			    	if ($row['finish_date'] && $row['finish_date'] != "Finish Date" && $row['finish_date'] != 'N/A' && $row['finish_date'] != 'Pending') {
				        $a->end_date = Date::excelToDateTimeObject($row['finish_date'])->format('Y-m-d');
			    	}else{
			    		$a->end_date = null;
			    	}
			    	// }
			    	if ($row['progress'] == 'N/A') {
			        	$a->progress = 0;
			    	}else{
			        	$a->progress = $row['progress']*100;
			    	}

			        $a->responsable_benbros = $row['person_in_charge_benbros'];
			        $a->responsable_external = $row['person_in_charge'];
			        $a->administrative = $row['competente_body'];
			        $a->commentary = $row['w5'];
			        $a->save();

			        $section = ActivitySection::find($a->activity_section_id);
			        $p = Permission::with('land')->find($section->permission_id);

			        $sections = ActivitySection::where('permission_id',$section->permission_id)->get();

			        $extra_inputs = [];

			        foreach ($sections as $key => $value) {
			            
			            $activities = Activity::where('activity_section_id',$value->id)->get();

			            foreach ($activities as $key => $value1) {
			                $i = Input::where('title',$value1->name)->first();
			                if ($i) {
			                    if ($value1->progress == 0) {
			                        $extra_inputs[] = ["id" => $i->id, "value" => "No"];
			                    }else if ($value1->progress > 0 && $value1->progress < 100) {
			                        $extra_inputs[] = ["id" => $i->id, "value" => "En progreso"];
			                    }else if ($value1->progress == 100) {
			                        $extra_inputs[] = ["id" => $i->id, "value" => "Si"];
			                    }
			                }
			            }

			        }

			        $p->extra_inputs = json_encode($extra_inputs);
			        $p->save();
	        	}
	        }
    	}

    }
}