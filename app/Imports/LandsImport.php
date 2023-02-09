<?php

namespace App\Imports;

use App\Models\Land;
use App\Models\Input;
use App\Models\Activity;
use App\Models\Technology;
use App\Models\ActivitySection;
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
                return 1;
                break;
            case 'En Estudio':
                return 2;
                break;
            case 'Aceptada':
                return 3;
                break;
            case 'Descartada':
                return 4;
                break;
            case 'Para Aclarar':
                return 5;
                break;
            case 'Para Posicionamiento':
                return 6;
                break;
            case 'Aceptada Ficticio 5':
                return 7;
                break;
            case 'Tramitación':
                return 8;
                break;
            case 'Posicionar con mas Terrenos':
                return 9;
                break;
            case 'Aceptada 5 MW Real':
                return 10;
                break;
            case 'Prioridad concurso/distribución':
                return 11;
                break;
            case 'Pendiente de Oferta':
                return 12;
                break;
            case 'Sin Terreno':
                return 13;
                break;
        }
    }
    public function getAnalysisState($name)
    {
        switch ($name) {

            case 'Sin identificar':
                return 1;
                break;
            case 'PTE Contrato Propiedad':
                return 2;
                break;
            case 'Negociación':
                return 3;
                break;
            case 'Negoc. Avanzada':
                return 4;
                break;
            case 'Sin Acuerdo':
                return 5;
                break;
            case 'Firmado':
                return 6;
                break;
            case 'No Posible':
                return 7;
                break;
            case 'Firmado Solar':
                return 8;
                break;
            default:
                return null;
                break;
        }
    }

    public function normalizeStr($str)
    {
        return preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
            return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
        }, $str);
    }

    public function getInputValue($row)
    {
        $final_json = [];

        // echo json_encode($row).'///hola///';

        foreach ((array)$row as $key => $value) {
            foreach (Input::where('table','land')->get() as $key2 => $i) {
                // echo Str::slug($i->title, '_').' - '.$key.' <br> ';
                if (Str::slug($i->getRawOriginal('title'), '_') == $key) {
                    \Log::info($this->stripAccents($value));
                    $final_json[] = ['id'=>$i->id, 'value' => $this->stripAccents($value)];
                }
            }
        }

        return json_encode($final_json);
    }

    public function stripAccents($str) {
        return strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ/'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY-');
    }

    public function getTechnology($name)
    {
        $t = Technology::where('name','like','%'.$name.'%')->first();

        if ($t) {
            return $t->id;
        }

        return null;
    }

    public function model(array $row)
    {
        $p = null;

        if (isset($row['socio'])) {
            $p = Partner::where('name',$row['socio'])->first();

            if (!$p) {
                $p = new Partner;
                $p->name = $row['socio'];
                $p->save();
            }
        }

        $l = Land::where('name',$row['nombre_del_proyecto'])
        /*->where('carpeta',$row['carpeta'])*/->where('technology',$this->getTechnology($row['tecnologia']))
        ->where(function($q) use($row){
            if ($row['id']) {
                $q->where('id',$row['id']);
            }
        })
        /*->where(function($q) use($p){
            if ($p) {
                $q->where('partner_id',$p->id);
            }
        })*/->first();

        if (!$l) {
            $l = new Land;
            
            $l->name = isset($row['principal']) ? ($row['principal'] == 1 ? 1 : null) : null;

            $l->id = $row['id'];
            $l->partner_id = $p ? $p->id : null;
            // $l->month = $row['mes'];
            // $l->week = $row['semana'];
            $l->carpeta = (int)$row['carpeta'];
            $l->name = $row['nombre_del_proyecto'];

            $l->negotiator = $row['negociador_contrato'];
            // partner_info
            $l->mwp = isset($row['mwp']) ? strval($row['mwp']) : 0;
            $l->mwn = strval($row['mwn']);

            $l->substation = $row['set'];
            $l->substation_km = $row['km_set'];

            $l->analisys_state = $this->getAnalisysState($row['estado_terrenosolicitud']);
            $l->contract_state = $this->getAnalysisState($row['estado_del_contrato']);

            $l->technology = $this->getTechnology($row['tecnologia']);

            $l->extra_inputs = $this->getInputValue($row);
            $l->save();

            if (($l->analisys_state == 1 || $l->analisys_state == 3 || $l->analisys_state == 7 || $l->analisys_state == 10)
                && ($l->contract_state == 6 || $l->contract_state == 8)) {

                $p = Permission::where('land_id',$l->id)->first();

                if (!$p) {
                    $p = new Permission;
                    $p->land_id = $l->id;
                    $p->save();

                    $this->generateActivities($p->id);
                }
            }
            /**/
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