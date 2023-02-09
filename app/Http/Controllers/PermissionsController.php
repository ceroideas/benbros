<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Input;
use App\Models\InputOption;
use App\Models\Section;
use App\Models\Permission;
use App\Models\Land;
use App\Models\Activity;
use App\Models\ActivitySection;
use App\Models\ActivityDocument;
use App\Models\ProjectDocument;
use App\Models\Endorsement;

class PermissionsController extends Controller
{
    //
    public function getPermissionTemplate()
    {
        return view('permissions.input-template')->render();
    }
    public function getTemplatePermissionEdit($id)
    {
        $inp = Input::find($id);
        return view('permissions.edit-template',compact('inp'))->render();
    }

    public function savePermissionInput(Request $r)
    {
        return response()->json($r->all(),422);
        $this->validate($r,[
            'title'=>'required',
        ]);

        if ($r->new_section) {
            $s = Section::where('name',$r->new_section)->first();
            if (!$s) {
                $s = new Section;
                $s->name = $r->new_section;
                $s->save();
            }
            $section = $s->id;
        }else{
            $section = $r->section_id;
        }

        $fr = new Input;
        $fr->section_id = $section;
        $fr->type = $r->type;
        $fr->table = 'project';
        $fr->title = $r->title;
        $fr->info = $r->info;
        $fr->save();

        /**/

        if ($r->type == 'normal') {
            $options = ['Si','No','En progreso'];

            foreach ($options as $key => $value) {
                $io = new InputOption;
                $io->input_id = $fr->id;
                $io->option = $value;
                $io->save();
            }
        }
    }

    public function editPermissionInput(Request $r)
    {
        return response()->json($r->all(),422);
        $this->validate($r,[
            'title'=>'required',
        ]);

        if ($r->new_section) {
            $s = Section::where('name',$r->new_section)->first();
            if (!$s) {
                $s = new Section;
                $s->name = $r->new_section;
                $s->save();
            }
            $section = $s->id;
        }else{
            $section = $r->section_id;
        }

        $fr = Input::find($r->id);
        $fr->section_id = $section;
        $fr->type = $r->type;
        $fr->table = 'project';
        $fr->title = $r->title;
        $fr->info = $r->info;
        $fr->save();

        InputOption::where('input_id',$fr->id)->delete();

        if ($r->type == 'normal') {
            $options = ['Si','No','En progreso'];

            foreach ($options as $key => $value) {
                $io = new InputOption;
                $io->input_id = $fr->id;
                $io->option = $value;
                $io->save();
            }
        }
    }

    public function addNewProject(Request $r)
    {
        $p = new Permission;
        $p->land_id = $r->land_id;
        $p->tramitation_type = $r->tramitation_type;
        $p->save();

        $this->generateActivities($p->id);

        return back();
    }

    public function addNewGuarantee(Request $r)
    {
        $p = new Endorsement;
        $p->land_id = $r->land_id;
        $p->save();

        return back();
    }
    public function saveGuarantee(Request $r)
    {
        $e = Endorsement::find($r->id);

        $extras = json_decode($e->land->extra_inputs,true);
        $editables = [];
        $index = [];

        foreach (json_decode($r->extras,true) as $key1 => $value1) {
            $count = 0;
            if ($extras) {
                foreach ($extras as $key => $value) {
                    if ($value['id'] == $value1['id']) {
                        $editables[] = ['id' => $key, 'value' => $value1['value']];
                        $count = 0;
                        break;
                    }else{
                        $count++;
                    }
                }
            }else{
                $count++;
            }

            if ($count>0) {

                $extras[] = ['id' => $value1['id'], 'value' => $value1['value']];
                
            }

        }

        foreach ($editables as $key => $value) {
            $extras[$value['id']]['value'] = $value['value'];
        }

        $e->land->extra_inputs = json_encode($extras);
        $e->land->save();

        $e->type = $r->type;
        $e->ammount = $r->ammount;
        $e->guarantee_status = $r->guarantee_status != 'null' ? $r->guarantee_status : $e->guarantee_status;
        $e->request_status = $r->request_status != 'null' ? $r->request_status : $e->request_status;
        $e->save();

        return view('includes.guarantee_summary')->render();
    }

