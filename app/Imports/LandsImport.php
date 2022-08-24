<?php

namespace App\Imports;

use App\Models\Land;
use App\Models\Input;
use App\Models\Permission;
use App\Models\Partner; // empresa colaboradora
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class LandsImport implements ToModel, WithHeadingRow
{
    use Importable;

    public function getAnalisysState($name)
    {
        switch ($name) {

            case 'Aceptada Ficticio':
                return 6;
                break;
            case 'En Estudio':
                return 3;
                break;
            case 'Aceptada':
                return 1;
                break;
            case 'Descartada':
                return 2;
                break;
            case 'Para Aclarar':
                return 4;
                break;
            case 'Para Posicionamiento':
                return 5;
                break;
            default:
                return null;
                break;
        }
    }
    public function getAnalysisState($name)
    {
        switch ($name) {

            case 'Negociación':
                return 3;
                break;
            case 'Negoc. Avanzada':
                return 4;
                break;
            case 'Sin Acuerdo':
                return 1;
                break;
            case 'Firmado':
                return 2;
                break;
            case 'No Posible':
                return 5;
                break;
            case 'Firmado Solar':
                return 2;
                break;
            default:
                return null;
                break;
        }
    }

    public function getInputValue($row)
    {
        $final_json = [];

        // echo json_encode($row).'///hola///';

        foreach ((array)$row as $key => $value) {
            foreach (Input::where('table','land')->get() as $key2 => $i) {
                // echo Str::slug($i->title, '_').' - '.$key.' <br> ';
                if (Str::slug($i->getRawOriginal('title'), '_') == $key) {
                    $final_json[] = ['id'=>$i->id, 'value' => trim($value)];
                    \Log::info($value);
                }
            }
        }

        return json_encode($final_json);
    }

    public function model(array $row)
    {
    	// dd(json_encode($row));

        if (isset($row['empresa_colaboradora'])) {
            $p = Partner::where('name',$row['empresa_colaboradora'])->first();

            if (!$p) {
                $p = new Partner;
                $p->name = $row['empresa_colaboradora'];
                $p->save();
            }

            // $l = Land::where('name',$row['nombre_del_proyecto'])->where('month',$row['mes'])->where('week',$row['semana'])->first();
            // if (!$l) {
                $l = new Land;
            // }
            $l->partner_id = $p ? $p->id : null;
            $l->month = $row['mes'];
            $l->week = $row['semana'];
            $l->name = $row['nombre_proyecto'];

            $l->negotiator = $row['negociador_contrato'];
            // partner_info
            $l->mwp = number_format((int)$row['mwp_estimados'],2);
            $l->mwn = number_format((int)$row['mw_nominales'],2);

            $l->substation = $row['set'];
            $l->substation_km = $row['km_set'];

            $l->analisys_state = $this->getAnalisysState($row['estado_operacion']);
            $l->contract_state = $this->getAnalysisState($row['estado_contrato']);

            $l->technology = 1;

            $l->extra_inputs = $this->getInputValue($row);
            $l->save();

            if ($l->analisys_state == 1 && $l->contract_state == 2) {

                $p = Permission::where('land_id',$l->id)->first();

                if (!$p) {
                    $p = new Permission;
                    $p->land_id = $l->id;
                    $p->save();

                    $this->generateActivities($p->id);
                }
            }
        }
    }

    public function generateActivities($id)
    {
        $sections = [["name"=>"Land permits", "activities"=>
        [
            "Land contracts",
            "Field visit",
            "DUP"
        ]],

        ["name"=>"Environmental Impact Assesment", "activities"=>
        [
            "EIA scoping document ",
            "Obtaining EIA scoping document",
            "Archeological study",
            "Birdlife study + fauna + alternatives",
            "Chiropteras study (with altenatives)",
            "EIA",
            "EIA Resolution"
        ]],

        ["name"=>"Technical Project", "activities"=>
        [
            "Topographical study",
            "Hydrological study",
            "Layout",
            "Offprints",
            "Execution project for AAP and AAC"
        ]],

        ["name"=>"Ministry of Industry", "activities"=>
        [
            "AAP request",
            "AAC request",
            "AAP and AAC resolution"
        ]],

        ["name"=>"Town Council", "activities"=>
        [
            "Urban compatibility site",
            "Urban compatibility line ",
            "Building permit application (licencia de obras)",
            "Building permit resolution"
        ]],

        ["name"=>"RBDA permits", "activities"=>
        [
            "RBDA permits",
            "Management of individual permits. Mutual agreements",
            "Management of emergency occupancy certificates",
            "Attendance at the lifting of emergency occupancy certificates",
            "Formalisation of deposits"
        ]],

        ["name"=>"Socio-economic criteria", "activities"=>
        [
            "Financial model per Project",
            "Job creation and re-skilling ",
            "Reduction of electricity costs and promotion of self-consumption",
            "Business development "
        ]]];


        foreach ($sections as $key => $value) {
            
            $s = new ActivitySection;
            $s->permission_id = $id;
            $s->name = $value['name'];
            $s->save();

            foreach ($value['activities'] as $key => $value1) {
                $a = new Activity;
                $a->name = $value1;
                $a->activity_section_id = $s->id;
                $a->save();
            }
        }
    }
}