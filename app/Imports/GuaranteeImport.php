<?php

namespace App\Imports;

use App\Models\Land;
use App\Models\Endorsement;
use App\Models\Status;
use App\Models\Input;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class GuaranteeImport implements ToModel, WithHeadingRow
{
    use Importable;

    public function getGuarantee($name)
    {
        // foreach ((array)$row as $key => $value) {
            foreach (Status::where('type','guarantee')->get() as $i) {
                if (Str::slug($i->name, '_') == Str::slug($name,'_')) {
                    if (trim($name) != "") {
                        return $i->id;
                    }
                }
            }
        // }

        return null;
    }
    public function getRequest($name)
    {
        // foreach ((array)$row as $key => $value) {
            foreach (Status::where('type','request')->get() as $i) {
                if (Str::slug($i->name, '_') == Str::slug($name,'_')) {
                    if (trim($name) != "") {
                        return $i->id;
                    }
                }
            }
        // }

        return null;
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
        $p = Land::where('name','like','%'.trim($row['project']).'%')->first();

        if (!$p) {
            $p = new Land;
            $p->name = $row['project'];
            $p->mwn = number_format($row['mwn'],2);
            $p->extra_inputs = $this->getInputValue($row);
            $p->save();
        }else{

            // $p->extra_inputs = $this->getInputValue($row);

            if (!$p->carpeta) {
                $p->carpeta = $p->id;
            }
            
            $p->save();
        }


            $e = new Endorsement;
            $e->land_id = $p->id;
            $e->type = $row['type'];
            $e->ammount = str_replace('.', '', $row['amount']);

            $e->guarantee_status = $this->getGuarantee($row['guarantee_status']);

            $e->request_status = $this->getRequest($row['request_status']);

            $e->save();
        
        /*bidden
        awarded
        denied

        in_suspension
        recovery_plan
        cancelled
        validation_pending*/

    }
}