    public function deleteGuarantee($id)
    {
        $e = Endorsement::find($id);
        $e->delete();

        return back();
    }


    public function saveLandPermission(Request $r)
    {
        $p = Permission::find($r->id);
        $p->tramitation_type = $r->tramitation_type;
        $p->extra_inputs = $r->extras;
        $p->save();
    }

    public function addSection($id)
    {
        $s = new ActivitySection;
        $s->permission_id = $id;
        $s->save();

        $p = Permission::find($id);

        return view('permissions.activities',compact('p'))->render();
    }

    public function saveSection(Request $r)
    {
        $s = ActivitySection::find($r->id);
        $s->name = $r->name;
        $s->save();

        // $p = Permission::find($s->permission_id);

        // return view('permissions.activities',compact('p'))->render();
    }

    public function deleteASection($id)
    {
        $s = ActivitySection::find($id);
        $s->delete();

        // $p = Permission::find($s->permission_id);

        // return view('permissions.activities',compact('p'))->render();
        return back();
    }
    public function createActivity(Request $r)
    {
        $a = new Activity;
        $a->name = $r->name;
        $a->activity_section_id = $r->activity_section_id;
        $a->save();

        $s = ActivitySection::find($r->activity_section_id);
        $p = Permission::find($s->permission_id);
        
        return view('permissions.activities',compact('p'))->render();
    }

    public function saveActivity(Request $r)
    {
        $a = Activity::find($r->id);
        $a->name = $r->name;
        $a->progress = $r->progress;
        $a->start_date = $r->start_date;
        $a->end_date = $r->end_date;
        $a->responsable_benbros = $r->responsable_benbros;
        $a->responsable_external = $r->responsable_external;
        $a->administrative = $r->administrative;
        $a->commentary = $r->commentary;
        // $a->status = $r->status != 'null' ? $r->status : null;
        $a->save();

        $section = ActivitySection::find($a->activity_section_id);
        $s = ActivitySection::with('activities')->where('permission_id',$section->permission_id)->get();
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

        return [$p,$s,$extra_inputs];
        // return view('includes.gantt',compact('p'))->render();
    }

    public function deleteActivity($id)
    {
        $a = Activity::find($id);
        $a->delete();

        return back();
    }

    public function deleteProject($id)
    {
        $p = Permission::find($id);
        $p->delete();

        return back();
    }

    public function uploadFile(Request $r)
    {
        $name_file = $r->file->getClientOriginalName().(uniqid()).'.'.$r->file->getClientOriginalExtension();
        $r->file->move(public_path().'/uploads/documents/activities/' , $name_file);

        $ad = new ActivityDocument;
        $ad->activity_id = $r->id;
        $ad->url = $name_file;
        $ad->save();

        $a = Activity::find($r->id);
        $s = ActivitySection::find($a->activity_section_id);
        $p = Permission::find($s->permission_id);

        return view('permissions.activities',compact('p'))->render();
    }

    public function uploadFileProject(Request $r)
    {
        $name_file = $r->file->getClientOriginalName().(uniqid()).'.'.$r->file->getClientOriginalExtension();
        $r->file->move(public_path().'/uploads/documents/permissions/' , $name_file);

        $ad = new ProjectDocument;
        $ad->permission_id = $r->id;
        $ad->type = $r->type;
        $ad->url = $name_file;
        $ad->save();
    }

    public function imageTest()
    {
        $ad = new ActivityDocument;
        $ad->activity_id = 1;
        $ad->url = "PRUEBA";
        $ad->save();

        return url('1.jpg');
    }

    public function saveValueProject(Request $r)
    {
        $l = Land::find($r->id);
        $l[$r->column] = $r->value;
        $l->save();
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
