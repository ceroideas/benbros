<?php

namespace App\Imports;

use App\Models\Land;
use App\Models\Endorsement;
use App\Models\Status;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class GuaranteeImport implements ToModel, WithHeadingRow
{
    use Importable;

    public function getGuarantee($row)
    {
        foreach ((array)$row as $key => $value) {
            foreach (Status::where('type','guarantee')->get() as $key2 => $i) {
                if (Str::slug($i->name, '_') == $key) {
                    if (trim($value) != "") {
                        return $i->id;
                    }
                }
            }
        }

        return null;
    }
    public function getRequest($row)
    {
        foreach ((array)$row as $key => $value) {
            foreach (Status::where('type','request')->get() as $key2 => $i) {
                if (Str::slug($i->name, '_') == $key) {
                    if (trim($value) != "") {
                        return $i->id;
                    }
                }
            }
        }

        return null;
    }

    public function model(array $row)
    {
        $p = null;
        foreach (Land::all() as $key => $value) {
            if (strtolower($value->name) == strtolower($row['project'])) {
                $p = $value;
            }
        }

        if (!$p) {
            $p = new Land;
            $p->name = $row['project'];
            $p->mwn = number_format($row['mwn'],2);
            $p->save();
        }

        $e = new Endorsement;
        $e->land_id = $p->id;
        $e->type = $row['type'];
        $e->ammount = str_replace('.', '', $row['amount']);

        $e->guarantee_status = $this->getGuarantee($row);


        $e->request_status = $this->getRequest($row);

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